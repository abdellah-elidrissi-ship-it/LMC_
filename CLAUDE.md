# CLAUDE.md

## Présentation du projet

LMC Conseil est une application de gestion de missions de conseil QSE/SMI
(Systèmes de Management Intégré — ISO 9001, 14001, 45001). Elle permet de
suivre des projets clients : consultants affectés, chapitres normatifs,
livrables, formations, planning (Gantt), et preuves documentaires.

## Stack technique

- Laravel 12, PHP 8.2
- Base de données : SQLite (dev par défaut), MySQL configuré en local
  (`lmc_conseil_db`)
- Vues : Blade pur, pas de layout partagé — chaque page est un document HTML
  autonome avec son propre `<head>` et son propre chargement CDN
- CSS/UI : Bootstrap 5.3 chargé via CDN sur chaque vue (pas via npm/Vite)
- Stockage fichiers : Cloudinary (`cloudinary-labs/cloudinary-laravel`) —
  logos clients, preuves de livrables, preuves projet
- `package.json` contient aussi Tailwind, React, MUI, Emotion — **installés
  mais non utilisés** dans les vues actuelles. Ne pas supposer qu'un
  composant React ou Tailwind existe déjà quelque part.

## Architecture générale

- `app/Models` — Eloquent, domaine métier (voir relations ci-dessous)
- `app/Http/Controllers` — contrôleurs web (une vue = un contrôleur dédié)
- `app/Http/Controllers/Api` — CRUD REST par ressource. Les routes de
  `routes/api.php` sont enveloppées dans `Route::middleware(['auth'])`,
  **mais ce fichier n'est pas encore chargé par l'application** :
  `bootstrap/app.php` → `withRouting()` ne déclare que `web`, `commands`
  et `health`, pas de clé `api:`. Concrètement, aucune route `/api/*`
  n'existe actuellement (vérifié via `php artisan route:list`) — ces
  contrôleurs API ne sont utilisés que ponctuellement en PHP direct
  (ex. `Api\ProjetController@index` monté sur `/` dans `routes/web.php`).
  Si un jour on veut exposer une vraie API, il faut explicitement
  ajouter `api: __DIR__.'/../routes/api.php'` dans `withRouting()`.
- `app/Services/ProjetProgressService.php` — `recalculerAvancement()`
  recalcule `avancement_percent` d'un projet à partir de la **moyenne des
  Av.% saisis manuellement par chapitre** (`suivi_chapitres.avancement_percent`,
  voir section Livrables/OneDrive plus bas) ; source de vérité unique,
  appelée depuis `EditController::update` et `NouveauProjetController::store`
- `app/Http/Middleware/CheckRole.php`, `CheckPermission.php` — alias
  `role:` et `permission:` déclarés dans `bootstrap/app.php`
- `routes/web.php` — toutes les routes protégées par `auth` + permissions
  granulaires ; contient aussi `/download-file` et `/view-file` qui ne
  servent que des URL Cloudinary (host `res.cloudinary.com` validé avant
  `file_get_contents`), et `/test-cloudinary`
- `resources/views` — vues Blade volumineuses (jusqu'à ~4400 lignes),
  pas de layout `@extends` commun sauf `partials/navbar.blade.php`

## Modèles et relations principales

- `Client` → `hasMany Projet`
- `Consultant` → `belongsToMany Projet` (pivot `affectations`), `hasMany`
  projets dirigés (`chef_projet_id`)
- `Projet` → `belongsTo Client`, `belongsTo Consultant` (chef),
  `belongsToMany Norme` (pivot `projet_normes`),
  `belongsToMany Formation` (pivot `projet_formations`),
  `hasMany Affectation`, `hasMany SuiviChapitre`
- `ChapitreSmi` → `hasMany SuiviChapitre`, `belongsToMany Projet` (via
  `suivi_chapitres`)
- `Affectation` — pivot enrichi projet↔consultant (jours alloués/réalisés,
  attributs calculés `charge_percent`, `jours_restants`) ; `jours_realises`
  n'est plus saisi manuellement, il est recalculé depuis le Gantt — voir
  `App\Services\AffectationChargeService` et la section Gantt plus bas
- `User` → `belongsTo Consultant` ; rôle (`super_admin`, `chef_projet`,
  `consultant`) + `permissions` (JSON) ; `hasPermission()` est le point
  d'entrée unique pour vérifier un droit ; `use Notifiable` (système de
  notifications Laravel prêt, table `notifications` standard)
- `Tache` → `belongsTo Consultant`, `belongsTo Client` (nullable),
  `belongsTo User` (`assigned_by`) ; `Consultant::taches()` hasMany

## Modules existants

- Authentification (`AuthController`)
- Gestion projets : création (`NouveauProjetController`), détails/édition/
  suppression (`EditController`), liste filtrée par droits
  (`Api\ProjetController@index`)
- Consultants (`ConsultantController` + `Api\ConsultantController`)
- Gantt (`GanttController`, refait le 2026-07-16) — modèles Eloquent
  `GanttPhase` (table `gantt_phases`) et `GanttTache` (table
  `gantt_taches`, `phase_id` nullable FK). Une phase regroupe plusieurs
  tâches (CT Prévu/Réalisé H/J, écart, avancement %) ; les tâches sans
  phase (legacy, avant la refonte) s'affichent dans un groupe virtuel
  "Sans phase". Couleur de la barre timeline / pastille avancement =
  3 paliers (même règle que `SuiviChapitre::getProgressColorAttribute` :
  <50% danger, 50-99% warning, 100% success). **Écart = CT Prévu -
  CT Réalisé** (positif = reste à faire, négatif = dépassement) sur
  `GanttTache::getEcartAttribute()`/`GanttPhase::getEcartTotalAttribute()`
  — le formulaire "Ajouter une tâche" ne demande que CT Prévu (CT Réalisé
  se renseigne ensuite via l'édition, une tâche qui vient d'être créée
  n'a encore rien de réalisé). CRUD complet phases et
  tâches via modals + panneau d'édition inline (mêmes routes
  `gantt.phase.*`/`gantt.tache.*`, permission `modifier_projets`).
  **Base standard (8 phases / 41 tâches, méthodologie SMI ISO
  9001/14001/45001)** définie dans
  `App\Services\GanttTemplateService::phasesTaches()` — source unique
  utilisée par `GanttTemplateService::creerPour($projetId)` (no-op si le
  projet a déjà des phases), appelée automatiquement dans
  `NouveauProjetController::store()` pour tout nouveau projet, et via
  `database/seeders/GanttTemplateSeeder.php` (à lancer explicitement :
  `php artisan db:seed --class=GanttTemplateSeeder` — **ne jamais lancer
  `php artisan db:seed` sans `--class`**, `DatabaseSeeder::run()` fait des
  `TRUNCATE` sur clients/consultants/projets/etc., il détruirait les
  données réelles). Chaque phase a une couleur distincte (palette de 8,
  variable CSS `--phase-color` posée en inline sur `.phase-row`/
  `.tl-phase-row`), les tâches restent neutres.
  Vue reconstruite étape par étape avec l'utilisateur à partir du
  2026-07-16 (repartie d'une page vide, juste la navbar, puis ajout
  progressif : titre, légende, boutons, formulaires) — avant de
  reprendre son développement, relire l'état actuel du fichier plutôt
  que de supposer qu'il contient encore le tableau de tâches/timeline
  complet décrit plus haut.
  **Piège Blade** : ne jamais déclarer une `function` nommée directement
  dans un `@php` de vue sans `function_exists()` guard — si la même vue
  est rendue 2 fois dans le même process PHP (ex: script qui boucle sur
  plusieurs projets), ça lève `Cannot redeclare function` (bug rencontré
  et corrigé sur `ganttBarPosition()`, voir aussi
  `CloudinaryHelper.php::cloudinary_url()` qui suit déjà ce pattern)
  **Consultants multiples par tâche (2026-07-23)** : une tâche Gantt peut
  être assignée à plusieurs consultants (équipe), pas un seul —
  `GanttTache::consultants()` est un `belongsToMany` via la table pivot
  `gantt_tache_consultant` (migration
  `2026_07_23_090000_create_gantt_tache_consultant_table.php`, qui a aussi
  backfillé les assignations simples existantes). **L'ancienne colonne
  `gantt_taches.consultant_id` existe toujours en base mais n'est plus
  lue/écrite par le code** (gardée volontairement le temps de valider la
  bascule ; suppression prévue dans une migration séparée, ne pas la
  réutiliser). Formulaires (ajout + édition inline) et "Vue par
  consultant" utilisent tous `consultant_ids[]` (checkboxes) / la
  relation `consultants` — une tâche à N consultants apparaît dans les N
  groupes de la vue par consultant.
  **Timeline et tâches datées dans le passé (2026-07-23)** : le scroll
  horizontal automatique au chargement centre la vue sur "aujourd'hui"
  (`$todayPosition`), ce qui peut laisser hors champ une tâche dont la
  date est loin dans le passé (ou le futur) — elle existe bien dans le
  DOM mais semble "ne pas apparaître" dans la timeline. Fix : après
  `storeTache`/`updateTache`, le contrôleur flashe `scrollToTacheId` en
  session ; `Gantt.blade.php` calcule `$scrollTargetLeft` = position du
  **milieu de `[date_debut, date_fin]`** de cette tâche et centre le
  scroll dessus au chargement si présent (sinon comportement par défaut,
  centré sur aujourd'hui). Ce milieu fonctionne aussi pour une tâche en
  **report** sans traitement spécial : `date_fin` est recalculée après la
  reprise (`GanttTacheDateCalculator::resoudrePourPhase`), donc le milieu
  de l'intervalle tombe naturellement dans/près de la fenêtre de pause
  `[date_interruption, date_reprise]`, quelle que soit sa durée — vérifié
  en tinker avec une pause de 3 mois (milieu tombe bien dedans).
  **`affectations.jours_realises` = calculé depuis Gantt (2026-07-23)** :
  ce champ n'est plus saisi manuellement (formulaires nouveau-projet/
  edit-projet : champ retiré / affiché en lecture seule) — il est
  recalculé par `App\Services\AffectationChargeService::recalculerPourProjet($projetId)`,
  qui fait la somme de `ct_realisee` de toutes les tâches Gantt du projet
  assignées à ce consultant (via `GanttTache::consultants()`). Une tâche
  assignée à une équipe compte pour le **total complet** chez chaque
  consultant (pas de répartition/division). Appelé après tout
  create/update/delete de tâche Gantt (`GanttController`) et après toute
  modification des affectations d'un projet (`EditController::update`).
  Ne pas réintroduire de saisie manuelle de ce champ.
  **Jours restants après un report ≠ CT Prévu − CT Réalisé (fix 2026-07-23)** :
  dans `GanttTacheDateCalculator::resoudrePourPhase()`, le nombre de jours
  du segment de réalisation APRÈS la reprise se calcule maintenant comme
  `CT Prévu − (jours ouvrés déjà couverts par le segment AVANT la pause)`
  (nouvelle méthode `joursOuvresDansIntervalle()`), plus le garde-fou
  "au moins 1 jour si < 100%" déjà existant (fix du 2026-07-22, préservé).
  L'ancienne formule (`CT Prévu − CT Réalisé`) mélangeait deux notions
  différentes — CT Réalisé/avancement ne pilotent QUE le remplissage
  visuel (`repartirAvancement`), jamais la durée totale du bâton — et
  tombait à 0 dès que le segment avant la pause ne couvrait pas déjà
  exactement CT Prévu jours, même si CT Prévu n'était pas encore
  "physiquement" représenté quelque part sur la timeline (bug réel sur
  "Constitution du comité de pilotage" : CT Prévu=4/CT Réalisé=4/
  avancement=100% mais interruption posée après seulement 3 jours ouvrés
  → aucun segment après la reprise, bâton visuellement figé en plein
  report malgré les 100%). Vérifié : ne régresse pas le cas de
  dépassement (CT Réalisé > CT Prévu, avancement < 100%).
  Les champs `<input type="date">` de cette vue ont aussi `lang="fr"`
  (affichage DD/MM/YYYY plutôt que le format US du navigateur — dépend
  in fine du navigateur/OS de l'utilisateur, pas garanti à 100%).
- **Lien OneDrive/SharePoint par chapitre SMI (2026-07-24)** : remplace
  l'ancienne checklist de livrables (voir "Historique de features" plus
  bas) — colonne `suivi_chapitres.lien_onedrive` (nullable, un lien par
  couple projet↔chapitre, saisi dans `nouveau-projet.blade.php` /
  `edit-projet.blade.php`, affiché en lecture seule — bouton "Ouvrir le
  dossier" ou rien si vide, jamais de bouton désactivé — dans
  `details-projet.blade.php`). Validation souple (host `sharepoint.com`,
  `onedrive.live.com` ou `1drv.ms`), côté client (JS `checkOnedriveLink`)
  et serveur (règle Laravel `regex`) — ne pas restreindre à un seul de
  ces domaines.
- Preuves documentaires : projet uniquement (`ProjetPreuveController`),
  uploadées sur Cloudinary. (L'ancien système de preuves par livrable —
  `PreuveController`, tables `livrables_smi`/`projet_livrables`/
  `livrable_preuves` — a été retiré du code le 2026-07-24, voir
  "Historique de features" ; les tables restent en base, non lues par
  le code.)
- Tableau de bord PMO (`tableau-de-bord.blade.php`) — calcule ses propres
  KPI/heatmap/risques inline (`@php` + `DB::select`) ; ne dépend d'aucun
  contrôleur dédié
- Administration utilisateurs (`AdminUserController`, réservé
  `role:super_admin`)
- **Calendrier des tâches/missions** (type Outlook) — table `taches`
  (`client_id` nullable, `assigned_by` = qui a assigné, `titre`,
  `objectif`, `date`, `heure_debut`/`heure_fin`, `statut` enum
  `Assignée→Lue→Acceptée/Refusée/En cours/Terminée`, `lu_at`,
  `reponse_at`, `commentaire`) :
  - Côté **Super Admin uniquement** (`role:super_admin`, même pattern
    que `/admin/users`) : `Admin\CalendrierAdminController` — liste des
    consultants (`admin.calendrier-consultants`, indique lesquels ont un
    compte `User` lié) → calendrier d'un consultant précis
    (`admin.calendrier-consultant`) avec assignation/édition/suppression
    de tâches. Envoie `TacheAssigneeNotification` (canal `database`
    uniquement pour l'instant, pas d'email) au `User` lié au consultant
    s'il existe.
  - Côté **consultant connecté** : `CalendrierController` — "Mon
    calendrier" (`calendrier.blade.php`) filtré sur
    `auth()->user()->consultant_id` ; ouvrir une tâche la marque `Lue`
    (`lu_at`) ; le consultant répond via Accepter/Refuser/En cours/
    Terminée + commentaire libre.
  - **Contrainte à connaître** : un `Consultant` n'a pas toujours de
    compte `User` lié (voir `AdminUserController`) — une tâche assignée
    à un consultant sans compte est enregistrée mais personne ne peut la
    voir/y répondre tant qu'un compte n'est pas créé pour lui.
    **Rattrapage déjà en place** : `AdminUserController::store()`
    renvoie `TacheAssigneeNotification` pour toutes les tâches au statut
    `Assignée` du consultant au moment où son compte est créé (bug réel
    rencontré le 2026-07-15 — une tâche créée avant le compte ne
    déclenchait jamais de notification, même après coup)
  - Le lien "Calendrier" dans la navbar n'apparaît que si
    `auth()->user()->consultant_id` est renseigné (les comptes
    `super_admin` purs, sans profil consultant, n'ont pas de calendrier
    personnel — `CalendrierController::index` les redirige vers `/`
    sinon, silencieusement car `projets.blade.php` n'affiche pas
    `session('error')`)
  - Cloche de notifications dans `partials/navbar.blade.php` (badge =
    `unreadNotifications`, tout marquer lu au clic via
    `notifications.lire-tout`) — **3 vues n'ont pas de meta
    `csrf-token`** (`consultants.blade.php`, `details-projet.blade.php`,
    `tableau-de-bord.blade.php`) : le JS de la cloche a un garde-fou et
    ne plante pas dessus, mais le badge ne se videra pas tant qu'on n'a
    pas visité une page qui a bien le meta tag.
  - Grid mois/semaine construite à la main (Bootstrap + vanilla JS,
    pas de FullCalendar) — la logique de construction du grid
    (`$jours`, décalage lundi-dimanche) est dupliquée entre
    `calendrier.blade.php` et `admin/calendrier-consultant.blade.php` ;
    si un 3ème usage apparaît, l'extraire dans un partial/service.
- Sensibilisation (thème + photo Cloudinary par projet) — modèle
  `Sensibilisation` (`hasMany` sur `Projet`), table `sensibilisations`.
  Gérée aux 3 endroits :
  - Création : `nouveau-projet.blade.php` (Section H) →
    `NouveauProjetController::store`
  - Édition : `edit-projet.blade.php` (Section H, lignes préremplies avec
    `existing_photo_path` en hidden pour ne pas perdre la photo si aucun
    nouveau fichier n'est choisi) → `EditController::update` fait un
    wipe-and-reinsert (`Sensibilisation::where('projet_id',...)->delete()`
    puis recréation depuis le tableau soumis), exactement comme
    `custom_formations` — retirer une ligne côté JS suffit à la supprimer,
    pas besoin de `deleted_sensibilisations[]`
  - Lecture : `details-projet.blade.php` — **attention**, cette vue
    n'utilise PAS le `$projet` Eloquent passé par le contrôleur ; elle
    réécrase `$projet` avec un `DB::selectOne(...)` (stdClass) dès le
    haut du `<body>` (basé sur `request()->route('id')`, pas sur les
    variables du contrôleur). La section Sensibilisation y utilise donc
    une requête `DB::table('sensibilisations')->where('projet_id', $id)`
    dédiée, pas `$projet->sensibilisations`. Le rendu réutilise le pattern
    existant `.intervention-card`/`.intervention-grid` (déjà utilisé pour
    "Fichiers d'intervention du projet") avec les fonctions JS globales
    `viewDocument()` (aperçu + bouton télécharger dans la modale),
    `downloadFile()` et `printDocumentUrl()` — mime toujours forcé à
    `'image/jpeg'` car la validation n'accepte que des images

## Conventions de code

- Les contrôleurs web utilisent des transactions (`DB::beginTransaction`)
  pour toute opération multi-tables (création/mise à jour/suppression de
  projet) — à conserver pour toute nouvelle logique similaire
- Messages flash avec emojis (`✅`, `❌`) dans les réponses `back()->with(...)`
- Certains commentaires historiques sont en arabe/darija (`app/Models`,
  quelques contrôleurs) — ne pas s'étonner, ne pas traduire sans demande
  explicite
- Les validations `Projet` sont dupliquées entre `EditController::update`
  et `Api\ProjetController::update` avec des règles parfois différentes —
  vérifier les deux si tu modifies une règle de validation d'un champ
  `Projet` (pas encore unifié, hors scope du nettoyage backend fait le
  2026-07-15)
- **`details-projet.blade.php` ignore le `$projet` Eloquent envoyé par
  `EditController::show`** : dès le `<body>`, un bloc `@php` fait
  `$id = request()->route('id')` puis `$projet = DB::selectOne(...)`
  (stdClass), et toutes les données affichées (`$formations`, `$normes`,
  `$consultants`, `$chapitres`, etc.) viennent de requêtes `DB::` locales
  au fichier, pas des relations Eloquent chargées par le contrôleur.
  Toute nouvelle section ajoutée à cette vue doit suivre ce même style
  (requête `DB::table(...)->where('projet_id', $id)`), sinon `$projet->x`
  plante avec `Undefined property: stdClass::$x`
- Le calcul d'`avancement_percent` passe désormais par
  `App\Services\ProjetProgressService::recalculerAvancement()` (moyenne
  des Av.% par chapitre, voir plus haut) — ne pas réintroduire de bloc de
  calcul dupliqué dans un contrôleur, appeler le service à la place.
  `jours_realises` est saisi manuellement (projet) / recalculé depuis le
  Gantt (par consultant, voir `AffectationChargeService`)

## Règles de sécurité

- `routes/api.php` est enveloppé dans `Route::middleware(['auth'])`, mais
  reste non chargé par l'app (voir Architecture) — si quelqu'un
  l'enregistre un jour dans `bootstrap/app.php`, garder ce middleware ;
  ne jamais retirer le `auth` de ce groupe
- **`/download-file` et `/view-file`** (`routes/web.php`) valident que
  `parse_url($url, PHP_URL_HOST) === 'res.cloudinary.com'` avant tout
  `file_get_contents($url)` — ne pas retirer cette vérification (SSRF),
  et l'adapter (pas la supprimer) si un autre host de stockage est ajouté
- Ne jamais committer les clés Cloudinary/DB (`.env`) — vérifier
  `.gitignore` avant tout commit incluant des fichiers de config
- Le middleware `permission:` (`CheckPermission`) et `role:`
  (`CheckRole`) sont la seule source de vérité pour les droits d'accès —
  ne pas dupliquer une logique de rôle ad hoc dans un contrôleur

## Commandes utiles

- `composer run dev` — lance serveur + queue + logs (`pail`) + Vite en
  parallèle
- `php artisan migrate` — `livrables_smi`, `projet_livrables` et
  `livrable_preuves` existent toujours en base (migrations
  `2026_03_19_124300_*`/`2026_03_19_124320_*`/`2026_03_19_124339_*`) mais
  ne sont plus lues par le code depuis le 2026-07-24 (voir "Historique de
  features") — ne pas y écrire de nouvelle logique
- `php artisan db:seed --class=LivrablesSmiSeeder` — peuplait
  `livrables_smi`, devenu inutile depuis le retrait de la checklist de
  livrables (2026-07-24), gardé pour ne pas casser un environnement qui
  l'exécuterait encore
- `npm run dev` / `npm run build` — Vite (Tailwind + build JS), impact
  limité puisque les vues actuelles n'en dépendent pas directement

## À ne jamais modifier ou supprimer sans validation

- Les migrations existantes ne doivent pas être modifiées a posteriori
  (Laravel) — toute correction de schéma doit passer par une nouvelle
  migration, jamais par l'édition d'une migration déjà exécutée en
  production
- Ne pas lancer de migration destructive (`migrate:fresh`,
  `migrate:reset`) sans confirmation explicite
- Ne jamais retirer la validation d'host Cloudinary dans
  `/download-file`/`/view-file`, ni le `auth` sur le groupe de
  `routes/api.php`
- Ne jamais exécuter de commit git sans demande explicite de l'utilisateur

## Historique de nettoyage (2026-07-15)

Passe de nettoyage backend effectuée (voir plan
`C:\Users\pc\.claude\plans\imperative-discovering-flute.md`) :
- `dd()` de debug retiré de `Api\ProjetController::destroy` (cascade
  delete + transaction, comme `EditController::destroy`)
- SSRF corrigée sur `/download-file` et `/view-file` (whitelist host
  Cloudinary)
- `routes/api.php` enveloppé dans `auth` (mais toujours non chargé, voir
  Architecture générale)
- Migrations `livrables_smi`/`projet_livrables` ajoutées (guard
  `Schema::hasTable`, no-op sur la base existante)
- Supprimé : `app/Http/NouveauProjetController.php` (doublon mort) et
  `app/Http/Controllers/PMODashboardController.php` (mort + requête
  cassée sur une colonne `nom_projet` inexistante)
- Calcul d'avancement dédupliqué dans `App\Services\ProjetProgressService`
- Non traité (volontairement, risque visuel) : duplication Bootstrap
  CDN / absence de layout Blade partagé, incohérences de validation
  `Projet` entre contrôleurs, nettoyage `package.json`

## Historique de features (2026-07-15)

- Ajout du module **Sensibilisation** (table `sensibilisations`, modèle
  `Sensibilisation`, relation `Projet::sensibilisations()`). Uploadée sur
  Cloudinary (`lmc/sensibilisations`) comme le logo client. Disponible à
  la création (`nouveau-projet.blade.php`), à l'édition
  (`edit-projet.blade.php`, wipe-and-reinsert) et en lecture
  (`details-projet.blade.php`, requête `DB::table` dédiée — voir la note
  sur le `$projet` stdClass de cette vue ci-dessus).

## Historique de features (2026-07-24)

- **Retrait de la checklist de livrables, remplacée par un lien
  OneDrive/SharePoint par chapitre** (colonne "LIVRABLES" du tableau
  "F - Suivi des chapitres SMI"). Décision produit : les fichiers vivent
  dans un dossier OneDrive/SharePoint d'entreprise organisé par chapitre,
  pas dans l'app.
  - Migration `2026_07_24_100000_add_lien_onedrive_to_suivi_chapitres_table.php`
    ajoute `suivi_chapitres.lien_onedrive` (nullable) — un lien par
    couple projet↔chapitre, pas de nouvelle table (`suivi_chapitres` a
    déjà exactement cette granularité).
  - Supprimés : `app/Http/Controllers/LivrablesController.php`,
    `app/Http/Controllers/PreuveController.php`, les routes
    `projet.livrables.save`/`.single`, `preuves.upload`, `preuves.destroy`.
    Le JS de preuves-par-livrable dans `edit-projet.blade.php` et
    `details-projet.blade.php` (upload/viewer/print par livrable) a été
    retiré ; le viewer/modal partagé (`viewDocument`/`closePreuveViewer`/
    `preuveViewerModal`) reste, il sert toujours aux "Fichiers
    d'intervention du projet" (`ProjetPreuveController`).
  - **Tables `livrables_smi`/`projet_livrables`/`livrable_preuves`
    conservées en base sans suppression** (décision explicite — pas de
    perte de données si un projet réel avait des livrables/preuves
    saisis avant ce changement) mais plus aucun code applicatif ne les
    lit ni ne les écrit.
  - **`avancement_percent` change de source** : avant, calculé à 100%
    depuis le ratio de livrables Terminé/Total (`ProjetProgressService`
    lisait `projet_livrables`) — pour chaque projet ET pour le "Av. %"
    par chapitre (`edit-projet.blade.php` l'affichait en readonly/auto).
    Maintenant : "Av. %" par chapitre redevient un champ saisi
    manuellement partout (comme il l'était déjà à la création dans
    `nouveau-projet.blade.php` — seul `edit-projet.blade.php` l'avait
    rendu readonly) et `avancement_percent` du projet =
    **moyenne des Av.% de tous ses chapitres**
    (`ProjetProgressService::recalculerAvancement()`, lit
    `suivi_chapitres.avancement_percent`). Recalculé après tout
    create/update de chapitres, à la fois dans
    `NouveauProjetController::store` (nouveau, n'appelait auparavant
    jamais ce service) et `EditController::update`.
  - **Connu et non traité** : `tableau-de-bord.blade.php` (KPI global de
    livrables `$livPct`/`$livStats`) et `Api\ProjetController::update`/
    `destroy` (code mort, non routé — voir Architecture générale)
    interrogent encore `projet_livrables` directement. Comme plus aucune
    ligne n'y est créée depuis ce changement, ce KPI du dashboard PMO va
    rester figé sur les anciennes données (ou à 0 pour un projet créé
    après le 2026-07-24) — à corriger si quelqu'un remarque ce chiffre
    incohérent sur le dashboard.