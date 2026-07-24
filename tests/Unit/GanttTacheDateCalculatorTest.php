<?php

namespace Tests\Unit;

use App\Models\GanttTache;
use App\Services\GanttTacheDateCalculator;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class GanttTacheDateCalculatorTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_ajouter_jours_ouvres_saute_le_weekend(): void
    {
        $calc = new GanttTacheDateCalculator();
        $vendredi = Carbon::parse('2026-07-31'); // vendredi

        $this->assertSame('2026-08-03', $calc->ajouterJoursOuvres($vendredi, 1)->toDateString());
    }

    public function test_prochain_jour_ouvre_avance_depuis_un_weekend(): void
    {
        $calc = new GanttTacheDateCalculator();
        $samedi = Carbon::parse('2026-08-01');

        $this->assertSame('2026-08-03', $calc->prochainJourOuvre($samedi)->toDateString());
    }

    public function test_segment_de_reprise_apres_report_avec_weekend_interne(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'phase',
            'ct_prevue' => 6.0,
            'ct_realisee' => 2.0,
            'avancement' => 33.0,
            'date_debut' => Carbon::parse('2026-07-22'),
            'jours_choisis' => null,
            'date_reprise_demandee' => Carbon::parse('2026-07-28'),
            'date_interruption_demandee' => Carbon::parse('2026-07-24'),
        ]);

        $this->assertSame('2026-08-03', $resultat['date_fin']->toDateString());

        $realisation = collect($resultat['segments'])->where('type', 'realisation')->values();
        $this->assertSame('2026-07-29', $realisation[1]['debut']);
        $this->assertSame('2026-07-31', $realisation[1]['fin']);
        $this->assertSame('2026-08-03', $realisation[2]['debut']);
        $this->assertSame('2026-08-03', $realisation[2]['fin']);

        $report = collect($resultat['segments'])->firstWhere('type', 'report');
        $this->assertNotNull($report);
        $this->assertSame(0, $report['fill_jours']);
    }

    public function test_depassement_ct_realise_avec_avancement_incomplet_force_un_jour_restant(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'phase',
            'ct_prevue' => 4.0,
            'ct_realisee' => 6.0, // dépassement
            'avancement' => 40.0, // pas terminée
            'date_debut' => Carbon::parse('2026-07-22'),
            'jours_choisis' => null,
            'date_reprise_demandee' => Carbon::parse('2026-07-28'),
            'date_interruption_demandee' => Carbon::parse('2026-07-24'),
        ]);

        $this->assertTrue($resultat['date_fin']->gt($resultat['date_reprise']));
        $this->assertTrue(collect($resultat['segments'])->contains(fn ($s) => $s['type'] === 'realisation' && $s['debut'] >= '2026-07-29'));
    }

    public function test_date_interruption_avant_date_debut_est_rejetee(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $this->expectException(ValidationException::class);

        $calc->calculerPourTache($tache, [
            'type_tache' => 'phase',
            'ct_prevue' => 6.0,
            'ct_realisee' => 2.0,
            'avancement' => 33.0,
            'date_debut' => Carbon::parse('2026-07-22'),
            'jours_choisis' => null,
            'date_reprise_demandee' => Carbon::parse('2026-07-28'),
            'date_interruption_demandee' => Carbon::parse('2026-07-20'), // avant date_debut
        ]);
    }

    public function test_journee_avec_report_garde_les_jours_choisis_en_blocs_independants(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'journee',
            'ct_prevue' => 6.0,
            'ct_realisee' => 4.0,
            'avancement' => 50.0,
            'date_debut' => null,
            'jours_choisis' => ['2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16'],
            'date_reprise_demandee' => Carbon::parse('2026-07-21'),
            // La fenêtre de conflit est [date_interruption, date_reprise] incluse :
            // 17 (lendemain du dernier jour choisi) pour qu'aucun jour choisi ne
            // tombe dedans et ne soit décalé par resoudreConflitsJoursChoisis().
            'date_interruption_demandee' => Carbon::parse('2026-07-17'),
        ]);

        $this->assertSame('2026-07-21', $resultat['date_reprise']->toDateString());
        $this->assertSame('2026-07-17', $resultat['date_interruption']->toDateString());
        // date_fin reste le max de jours_choisis — pas de projection automatique
        // pour Journée, les jours restants sont choisis plus tard par l'utilisateur.
        $this->assertSame('2026-07-16', $resultat['date_fin']->toDateString());

        $journee = collect($resultat['segments'])->where('type', 'journee')->values();
        $this->assertCount(4, $journee);
        $this->assertSame(['2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16'], $journee->pluck('debut')->all());

        // Report du lendemain de l'interruption (17/07) à la reprise (21/07),
        // weekend 18-19 exclu -> 3 jours ouvrés au total (17, 20, 21).
        $reportJours = collect($resultat['segments'])->where('type', 'report')->sum('jours');
        $this->assertEquals(3, $reportJours);
    }

    public function test_journee_report_deplace_les_jours_choisis_tombant_dans_la_fenetre(): void
    {
        // Une date de début de report saisie AVANT le dernier jour choisi (14/07
        // au lieu de 17/07, avec des jours choisis jusqu'au 16/07) place les jours
        // 14, 15 et 16 dans la fenêtre de report [14, 21] -> ils sont décalés aux
        // prochains jours ouvrés libres après le 21 (22, 23, 24). Seul le 13/07
        // (avant la fenêtre) reste inchangé. Aucun segment "journee" ne se
        // retrouve donc sous le report (bug constaté le 2026-07-22).
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'journee',
            'ct_prevue' => 6.0,
            'ct_realisee' => 4.0,
            'avancement' => 50.0,
            'date_debut' => null,
            'jours_choisis' => ['2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16'],
            'date_reprise_demandee' => Carbon::parse('2026-07-21'),
            'date_interruption_demandee' => Carbon::parse('2026-07-14'),
        ]);

        $this->assertSame(['2026-07-13', '2026-07-22', '2026-07-23', '2026-07-24'], $resultat['jours_choisis']);

        $report = collect($resultat['segments'])->where('type', 'report')->values();
        $this->assertTrue($report->every(fn ($s) => $s['debut'] >= '2026-07-14'));

        $journee = collect($resultat['segments'])->where('type', 'journee')->values();
        $this->assertSame(['2026-07-13', '2026-07-22', '2026-07-23', '2026-07-24'], $journee->pluck('debut')->all());
    }

    public function test_journee_decale_les_jours_choisis_en_conflit_avec_la_fenetre_de_report(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        // 14 et 15 tombent dans la fenêtre de report [14, 21] -> doivent être
        // décalés aux prochains jours ouvrés libres après le 21 (22, 23).
        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'journee',
            'ct_prevue' => 2.0,
            'ct_realisee' => 0.0,
            'avancement' => 0.0,
            'date_debut' => null,
            'jours_choisis' => ['2026-07-14', '2026-07-15'],
            'date_reprise_demandee' => Carbon::parse('2026-07-21'),
            'date_interruption_demandee' => Carbon::parse('2026-07-14'),
        ]);

        $this->assertSame(['2026-07-22', '2026-07-23'], $resultat['jours_choisis']);
        $this->assertSame('2026-07-22', $resultat['date_debut']->toDateString());
        $this->assertSame('2026-07-23', $resultat['date_fin']->toDateString());

        $journee = collect($resultat['segments'])->where('type', 'journee')->values();
        $this->assertSame(['2026-07-22', '2026-07-23'], $journee->pluck('debut')->all());
    }

    public function test_journee_decale_en_evitant_les_collisions_avec_des_jours_deja_choisis(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        // Le 22/07 est déjà choisi (après la reprise) -> le jour décalé (14, en
        // conflit) doit sauter cette collision et atterrir sur le 23/07.
        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'journee',
            'ct_prevue' => 2.0,
            'ct_realisee' => 0.0,
            'avancement' => 0.0,
            'date_debut' => null,
            'jours_choisis' => ['2026-07-14', '2026-07-22'],
            'date_reprise_demandee' => Carbon::parse('2026-07-21'),
            'date_interruption_demandee' => Carbon::parse('2026-07-14'),
        ]);

        $this->assertSame(['2026-07-22', '2026-07-23'], $resultat['jours_choisis']);
    }

    public function test_journee_sans_conflit_ne_modifie_pas_jours_choisis(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'journee',
            'ct_prevue' => 4.0,
            'ct_realisee' => 4.0,
            'avancement' => 50.0,
            'date_debut' => null,
            'jours_choisis' => ['2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16'],
            'date_reprise_demandee' => Carbon::parse('2026-07-21'),
            'date_interruption_demandee' => Carbon::parse('2026-07-17'),
        ]);

        $this->assertSame(['2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16'], $resultat['jours_choisis']);
    }

    public function test_journee_avec_report_relache_puis_complete_les_jours_choisis(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        // Les 2 jours restants (pour atteindre CT Prévu=6) sont choisis après la reprise.
        $resultat = $calc->calculerPourTache($tache, [
            'type_tache' => 'journee',
            'ct_prevue' => 6.0,
            'ct_realisee' => 6.0,
            'avancement' => 100.0,
            'date_debut' => null,
            'jours_choisis' => ['2026-07-13', '2026-07-14', '2026-07-15', '2026-07-16', '2026-07-22', '2026-07-23'],
            'date_reprise_demandee' => Carbon::parse('2026-07-21'),
            'date_interruption_demandee' => Carbon::parse('2026-07-17'),
        ]);

        $journee = collect($resultat['segments'])->where('type', 'journee')->values();
        $this->assertCount(6, $journee);
        // Les jours choisis après la reprise gardent la même couleur/type "journee"
        // — aucune distinction visuelle avec ceux d'avant la pause.
        $this->assertSame('2026-07-22', $journee[4]['debut']);
        $this->assertSame('2026-07-23', $journee[5]['debut']);
    }

    public function test_construire_segments_rejoue_a_l_identique(): void
    {
        $calc = new GanttTacheDateCalculator();
        $tache = new GanttTache(['date_reprise' => null, 'date_interruption' => null]);

        $donnees = [
            'type_tache' => 'phase', 'ct_prevue' => 6.0, 'ct_realisee' => 2.0, 'avancement' => 33.0,
            'date_debut' => Carbon::parse('2026-07-22'), 'jours_choisis' => null,
            'date_reprise_demandee' => Carbon::parse('2026-07-28'),
            'date_interruption_demandee' => Carbon::parse('2026-07-24'),
        ];

        $resultat = $calc->calculerPourTache($tache, $donnees);

        $rejoue = $calc->construireSegments(
            'phase',
            $resultat['date_debut'],
            $resultat['date_fin'],
            $resultat['date_interruption'],
            $resultat['date_reprise'],
            null,
            33.0
        );

        $this->assertSame($resultat['segments'], $rejoue);
    }
}
