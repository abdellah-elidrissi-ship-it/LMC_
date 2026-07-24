<?php

namespace App\Services;

use App\Models\GanttTache;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

/**
 * Centralise tout le calcul de dates/segments d'une tâche Gantt — appelé
 * uniquement au save() (storeTache/updateTache/migration de backfill), jamais
 * au rendu. Gantt.blade.php ne fait plus qu'une projection date -> pixel sur
 * le résultat déjà stocké (colonne `segments`).
 */
class GanttTacheDateCalculator
{
    public function ajouterJoursOuvres(Carbon $depart, int $nbJours): Carbon
    {
        $date = $depart->copy();
        $restant = $nbJours;

        while ($restant > 0) {
            $date->addDay();
            if (!$date->isWeekend()) {
                $restant--;
            }
        }

        return $date;
    }

    public function prochainJourOuvre(Carbon $date): Carbon
    {
        $d = $date->copy();

        while ($d->isWeekend()) {
            $d->addDay();
        }

        return $d;
    }

    public function calculerDateFin(Carbon $dateDebut, float $ctJours): Carbon
    {
        $jours = max(1, (int) ceil($ctJours));

        return $this->ajouterJoursOuvres($dateDebut, $jours - 1);
    }

    /**
     * Découpe [debut, fin] en blocs contigus de jours ouvrés (les weekends
     * "coupent" un bloc en deux, ils ne sont jamais inclus dedans).
     */
    private function decouperEnBlocsOuvres(Carbon $debut, Carbon $fin): array
    {
        if ($fin->lt($debut)) {
            return [];
        }

        $blocs = [];
        $blocDebut = null;
        $cur = $debut->copy();

        while ($cur->lte($fin)) {
            if ($cur->isWeekend()) {
                if ($blocDebut) {
                    $blocs[] = ['debut' => $blocDebut, 'fin' => $cur->copy()->subDay()];
                    $blocDebut = null;
                }
            } elseif (!$blocDebut) {
                $blocDebut = $cur->copy();
            }
            $cur->addDay();
        }
        if ($blocDebut) {
            $blocs[] = ['debut' => $blocDebut, 'fin' => $fin->copy()];
        }

        return array_map(fn ($b) => [
            'debut' => $b['debut'],
            'fin' => $b['fin'],
            'jours' => $b['debut']->diffInDays($b['fin']) + 1,
        ], $blocs);
    }

    private function segmentsDecoupes(Carbon $debut, Carbon $fin, string $type): array
    {
        return array_map(
            fn ($b) => ['type' => $type, 'debut' => $b['debut'], 'fin' => $b['fin'], 'jours' => $b['jours']],
            $this->decouperEnBlocsOuvres($debut, $fin)
        );
    }

    /**
     * Répartit l'avancement (%) en jours ouvrés remplis, chronologiquement, à
     * travers les segments — les segments "report" ne sont jamais remplis.
     * En jours (pas en pixels) : fillWidth en pixels dépend de $jourWidth, une
     * constante de rendu, donc reste calculé côté vue.
     */
    private function repartirAvancement(array $segments, float $avancement): array
    {
        $totalJours = collect($segments)->where('type', '!=', 'report')->sum('jours');
        $joursRestants = $totalJours > 0 ? round($totalJours * min(max($avancement, 0), 100) / 100, 2) : 0;

        return array_map(function ($seg) use (&$joursRestants) {
            $fillJours = 0;
            if ($seg['type'] !== 'report') {
                if ($joursRestants >= $seg['jours']) {
                    $fillJours = $seg['jours'];
                    $joursRestants -= $seg['jours'];
                } elseif ($joursRestants > 0) {
                    $fillJours = round($joursRestants, 2);
                    $joursRestants = 0;
                }
            }

            return [
                'type' => $seg['type'],
                'debut' => $seg['debut']->toDateString(),
                'fin' => $seg['fin']->toDateString(),
                'jours' => $seg['jours'],
                'fill_jours' => $fillJours,
            ];
        }, $segments);
    }

    /**
     * Projection pure : à partir de dates déjà résolues, produit le tableau
     * de segments (déjà découpés aux weekends) à stocker en colonne JSON.
     * Aucune décision de date ici — réutilisée telle quelle par le backfill
     * ET par calculerPourTache(), pour ne jamais avoir deux implémentations
     * qui divergent.
     */
    public function construireSegments(
        string $typeTache,
        ?Carbon $dateDebut,
        ?Carbon $dateFin,
        ?Carbon $dateInterruption,
        ?Carbon $dateReprise,
        ?array $joursChoisis,
        float $avancement
    ): array {
        if ($typeTache === 'journee') {
            // Chaque jour choisi reste un bloc indépendant (même couleur, qu'il ait
            // été choisi avant ou après une éventuelle pause — pas de distinction
            // visuelle). Le report est un calque indépendant ajouté par-dessus,
            // exactement comme pour "phase" (même découpage en jours ouvrés).
            $joursTries = collect($joursChoisis ?? [])->map(fn ($d) => Carbon::parse($d))->sort()->values();

            $segments = $joursTries
                ->map(fn ($j) => ['type' => 'journee', 'debut' => $j->copy(), 'fin' => $j->copy(), 'jours' => 1])
                ->all();

            if ($dateInterruption !== null && $dateReprise !== null) {
                // [date_interruption, date_reprise] inclus, tel que saisi — fiable
                // car resoudreConflitsJoursChoisis() garantit en amont qu'aucun jour
                // choisi ne tombe dans cette fenêtre (les jours en conflit ont déjà
                // été décalés après date_reprise, voir GanttTacheDateCalculator).
                // Ancrer sur max(jours_choisis) comme avant ne fonctionne plus une
                // fois les jours décalés : le max inclut alors des jours APRÈS la
                // reprise, ce qui repoussait le report au-delà de date_reprise et le
                // faisait disparaître entièrement (bug constaté le 2026-07-22).
                if ($dateInterruption->lte($dateReprise)) {
                    $segments = array_merge($segments, $this->segmentsDecoupes($dateInterruption, $dateReprise, 'report'));
                }
            }

            return $this->repartirAvancement($segments, $avancement);
        }

        if (!$dateDebut) {
            return [];
        }

        $hasReport = $dateReprise !== null && $dateInterruption !== null;

        if (!$hasReport) {
            $fin = $dateFin ?? $dateDebut;

            return $this->repartirAvancement($this->segmentsDecoupes($dateDebut, $fin, 'realisation'), $avancement);
        }

        // Segment(s) réalisés avant la pause — jamais avant date_debut (garde
        // de sécurité, la contrainte est déjà garantie côté calculerPourTache).
        $finSeg1 = $dateInterruption->lt($dateDebut) ? $dateDebut->copy() : $dateInterruption->copy();
        $segments = $this->segmentsDecoupes($dateDebut, $finSeg1, 'realisation');

        // Segment(s) "report" (pause hachurée) : lendemain de l'interruption -> reprise.
        $debutPause = $finSeg1->copy()->addDay();
        if ($debutPause->lte($dateReprise)) {
            $segments = array_merge($segments, $this->segmentsDecoupes($debutPause, $dateReprise, 'report'));
        }

        // Segment(s) de reprise du travail, jusqu'à date_fin.
        if ($dateFin && $dateFin->gt($dateReprise)) {
            $segments = array_merge($segments, $this->segmentsDecoupes($dateReprise->copy()->addDay(), $dateFin, 'realisation'));
        }

        return $this->repartirAvancement($segments, $avancement);
    }

    /**
     * Point d'entrée décisionnel, appelé au save() (storeTache/updateTache et
     * migration de backfill). $donnees attend :
     * type_tache, ct_prevue, ct_realisee, avancement, date_debut (Carbon|null),
     * jours_choisis (array|null), date_reprise_demandee (Carbon|null),
     * date_interruption_demandee (Carbon|null) — les deux dates du report sont
     * saisies manuellement par l'utilisateur, jamais devinées.
     */
    public function calculerPourTache(GanttTache $tache, array $donnees): array
    {
        return $donnees['type_tache'] === 'journee'
            ? $this->resoudrePourJournee($donnees)
            : $this->resoudrePourPhase($donnees);
    }

    /**
     * "Report" pour une tâche journée : les jours déjà choisis (avant ou après
     * la pause) restent des blocs "journee" indépendants, identiques visuellement
     * — le report n'est qu'un calque de pause ajouté par-dessus (même mécanique
     * que "phase"). Contrairement à "phase", les jours ne sont pas continus :
     * l'utilisateur choisit les jours restants au fil de l'eau après la reprise,
     * pas de date_fin projetée automatiquement (impossible sans savoir quels
     * jours seront choisis) — date_fin reste le max de jours_choisis (déjà
     * résolu, voir resoudreConflitsJoursChoisis()).
     */
    private function resoudrePourJournee(array $donnees): array
    {
        // Comme pour "phase" : les deux dates sont exigées ensemble (déjà garanti
        // par la validation HTTP du contrôleur) — si l'une manque, pas de report.
        $dateReprise = $donnees['date_reprise_demandee'];
        $dateInterruption = $donnees['date_interruption_demandee'];
        if (!$dateReprise || !$dateInterruption) {
            $dateReprise = null;
            $dateInterruption = null;
        }

        $joursChoisis = ($dateReprise && $dateInterruption)
            ? $this->resoudreConflitsJoursChoisis($donnees['jours_choisis'] ?? [], $dateInterruption, $dateReprise)
            : ($donnees['jours_choisis'] ?? []);

        $jours = collect($joursChoisis)->map(fn ($d) => Carbon::parse($d));
        $dateDebut = $jours->isNotEmpty() ? $jours->min() : null;
        $dateFin = $jours->isNotEmpty() ? $jours->max() : null;

        return [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'date_interruption' => $dateInterruption,
            'date_reprise' => $dateReprise,
            'jours_choisis' => $joursChoisis,
            'segments' => $this->construireSegments('journee', $dateDebut, $dateFin, $dateInterruption, $dateReprise, $joursChoisis, $donnees['avancement']),
        ];
    }

    /**
     * Détecte les jours choisis tombant dans la fenêtre de report qui vient
     * d'être définie ([date_interruption, date_reprise], bornes incluses) et
     * les décale vers les prochains jours ouvrés libres après date_reprise,
     * dans l'ordre chronologique, sans collision avec des jours déjà choisis
     * (bug constaté le 2026-07-22 : un jour "journee" pouvait se retrouver sous
     * la pause hachurée du report sans qu'aucune donnée ne le corrige).
     * Sans effet si aucun jour ne tombe dans la fenêtre (idempotent : peut être
     * rappelé à chaque sauvegarde tant qu'un report reste actif).
     */
    private function resoudreConflitsJoursChoisis(array $joursChoisis, Carbon $dateInterruption, Carbon $dateReprise): array
    {
        $jours = collect($joursChoisis)->map(fn ($d) => Carbon::parse($d))->sort()->values();

        $enConflit = $jours->filter(fn ($j) => $j->gte($dateInterruption) && $j->lte($dateReprise))->values();
        if ($enConflit->isEmpty()) {
            return $jours->map(fn ($j) => $j->toDateString())->all();
        }

        $conserves = $jours->reject(fn ($j) => $j->gte($dateInterruption) && $j->lte($dateReprise))->values();
        $occupes = $conserves->map(fn ($j) => $j->toDateString())->flip()->all();

        $resultat = $conserves->map(fn ($j) => $j->toDateString())->all();
        $curseur = $dateReprise->copy();

        foreach ($enConflit as $ignore) {
            do {
                $curseur->addDay();
            } while ($curseur->isWeekend() || isset($occupes[$curseur->toDateString()]));

            $resultat[] = $curseur->toDateString();
            $occupes[$curseur->toDateString()] = true;
        }

        sort($resultat);

        return $resultat;
    }

    /**
     * "Report" est un état orthogonal (présence de date_reprise), pas un type
     * de tâche. date_interruption ("date de début du report") est saisie
     * manuellement par l'utilisateur — jamais devinée/calculée par le système
     * (fix du 2026-07-22 : l'auto-calcul sur la date du jour n'avait aucun
     * rapport avec le nombre de jours réellement travaillés, et produisait un
     * segment "réalisation avant le report" de longueur arbitraire).
     *
     * date_fin se recalcule pour représenter la fin RÉELLEMENT attendue : les
     * jours restants sont désormais CT Prévu − (jours ouvrés déjà couverts par
     * le segment AVANT la pause), positionnés à partir du lendemain de la
     * reprise. Fix du 2026-07-23 : l'ancienne formule (CT Prévu − CT Réalisé)
     * mélangeait deux notions différentes — CT Réalisé/avancement ne pilotent
     * QUE le remplissage visuel (repartirAvancement), pas la durée totale du
     * bâton. Résultat : dès que le segment avant la pause ne couvrait pas
     * exactement CT Prévu jours (ex. interruption posée plus tôt que prévu),
     * cette formule pouvait tomber à 0 alors qu'il restait bel et bien des
     * jours prévus non couverts nulle part — aucun segment 3 après la reprise,
     * bâton visuellement "arrêté" en plein report même à 100% d'avancement
     * (bug constaté sur "Constitution du comité de pilotage", CT Prévu=4,
     * CT Réalisé=4, interruption 2 jours seulement après le début).
     *
     * Cas de dépassement : si le segment avant la pause couvre déjà CT Prévu
     * mais que l'avancement est encore < 100%, la tâche continue réellement —
     * on force alors au moins 1 jour restant (fix du 2026-07-22, préservé ici).
     */
    private function resoudrePourPhase(array $donnees): array
    {
        $dateDebut = $donnees['date_debut'];
        $dateReprise = $donnees['date_reprise_demandee'];
        $dateInterruption = $donnees['date_interruption_demandee'];

        if (!$dateDebut) {
            return [
                'date_debut' => null,
                'date_fin' => null,
                'date_interruption' => null,
                'date_reprise' => null,
                'segments' => [],
            ];
        }

        if (!$dateReprise || !$dateInterruption) {
            $dateFin = $this->calculerDateFin($dateDebut, $donnees['ct_prevue']);

            return [
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'date_interruption' => null,
                'date_reprise' => null,
                'segments' => $this->construireSegments('phase', $dateDebut, $dateFin, null, null, null, $donnees['avancement']),
            ];
        }

        if ($dateInterruption->lt($dateDebut)) {
            throw ValidationException::withMessages([
                'date_interruption' => 'La date de début du report ne peut pas être avant la date de début de la tâche.',
            ]);
        }

        $finSeg1 = $dateInterruption->lt($dateDebut) ? $dateDebut->copy() : $dateInterruption->copy();
        $joursAvantPause = $this->joursOuvresDansIntervalle($dateDebut, $finSeg1);

        $joursRestants = max(0, $donnees['ct_prevue'] - $joursAvantPause);
        if ($joursRestants <= 0 && $donnees['avancement'] < 100) {
            $joursRestants = 1;
        }

        $dateFin = $joursRestants > 0
            ? $this->calculerDateFin($dateReprise->copy()->addDay(), $joursRestants)
            : $dateReprise->copy();

        return [
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'date_interruption' => $dateInterruption,
            'date_reprise' => $dateReprise,
            'segments' => $this->construireSegments('phase', $dateDebut, $dateFin, $dateInterruption, $dateReprise, null, $donnees['avancement']),
        ];
    }

    /**
     * Nombre de jours ouvrés dans [debut, fin] (bornes incluses) — utilisé pour
     * savoir combien de jours de CT Prévu le segment avant la pause couvre déjà.
     */
    private function joursOuvresDansIntervalle(Carbon $debut, Carbon $fin): int
    {
        return (int) collect($this->decouperEnBlocsOuvres($debut, $fin))->sum('jours');
    }
}
