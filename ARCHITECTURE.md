# Architecture du code source — LMC Conseil

> Documentation générée par exploration directe du code source (pas de
> déploiement, pas d'hébergement — uniquement la structure et l'organisation
> du code tel qu'il existe dans ce dépôt). Laravel 12 / PHP 8.2, vues Blade
> pures, SQLite en dev / MySQL en local.

---

## 1. Arborescence complète du projet

Arborescence réelle (hors `vendor/`, `node_modules/`, `.git/`,
`storage/framework/*`, `storage/logs/*` — dossiers générés/dépendances) :

```
lmc-conseil/
├── app/
│   ├── Helpers/
│   │   └── CloudinaryHelper.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── CalendrierAdminController.php
│   │   │   ├── Api/
│   │   │   │   ├── AffectationController.php
│   │   │   │   ├── ChapitreSmiController.php
│   │   │   │   ├── ClientController.php
│   │   │   │   ├── ConsultantController.php
│   │   │   │   ├── FormationController.php
│   │   │   │   ├── NormeController.php
│   │   │   │   ├── ProjetController.php
│   │   │   │   ├── ProjetFormationController.php
│   │   │   │   ├── ProjetNormeController.php
│   │   │   │   └── SuiviChapitreController.php
│   │   │   ├── AdminUserController.php
│   │   │   ├── AuthController.php
│   │   │   ├── CalendrierController.php
│   │   │   ├── ConsultantController.php
│   │   │   ├── Controller.php               (classe abstraite de base, vide)
│   │   │   ├── EditController.php
│   │   │   ├── GanttController.php
│   │   │   ├── NouveauProjetController.php
│   │   │   ├── ProjetPreuveController.php
│   │   │   ├── RegisterController.php
│   │   │   └── VerifyEmailController.php
│   │   └── Middleware/
│   │       ├── CheckPermission.php
│   │       ├── CheckRole.php
│   │       └── EnsureAccountApproved.php
│   ├── Mail/
│   │   ├── CompteApprouveMail.php
│   │   ├── CompteRefuseMail.php
│   │   └── VerifyAccountMail.php
│   ├── Models/
│   │   ├── AccesAuditLog.php
│   │   ├── Affectation.php
│   │   ├── ChapitreSmi.php
│   │   ├── Client.php
│   │   ├── Consultant.php
│   │   ├── Formation.php
│   │   ├── GanttPhase.php
│   │   ├── GanttTache.php
│   │   ├── Norme.php
│   │   ├── Projet.php
│   │   ├── ProjetFormation.php
│   │   ├── ProjetNorme.php               (vide, sans relations)
│   │   ├── Sensibilisation.php
│   │   ├── SuiviChapitre.php
│   │   ├── Tache.php
│   │   └── User.php
│   ├── Notifications/
│   │   ├── ProjetAssigneNotification.php
│   │   ├── ProjetRetireNotification.php
│   │   ├── TacheAssigneeNotification.php
│   │   └── TacheRepondueNotification.php
│   ├── Observers/
│   │   └── TacheObserver.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/
│       ├── AffectationChargeService.php
│       ├── GanttDateService.php          (façade de compatibilité, voir §6)
│       ├── GanttTacheDateCalculator.php
│       ├── GanttTemplateService.php
│       ├── OutlookSyncService.php
│       ├── ProjetAccessNotifier.php
│       └── ProjetProgressService.php
│   (aucun dossier app/Jobs — pas de Job custom, voir §7)
│
├── bootstrap/
│   ├── app.php                # config centrale Laravel 12 (routing, middleware aliases)
│   ├── cache/                 # cache framework généré (packages.php, services.php)
│   └── providers.php
│
├── config/
│   ├── app.php, auth.php, cache.php, cloudinary.php, database.php,
│   │   filesystems.php, logging.php, mail.php, queue.php, services.php,
│   │   session.php            # config Laravel standard (Cloudinary inclus)
│
├── database/
│   ├── database.sqlite        # base SQLite locale (seules les tables Laravel
│   │                             de base y sont migrées actuellement, voir §11)
│   ├── factories/              # ClientFactory, ConsultantFactory, ProjetFactory,
│   │                             TacheFactory, UserFactory
│   ├── migrations/             # 43 fichiers, voir §5
│   └── seeders/
│       ├── DatabaseSeeder.php       # ⚠️ TRUNCATE plusieurs tables, jamais
│       │                              lancer sans --class (voir CLAUDE.md)
│       ├── GanttTemplateSeeder.php
│       └── LivrablesSmiSeeder.php   # peuple livrables_smi (module retiré)
│
├── public/
│   ├── index.php, .htaccess, robots.txt, favicon.ico
│   ├── images/ (favicon.svg, lmc-logo.png)
│   ├── js/form-persist.js         # brouillon auto de formulaires, chargé par la navbar, voir §13.0
│   └── storage/                # lien symbolique vers storage/app/public
│
├── resources/
│   ├── css/app.css
│   ├── js/ (app.js, bootstrap.js)          # présents mais peu utilisés (Bootstrap CDN)
│   └── views/                              # 24 fichiers Blade, voir §10
│
├── routes/
│   ├── web.php                # toutes les routes actives de l'app
│   ├── api.php                # défini mais NON chargé par bootstrap/app.php
│   └── console.php            # 1 commande artisan custom ("inspire")
│
├── storage/
│   ├── app/ (private/, public/ — fichiers legacy pré-Cloudinary : preuves/,
│   │         preuves_livrables/, preuves_projet/)
│   ├── framework/ (cache, sessions, views compilées — généré)
│   └── logs/laravel.log
│
├── tests/
│   ├── Feature/ (AdminAccesTest, CalendrierTest, ExampleTest,
│   │             ProjetNotificationsTest, RegistrationApprovalTest)
│   ├── Unit/ (ExampleTest, GanttTacheDateCalculatorTest)
│   └── TestCase.php
│
├── artisan
├── composer.json / composer.lock
├── package.json / package-lock.json
├── phpunit.xml
├── vite.config.js
└── CLAUDE.md
```

### Rôle des dossiers principaux

| Dossier | Rôle |
|---|---|
| `app/Models` | Entités Eloquent du domaine métier (clients, projets, consultants, Gantt, tâches...) |
| `app/Http/Controllers` | Un contrôleur par vue/fonctionnalité web ; sous-dossier `Api/` = CRUD REST non routé (voir §4) ; sous-dossier `Admin/` = fonctionnalités réservées au super admin |
| `app/Http/Middleware` | Contrôle d'accès : rôle, permission, statut de compte |
| `app/Services` | Logique métier réutilisable et centralisée (calculs Gantt, avancement, notifications d'accès) |
| `app/Notifications` / `app/Mail` | Notifications multi-canal (base de données + email) et emails transactionnels |
| `app/Observers` | Hooks sur le cycle de vie des modèles Eloquent |
| `app/Helpers` | Fonctions globales (`cloudinary_url()`) |
| `database/migrations` | Historique complet et chronologique du schéma SQL |
| `database/seeders` | Données de démonstration / données de référence (à lancer explicitement) |
| `resources/views` | Vues Blade autonomes (pas de layout partagé, sauf `partials/navbar.blade.php`) |
| `routes` | Déclaration des routes HTTP (`web.php` actif, `api.php` inactif) |
| `config` | Configuration Laravel standard, y compris Cloudinary |
| `storage` | Fichiers legacy uploadés localement (avant migration vers Cloudinary), logs, cache framework |
| `tests` | Tests Feature (HTTP, flux applicatifs) et Unit (logique pure, ex. calculateur de dates Gantt) |

---

## 2. Modèles Eloquent (`app/Models/`)

16 modèles au total.

### `Projet`
- **Table** : `projets`
- **Colonnes principales** : `reference_projet` (unique), `client_id` (FK),
  `chef_projet_id` (FK → `consultants`), `type_projet`, `statut` (enum),
  `jours_prevus`, `jours_realises`, `avancement_percent`, `blocage`,
  `commentaire`, `date_debut`, `date_fin_prevue`, `date_fin_reelle`
- **Relations** : `belongsTo Client`, `belongsTo Consultant` (`chefProjet`),
  `belongsToMany Norme` (pivot `projet_normes`), `hasMany Affectation`,
  `belongsToMany Consultant` (via `affectations`, avec pivot),
  `hasMany SuiviChapitre`, `hasMany GanttPhase`,
  `belongsToMany Formation` (pivot `projet_formations`),
  `hasMany Sensibilisation`, `belongsToMany User` (`usersAccesDirect`, pivot
  `user_projet_access`)
- **Rôle** : entité centrale de l'application — un mandat/mission client.
  Porte le scope `visiblesPour(User)` (seule source de vérité pour la
  visibilité d'un projet selon le rôle/staffing/accès direct de
  l'utilisateur). Attributs calculés : `conso_jours_percent`, `ecart_jours`.

### `Client`
- **Table** : `clients`
- **Colonnes** : `nom_client`, `secteur_activite`, `adresse`, `telephone`,
  `email_contact`, `logo_path`
- **Relations** : `hasMany Projet`
- **Rôle** : entreprise cliente d'une mission.

### `Consultant`
- **Table** : `consultants`
- **Colonnes** : `nom_complet`, `type_consultant` (enum `Interne`/
  `Freelancer`/`Externe`), `specialite`, `email`, `telephone`, `actif`
- **Relations** : `belongsToMany Projet` (via `affectations`),
  `hasMany Projet` (`projetsDiriges`, via `chef_projet_id`),
  `hasMany Tache`
- **Rôle** : consultant QSE, staffé sur des projets ; peut avoir un compte
  `User` lié ou non.

### `Affectation`
- **Table** : `affectations` (pivot enrichi projet↔consultant)
- **Colonnes** : `projet_id`, `consultant_id`, `role_dans_projet`,
  `jours_alloues`, `jours_realises`
- **Relations** : `belongsTo Projet`, `belongsTo Consultant`
- **Rôle** : staffing d'un consultant sur un projet. Attributs calculés :
  `charge_percent`, `jours_restants`, `est_complete`, `charge_color`.
  `jours_realises` est recalculé depuis les tâches Gantt
  (`AffectationChargeService`), plus saisi manuellement.

### `ChapitreSmi`
- **Table** : `chapitres_smis`
- **Colonnes** : `code_chapitre`, `titre_chapitre`, `exigences_cles`, `ordre`
- **Relations** : `hasMany SuiviChapitre`, `belongsToMany Projet` (via
  `suivi_chapitres`)
- **Rôle** : référentiel des chapitres normatifs SMI (§4 à §10, ISO
  9001/14001/45001), commun à tous les projets.

### `SuiviChapitre`
- **Table** : `suivi_chapitres`
- **Colonnes** : `projet_id`, `chapitre_id`, `avancement_percent`, `phase`
  (enum emoji), `jours_intervention`, `statut_livrables`, `lien_onedrive`,
  `observations`
- **Relations** : `belongsTo Projet`, `belongsTo ChapitreSmi`
- **Rôle** : suivi d'avancement d'un chapitre SMI pour un projet donné —
  granularité projet↔chapitre. Porte le lien OneDrive/SharePoint des
  livrables de ce chapitre (remplace l'ancien système de livrables, voir
  CLAUDE.md).

### `Formation`
- **Table** : `formations`
- **Colonnes** : `titre_formation`, `description`
- **Relations** : `belongsToMany Projet` (pivot `projet_formations`)
- **Rôle** : catalogue des formations proposées/réalisées.

### `ProjetFormation`
- **Table** : `projet_formations`
- **Colonnes** : `projet_id`, `formation_id`, `statut` (enum), `observations`,
  `jours_realises`, `date_realisation`
- **Relations** : `belongsTo Projet`, `belongsTo Formation`
- **Rôle** : pivot enrichi projet↔formation ; attribut calculé
  `statut_color`.

### `Norme`
- **Table** : `normes`
- **Colonnes** : `code_norme`, `description`
- **Relations** : `belongsToMany Projet` (pivot `projet_normes`)
- **Rôle** : référentiel normatif applicable (ISO 9001/14001/45001, ISO
  31007:2025...) qu'un projet peut cocher.

### `ProjetNorme`
- **Table** : `projet_normes` (déduite par convention)
- **Colonnes/relations** : aucune — classe vide, la table pivot est gérée
  directement via les relations `belongsToMany` de `Projet`/`Norme`
- **Rôle** : classe présente mais non utilisée pour porter de logique.

### `GanttPhase`
- **Table** : `gantt_phases`
- **Colonnes** : `projet_id`, `nom`, `ordre`
- **Relations** : `belongsTo Projet`, `hasMany GanttTache` (`taches`)
- **Rôle** : regroupement de tâches Gantt (8 phases standard SMI). Attributs
  calculés : `ct_prevu_total`, `ct_realise_total`, `ecart_total`,
  `avancement_moyen`.

### `GanttTache`
- **Table** : `gantt_taches`
- **Colonnes** : `projet_id`, `phase_id`, `numero`, `designation`, `unite`,
  `responsable`, `ct_prevue`, `ct_realisee`, `avancement`, `type_tache`
  (`phase`/`journee`), `date_debut`, `date_fin`, `date_interruption`,
  `jours_choisis` (JSON), `date_reprise`, `segments` (JSON)
- **Relations** : `belongsTo GanttPhase`, `belongsTo Projet`,
  `belongsToMany Consultant` (pivot `gantt_tache_consultant`)
- **Rôle** : tâche unitaire du planning Gantt d'un projet. Attribut calculé
  `ecart` (CT Prévu − CT Réalisé) ; méthodes `isJournee()`, `hasReport()`.

### `Sensibilisation`
- **Table** : `sensibilisations`
- **Colonnes** : `projet_id`, `theme`, `photo_path`, `jours_prevus`,
  `date_realisation`
- **Relations** : `belongsTo Projet`
- **Rôle** : action de sensibilisation réalisée sur un projet, avec photo
  Cloudinary justificative.

### `Tache`
- **Table** : `taches`
- **Colonnes** : `consultant_id`, `client_id` (nullable), `assigned_by`
  (FK `users`), `titre`, `objectif`, `date`, `heure_debut`, `heure_fin`,
  `statut` (enum `Assignée→Lue→Acceptée/Refusée/En cours/Terminée`),
  `lu_at`, `reponse_at`, `commentaire`
- **Relations** : `belongsTo Consultant`, `belongsTo Client`,
  `belongsTo User` (`assignePar`)
- **Rôle** : mission/tâche de calendrier assignée à un consultant (module
  Calendrier). Méthode `toCalendarEvent()` pour le rendu FullCalendar.
  Observée par `TacheObserver` (création/mise à jour).

### `User`
- **Table** : `users`
- **Colonnes** : `name`, `prenom`, `nom`, `email`, `password`, `role` (enum
  `super_admin`/`chef_projet`/`consultant`), `consultant_id` (FK nullable),
  `permissions` (JSON), `statut_compte` (enum `en_attente`/`approuve`/
  `refuse`), `motif_refus`
- **Relations** : `belongsTo Consultant`, `belongsToMany Projet`
  (`projetsAccesDirect`, pivot `user_projet_access`)
- **Rôle** : compte applicatif. Implémente `MustVerifyEmail` + `Notifiable`.
  Porte `hasPermission()` (source unique de vérification des droits) et les
  helpers de rôle/statut de compte.

### `AccesAuditLog`
- **Table** : `acces_audit_log`
- **Colonnes** : `user_id`, `action` (enum `approuve`/`refuse`),
  `performed_by` (FK `users`), `details` ; pas de `updated_at`
  (`const UPDATED_AT = null`)
- **Relations** : `belongsTo User` (`user`), `belongsTo User`
  (`admin`, via `performed_by`)
- **Rôle** : journal d'audit des décisions d'approbation/refus de compte par
  un Super Admin.

---

## 3. Contrôleurs (`app/Http/Controllers/`)

22 fichiers (21 contrôleurs concrets + `Controller.php`, classe abstraite de
base sans méthode).

### `AuthController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `showLogin()` | Affiche le formulaire de connexion | `GET /login` |
| `login(Request)` | Authentifie ; bloque si compte non approuvé | `POST /login` |
| `logout(Request)` | Déconnecte, invalide la session | `POST /logout` |

### `RegisterController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `create()` | Affiche le formulaire d'inscription | `GET /register` |
| `store(Request)` | Crée un `User` (`statut_compte=en_attente`), envoie `VerifyAccountMail` | `POST /register` |

### `VerifyEmailController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `verify(Request, id, hash)` | Vérifie l'email d'un compte pas encore connecté (URL signée) | `GET /email/verify/{id}/{hash}` |

### `AdminUserController` (réservé `role:super_admin`)
| Méthode | Rôle | Route(s) |
|---|---|---|
| `index()` | Liste comptes approuvés/en attente + audit log | `GET /admin/users` |
| `update(Request, id)` | Modifie rôle/permissions/mot de passe d'un compte | `PUT /admin/users/{id}` |
| `approuver(Request, id)` | Approuve une inscription, lie/crée un `Consultant`, envoie `CompteApprouveMail`, notifie les tâches en attente | `PUT /admin/users/{id}/approuver` |
| `refuser(Request, id)` | Refuse une inscription, envoie `CompteRefuseMail` | `PUT /admin/users/{id}/refuser` |
| `mettreAJourAccesProjets(Request, id)` | Sync des accès directs projet (`user_projet_access`), notifie ajout/retrait | `PUT /admin/users/{id}/projets` |
| `destroy(id)` | Supprime un compte (garde-fous : soi-même, dernier super admin) | `DELETE /admin/users/{id}` |

### `ConsultantController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `index()` | Liste des consultants | `GET /consultants` |
| `store(Request)` | Crée un consultant | `POST /consultants` |
| `update(Request, id)` | Modifie un consultant | `PUT /consultants/{id}` |
| `destroy(id)` | Supprime (garde-fous chef de projet / compte lié), cascade affectations + tâches | `DELETE /consultants/{id}` |

### `CalendrierController` (consultant connecté — "Mon calendrier")
| Méthode | Rôle | Route(s) |
|---|---|---|
| `index(Request)` | Affiche le calendrier du consultant connecté | `GET /calendrier` |
| `events(Request)` | Flux JSON FullCalendar (filtré par dates) | `GET /calendrier/events` |
| `marquerLue(id)` | Marque une tâche lue | `POST /calendrier/taches/{id}/lire` |
| `marquerNotificationsLues()` | Marque toutes les notifications lues | `POST /notifications/lire-tout` |
| `repondre(Request, id)` | Réponse du consultant (statut + commentaire), notifie l'assignateur | `POST /calendrier/taches/{id}/repondre` |

### `Admin\CalendrierAdminController` (réservé `role:super_admin,chef_projet`)
| Méthode | Rôle | Route(s) |
|---|---|---|
| `index()` | Liste des consultants avec compte lié + tâches à venir | `GET /admin/calendrier` |
| `show(consultantId)` | Calendrier d'un consultant précis | `GET /admin/calendrier/{consultantId}` |
| `events(Request, consultantId)` | Flux JSON filtrable (client/statut/dates) | `GET /admin/calendrier/{consultantId}/events` |
| `store(Request, consultantId)` | Assigne une nouvelle tâche, notifie le consultant | `POST /admin/calendrier/{consultantId}/taches` |
| `update(Request, id)` | Modifie une tâche | `PUT /admin/calendrier/taches/{id}` |
| `destroy(id)` | Supprime une tâche | `DELETE /admin/calendrier/taches/{id}` |
| `deplacer(Request, id)` | Déplace/redimensionne (drag & drop) | `PATCH /admin/calendrier/taches/{id}/deplacer` |
| `viderCalendrier(consultantId)` | Supprime toutes les tâches du consultant | `DELETE /admin/calendrier/{consultantId}/vider` |

### `EditController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `show(id)` | Détails d'un projet (charge toutes les relations) | `GET /projet/{id}` |
| `edit(id)` | Formulaire d'édition (+ listes clients/consultants/normes/chapitres/formations/secteurs) | `GET /projet/{id}/edit` |
| `update(Request, id)` | Transaction complète : client (+ logo Cloudinary), projet, normes, consultants (+ notifications), chapitres, formations (wipe-and-reinsert), sensibilisations (wipe-and-reinsert), recalcul avancement | `PUT /projets/{id}` |
| `destroy(id)` | Suppression transactionnelle en cascade (affectations, normes, chapitres, formations, livrables legacy, projet, client si orphelin) | `DELETE /projets/{id}` |

### `NouveauProjetController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `create()` | Formulaire de création (+ référence auto `PRJ-XXX`) | `GET /nouveau-projet` |
| `store(Request)` | Transaction complète : client, projet, base Gantt standard (`GanttTemplateService`), normes, affectations, chapitres, formations, nouveaux consultants, sensibilisations | `POST /projets` |

### `GanttController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `show(Request, id)` | Affiche le Gantt (permission `voir_gantt`), groupé par phase ou consultant | `GET /projet/{id}/gantt` |
| `storePhase(Request, id)` | Ajoute une phase | `POST /projet/{id}/gantt/phase` |
| `updatePhase(Request, id, phaseId)` | Renomme une phase | `PUT /projet/{id}/gantt/phase/{phaseId}` |
| `destroyPhase(id, phaseId)` | Supprime une phase | `DELETE /projet/{id}/gantt/phase/{phaseId}` |
| `storeTache(Request, id, GanttTacheDateCalculator)` | Crée une tâche (calcul dates via service), sync consultants, recalcule charge | `POST /projet/{id}/gantt/tache` |
| `updateTache(Request, id, tacheId, GanttTacheDateCalculator)` | Modifie une tâche (gère aussi le report/interruption) | `PUT /projet/{id}/gantt/tache/{tacheId}/update` |
| `destroyTache(id, tacheId)` | Supprime une tâche, recalcule charge | `DELETE /projet/{id}/gantt/tache/{tacheId}` |
| `resoudreChampsType()` / `autoriser()` | Méthodes privées internes (validation type de tâche, permission `modifier_projets`) | — |

### `ProjetPreuveController`
| Méthode | Rôle | Route(s) |
|---|---|---|
| `upload(Request)` | Upload une preuve projet vers Cloudinary (`lmc/preuves_projet`), insert `projet_preuves` | `POST /preuves-projet/upload` |
| `destroy(id)` | Supprime une preuve | `DELETE /preuves-projet/{id}` |
| `index(projetId)` | Liste les preuves d'un projet | `GET /preuves-projet/{projetId}` |

*(les 3 méthodes vérifient l'accès via `Projet::visiblesPour(auth()->user())`)*

### `Api\ProjetController` (web + JSON — voir §4 pour le statut de routage)
| Méthode | Rôle |
|---|---|
| `index()` | Page principale liste des projets (WEB, montée sur `/`) |
| `store(Request)` | Création (+ normes, livrables legacy via `saveLivrables()`) |
| `show(id)` | JSON détaillé d'un projet |
| `update(Request, id)` | Mise à jour (+ normes, livrables legacy, formations) |
| `destroy(id)` | Suppression transactionnelle en cascade |
| `saveLivrables()` (privée) | Upsert `projet_livrables` (module legacy retiré du front, table conservée) |

*(référence une classe `App\Services\LivrablesSMI` importée mais inexistante
dans `app/Services/` — import mort, sans effet tant qu'elle n'est pas
invoquée)*

### `Api\ClientController`, `Api\ConsultantController`, `Api\AffectationController`, `Api\ChapitreSmiController`, `Api\FormationController`, `Api\NormeController`, `Api\ProjetFormationController`, `Api\SuiviChapitreController`
CRUD REST standard (`index`/`store`/`show`/`update`/`destroy`, réponses JSON)
pour chaque ressource correspondante. Déclarés comme `apiResource` dans
`routes/api.php` mais **non routés dans l'application actuelle** (voir §4).

### `Api\ProjetNormeController`
Squelette généré par `make:controller --resource`, toutes les méthodes sont
vides (aucune implémentation).

---

## 4. Routes

### 4.1 `routes/web.php` — actif (chargé par `bootstrap/app.php`)

**Non authentifiées**

| Méthode | URI | Nom | Contrôleur@méthode |
|---|---|---|---|
| GET | `/login` | `login` | `AuthController@showLogin` |
| POST | `/login` | — | `AuthController@login` |
| POST | `/logout` | `logout` | `AuthController@logout` |
| GET | `/register` | `register` | `RegisterController@create` |
| POST | `/register` | `register.store` | `RegisterController@store` |
| GET | `/email/verify/{id}/{hash}` (middleware `signed`) | `verification.verify` | `VerifyEmailController@verify` |

**Groupe `middleware(['auth', 'approuve'])`**

| Méthode | URI | Nom | Contrôleur@méthode | Permission/rôle additionnel |
|---|---|---|---|---|
| GET | `/` | `projets.index` | `Api\ProjetController@index` | — |
| GET | `/tableau-de-bord` | `tableau-de-bord` | closure inline (`view('tableau-de-bord')`) | `voir_tableau_bord` (vérifié dans la closure) |
| GET | `/projet/{id}` | `projet.details` | `EditController@show` | `voir_details` |
| GET | `/projet/{id}/gantt` | `gantt.show` | `GanttController@show` | `voir_gantt` (vérifié dans le contrôleur) |
| POST | `/projet/{id}/gantt/phase` | `gantt.phase.store` | `GanttController@storePhase` | `modifier_projets` |
| PUT | `/projet/{id}/gantt/phase/{phaseId}` | `gantt.phase.update` | `GanttController@updatePhase` | `modifier_projets` |
| DELETE | `/projet/{id}/gantt/phase/{phaseId}` | `gantt.phase.destroy` | `GanttController@destroyPhase` | `modifier_projets` |
| POST | `/projet/{id}/gantt/tache` | `gantt.tache.store` | `GanttController@storeTache` | `modifier_projets` |
| PUT | `/projet/{id}/gantt/tache/{tacheId}/update` | `gantt.tache.update` | `GanttController@updateTache` | `modifier_projets` |
| DELETE | `/projet/{id}/gantt/tache/{tacheId}` | `gantt.tache.destroy` | `GanttController@destroyTache` | `modifier_projets` |
| GET | `/nouveau-projet` | `projet.create` | `NouveauProjetController@create` | `creer_projets` |
| POST | `/projets` | `projets.store` | `NouveauProjetController@store` | `creer_projets` |
| GET | `/projet/{id}/edit` | `projet.edit` | `EditController@edit` | `modifier_projets` |
| PUT | `/projets/{id}` | `projets.update` | `EditController@update` | `modifier_projets` |
| DELETE | `/projets/{id}` | `projets.destroy` | `EditController@destroy` | `supprimer_projets` |
| GET | `/consultants` | `consultants.index` | `ConsultantController@index` | `voir_consultants` |
| POST | `/consultants` | `consultants.store` | `ConsultantController@store` | `creer_consultants` |
| PUT | `/consultants/{id}` | `consultants.update` | `ConsultantController@update` | `modifier_consultants` |
| DELETE | `/consultants/{id}` | `consultants.destroy` | `ConsultantController@destroy` | `supprimer_consultants` |
| GET | `/calendrier` | `calendrier.index` | `CalendrierController@index` | — |
| GET | `/calendrier/events` | `calendrier.events` | `CalendrierController@events` | — |
| POST | `/calendrier/taches/{id}/lire` | `calendrier.tache.lire` | `CalendrierController@marquerLue` | — |
| POST | `/calendrier/taches/{id}/repondre` | `calendrier.tache.repondre` | `CalendrierController@repondre` | — |
| POST | `/notifications/lire-tout` | `notifications.lire-tout` | `CalendrierController@marquerNotificationsLues` | — |
| GET | `/admin/users` | `admin.users` | `AdminUserController@index` | `role:super_admin` |
| PUT | `/admin/users/{id}` | `admin.users.update` | `AdminUserController@update` | `role:super_admin` |
| DELETE | `/admin/users/{id}` | `admin.users.destroy` | `AdminUserController@destroy` | `role:super_admin` |
| PUT | `/admin/users/{id}/approuver` | `admin.users.approuver` | `AdminUserController@approuver` | `role:super_admin` |
| PUT | `/admin/users/{id}/refuser` | `admin.users.refuser` | `AdminUserController@refuser` | `role:super_admin` |
| PUT | `/admin/users/{id}/projets` | `admin.users.projets.update` | `AdminUserController@mettreAJourAccesProjets` | `role:super_admin` |
| GET | `/admin/calendrier` | `admin.calendrier.index` | `CalendrierAdminController@index` | `role:super_admin,chef_projet` |
| GET | `/admin/calendrier/{consultantId}` | `admin.calendrier.show` | `CalendrierAdminController@show` | `role:super_admin,chef_projet` |
| GET | `/admin/calendrier/{consultantId}/events` | `admin.calendrier.events` | `CalendrierAdminController@events` | `role:super_admin,chef_projet` |
| POST | `/admin/calendrier/{consultantId}/taches` | `admin.calendrier.tache.store` | `CalendrierAdminController@store` | `role:super_admin,chef_projet` |
| PUT | `/admin/calendrier/taches/{id}` | `admin.calendrier.tache.update` | `CalendrierAdminController@update` | `role:super_admin,chef_projet` |
| PATCH | `/admin/calendrier/taches/{id}/deplacer` | `admin.calendrier.tache.deplacer` | `CalendrierAdminController@deplacer` | `role:super_admin,chef_projet` |
| DELETE | `/admin/calendrier/taches/{id}` | `admin.calendrier.tache.destroy` | `CalendrierAdminController@destroy` | `role:super_admin,chef_projet` |
| DELETE | `/admin/calendrier/{consultantId}/vider` | `admin.calendrier.vider` | `CalendrierAdminController@viderCalendrier` | `role:super_admin,chef_projet` |
| POST | `/preuves-projet/upload` | `preuves-projet.upload` | `ProjetPreuveController@upload` | `gerer_preuves` |
| DELETE | `/preuves-projet/{id}` | `preuves-projet.destroy` | `ProjetPreuveController@destroy` | `gerer_preuves` |
| GET | `/preuves-projet/{projetId}` | `preuves-projet.index` | `ProjetPreuveController@index` | `gerer_preuves` |

**Hors groupe (middleware `auth` seul)**

| Méthode | URI | Nom | Rôle |
|---|---|---|---|
| GET | `/download-file` | `file.download` | Closure — stream un fichier Cloudinary (host validé `res.cloudinary.com`) |
| GET | `/view-file` | `file.view` | Closure — affiche un PDF Cloudinary inline (même validation d'host) |

**Ajoutées automatiquement par le framework** (non déclarées dans `web.php`) :
`GET /up` (health check, `bootstrap/app.php`), `GET|PUT /storage/{path}`
(`storage.local`/`storage.local.upload`, service local file Laravel 12).

### 4.2 `routes/api.php` — déclaré mais **inactif**

`bootstrap/app.php` → `withRouting()` ne référence que `web`, `commands`,
`health` — pas de clé `api:`. Ce fichier n'est donc jamais chargé, mais
documenté ici pour exhaustivité :

```php
Route::middleware(['auth'])->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('consultants', ConsultantController::class);
    Route::apiResource('normes', NormeController::class);
    Route::apiResource('projets', ProjetController::class);
    Route::apiResource('chapitres', ChapitreSmiController::class);
    Route::apiResource('suivis-chapitres', SuiviChapitreController::class);
    Route::apiResource('formations', FormationController::class);
    Route::apiResource('projet-formations', ProjetFormationController::class);
    Route::apiResource('affectations', AffectationController::class);
});
```

9 `apiResource` (= 45 routes potentielles CRUD) qui n'existent pas
effectivement dans l'application tant que `api:` n'est pas ajouté à
`withRouting()`.

### 4.3 `routes/console.php`

1 commande artisan custom : `inspire` (citation inspirante, exemple par
défaut de Laravel).

---

## 5. Migrations (`database/migrations/`)

43 fichiers, ordre chronologique.

| Date | Fichier | Résumé |
|---|---|---|
| 0001-01-01 | `000000_create_users_table` | Crée `users`, `password_reset_tokens`, `sessions` |
| 0001-01-01 | `000001_create_cache_table` | Crée `cache`, `cache_locks` |
| 0001-01-01 | `000002_create_jobs_table` | Crée `jobs`, `job_batches`, `failed_jobs` |
| 2026-03-05 | `122745_create_clients_table` | Crée `clients` |
| 2026-03-05 | `122756_create_consultants_table` | Crée `consultants` |
| 2026-03-05 | `122831_create_normes_table` | Crée `normes` |
| 2026-03-05 | `122839_create_projets_table` | Crée `projets` (FK `client_id`, `chef_projet_id`) |
| 2026-03-05 | `123257_create_projet_normes_table` | Crée le pivot `projet_normes` |
| 2026-03-05 | `124941_create_chapitre_smis_table` | Crée `chapitres_smis` |
| 2026-03-05 | `124954_create_suivi_chapitres_table` | Crée `suivi_chapitres` (FK `projet_id`, `chapitre_id`) |
| 2026-03-05 | `125000_create_formations_table` | Crée `formations` |
| 2026-03-05 | `125006_create_projet_formations_table` | Crée le pivot enrichi `projet_formations` |
| 2026-03-05 | `125012_create_affectations_table` | Crée le pivot enrichi `affectations` |
| 2026-03-09 | `135412_add_role_to_users_table` | Ajoute `role` + `consultant_id` (FK) à `users` |
| 2026-03-10 | `100358_add_permissions_to_users_table` | Ajoute `permissions` (JSON) à `users` |
| 2026-03-10 | `112636_create_gantt_taches_table` | Crée `gantt_taches` (v1, avant refonte du 2026-07-16) |
| 2026-03-19 | `124300_create_livrables_smi_table` | Crée `livrables_smi` (guard `hasTable`) — module retiré depuis |
| 2026-03-19 | `124320_create_projet_livrables_table` | Crée `projet_livrables` (guard `hasTable`) — module retiré depuis |
| 2026-03-19 | `124339_livrable_preuves` | Crée `livrable_preuves` — module retiré depuis |
| 2026-03-19 | `132917_projet_preuves` | Crée `projet_preuves` (guard `hasTable`) — toujours utilisé (`ProjetPreuveController`) |
| 2026-07-14 | `123415_add_logo_path_to_clients_table` | Ajoute `logo_path` à `clients` |
| 2026-07-15 | `090000_create_sensibilisations_table` | Crée `sensibilisations` (v1, sans jours_prevus/date_realisation) |
| 2026-07-15 | `100000_create_taches_table` | Crée `taches` (module Calendrier) |
| 2026-07-15 | `100001_create_notifications_table` | Crée `notifications` (table standard Laravel, guard `hasTable`) |
| 2026-07-16 | `090000_create_gantt_phases_table` | Crée `gantt_phases` |
| 2026-07-16 | `090001_add_phase_and_date_fin_to_gantt_taches_table` | Ajoute `phase_id` (FK) + `date_fin` à `gantt_taches`, backfill avancement 0-1→0-100 |
| 2026-07-16 | `124744_add_statut_compte_to_users_table` | Ajoute `statut_compte`, `role_souhaite`, `motif_refus` à `users` |
| 2026-07-16 | `130555_update_users_table_for_registration_v2` | Ajoute `prenom`/`nom`, supprime `role_souhaite` |
| 2026-07-16 | `142022_create_acces_audit_log_table` | Crée `acces_audit_log` |
| 2026-07-16 | `142022_create_user_projet_access_table` | Crée `user_projet_access` (pivot accès direct) |
| 2026-07-17 | `120000_backfill_consultants_permissions` | Backfill des permissions `creer/modifier/supprimer_consultants` pour les comptes ayant déjà `voir_consultants` |
| 2026-07-18 | `150000_add_jours_realises_and_date_realisation_to_projet_formations_table` | Ajoute `jours_realises`, `date_realisation` à `projet_formations` |
| 2026-07-20 | `090000_add_jours_prevus_and_date_realisation_to_sensibilisations_table` | Ajoute `jours_prevus`, `date_realisation` à `sensibilisations` |
| 2026-07-21 | `090000_add_iso_31001_norme` | Insère la norme "ISO 31001:2025" (donnée, pas schéma) |
| 2026-07-21 | `100000_add_consultant_id_to_gantt_taches_table` | Ajoute `consultant_id` (FK, legacy non lu) à `gantt_taches` |
| 2026-07-21 | `110000_add_type_tache_fields_to_gantt_taches_table` | Ajoute `type_tache`, `jours_choisis` (JSON), `date_reprise` à `gantt_taches` |
| 2026-07-22 | `090000_add_date_interruption_and_restructure_report` | Ajoute `date_interruption`, migre les anciennes tâches `type_tache='report'` vers `'phase'` |
| 2026-07-22 | `100000_remove_unused_normes` | Supprime 8 normes non utilisées (0 usage vérifié dans `projet_normes`) |
| 2026-07-22 | `101000_add_iso_31007_norme` | Insère la norme "ISO 31007:2025" (donnée) |
| 2026-07-22 | `150000_add_segments_to_gantt_taches_table` | Ajoute `segments` (JSON) à `gantt_taches`, recalcule tous les segments existants |
| 2026-07-23 | `090000_create_gantt_tache_consultant_table` | Crée le pivot `gantt_tache_consultant`, backfill depuis `consultant_id` simple |
| 2026-07-24 | `090000_add_externe_to_consultants_type_enum` | Élargit l'ENUM `type_consultant` à `'Externe'` (⚠️ `ALTER ... ENUM` en SQL brut, syntaxe MySQL uniquement) |
| 2026-07-24 | `100000_add_lien_onedrive_to_suivi_chapitres_table` | Ajoute `lien_onedrive` à `suivi_chapitres` (remplace la checklist de livrables) |

---

## 6. Services (`app/Services/`)

7 classes.

### `ProjetProgressService`
- **Rôle** : source unique de calcul de `projets.avancement_percent`.
- **Méthode** : `recalculerAvancement(int $projetId): int` — moyenne des
  `suivi_chapitres.avancement_percent` du projet, persiste et retourne le
  résultat. Appelée depuis `EditController::update` et
  `NouveauProjetController::store`.

### `AffectationChargeService`
- **Rôle** : source unique de calcul de `affectations.jours_realises`.
- **Méthode** : `recalculerPourProjet(int $projetId): void` — somme
  `gantt_taches.ct_realisee` par consultant (via le pivot
  `gantt_tache_consultant`) et met à jour chaque `Affectation` du projet.
  Appelée après toute création/modification/suppression de tâche Gantt et
  après modification des affectations d'un projet.

### `GanttDateService`
- **Rôle** : façade de compatibilité conservée uniquement parce qu'une
  migration déjà exécutée (`2026_07_22_090000_...`) appelle
  `calculerDateFin()` en statique — ne jamais y ajouter de nouvelle logique.
- **Méthode** : `calculerDateFin(Carbon, float): Carbon` — délègue à
  `GanttTacheDateCalculator`.

### `GanttTacheDateCalculator`
- **Rôle** : centralise tout le calcul de dates/segments d'une tâche Gantt
  (jours ouvrés, découpage en blocs, gestion des reports/interruptions,
  répartition visuelle de l'avancement). Appelé uniquement au moment de
  l'enregistrement (jamais au rendu — `Gantt.blade.php` ne fait qu'une
  projection date→pixel du résultat déjà stocké en colonne `segments`).
- **Méthodes principales** : `ajouterJoursOuvres()`, `prochainJourOuvre()`,
  `calculerDateFin()`, `construireSegments()`, `calculerPourTache()`
  (point d'entrée), `resoudrePourJournee()` (privée),
  `resoudrePourPhase()` (privée), `resoudreConflitsJoursChoisis()`
  (privée), `joursOuvresDansIntervalle()` (privée).

### `GanttTemplateService`
- **Rôle** : fournit et applique la base standard de phases/tâches Gantt
  (8 phases, 41 tâches, méthodologie SMI ISO 9001/14001/45001).
- **Méthodes** : `phasesTaches(): array` (données statiques),
  `creerPour(int $projetId): void` (no-op si le projet a déjà des phases —
  appelé automatiquement à la création d'un projet et par
  `GanttTemplateSeeder`).

### `OutlookSyncService`
- **Rôle** : point d'extension pour un futur sync unidirectionnel vers
  Outlook (Microsoft Graph API) — actuellement un stub qui ne fait que
  logger, aucun appel API réel.
- **Méthode** : `sync(Tache $tache): void`. Appelée par `TacheObserver`.

### `ProjetAccessNotifier`
- **Rôle** : résout un `Consultant` (ou un `User` déjà connu) vers son
  compte `User` et déclenche la notification d'ajout/retrait d'accès à un
  projet, quel que soit le mécanisme d'origine (staffing, chef de projet,
  accès direct). Ne fait rien si le consultant n'a pas de compte lié.
- **Méthodes statiques** : `notifierAjout()`, `notifierRetrait()`,
  `resoudreUser()` (protégée).

---

## 7. Jobs (`app/Jobs/`)

**Aucun Job custom.** Le dossier `app/Jobs/` n'existe pas dans le code
source actuel. La table `jobs` (migration `0001_01_01_000002`) et la
configuration `queue.php` sont présentes mais servent uniquement aux
`ShouldQueue` des Notifications/Mailables (voir §8 et §9), pas à des Jobs
dédiés.

---

## 8. Observers (`app/Observers/`)

1 classe.

### `TacheObserver`
- **Modèle observé** : `Tache` (enregistré dans
  `AppServiceProvider::boot()` via `Tache::observe(TacheObserver::class)`)
- **Événements écoutés** :
  - `created(Tache $tache)` → appelle `OutlookSyncService::sync()`
  - `updated(Tache $tache)` → appelle `OutlookSyncService::sync()`
- **Rôle** : point d'accroche unique pour un futur sync Outlook, déclenché
  à chaque création/modification de tâche de calendrier.

---

## 9. Notifications (`app/Notifications/`) et Mailables (`app/Mail/`)

### Notifications (4 classes, toutes `ShouldQueue`, canaux `database` + `mail` conditionnels)

| Classe | Canal(aux) | Déclenchée par |
|---|---|---|
| `ProjetAssigneNotification` | `database` (+ `mail` si email présent) | `ProjetAccessNotifier::notifierAjout()` — affectation à un projet (staffing, chef de projet, ou accès direct) |
| `ProjetRetireNotification` | `database` (+ `mail` si email présent) | `ProjetAccessNotifier::notifierRetrait()` — retrait d'accès à un projet |
| `TacheAssigneeNotification` | `database` (+ `mail` si email présent) | `CalendrierAdminController::store()` (nouvelle tâche) et `AdminUserController::approuver()` (rattrapage des tâches en attente à l'approbation d'un compte) |
| `TacheRepondueNotification` | `database` (+ `mail` si email présent) | `CalendrierController::repondre()` — le consultant répond à une tâche |

Toutes utilisent des vues email dédiées dans `resources/views/emails/`
(`projet-assigne`, `projet-retire`, `tache-assignee`, `tache-repondue`).
Si le `notifiable` n'a pas d'email, seul le canal `database` est utilisé
(log de warning).

### Mailables (3 classes, toutes `ShouldQueue`)

| Classe | Déclenchée par | Vue |
|---|---|---|
| `VerifyAccountMail` | `RegisterController::store()` — inscription | `emails.verify-account` (lien signé temporaire, 60 min) |
| `CompteApprouveMail` | `AdminUserController::approuver()` | `emails.compte-approuve` |
| `CompteRefuseMail` | `AdminUserController::refuser()` | `emails.compte-refuse` |

---

## 10. Vues Blade principales (`resources/views/`)

26 fichiers, pas de layout `@extends` partagé (sauf inclusion du partial
navbar) — chaque vue est un document HTML autonome avec son propre `<head>`
et CDN Bootstrap 5.3.

### Authentification
| Vue | Rôle |
|---|---|
| `login.blade.php` | Formulaire de connexion |
| `register.blade.php` | Formulaire d'inscription |
| `errors/403.blade.php` | Page d'erreur accès refusé |

### Projets
| Vue | Rôle |
|---|---|
| `projets.blade.php` | Liste des projets (page d'accueil `/`) |
| `nouveau-projet.blade.php` | Formulaire de création complet (client, chapitres, normes, consultants, formations, sensibilisations) |
| `edit-projet.blade.php` | Formulaire d'édition complet (même structure que création) |
| `details-projet.blade.php` | Fiche détail d'un projet — ⚠️ réécrase `$projet` avec une requête `DB::` locale, n'utilise pas le `$projet` Eloquent du contrôleur |
| `tableau-de-bord.blade.php` | Dashboard PMO — KPI/heatmap/risques calculés inline (`@php` + `DB::select`) |

### Gantt
| Vue | Rôle |
|---|---|
| `Gantt.blade.php` | Planning Gantt d'un projet — timeline, phases/tâches, CRUD via modals |

### Consultants
| Vue | Rôle |
|---|---|
| `consultants.blade.php` | Liste et gestion des consultants |

### Calendrier
| Vue | Rôle |
|---|---|
| `calendrier.blade.php` | "Mon calendrier" (consultant connecté) |
| `admin/calendrier-consultants.blade.php` | Liste des consultants (Super Admin) pour choisir à qui assigner des tâches |
| `admin/calendrier-consultant.blade.php` | Calendrier d'un consultant précis, vue admin |
| `partials/calendrier-fullcalendar.blade.php` | Partial JS/grid FullCalendar partagé |

### Administration
| Vue | Rôle |
|---|---|
| `admin-users.blade.php` | Gestion des comptes utilisateurs (approbation, rôles, permissions, accès projets, audit log) |

### Emails (`emails/`)
| Vue | Rôle |
|---|---|
| `layout.blade.php` | Layout HTML commun aux emails |
| `verify-account.blade.php` | Email de vérification d'adresse |
| `compte-approuve.blade.php` | Email d'approbation de compte |
| `compte-refuse.blade.php` | Email de refus de compte |
| `projet-assigne.blade.php` | Email de notification d'affectation projet |
| `projet-retire.blade.php` | Email de notification de retrait d'accès projet |
| `tache-assignee.blade.php` | Email de nouvelle tâche assignée |
| `tache-repondue.blade.php` | Email de réponse à une tâche |

### Partagés / partials
| Vue | Rôle |
|---|---|
| `partials/navbar.blade.php` | Navbar principale, incluse via `@include('partials.navbar', ...)` par toutes les vues qui l'utilisent (`projets`, `nouveau-projet`, `edit-projet`, `details-projet`, `consultants`, `calendrier`, `Gantt`, `tableau-de-bord`, `admin-users`, `admin/calendrier-consultant(s)`, `errors/403`), inclut la cloche de notifications |
| `partials/client-logo-name.blade.php` | Partial affichage logo + nom client |
| `welcome.blade.php` | Vue par défaut Laravel (landing page framework, probablement inutilisée en pratique) |

---

## 11. Structure de la base de données

> **Correction** : la connexion réellement active est **MySQL**
> (`DB_CONNECTION=mysql`, base `lmc_conseil_db`, voir `.env`) — pas le
> fichier `database/database.sqlite` du dépôt, qui est un reliquat
> quasi-vide (seules les tables système Laravel y existent, jamais
> migrées). `php artisan migrate:status` confirme que les 43 migrations
> sont bien `Ran` sur cette base MySQL, et un comptage réel des lignes
> (2026-07-28) donne : `projets` (4), `clients` (4), `consultants` (9),
> `affectations` (13), `gantt_taches` (164, dont 160 `type_tache=phase` et
> 4 `type_tache=journee`), `gantt_phases` (32), `chapitres_smis` (7),
> `suivi_chapitres` (28), `normes` (7), `formations` (8),
> `livrables_smi` (90, legacy), `projet_livrables` (77, legacy),
> `users` (3), `taches` (2), `notifications` (10),
> `acces_audit_log` (1), `user_projet_access` (1) — les autres tables
> métier (`projet_formations`, `sensibilisations`, `projet_preuves`,
> `livrable_preuves`) sont vides actuellement. Schéma ci-dessous déduit des
> migrations (source de vérité du code — voir §5), confirmé par cette
> lecture directe de la base réelle.

### Tables métier et leurs relations (FK)

| Table | Colonnes principales | Clés étrangères |
|---|---|---|
| `clients` | `nom_client`, `secteur_activite`, `adresse`, `telephone`, `email_contact`, `logo_path` | — |
| `consultants` | `nom_complet`, `type_consultant` (enum), `specialite`, `email`, `telephone`, `actif` | — |
| `normes` | `code_norme`, `description` | — |
| `projets` | `reference_projet` (unique), `client_id`, `chef_projet_id`, `type_projet`, `statut`, `jours_prevus`, `jours_realises`, `avancement_percent`, `blocage`, `commentaire`, `date_debut`, `date_fin_prevue`, `date_fin_reelle` | `client_id → clients.id` (cascade), `chef_projet_id → consultants.id` (cascade) |
| `projet_normes` | (pivot) | `projet_id → projets.id` (cascade), `norme_id → normes.id` (cascade) |
| `chapitres_smis` | `code_chapitre`, `titre_chapitre`, `exigences_cles`, `ordre` | — |
| `suivi_chapitres` | `avancement_percent`, `phase` (enum), `jours_intervention`, `statut_livrables`, `lien_onedrive`, `observations` | `projet_id → projets.id` (cascade), `chapitre_id → chapitres_smis.id` (cascade) |
| `formations` | `titre_formation`, `description` | — |
| `projet_formations` | (pivot enrichi) `statut` (enum), `observations`, `jours_realises`, `date_realisation` | `projet_id → projets.id` (cascade), `formation_id → formations.id` (cascade) |
| `affectations` | (pivot enrichi) `role_dans_projet`, `jours_alloues`, `jours_realises` | `projet_id → projets.id` (cascade), `consultant_id → consultants.id` (cascade) |
| `sensibilisations` | `theme`, `photo_path`, `jours_prevus`, `date_realisation` | `projet_id → projets.id` (cascade) |
| `gantt_phases` | `nom`, `ordre` | `projet_id → projets.id` (cascade) |
| `gantt_taches` | `numero`, `designation`, `unite`, `responsable`, `ct_prevue`, `ct_realisee`, `avancement`, `type_tache`, `date_debut`, `date_fin`, `date_interruption`, `jours_choisis` (JSON), `date_reprise`, `segments` (JSON), `consultant_id` (legacy, non lu par le code) | `projet_id → projets.id` (cascade), `phase_id → gantt_phases.id` (nullOnDelete), `consultant_id → consultants.id` (legacy, nullOnDelete) |
| `gantt_tache_consultant` | (pivot) unique `[gantt_tache_id, consultant_id]` | `gantt_tache_id → gantt_taches.id` (cascade), `consultant_id → consultants.id` (cascade) |
| `taches` | `titre`, `objectif`, `date`, `heure_debut`, `heure_fin`, `statut` (enum), `lu_at`, `reponse_at`, `commentaire` | `consultant_id → consultants.id` (cascade), `client_id → clients.id` (nullable), `assigned_by → users.id` (nullable) |
| `acces_audit_log` | `action` (enum), `details`, `created_at` seul (pas de `updated_at`) | `user_id → users.id` (cascade), `performed_by → users.id` (nullable) |
| `user_projet_access` | (pivot) unique `[user_id, projet_id]` | `user_id → users.id` (cascade), `projet_id → projets.id` (cascade) |
| `projet_preuves` | `label`, `fichier_nom`, `fichier_path`, `mime_type`, `taille_kb` | `projet_id → projets.id` (cascade) |
| `livrables_smi` *(legacy, non lu par le code applicatif)* | `chapitre_code`, `clause`, `libelle`, `phase_smi`, `ordre` | — |
| `projet_livrables` *(legacy, non lu par le code applicatif)* | `statut` (enum), `observations` ; unique `[projet_id, livrable_id]` | `projet_id → projets.id` (cascade), `livrable_id → livrables_smi.id` (cascade) |
| `livrable_preuves` *(legacy, non lu par le code applicatif)* | `label`, `fichier_nom`, `fichier_path`, `mime_type`, `taille_kb` | `projet_id → projets.id` (cascade), `livrable_id → livrables_smi.id` (cascade) |

### Tables d'authentification / système (Laravel standard)

| Table | Colonnes principales | Clés étrangères |
|---|---|---|
| `users` | `name`, `prenom`, `nom`, `email` (unique), `password`, `role` (enum), `consultant_id`, `permissions` (JSON), `statut_compte` (enum), `motif_refus`, `email_verified_at` | `consultant_id → consultants.id` (nullOnDelete) |
| `password_reset_tokens` | `email` (PK), `token` | — |
| `sessions` | `id` (PK), `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity` | `user_id → users.id` (nullable, index) |
| `notifications` | `id` (UUID, PK), `type`, `notifiable_type`/`notifiable_id` (morphs), `data`, `read_at` | polymorphe (`notifiable`) |
| `cache` / `cache_locks` | `key` (PK), `value`/`owner`, `expiration` | — |
| `jobs` / `job_batches` / `failed_jobs` | files standard de la queue Laravel | — |

### Schéma relationnel simplifié (entités métier)

```
clients ──1:N──> projets ──N:1──> consultants (chef_projet_id)
projets ──N:N──> normes (projet_normes)
projets ──N:N──> consultants (affectations, pivot enrichi)
projets ──1:N──> gantt_phases ──1:N──> gantt_taches ──N:N──> consultants (gantt_tache_consultant)
projets ──1:N──> suivi_chapitres ──N:1──> chapitres_smis
projets ──N:N──> formations (projet_formations, pivot enrichi)
projets ──1:N──> sensibilisations
projets ──1:N──> projet_preuves
projets ──N:N──> users (user_projet_access — accès direct)
consultants ──1:N──> taches (calendrier)
consultants ──0:1──> users (consultant_id, lien optionnel)
users ──1:N──> acces_audit_log (comme user OU comme performed_by)
users ──1:N──> notifications (polymorphe)
```

---

## 12. Logique applicative — comment l'application fonctionne réellement

Cette section documente les flux métier de bout en bout : qui déclenche
quoi, dans quel ordre, avec quelles règles. Objectif : comprendre le
fonctionnement complet sans avoir à relire chaque contrôleur.

### 12.1 Inscription et validation d'un compte

Flux complet (aucun compte n'est utilisable sans passer par les 3 étapes) :

1. **Inscription** (`RegisterController::store`, `POST /register`) — un
   visiteur crée un `User` avec `role=consultant` (toujours, non
   modifiable au moment de l'inscription), `statut_compte=en_attente`,
   `permissions=[]`. `VerifyAccountMail` est envoyé (lien signé Laravel,
   valable 60 min).
2. **Vérification d'email** (`VerifyEmailController::verify`,
   `GET /email/verify/{id}/{hash}`, route `signed`) — marque
   `email_verified_at`. Volontairement un contrôleur maison (pas le
   `VerifyEmailController` stock de Laravel) car l'utilisateur n'a **pas de
   session** à ce stade (jamais connecté).
3. **Approbation par un Super Admin** (`AdminUserController::approuver`,
   réservé `role:super_admin`) — l'admin choisit à ce moment précis :
   - le **rôle final** (`super_admin`/`chef_projet`/`consultant`)
   - les **permissions granulaires** (tableau `[permission => 'yes'/'no']`)
   - le **lien Consultant** : soit un `Consultant` existant (bloqué si déjà
     lié à un autre `User`), soit création d'un nouveau `Consultant`
     (`consultant_mode=nouveau`) — sauf si `role=super_admin`, où aucun
     lien consultant n'est requis.
   - `statut_compte` passe à `approuve`, `CompteApprouveMail` est envoyé,
     et **rattrapage** : toutes les `Tache` déjà assignées à ce consultant
     au statut `Assignée` déclenchent `TacheAssigneeNotification`
     immédiatement (cas réel : un chef de projet peut avoir assigné des
     tâches à un consultant avant même que son compte existe).
   - Chaque décision (`approuve`/`refuse`) est journalisée dans
     `acces_audit_log` (`AccesAuditLog`, colonnes `action`, `performed_by`,
     `details`).
   - Alternative : `AdminUserController::refuser` → `statut_compte=refuse`,
     `motif_refus` optionnel, `CompteRefuseMail`.

**Garde-fou à la connexion** (`AuthController::login`) : même avec les bons
identifiants, si `statut_compte !== 'approuve'`, la session est
immédiatement détruite et un message contextuel est affiché
(`User::messageStatut()`). **Garde-fou en session active**
(`EnsureAccountApproved` middleware, alias `approuve`, sur tout le groupe
de routes protégées) : si un compte déjà connecté est repassé à `refuse`
pendant qu'il navigue, il est déconnecté au prochain accès à une page.

*Donnée réelle observée (2026-07-28) : sur 3 comptes en base, 1 est
`en_attente` — le flux d'approbation est donc un point de friction actif du
projet, pas juste théorique.*

### 12.2 Rôles et permissions

Deux mécanismes **cumulés**, jamais l'un sans l'autre :

- **Rôle** (`users.role`, un seul par compte) : `super_admin` (accès total
  implicite, voir `User::isSuperAdmin()` — court-circuite toute vérification
  de permission), `chef_projet`, `consultant`. Vérifié via le middleware
  `role:xxx,yyy` (`CheckRole`, alias déclaré dans `bootstrap/app.php`) —
  utilisé pour `/admin/users` (`super_admin` seul) et `/admin/calendrier`
  (`super_admin,chef_projet`).
- **Permissions granulaires** (`users.permissions`, JSON
  `{permission: 'yes'|'no'}`) : 11 permissions nommées dans
  `CheckPermission::LABELS` (`voir_details`, `creer_projets`,
  `modifier_projets`, `supprimer_projets`, `voir_consultants`,
  `creer_consultants`, `modifier_consultants`, `supprimer_consultants`,
  `voir_gantt`, `voir_tableau_bord`, `gerer_preuves`). Vérifiées via le
  middleware `permission:xxx` (`CheckPermission`) sur la plupart des routes
  projet/consultant/preuves, **ou directement dans le contrôleur**
  (`GanttController::show`/`autoriser()` pour `voir_gantt`/
  `modifier_projets`, closure de `/tableau-de-bord` pour
  `voir_tableau_bord`) quand la vérification ne peut pas être une simple
  route middleware.
- **Point d'entrée unique** : `User::hasPermission(string $permission)` —
  toujours l'utiliser, ne jamais dupliquer une logique de rôle ad hoc dans
  un contrôleur (règle explicite, voir CLAUDE.md).
- Exemple réel observé : un compte `consultant` avec
  `{"voir_gantt":"no","voir_details":"yes","voir_tableau_bord":"yes", ...}`
  — chaque permission est vraiment indépendante, pas de préréglage par
  rôle.

### 12.3 Visibilité d'un projet (contrôle d'accès aux données)

`Projet::scopeVisiblesPour($query, User $user)` est la **seule source de
vérité** (réutilisée par `Api\ProjetController::index` pour `/`, et par
`ProjetPreuveController` pour vérifier l'accès avant upload/suppression de
preuve). Règle :

- `super_admin` → voit tout, sans condition.
- Sinon, un projet est visible si **au moins une** de ces conditions est
  vraie :
  1. l'utilisateur est le chef de projet (`projets.chef_projet_id ===
     user.consultant_id`) ;
  2. l'utilisateur est staffé dessus (ligne dans `affectations` pour son
     `consultant_id`) ;
  3. un accès direct lui a été accordé manuellement
     (`user_projet_access`, géré par
     `AdminUserController::mettreAJourAccesProjets`, indépendant du
     staffing).

Cette 3ᵉ voie (accès direct) sert typiquement à donner de la visibilité à
un `chef_projet`/`consultant` sur un projet qu'il ne staffe pas
officiellement. Chaque ajout/retrait déclenche
`ProjetAccessNotifier::notifierAjout()`/`notifierRetrait()` (§12.9).

### 12.4 Cycle de vie complet d'un projet

**Création** (`NouveauProjetController::store`, transaction unique) — ordre
des opérations :
1. Résolution/création du `Client` (recherche insensible à la casse sur
   `nom_client` — un même client peut être réutilisé entre projets), upload
   du logo vers Cloudinary si fourni.
2. Création du `Projet` avec référence auto-générée côté `create()`
   (`PRJ-XXX`, incrémentée depuis le dernier `Projet` créé).
3. **Génération automatique de la base Gantt standard**
   (`GanttTemplateService::creerPour()`) — 8 phases / 41 tâches SMI,
   toujours à ce stade, avant toute normes/consultant/chapitre.
4. Notification du chef de projet (`ProjetAccessNotifier`).
5. Sync des normes (`projet_normes`), création des `Affectation`
   (consultants existants **et** nouveaux consultants créés à la volée via
   `new_consultants[]`), création des `SuiviChapitre` (avec calcul immédiat
   de `avancement_percent` via `ProjetProgressService`), des
   `ProjetFormation`, des `Sensibilisation` (avec upload photo Cloudinary
   par ligne).

**Édition** (`EditController::update`, transaction unique) — logique plus
complexe car elle doit gérer les diffs par rapport à l'existant :
- Client : mise à jour en place (jamais de nouveau `Client`, sauf logo
  remplacé si un nouveau fichier est fourni — sinon `logo_path` inchangé).
- `chef_projet_id` : si changé, notifie le retrait de l'ancien chef ET
  l'ajout du nouveau (`ProjetAccessNotifier`, rôle forcé à `Chef de
  Projet`).
- Consultants : `deleted_consultants[]` (envoyé par le JS front) pilote les
  suppressions d'`Affectation` (+ notification de retrait) ; le reste du
  tableau `consultants[]` passe par `updateOrCreate` (upsert), et
  **seulement** les nouvelles affectations déclenchent une notification
  d'ajout (`wasRecentlyCreated`). `AffectationChargeService::
  recalculerPourProjet()` est rappelé après (recalcule `jours_realises`
  depuis le Gantt, écrase toute valeur qu'un upsert aurait pu y mettre).
- Chapitres : mise à jour ligne par ligne des `SuiviChapitre` existants
  (jamais de création/suppression ici — les lignes sont créées une seule
  fois à la création du projet, une par chapitre du référentiel).
- Formations et sensibilisations : **wipe-and-reinsert** total (`DELETE`
  puis re-`INSERT`/`create` de tout ce qui est soumis) — retirer une ligne
  côté JS suffit donc à la supprimer, pas besoin d'un
  `deleted_xxx[]` dédié comme pour les consultants.
- `avancement_percent` recalculé en tout dernier
  (`ProjetProgressService::recalculerAvancement`), jamais saisi
  directement dans `$projet->update()` (mis à `0` puis écrasé).

**Suppression** (`EditController::destroy` et `Api\ProjetController::
destroy`, transaction) — cascade manuelle explicite (`affectations`,
`projet_normes`, `suivi_chapitres`, `projet_formations`,
`projet_livrables`) avant `$projet->delete()`, puis suppression du
`Client` **seulement s'il n'est plus référencé par aucun autre projet**.
*(Les FK `ON DELETE CASCADE` existent déjà en base pour la plupart de ces
tables — cette suppression manuelle est redondante avec les contraintes SQL
mais explicite dans le code.)*

### 12.5 Gantt — phases, tâches, calcul de dates (le sous-système le plus complexe du code)

**Modèle mental** : une tâche Gantt a un `type_tache` (`phase` = bloc
continu classique avec `date_debut`/`ct_prevue`, ou `journee` = jours
discontinus choisis un par un dans un calendrier) et un état orthogonal
**"report"** (présence de `date_reprise`/`date_interruption`, applicable
aux deux types). Tout le calcul est **centralisé et fait au `save()`**
dans `App\Services\GanttTacheDateCalculator` — jamais recalculé à
l'affichage : `Gantt.blade.php` ne fait qu'une projection pixel de la
colonne JSON `segments` déjà stockée.

Séquence à chaque `storeTache`/`updateTache` :
1. `GanttController::resoudreChampsType()` valide/normalise les champs
   selon `type_tache` (pour `journee`, vérifie que le nombre de jours
   choisis correspond à `ct_prevue`, sauf si un report est actif — les
   jours restants peuvent alors être choisis progressivement après la
   reprise).
2. `GanttTacheDateCalculator::calculerPourTache()` route vers
   `resoudrePourPhase()` ou `resoudrePourJournee()`, qui déterminent
   `date_debut`/`date_fin`/`date_interruption`/`date_reprise` et
   appellent `construireSegments()` pour produire le JSON `segments`
   (découpé en blocs de jours ouvrés, weekends exclus, avec `fill_jours`
   calculé depuis `avancement` pour le rendu visuel du remplissage).
3. Règle métier clé sur `resoudrePourPhase()` : le nombre de jours restants
   après une pause = `CT Prévu − jours ouvrés déjà couverts avant la
   pause` (pas `CT Prévu − CT Réalisé`, qui mélangeait avancement visuel et
   durée réelle — bug corrigé le 2026-07-23, voir CLAUDE.md).
4. `tache->consultants()->sync()` — une tâche peut être assignée à
   plusieurs consultants (équipe), chacun comptant pour le **total complet**
   de `ct_realisee` dans son calcul de charge (pas de répartition).
5. `AffectationChargeService::recalculerPourProjet()` systématiquement
   rappelé après toute modif de tâche (création/édition/suppression).

*Donnée réelle : 164 tâches Gantt en base, dont 160 `phase` et 4
`journee` — le mode `journee` est utilisé mais très minoritaire.*

Consultants : relation `belongsToMany` via `gantt_tache_consultant`
(colonne legacy `gantt_taches.consultant_id` toujours présente en base mais
plus lue/écrite — 9 lignes dans le pivot actuellement).

### 12.6 Calcul de l'avancement d'un projet

`avancement_percent` d'un `Projet` = **moyenne arithmétique** des
`suivi_chapitres.avancement_percent` de ses chapitres (saisis manuellement
un par un dans le formulaire projet). Recalculé par
`ProjetProgressService::recalculerAvancement()`, appelé après toute
création/mise à jour de chapitres (`NouveauProjetController::store`,
`EditController::update`). **Ne dépend plus des livrables** depuis le
2026-07-24 (voir §12.10 pour l'historique de ce changement).

### 12.7 Calcul de la charge de travail (jours_realises par consultant)

`affectations.jours_realises` (affiché comme "Charge de travail" par
consultant sur un projet) n'est **plus jamais saisi manuellement** — il est
recalculé par `AffectationChargeService::recalculerPourProjet()` : somme de
`gantt_taches.ct_realisee` pour toutes les tâches Gantt du projet assignées
à ce consultant (jointure via `gantt_tache_consultant`). Appelé après :
- toute création/modification/suppression de tâche Gantt
  (`GanttController`) ;
- toute modification des affectations d'un projet (`EditController::
  update`, `NouveauProjetController::store` ne le déclenche pas
  explicitement car les affectations démarrent à 0 tant qu'aucune tâche
  Gantt n'est réalisée).

`jours_realises` **du projet** (`projets.jours_realises`, différent de
celui d'`Affectation`) reste lui saisi manuellement dans le formulaire
d'édition — les deux notions ne sont pas synchronisées entre elles.

### 12.8 Calendrier — cycle de vie d'une tâche assignée

Machine à états de `taches.statut` :
`Assignée → Lue → (Acceptée | Refusée | En cours | Terminée)`

1. **Assignation** (`CalendrierAdminController::store`, super admin ou chef
   de projet) — crée une `Tache` avec `statut=Assignée`,
   `assigned_by=auth()->id()`. Si le consultant a un compte `User` lié,
   `TacheAssigneeNotification` est envoyée immédiatement (email + base de
   données) ; sinon rien ne se passe côté notification tant qu'aucun
   compte n'existe (rattrapé à l'approbation du compte, voir §12.1).
2. **Lecture** (`CalendrierController::marquerLue`, déclenchée à
   l'ouverture du détail côté consultant) — pose `lu_at`, et fait passer
   `statut` de `Assignée` à `Lue` (uniquement si c'était encore
   `Assignée` — idempotent).
3. **Réponse** (`CalendrierController::repondre`) — le consultant choisit
   `Acceptée`/`Refusée`/`En cours`/`Terminée` + un commentaire libre,
   pose `reponse_at`, et notifie l'assignateur
   (`TacheRepondueNotification`).
4. **Déplacement** (`CalendrierAdminController::deplacer`, drag & drop
   FullCalendar côté admin) — met à jour uniquement `date`/`heure_debut`/
   `heure_fin`, ne touche pas au statut.

Chaque `created`/`updated` sur `Tache` déclenche aussi
`TacheObserver → OutlookSyncService::sync()` — actuellement un **stub qui
ne fait que logger** (`Log::debug`), point d'extension prévu pour un futur
sync Microsoft Graph API vers Outlook, non implémenté.

*Donnée réelle : 2 tâches en base, toutes deux au statut `Assignée` —
le module calendrier est en place mais très peu utilisé pour l'instant.*

### 12.9 Notifications — déclencheurs et canaux

Toutes les notifications métier (`app/Notifications/*`) sont `ShouldQueue`
(passent par la table `jobs` si une queue autre que `sync` est configurée)
et choisissent dynamiquement leurs canaux dans `via()` : `['database',
'mail']` si le `notifiable` a un email, `['database']` seul sinon (avec un
`Log::warning` — jamais d'erreur silencieuse totale). Table `notifications`
(polymorphe standard Laravel) alimente la cloche de la navbar
(`partials/navbar.blade.php`, badge = `unreadNotifications`, "tout marquer
lu" via `notifications.lire-tout`).

| Déclencheur | Notification envoyée |
|---|---|
| Nouvelle affectation (staffing, chef de projet, ou accès direct) | `ProjetAssigneNotification` |
| Retrait d'accès à un projet | `ProjetRetireNotification` |
| Nouvelle tâche calendrier assignée (+ rattrapage à l'approbation de compte) | `TacheAssigneeNotification` |
| Réponse du consultant à une tâche | `TacheRepondueNotification` |

*Donnée réelle : 10 notifications en base pour 3 comptes utilisateurs —
le système est actif.*

### 12.10 Stockage de fichiers — Cloudinary

Trois usages distincts, tous via `CloudinaryLabs\CloudinaryLaravel\Facades\
Cloudinary::uploadApi()->upload()` (jamais de stockage disque en
production — `storage/app/public/preuves*` ne contient que des fichiers
legacy d'avant la bascule Cloudinary) :

| Usage | Dossier Cloudinary | Déclenché par |
|---|---|---|
| Logo client | `lmc/clients/logos` | `NouveauProjetController::store`, `EditController::update` |
| Photo de sensibilisation | `lmc/sensibilisations` | `NouveauProjetController::store`, `EditController::update` |
| Preuve documentaire projet | `lmc/preuves_projet` | `ProjetPreuveController::upload` |

Lecture sécurisée : `/download-file` et `/view-file` (`routes/web.php`)
valident que `parse_url($url, PHP_URL_HOST) === 'res.cloudinary.com'`
avant tout `file_get_contents()` — protection SSRF explicite, à ne jamais
retirer (voir CLAUDE.md, règle de sécurité).

**Historique** : jusqu'au 2026-07-24, il existait un système de preuves
**par livrable** (`livrables_smi`/`projet_livrables`/`livrable_preuves`,
`LivrablesController`/`PreuveController`, aujourd'hui supprimés du code).
Remplacé par un simple **lien externe OneDrive/SharePoint par chapitre**
(`suivi_chapitres.lien_onedrive`) — décision produit : les fichiers vivent
dans un dossier d'entreprise organisé par chapitre, pas uploadés dans
l'app. Validation souple (host `sharepoint.com`, `onedrive.live.com` ou
`1drv.ms`), côté client (JS) et serveur (règle Laravel `regex`).
*Les 3 tables legacy existent toujours en base avec des données réelles
(`livrables_smi` : 90 lignes, `projet_livrables` : 77 lignes) mais plus
aucun code applicatif actif ne les lit ni ne les écrit — sauf
`tableau-de-bord.blade.php` et `Api\ProjetController` (code mort, non
routé) qui les interrogent encore, ce qui fige un KPI du dashboard PMO sur
des données obsolètes (connu, non corrigé, voir CLAUDE.md).*

### 12.11 Journal d'audit des décisions d'accès

`AccesAuditLog` (table `acces_audit_log`) trace uniquement les décisions
`approuve`/`refuse` prises par un Super Admin sur une demande de compte
(`AdminUserController::approuver`/`refuser`) — pas les modifications
ultérieures de rôle/permissions (`update()`), ni les accès directs à des
projets (`mettreAJourAccesProjets`, non journalisés). Affiché dans
`admin-users.blade.php` (30 dernières entrées, avec relations `user` et
`admin`/`performed_by`).

### 12.12 Ce qui reste non implémenté ou non actif

Pour une vision honnête de l'état du projet :

- **`routes/api.php`** : 9 ressources REST complètes codées
  (`Api\ClientController`, etc.) mais **aucune route active** — il manque
  `api: __DIR__.'/../routes/api.php'` dans `withRouting()`
  (`bootstrap/app.php`). Tout le code existe, rien n'est branché.
- **`OutlookSyncService`** : stub, aucun appel Microsoft Graph API réel.
- **Sync Outlook côté calendrier** : l'observer est en place
  (`TacheObserver`), le service ne fait rien.
- **`Api\ProjetNormeController`** : squelette vide (5 méthodes sans corps).
- **`Api\ProjetController`** : référence une classe
  `App\Services\LivrablesSMI` qui n'existe pas dans `app/Services/` — import
  mort, sans effet tant que non invoqué.
- **KPI livrables du tableau de bord** (`tableau-de-bord.blade.php`) : basé
  sur `projet_livrables`, plus alimenté depuis le 2026-07-24 → figé sur des
  données historiques pour les projets existants, à 0 pour tout projet créé
  après cette date.
- **Migration MySQL-only** : `2026_07_24_090000_add_externe_to_consultants_
  type_enum.php` utilise `ALTER TABLE ... MODIFY COLUMN ENUM` en SQL brut —
  ne fonctionnerait pas si l'équipe basculait un jour sur SQLite/PostgreSQL
  en production.

---

## 13. Anatomie détaillée des vues les plus complexes

Cette section documente le contenu réel (structure HTML, JS, logique
front) des vues les plus lourdes de l'application — `Gantt.blade.php`
(1447 lignes), `edit-projet.blade.php` (4052 lignes),
`details-projet.blade.php` (1523 lignes) et `tableau-de-bord.blade.php`
(2434 lignes) lues intégralement,
`nouveau-projet.blade.php` (1398 lignes) documentée par différence avec
`edit-projet.blade.php` — pas seulement leur rôle général comme en §10.

### 13.0 Mécanisme transversal : brouillon automatique de formulaire (`public/js/form-persist.js`)

Chargé globalement par `partials/navbar.blade.php` (donc actif sur
**toutes les pages qui incluent la navbar** — la quasi-totalité de
l'app), pas seulement `edit-projet`/`Gantt`. Rôle : éviter de perdre une
saisie en cours si l'utilisateur quitte la page par erreur. Convention
(aucune config requise pour un formulaire "normal") :
- Écoute `input`/`change` sur tout `<form>` de la page, sérialise ses
  champs (hors `password`, `file`, `hidden`, boutons) dans
  `sessionStorage`, clé = `formpersist::<pathname>::<id ou name ou
  action du form>`, avec un debounce de 300 ms.
- **Jamais** de persistance sur un formulaire contenant un
  `input[type=password]` (sécurité), ni sur un formulaire sans champ
  "utile".
- `data-no-persist` sur le `<form>` désactive explicitement la
  persistance — utilisé pour les modales génériques réutilisées pour
  plusieurs enregistrements différents (ex. `renamePhaseModal` dans
  `Gantt.blade.php`, qui sert à renommer n'importe quelle phase : sans
  ce flag, un brouillon de la phase A pourrait se réappliquer par erreur
  en ouvrant le formulaire pour la phase B).
- `data-persist-cancel` sur un bouton "Annuler" efface le brouillon
  correspondant (ex. bouton Annuler de `edit-projet.blade.php`, attribut
  `data-persist-cancel="mainForm"`).
- La sauvegarde est effacée automatiquement à la soumission réussie du
  formulaire (`submit` event).
- Expose `window.FormPersist.{clear,save,restore}` pour un contrôle
  manuel (utile pour un formulaire réutilisé création/édition dont la
  clé change dynamiquement en JS).

### 13.1 `Gantt.blade.php` — planning Gantt d'un projet

**CSS** : thème clair/sombre entièrement piloté par variables CSS
(`:root`, `@media (prefers-color-scheme: dark)`, et override explicite
`[data-theme="dark"]`/`[data-theme="light"]` posé en JS + persisté dans
`localStorage['lmc-theme']`) — palette dédiée à cette vue (`--prevu`,
`--realise`, `--journee`, `--report-gap`, etc.), non partagée avec les
autres vues (confirme l'absence de layout/design-system commun notée en
§10).

**En-tête / légende** (calculée server-side dans un bloc `@php` en haut
de la vue, avant le rendu) :
- **Avancement global du projet** = moyenne **pondérée par CT Prévu**
  (`Σ(ct_prevue × avancement) / Σ(ct_prevue)`), volontairement différente
  de `GanttPhase::avancement_moyen` (moyenne simple par phase) — une
  tâche de 20 j/h à 10% pèse plus dans ce total qu'une tâche de 1 j/h à
  100%. Ce chiffre global n'existe que dans cette vue, il n'est stocké
  nulle part.
- Légende visuelle des 4 types de segments (Prévu / Réalisation /
  Journée / Report).

**Barre d'outils** : bascule "Vue par phase" ↔ "Vue par consultant"
(`?groupBy=consultant`, lu par `GanttController::show`), boutons
"Ajouter une phase"/"Ajouter une tâche" (visibles seulement si
`hasPermission('modifier_projets')`).

**Calcul des groupes et de la fenêtre temporelle** (bloc `@php`, avant le
rendu) :
- Si `groupBy=consultant` : un groupe par consultant du projet (une
  tâche à plusieurs consultants apparaît dans chacun de leurs groupes),
  + un groupe "Non assigné" pour les tâches sans consultant ou assignées
  à un consultant qui n'est plus dans l'équipe.
- Sinon : un groupe par `GanttPhase` (ordonné), + un groupe "Sans phase".
- Fenêtre timeline (`$tlStart`/`$tlEnd`) : bornée sur les dates réelles
  des tâches (`min(date_debut) - 5j` → `max(date_fin ou date_reprise) +
  10j`), ou une fenêtre par défaut (mois courant −5j → +2 mois) si aucune
  tâche n'a de date. `$jourWidth = 30px` (constante de rendu).
- `ganttProjeterSegments()` (fonction PHP globale, gardée par
  `function_exists()` — piège Blade documenté en CLAUDE.md) : projette
  la colonne JSON `segments` (déjà calculée côté serveur par
  `GanttTacheDateCalculator`, voir §12.5) en coordonnées pixel
  (`left`/`width`/`fillWidth`). **Aucune décision de date n'est prise
  ici** — uniquement une projection date→pixel.

**Tableau (panneau gauche)** : une ligne par phase (totaux agrégés,
actions renommer/supprimer si permission) puis une ligne par tâche
(désignation avec icônes type `journee`/`report`, consultant(s) —
badge "Équipe (N)" si plusieurs —, CT Prévu, CT Réalisé, écart, pastille
d'avancement en dégradé linéaire `--fill`). Cliquer une ligne
(`toggleEdit()`) ouvre un **panneau d'édition inline** juste en dessous
(un seul ouvert à la fois) avec le formulaire complet de la tâche
(désignation, phase, consultants — multi-select en dropdown à
checkboxes —, CT Prévu/Réalisé, avancement, sélecteur de type
Phase/Journée, champs date ou sélecteur de jours selon le type, bloc
report). Bouton Supprimer déclenche une modale de confirmation générique
(remplace `confirm()` natif) plutôt qu'une soumission directe.

**Timeline (panneau droit)** : une ligne par tâche synchronisée en
scroll horizontal avec l'en-tête des mois/jours (`timelineBodyScroll`
↔ `timelineHeadScroll`), colonnes de jours avec ombrage weekend, ligne
verticale "aujourd'hui", et un `<div>` positionné en absolu par segment
(barre `Prévu` + remplissage `Réalisé` pour `type=realisation`, bloc
plein pour `type=journee`, hachures pour `type=report`).

**JS notable** (au-delà du toggle de thème et du dropdown consultants) :
- `applyTypeTacheVisibility()` : bascule l'affichage des champs
  date/CT Prévu (type `phase`) vs sélecteur de jours (type `journee`)
  selon le radio sélectionné, et relabellise "CT Prévu (H/J)" en
  "Nombre de jours" pour le type `journee`.
- `updateDateFinPreview()` : **recalcule côté client** une date de fin
  prévisionnelle (jours ouvrés, weekends sautés) — une réplique
  simplifiée de `GanttTacheDateCalculator::ajouterJoursOuvres()`,
  uniquement pour affichage immédiat avant soumission ; la vraie date
  stockée est toujours recalculée côté serveur. Désactivée si un report
  est actif (la vraie date de fin dépend alors du calcul serveur post
  reprise, pas de ce calcul naïf).
- `updateReportRemainingWork()` : affiche "X jours de travail restants"
  = `CT Prévu − CT Réalisé` — **volontairement différent** d'un compte à
  rebours calendaire jusqu'à la date de reprise (commentaire explicite
  dans le code : la date de reprise dit *quand* on reprend, pas *combien*
  il reste à faire).
- `initJourPicker()` : mini-calendrier maison (sans librairie) pour le
  type `journee` — navigation mois par mois, clic pour cocher/décocher un
  jour, compteur "`X / CT Prévu` jours sélectionnés" tolérant un compte
  partiel si un report est actif (les jours restants seront choisis
  après la reprise), génère des inputs hidden `jours[]`.
- `toggleReportField()`/`annulerReport()` : révèle/masque les 2 champs
  manuels de report (date de début du report + date de reprise — jamais
  devinées, voir §12.5) ; annuler vide les deux champs, ce qui efface le
  report côté serveur à l'enregistrement suivant.
- Au chargement (`window.addEventListener('load', ...)`), la timeline se
  scroll automatiquement soit sur la tâche qui vient d'être créée/modifiée
  (`$scrollTargetLeft`, flashé en session par le contrôleur — voir
  CLAUDE.md, milieu de `[date_debut, date_fin]`), soit sur "aujourd'hui"
  par défaut.
- Si une soumission échoue la validation (ex. report invalide) et que
  `old('_tache_id')` est présent, le panneau d'édition de la tâche
  concernée se rouvre automatiquement et scroll dessus — sinon le message
  d'erreur global n'a aucun panneau visible où se rattacher.

### 13.2 `edit-projet.blade.php` — formulaire d'édition complet d'un projet

**CSS** : ~2400 lignes de design system "premium" (variables `--primary-*`,
`--gray-*`, `--shadow-*`, `--radius-*`, glassmorphism sur le header) —
**totalement indépendant** de celui de `Gantt.blade.php` (autre palette,
autres conventions de nommage), confirmant qu'il n'existe aucun design
system partagé entre les vues (§10/CLAUDE.md).

**Un seul `<form id="mainForm" method="POST" action="projets.update"
enctype="multipart/form-data">`** englobant les sections A à J (toutes
soumises ensemble en un seul `PUT /projets/{id}`, traité par
`EditController::update`, voir §12.4) :

| Section | Contenu | Champs / mécanique notable |
|---|---|---|
| **A — Informations générales** | Référence, client, chef de projet, statut, secteur, type de projet, logo client | Upload logo avec **aperçu client-side instantané** (`FileReader` + validation JS du type MIME/taille, miroir de la validation serveur `EditController::update`) ; `resetClientLogoSelection()` restaure l'aperçu du logo existant si le fichier est désélectionné |
| **B — Équipe projet** | Tableau des `Affectation` existantes + ajout dynamique | `jours_realises` est un `<input disabled>` (lecture seule, calculé par `AffectationChargeService`, voir §12.7) ; `jours_alloues` masqué/désactivé pour les rôles `Chef de Projet`/`Consultant` (pertinent seulement pour `Consultant Ext.`) via `applyJoursAllouesVisibility()` ; suppression d'une ligne (`removeConsultant()`) ajoute un hidden `deleted_consultants[]` lu par `EditController` ; bloc de comparaison live "Total J. réalisés consultants" vs "Total J. réalisés projet (E)" |
| **C — Normes** | Checkboxes `normes[]` | — |
| **D — Dates** | `date_debut`, `date_fin_prevue`, `date_fin_reelle` | — |
| **E — Indicateurs** | `jours_prevus`, `jours_realises` (manuel, projet), `avancement_percent` | `avancement_percent` recalculé **aussi côté client** (`recalcAvancementGlobal()`, miroir exact de `ProjetProgressService` — moyenne des `.chap-avancement` de la section F) pour un retour visuel immédiat ; la valeur réellement persistée reste toujours recalculée côté serveur à l'enregistrement |
| **F — SMI (chapitres)** | Une ligne par `SuiviChapitre` existant (hidden `id`/`chapitre_id`, jamais créées/supprimées ici) | Champ `lien_onedrive` avec validation JS live (`checkOnedriveLink()` — regex `sharepoint.com`/`onedrive.live.com`/`1drv.ms`, classes `is-valid`/`is-invalid`), avancement par chapitre (déclenche `recalcAvancementGlobal()`), jours d'intervention (déclenche `recalcTotalDays()`) |
| **G — Plan de formation** | Lignes dynamiques `custom_formations[idx]` | `addFormationRow()`/`removeFormationRow()` — correspond au wipe-and-reinsert côté serveur (retirer une ligne suffit, pas de `deleted_xxx[]` nécessaire ici, voir §12.4) |
| **H — Sensibilisation** | Lignes dynamiques avec upload photo par ligne | `existing_photo_path` en hidden pour préserver la photo si aucun nouveau fichier n'est choisi ; `addSensibilisationRow()`/`removeSensibilisationRow()`, même mécanique wipe-and-reinsert que G |
| **I — Points d'attention** | `blocage`, `commentaire` (textareas libres) | — |
| **J — Fichiers d'intervention** | Upload/liste des `projet_preuves` | Zone drag & drop (`handleProjetDragOver/Leave/Drop`), aperçu avant envoi, **upload AJAX** (`uploadProjetPreuve()` → `POST preuves-projet.upload`, indépendant de la soumission du formulaire principal), visionneuse plein écran + impression (`openFullscreen()`/`printCurrentPreuve()`, pattern partagé avec `details-projet.blade.php` selon CLAUDE.md), suppression AJAX (`deleteProjetPreuve()`) |

**Pied de formulaire** : bouton "Annuler" (`data-persist-cancel="mainForm"`
— efface le brouillon, voir §13.0), lien "Planning Gantt" (visible si
`hasPermission('voir_gantt')`, badge = nombre de tâches Gantt du projet),
bouton "Enregistrer les modifications" (soumet tout le formulaire).

**Cohérence client/serveur observée** : les deux recalculs live côté
client (`recalcAvancementGlobal()` pour l'avancement, la comparaison B/E
pour les jours) sont des **miroirs d'affichage uniquement** — aucune
valeur calculée en JS n'est jamais soumise comme source de vérité ; le
serveur (`ProjetProgressService`, `AffectationChargeService`) recalcule
systématiquement tout à l'enregistrement, donc pas de risque de
désynchronisation même si le JS a un bug d'affichage.

### 13.3 `nouveau-projet.blade.php` — formulaire de création (même structure que l'édition)

1398 lignes, non relu ligne à ligne car **structurellement identique** à
`edit-projet.blade.php` (§13.2) : même design system CSS "premium", même
découpage en sections A→H (I/J n'existent pas ici — pas de "Points
d'attention" ni de "Fichiers d'intervention" à la création, ces deux
sections n'ont de sens qu'une fois le projet créé), mêmes mécaniques JS
(ajout dynamique de consultants/formations/sensibilisations, aperçu logo
client, validation live du lien OneDrive). Différences réelles avec
l'édition, déjà identifiées en §12.4 :
- Formulaire `POST /projets` (`NouveauProjetController::store`) au lieu
  de `PUT /projets/{id}`.
- `avancement_percent` est un champ **saisi directement** (validation
  `required|integer|0-100`), pas encore piloté par
  `ProjetProgressService` puisqu'aucun `SuiviChapitre` n'existe avant la
  création.
- Pas de ligne `SuiviChapitre` pré-existante à éditer : le formulaire
  génère une ligne par chapitre du référentiel (`$chapitres`, tous les
  `ChapitreSmi`) directement dans le HTML, sans hidden `id` (elles seront
  créées, pas mises à jour).
- Pas de section J (upload de preuves) : `ProjetPreuveController` exige
  un `projet_id` existant.

### 13.4 `details-projet.blade.php` — fiche détail (lecture seule)

**Point d'architecture central** (déjà signalé en §10/CLAUDE.md, confirmé
ligne par ligne ici) : dès le `@php` en haut du `<body>` (ligne 550),
cette vue **ignore totalement** le `$projet` Eloquent envoyé par
`EditController::show` et reconstruit tout depuis zéro avec des requêtes
`DB::` brutes, à partir du seul `request()->route('id')` :

```php
$projet = DB::selectOne("SELECT p.*, c.nom_client, c.secteur_activite, c.logo_path,
    cons.nom_complet as chef_nom, cons.email as chef_email
    FROM projets p
    LEFT JOIN clients c ON p.client_id = c.id
    LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
    WHERE p.id = ?", [$id]);
// + $normes, $consultants, $chapitres, $formations (jointures SQL brutes),
// $sensibilisations et $fichiersIntervention (DB::table(...)->get())
```

`$projet` est donc un **`stdClass`**, pas un modèle `Projet` — toute
nouvelle section ajoutée à cette vue doit suivre le même style
(`DB::table(...)->where('projet_id', $id)`), sinon `$projet->x` plante en
`Undefined property`.

**Sections affichées** (toutes en lecture seule, pas de `<form>`) :
Informations générales (statut, chef de projet, client + logo, période,
normes), Indicateurs de suivi (jours prévus/réalisés, consommation,
écart, barre d'avancement), une carte **"Cohérence des jours réalisés"**
(voir ci-dessous), Exigences clés SMI (texte libre par chapitre),
tableau Suivi des chapitres SMI (avec lien OneDrive et bouton imprimer
par ligne), Charge de travail (tableau consultants + **graphique Chart.js
en barres horizontales**, jours réalisés par consultant coloré par type
interne/externe), Plan de formation, Sensibilisation (grille de cartes
avec photo), Points d'attention (affiché seulement si `blocage` renseigné
et différent de `'RAS'`, ou si `commentaire` non vide), Fichiers
d'intervention (grille de documents `projet_preuves`).

**"Cohérence des jours réalisés" — 3 notions distinctes de "jours
réalisés" coexistent dans l'app, à ne pas confondre** :
1. `projets.jours_realises` — saisi manuellement dans le formulaire
   projet (Section E), affiché tel quel dans le KPI "Jours réalisés" en
   haut de cette vue.
2. `Σ affectations.jours_realises` (variable `$joursConsultantsCalc`) —
   calculée automatiquement depuis le Gantt par
   `AffectationChargeService` (voir §12.7).
3. `Σ suivi_chapitres.jours_intervention + Σ projet_formations.jours_realises`
   (variable `$joursRealisesCalc`) — un **troisième total, indépendant**,
   recalculé à l'affichage de cette vue uniquement (nulle part persisté).

La carte "Cohérence des jours réalisés" compare **(2) contre (3)**
(jamais (1)) et affiche un badge vert/orange/rouge selon l'écart — un
commentaire dans le code (ligne 743-750) explique explicitement que le
KPI du haut utilise bien (1) et non (3), suite à un bug constaté le
2026-07-22 où (3) restait bloqué à 0 tant qu'aucun chapitre/formation
n'était renseigné, en désaccord avec la page Modifier Projet.

**⚠️ Deux bugs réels identifiés à la lecture du code** (comparaison de
chaîne contre les valeurs d'enum `phase`, qui contiennent un préfixe
emoji — voir `SuiviChapitre` §2 et la migration `suivi_chapitres`,
valeurs réelles : `'⬜ Non démarré'`, `'⏳ Démarré'`, `'🔄 En cours'`,
`'✅ Terminé'`) :
- Ligne 640 : `$doneChap = $chapsColl->where('phase', 'Terminé')->count();`
  compare contre `'Terminé'` sans l'emoji — **ne matche jamais aucune
  ligne**, donc le compteur "Chapitres terminés" affiché en bas du
  tableau de suivi (ligne 931) affiche toujours **0/N**, même quand des
  chapitres sont réellement à 100%/`✅ Terminé`.
- Ligne 874-879 :
  `match($chap->phase) { 'Terminé' => 'phase-completed', 'En cours' =>
  'phase-in-progress', 'Démarré' => 'phase-started', default =>
  'phase-not-started' }` — même cause : **aucune valeur réelle ne matche
  jamais**, donc le badge de couleur de la colonne "Phase" du tableau
  affiche systématiquement le style "non démarré" (`phase-not-started`),
  quel que soit l'état réel du chapitre. Le texte affiché à côté
  (`{{ $chap->phase }}`) reste correct (avec l'emoji), seule la couleur
  du badge est fausse.
  *(Note : `EditController::edit`/`nouveau-projet.blade.php` utilisent
  directement les valeurs avec emoji dans leurs `<select>` — le bug est
  localisé à ces deux comparaisons de `details-projet.blade.php`, pas
  ailleurs dans l'app.)*

**Visionneuses** : cette vue a ses **propres** implémentations de
`viewDocument()`/`printDocumentUrl()`/`downloadFile()` (modale
`preuveViewerModal`) — conceptuellement le même pattern que le
fullscreen viewer d'`edit-projet.blade.php` (§13.2, `openFullscreen()`),
mais du code dupliqué, pas une fonction partagée (cohérent avec
l'absence de layout/JS commun entre vues, voir §10). `showPrintDocument()`
génère en plus un document imprimable dédié pour un chapitre SMI (avec
son propre `<head>`/styles injectés dans une fenêtre `window.open()`).

### 13.5 `tableau-de-bord.blade.php` — dashboard PMO (2434 lignes, lu intégralement)

La vue la plus dense de l'app en logique métier auto-portée : **5 requêtes
SQL brutes** dans un `@php` en tête de fichier, un rendu HTML complet
côté serveur, **et une réimplémentation JS quasi complète de la même
agrégation** pour piloter 3 filtres interactifs (Statut / Chef de projet
/ Secteur) sans aucun aller-retour serveur.

**Les 5 requêtes `DB::select()` de tête** (`Illuminate\Support\Facades\DB`) :
1. `$projets` — tous les projets + `nom_client`/`secteur_activite`/
   `logo_path` (jointure `clients`) + `chef_nom`/`chef_type` (jointure
   `consultants` sur `chef_projet_id`), triés par référence.
2. `$consultants` — un par consultant actif, avec `SUM(jours_realises)`,
   `SUM(jours_alloues)` et `COUNT(DISTINCT projet_id)` agrégés depuis
   `affectations` (`LEFT JOIN`, donc un consultant sans affectation
   apparaît quand même avec des totaux à 0).
3. `$normeRows` → reconstruit en PHP un tableau associatif
   `$normesParProjet[projet_id][] = code_norme` (pas de agrégation SQL
   `GROUP_CONCAT`, fait manuellement en boucle).
4. `$chapitres` — moyenne d'avancement **par code de chapitre, tous
   projets confondus** (`GROUP BY cs.id`) — sert au widget "Avancement
   Chapitres SMI" (une barre par chapitre §4→§10, pas par projet).
5. `$formations` — par projet, `COUNT` total de formations liées et
   `SUM` conditionnelle des statuts `Finalisée`/`Réalisée` (`HAVING
   COUNT(...) > 0` exclut les projets sans aucune formation).

Deux requêtes supplémentaires (`$affectationsRaw`, `$chapitresRaw`) sont
exécutées **uniquement pour être sérialisées en JSON** et réutilisées
côté client (voir plus bas) — elles dupliquent en partie `$consultants`/
`$chapitres` mais à la granularité ligne-par-ligne (non agrégée), pour
que le JS puisse ré-agréger lui-même après filtrage.

**KPI et cartes rendus côté serveur** (7 KPI en tête, puis 3 lignes de
cartes "Pilotage Portefeuille" / "Pilotage Ressources" / "Pilotage SMI"
+ une table "Santé Projets" + une table détaillée "Vue Détaillée
Portefeuille") — tous calculés à partir des 5 requêtes ci-dessus, sans
passer par un contrôleur ni par les Services applicatifs (`ProjetProgressService`
n'est pas utilisé ici : `avancement_percent` est relu tel quel depuis la
colonne `projets.avancement_percent`, déjà à jour).

**⚠️ Le libellé "Moyenne pondérée" du KPI Avancement global est trompeur**
— le calcul réel est `round(collect($projets)->avg('avancement_percent'))`,
une **moyenne simple**, pas pondérée par jours prévus ni par taille de
projet (contrairement à l'avancement global réellement pondéré par
`ct_prevue` calculé dans `Gantt.blade.php`, voir §13.1). À reproduire
comme une moyenne simple dans une réécriture, malgré le texte affiché.

**"Santé Projets" (heatmap 3 colonnes)** — classification par heuristique
pure, sans persistance ni service dédié, reproduite à l'identique en PHP
(rendu initial) et en JS (`updateHeatmap()`, après filtrage) — vérifié
ligne à ligne, les deux implémentations sont cohérentes :
- **Planning** : `En retard` → rouge "✗ Retard" ; sinon `avancement > 0`
  → vert "✓ OK" ; sinon gris "— N/D" (non démarré).
- **Budget** : `écart = jours_realises − jours_prevus` ; `écart > 5` →
  rouge "✗ Dépass." ; `écart > 0` → orange "⚡ Risque" ; sinon vert "✓ OK".
- **Risque** : `En retard` → rouge "✗ Élevé" ; `En cours` ET
  `avancement < 30` → orange "⚡ Moyen" ; `Planifié` → gris "— Faible" ;
  sinon vert "✓ Faible" (couvre implicitement `Finalisé` et `En pause`).

**Colonne "Performance"** de la table détaillée (logique différente,
propre à cette colonne, à ne pas confondre avec la classification
"Risque" ci-dessus) : `Finalisé` → vert "Dans les temps" ; `En retard` →
rouge "Critique" ; sinon `avancement ≥ 50` → vert "Dans les temps" ;
sinon `avancement > 0` → orange "À surveiller" ; sinon gris "Non démarré".

**Filtres 100% client-side** : au chargement, la vue sérialise
l'intégralité du portefeuille en JSON (`ALL_PROJETS`, `ALL_AFFECTATIONS`,
`ALL_CHAPITRES_RAW`, `ALL_FORMATIONS`) directement dans le `<script>` —
**aucune pagination, aucun appel serveur lors du filtrage**. `applyFilters()`
recalcule tout (`filterProjects` → `projectStats`/`groupConsultants`/
`groupChapitres`/`chapCompletionStats`/`groupFormations`) et met à jour
KPI, banner, 4 graphiques Chart.js et la heatmap ; la table détaillée,
elle, n'est **pas reconstruite** — `updateTable()` masque/affiche
simplement les `<tr>` déjà présentes dans le DOM en comparant leur `id`
projet (extrait par regex de l'attribut `href` du lien client). **Cette
fonction `applyFilters()` est appelée une première fois inconditionnellement
à la fin du script** (`// First paint`), donc le rendu PHP initial n'est
visible qu'une fraction de seconde avant d'être immédiatement recalculé/
écrasé par le chemin JS — dans les faits, la logique JS est le chemin
qui s'affiche réellement à l'utilisateur, le PHP ne sert que de squelette
HTML + valeur initiale pour "aucun filtre".

**Bascule de thème incohérente avec le reste de l'app** : ici,
`themeToggle` déclenche `location.reload()` (après 80 ms) au lieu de
basculer `data-theme` en direct comme dans `Gantt.blade.php`/
`edit-projet.blade.php`/`details-projet.blade.php` — nécessaire car les
couleurs des 4 graphiques Chart.js sont capturées une seule fois dans des
constantes JS (`isDark`, `COLORS`) au chargement du script, jamais
recalculées après coup (contrairement à `details-projet.blade.php` qui,
lui, met à jour son unique graphique en direct au toggle, voir §13.4).
Reproduire ce choix (recharger vs. recalculer les couleurs de charts) est
à trancher explicitement dans une réécriture — les deux approches
coexistent aujourd'hui dans la même app.

**⚠️ Correction d'une note obsolète de `CLAUDE.md`** : le fichier
`CLAUDE.md` du dépôt affirme encore (section "Historique de features
2026-07-24") que `tableau-de-bord.blade.php` "interroge encore
`projet_livrables` directement" pour un KPI de livrables (`$livPct`/
`$livStats`). **Ce n'est plus vrai à la lecture du code actuel** — aucune
référence à `livrable`/`projet_livrables` n'existe dans ce fichier
aujourd'hui ; le KPI "Chapitres terminés" (basé sur `suivi_chapitres`,
voir plus haut) l'a manifestement remplacé depuis. Ne pas se fier à cette
note de `CLAUDE.md` pour une réécriture — elle documente un état du code
antérieur à la version actuelle.

**Aucun graphique/KPI de ce tableau de bord ne touche aux tables legacy**
(`livrables_smi`/`projet_livrables`/`livrable_preuves`) — contrairement à
ce que suggérait CLAUDE.md, ce dashboard est déjà entièrement aligné sur
le système actuel (chapitres SMI + formations + Gantt indirectement via
`affectations`).

---

## 14. Schéma SQL exact (DDL réel, extrait de la base MySQL vivante)

> Contrairement au §11 (déduit des migrations), ce qui suit est le
> **`SHOW CREATE TABLE` réel** de chaque table métier, tel qu'il existe
> aujourd'hui dans `lmc_conseil_db` (2026-07-28) — la source la plus
> fiable possible pour reproduire le schéma dans un autre stack/SGBD :
> types exacts, longueurs, valeurs par défaut, nullabilité, index,
> contraintes de clé étrangère et leur `ON DELETE`. `ENGINE=InnoDB`,
> `CHARSET=utf8mb4`/`COLLATE=utf8mb4_unicode_ci` partout.

```sql
CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(255) NOT NULL,
  `secteur_activite` varchar(255) DEFAULT NULL,
  `adresse` text,
  `telephone` varchar(255) DEFAULT NULL,
  `email_contact` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `consultants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom_complet` varchar(255) NOT NULL,
  `type_consultant` enum('Interne','Freelancer','Externe') NOT NULL DEFAULT 'Interne',
  `specialite` text,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `normes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code_norme` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `projets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference_projet` varchar(255) NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `chef_projet_id` bigint unsigned NOT NULL,
  `type_projet` varchar(255) NOT NULL DEFAULT 'SMI — Système de Management Intégré',
  `statut` enum('Finalisé','En cours','Planifié','En retard','En pause') NOT NULL DEFAULT 'Planifié',
  `jours_prevus` int NOT NULL DEFAULT '0',
  `jours_realises` int NOT NULL DEFAULT '0',
  `avancement_percent` int NOT NULL DEFAULT '0',
  `blocage` text,
  `commentaire` text,
  `date_debut` date DEFAULT NULL,
  `date_fin_prevue` date DEFAULT NULL,
  `date_fin_reelle` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`reference_projet`),
  CONSTRAINT FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`chef_projet_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE
);

CREATE TABLE `projet_normes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `norme_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`norme_id`) REFERENCES `normes` (`id`) ON DELETE CASCADE
);

CREATE TABLE `chapitres_smis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code_chapitre` varchar(255) NOT NULL,
  `titre_chapitre` varchar(255) NOT NULL,
  `exigences_cles` text,
  `ordre` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ⚠️ VOIR AVERTISSEMENT CRITIQUE JUSTE APRÈS CE BLOC — la 3e valeur de cet
-- enum est CORROMPUE en base réelle (contient un '?' littéral, pas l'emoji 🔄).
CREATE TABLE `suivi_chapitres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `chapitre_id` bigint unsigned NOT NULL,
  `avancement_percent` int NOT NULL DEFAULT '0',
  `phase` enum('⬜ Non démarré','⏳ Démarré','? En cours','✅ Terminé') NOT NULL DEFAULT '⬜ Non démarré',
  `jours_intervention` int NOT NULL DEFAULT '0',
  `statut_livrables` text,
  `lien_onedrive` varchar(255) DEFAULT NULL,
  `observations` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`chapitre_id`) REFERENCES `chapitres_smis` (`id`) ON DELETE CASCADE
);

CREATE TABLE `formations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titre_formation` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `projet_formations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `formation_id` bigint unsigned NOT NULL,
  `statut` enum('Finalisée','Réalisée','À planifier','En cours') NOT NULL DEFAULT 'À planifier',
  `observations` text,
  `jours_realises` decimal(5,1) NOT NULL DEFAULT '0.0',
  `date_realisation` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE
);

CREATE TABLE `affectations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `consultant_id` bigint unsigned NOT NULL,
  `role_dans_projet` varchar(255) DEFAULT NULL,
  `jours_alloues` decimal(5,1) NOT NULL DEFAULT '0.0',
  `jours_realises` decimal(5,1) NOT NULL DEFAULT '0.0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE
);

CREATE TABLE `sensibilisations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `theme` varchar(255) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `jours_prevus` decimal(5,1) NOT NULL DEFAULT '0.0',
  `date_realisation` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
);

CREATE TABLE `gantt_phases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ordre` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
);

-- consultant_id : colonne LEGACY, plus lue/écrite par le code (voir gantt_tache_consultant)
CREATE TABLE `gantt_taches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `phase_id` bigint unsigned DEFAULT NULL,
  `consultant_id` bigint unsigned DEFAULT NULL,           -- legacy, non utilisé
  `type_tache` varchar(255) NOT NULL DEFAULT 'phase',      -- 'phase' | 'journee'
  `numero` int DEFAULT NULL,
  `designation` varchar(255) NOT NULL,
  `unite` varchar(255) NOT NULL DEFAULT 'H/J',
  `responsable` varchar(255) DEFAULT NULL,
  `ct_prevue` decimal(8,2) NOT NULL DEFAULT '0.00',
  `ct_realisee` decimal(8,2) NOT NULL DEFAULT '0.00',
  `avancement` decimal(5,2) NOT NULL DEFAULT '0.00',        -- 0-100
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `date_interruption` date DEFAULT NULL,
  `jours_choisis` json DEFAULT NULL,                        -- ["YYYY-MM-DD", ...]
  `date_reprise` date DEFAULT NULL,
  `segments` json DEFAULT NULL,                             -- [{type,debut,fin,jours,fill_jours}, ...]
  -- Colonnes legacy (v1 du Gantt, avant la refonte du 2026-07-16) — plus utilisées :
  `delai_jours` int NOT NULL DEFAULT '1',
  `date_fin_initiale` date DEFAULT NULL,
  `arret_1` date DEFAULT NULL,
  `reprise_1` date DEFAULT NULL,
  `arret_2` date DEFAULT NULL,
  `reprise_2` date DEFAULT NULL,
  `delai_sup` int NOT NULL DEFAULT '0',
  `date_fin_calculee` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`phase_id`) REFERENCES `gantt_phases` (`id`) ON DELETE SET NULL,
  CONSTRAINT FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE SET NULL
);

CREATE TABLE `gantt_tache_consultant` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gantt_tache_id` bigint unsigned NOT NULL,
  `consultant_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`gantt_tache_id`,`consultant_id`),
  CONSTRAINT FOREIGN KEY (`gantt_tache_id`) REFERENCES `gantt_taches` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE
);

CREATE TABLE `taches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `consultant_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `assigned_by` bigint unsigned DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `objectif` text,
  `date` date NOT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `statut` enum('Assignée','Lue','Acceptée','Refusée','En cours','Terminée') NOT NULL DEFAULT 'Assignée',
  `lu_at` timestamp NULL DEFAULT NULL,
  `reponse_at` timestamp NULL DEFAULT NULL,
  `commentaire` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('super_admin','chef_projet','consultant') NOT NULL DEFAULT 'consultant',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `consultant_id` bigint unsigned DEFAULT NULL,
  `permissions` json DEFAULT NULL,
  `statut_compte` enum('en_attente','approuve','refuse') NOT NULL DEFAULT 'approuve',
  `motif_refus` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`email`),
  CONSTRAINT FOREIGN KEY (`consultant_id`) REFERENCES `consultants` (`id`) ON DELETE SET NULL
);

CREATE TABLE `acces_audit_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `action` enum('approuve','refuse') NOT NULL,
  `performed_by` bigint unsigned DEFAULT NULL,
  `details` text,
  `created_at` timestamp NULL DEFAULT NULL,               -- pas d'updated_at (const UPDATED_AT = null côté modèle)
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`performed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
);

CREATE TABLE `user_projet_access` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `projet_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`user_id`,`projet_id`),
  CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
);

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,                                   -- UUID
  `type` varchar(255) NOT NULL,                             -- classe PHP de la notification (nom complet)
  `notifiable_type` varchar(255) NOT NULL,                  -- polymorphe, toujours 'App\Models\User' ici
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text NOT NULL,                                     -- JSON sérialisé (toDatabase())
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`notifiable_type`,`notifiable_id`)
);

CREATE TABLE `projet_preuves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `fichier_nom` varchar(255) NOT NULL,
  `fichier_path` varchar(255) NOT NULL,                     -- URL Cloudinary complète (secure_url)
  `mime_type` varchar(255) DEFAULT NULL,
  `taille_kb` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
);

-- ── Tables LEGACY (schéma conservé, plus aucun code applicatif actif ne les lit/écrit) ──
CREATE TABLE `livrables_smi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chapitre_code` varchar(20) NOT NULL,
  `clause` varchar(30) DEFAULT NULL,
  `libelle` text NOT NULL,
  `phase_smi` varchar(100) DEFAULT NULL,
  `ordre` smallint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `projet_livrables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `livrable_id` bigint unsigned NOT NULL,
  `statut` enum('Non commencé','En cours','Terminé') NOT NULL DEFAULT 'Non commencé',
  `observations` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`projet_id`,`livrable_id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`livrable_id`) REFERENCES `livrables_smi` (`id`) ON DELETE CASCADE
);

CREATE TABLE `livrable_preuves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint unsigned NOT NULL,
  `livrable_id` bigint unsigned NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `fichier_nom` varchar(255) NOT NULL,
  `fichier_path` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `taille_kb` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`livrable_id`) REFERENCES `livrables_smi` (`id`) ON DELETE CASCADE
);
```

### 🔴 Bug critique découvert (corruption de données, pas juste un bug d'affichage)

En comparant les octets réels de `information_schema.COLUMNS` (pas
seulement la sortie texte, qui peut mentir sur un terminal), la 3ᵉ valeur
de l'enum `suivi_chapitres.phase` **n'est PAS `🔄 En cours`** en base
réelle — c'est littéralement le caractère `?` (0x3F) suivi de
`" En cours"`. Vérifié en hexadécimal :
`... 27 3f 20 45 6e 20 63 6f 75 72 73 27 ...` = `'? En cours'`, alors que
les 3 autres valeurs (`⬜`, `⏳`, `✅`) sont, elles, correctement encodées.

**Explication technique** : `🔄` (U+1F504) est un caractère **astral**
(4 octets en UTF-8, nécessite `utf8mb4`), alors que `⬜`/`⏳`/`✅` sont
dans le plan de base Unicode (3 octets, compatibles avec l'ancien
charset `utf8` MySQL 3-octets). Un `ALTER TABLE`/import exécuté à un
moment donné avec une connexion en charset `utf8` (au lieu de
`utf8mb4`) a silencieusement tronqué le seul caractère 4-octets du
groupe en `?`, sans erreur.

**Impact réel vérifié** : `SELECT phase, COUNT(*) FROM suivi_chapitres
GROUP BY phase` (2026-07-28) montre que **les 28 lignes existantes sont
toutes à `⬜ Non démarré`** (la valeur par défaut) — aucune ligne n'est
à `⏳ Démarré`, `? En cours` ou `✅ Terminé`, alors que
`DatabaseSeeder.php` insère explicitement des projets avec des chapitres
à ces 3 autres statuts. `sql_mode` de la connexion inclut
`STRICT_TRANS_TABLES` : toute tentative applicative d'écrire la valeur
`🔄 En cours` (ex. via `edit-projet.blade.php`, qui envoie l'emoji brut
dans son `<select name="chapitres[...][phase]">`, voir §13.2) provoque
une **erreur SQL 1265 "Data truncated for column 'phase'"**, qui fait
échouer toute la transaction `EditController::update` (retour utilisateur :
message d'erreur générique, aucune donnée enregistrée). **Personne ne
peut donc actuellement passer un chapitre à "🔄 En cours" sans que
l'enregistrement échoue silencieusement (pour l'utilisateur).** Combiné
aux 2 bugs d'affichage déjà identifiés en §13.4 (comparaisons de chaîne
sans emoji dans `details-projet.blade.php`), le champ `phase` des
chapitres SMI est la zone la plus fragile de tout le schéma actuel.

**Recommandation pour une réécriture** : ne jamais utiliser un
caractère Unicode astral (emoji hors BMP) comme valeur discriminante
d'un `ENUM`/type énuméré en base — stocker un code stable
(`not_started`/`started`/`in_progress`/`done`) et ne mapper l'emoji
qu'en couche d'affichage. S'applique aussi par précaution aux autres
enums à emoji du code (aucun autre n'a été trouvé corrompu à ce jour,
mais le même risque existe structurellement).

---

## 15. Référence consolidée des règles de validation (par formulaire/action)

Vue portable de toutes les règles `$request->validate([...])` du code,
regroupées par entité — utile pour redéfinir des schémas de validation
dans un autre langage sans avoir à parcourir chaque contrôleur.
**Incohérences réelles relevées entre couches** (marquées ⚠️) : la
duplication de règles entre contrôleurs web et API n'est pas qu'une note
théorique de CLAUDE.md, elle produit de vraies divergences de valeurs
acceptées.

### Projet

| Champ | `NouveauProjetController::store` | `EditController::update` | `Api\ProjetController` (non routé) |
|---|---|---|---|
| `reference_projet` | required, string, max:255, unique | required, string, max:255, unique (hors id courant) | required, string, unique |
| `client_nom` / `client_id` | `client_nom` required, string, max:255 (résolution par nom, insensible à la casse) | `client_nom` required, string, max:255 | ⚠️ `client_id` required, exists:clients,id (FK directe, pas de résolution par nom) |
| `client_logo` | nullable, image, mimes:jpg,jpeg,png,webp, max:2048 Ko | idem | — (non géré) |
| `chef_projet_id` | required, integer, exists:consultants,id | required, exists:consultants,id | required, exists:consultants,id |
| `statut` | ⚠️ required, in: **Planifié, En cours, En retard, Finalisé** (4 valeurs — **`En pause` absent**, alors que la colonne DB l'autorise) | même 4 valeurs, même absence de `En pause` | required, in: **Finalisé, En cours, Planifié, En retard, En pause** (5 valeurs, conforme à la colonne DB) |
| `type_projet` | required, string, max:255 | required, string, max:255 | required, string |
| `jours_prevus` | required, integer, min:0 | required, integer, min:0 | required, integer |
| `jours_realises` | required, integer, min:0 | nullable, integer, min:0 | required, numeric |
| `avancement_percent` | required, integer, 0-100 | *(non validé — recalculé serveur, voir §12.6)* | required, integer, 0-100 |
| `date_debut` | nullable, date | nullable, date | nullable, date |
| `date_fin_prevue` | nullable, date, **after_or_equal:date_debut** | ⚠️ nullable, date (pas de contrainte d'ordre avec `date_debut`) | nullable, date |
| `date_fin_reelle` | nullable, date | nullable, date | nullable, date |
| `blocage` / `commentaire` | nullable, string | nullable, string | nullable, string |
| `secteur_activite` | nullable, string, max:100 | nullable, string, max:100 | — |
| `normes[]` | nullable, array ; chaque id integer, exists:normes,id | idem | sometimes, array |
| `chapitres[].lien_onedrive` | nullable, url, regex `(sharepoint\.com\|onedrive\.live\.com\|1drv\.ms)` | idem | — |
| `custom_formations[]` | — (utilise `formations[]`/`new_consultants[]` à la place, structure différente) | array ; `.titre` required_with, string, max:255 ; `.statut` nullable, string, max:100 ; `.jours` nullable, numeric, min:0 ; `.date_realisation` nullable, date ; `.observations` nullable, string ; `.id_original` nullable, integer | array ; mêmes sous-règles que `EditController` |
| `sensibilisations[]` | array ; `.theme` nullable, string, max:255 ; `.photo` nullable, image, mimes:jpg,jpeg,png,webp, **max:5120 Ko** (5 Mo, différent du logo client à 2 Mo) ; `.jours_prevus` nullable, numeric, min:0 ; `.date_realisation` nullable, date | même structure, wipe-and-reinsert (voir §12.4) | — |

### Consultant

| Champ | `ConsultantController` (web) | `Api\ConsultantController` (non routé) |
|---|---|---|
| `nom_complet` | required, string, max:255 | required, string, max:255 |
| `type_consultant` | required, in: **Interne, Freelancer, Externe** (3 valeurs, conforme DB) | ⚠️ required, in: **Interne, Freelancer** (2 valeurs — `Externe` rejeté alors que la colonne DB l'autorise depuis le 2026-07-24) |
| `specialite` | nullable, string, max:255 | nullable, string |
| `email` | nullable, email, max:255 | nullable, email |
| `telephone` | nullable, string, max:50 | nullable, string |
| `actif` | boolean (update uniquement) | boolean |

### Tâche calendrier (`Tache`)

| Action | Règles |
|---|---|
| Assignation (`CalendrierAdminController::store`) / modification (`::update`) | `client_id` nullable, exists:clients,id ; `titre` required, string, max:255 ; `objectif` nullable, string ; `date` required, date ; `heure_debut` nullable, date_format:H:i ; `heure_fin` nullable, date_format:H:i, after:heure_debut |
| Déplacement drag & drop (`::deplacer`) | `date` required, date ; `heure_debut`/`heure_fin` mêmes règles que ci-dessus |
| Réponse du consultant (`CalendrierController::repondre`) | `statut` required, in: Acceptée, Refusée, En cours, Terminée ; `commentaire` nullable, string |

### Compte utilisateur

| Action | Règles |
|---|---|
| Inscription (`RegisterController::store`) | `prenom`/`nom` required, string, max:255 ; `email` required, email, unique:users,email ; `password` required, min:8, confirmed |
| Modification par admin (`AdminUserController::update`) | `name` required, string, max:255 ; `email` required, email, unique (hors id courant) ; `role` required, in:super_admin,chef_projet,consultant ; `password` nullable, min:8 |
| Approbation (`AdminUserController::approuver`) | `role` required, in:super_admin,chef_projet,consultant ; `permissions` nullable, array ; `consultant_mode` required_unless:role,super_admin, in:existing,nouveau ; `consultant_id` required_if:consultant_mode,existing, exists:consultants,id ; `nouveau_type_consultant` required_if:consultant_mode,nouveau, in:Interne,Freelancer (⚠️ `Externe` absent ici aussi) ; `nouveau_specialite` nullable, string, max:255 ; `nouveau_telephone` nullable, string, max:50 |
| Refus (`AdminUserController::refuser`) | `motif_refus` nullable, string, max:1000 |
| Accès directs projets (`AdminUserController::mettreAJourAccesProjets`) | `projets[]` nullable, array ; chaque id exists:projets,id |

### Gantt

| Action | Règles |
|---|---|
| Phase (`storePhase`/`updatePhase`) | `nom` required, string, max:255 |
| Tâche (`storeTache`/`updateTache`) | `designation` required, string, max:255 ; `phase_id` nullable, exists:gantt_phases,id ; `consultant_ids[]` nullable, array, chaque id exists:consultants,id ; `date_reprise` nullable, date, required_with:date_interruption ; `date_interruption` nullable, date, required_with:date_reprise, **before_or_equal:date_reprise** ; type `journee` → `jours[]` nullable, array de dates, **doit égaler `ct_prevue` en nombre (sauf report actif → ≤)** ; type `phase` → `date_debut` nullable, date, `ct_prevue` nullable, numeric, min:0 |

### Preuve projet (`ProjetPreuveController::upload`)

`projet_id` required, integer, exists:projets,id ; `fichier` required, file, **max:10240 Ko (10 Mo)**, mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx ; `label` nullable, string, max:255.

---

## Récapitulatif quantitatif

| Élément | Nombre |
|---|---|
| Modèles Eloquent (`app/Models`) | 16 |
| Contrôleurs (`app/Http/Controllers`, y compris `Controller.php` de base) | 22 |
| Routes actives déclarées dans `routes/web.php` (hors routes framework auto) | 49 |
| Routes framework ajoutées automatiquement (`up`, `storage/{path}` ×2) | 3 |
| Routes `apiResource` déclarées dans `routes/api.php` (non actives) | 9 (→ jusqu'à 45 endpoints potentiels) |
| Migrations (`database/migrations`) | 43 |
| Services (`app/Services`) | 7 |
| Jobs custom (`app/Jobs`) | 0 |
| Observers (`app/Observers`) | 1 |
| Notifications (`app/Notifications`) | 4 |
| Mailables (`app/Mail`) | 3 |
| Middlewares custom (`app/Http/Middleware`) | 3 |
| Vues Blade (`resources/views`, y compris `emails/` et `admin/`) | 26 |
| Tables métier définies par les migrations (hors tables système Laravel) | 21 |
| Tables système Laravel (auth/cache/queue/notifications) | 9 |
| Bugs réels confirmés en base/code (§13.4, §14) | 3 (2 d'affichage + 1 corruption de données bloquant l'enregistrement) |
| Incohérences de validation confirmées entre couches (§15) | 4 (`statut` projet, `type_consultant`, contrainte de dates, permission `Externe` à l'approbation) |

### Sections de ce document

1. Arborescence — 2. Modèles — 3. Contrôleurs — 4. Routes — 5. Migrations
— 6. Services — 7. Jobs — 8. Observers — 9. Notifications/Mail —
10. Vues Blade (rôle général) — 11. Structure DB (résumé) —
12. **Logique applicative** (flux métier de bout en bout) —
13. **Anatomie détaillée** des 5 vues les plus complexes (Gantt, création/
édition projet, détails projet, tableau de bord PMO) — 14. **DDL SQL
exact** + bug critique — 15. **Règles de validation consolidées** par
formulaire.

Avec cette 5ᵉ vue (`tableau-de-bord.blade.php`), les **7 vues Blade non
triviales** de l'application (les 5 ci-dessus + les vues Calendrier/Admin
déjà couvertes fonctionnellement en §12.8) sont toutes documentées en
profondeur. Les vues restantes non détaillées (`projets.blade.php`,
`consultants.blade.php`, `login`/`register`, `admin-users.blade.php`,
templates `emails/`) sont des CRUD/formulaires simples sans logique
métier propre au-delà de ce qui est déjà couvert en §3/§12 — donc à
faible risque pour une réécriture.
