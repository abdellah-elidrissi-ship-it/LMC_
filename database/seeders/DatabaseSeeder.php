<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Norme;
use App\Models\Projet;
use App\Models\ProjetNorme;
use App\Models\ChapitreSmi;
use App\Models\SuiviChapitre;
use App\Models\Formation;
use App\Models\ProjetFormation;
use App\Models\Affectation;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // =============================================
        // 1. تفريغ الجداول (تنظيف)
        // =============================================
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('affectations')->truncate();
        DB::table('projet_formations')->truncate();
        DB::table('suivi_chapitres')->truncate();
        DB::table('projet_normes')->truncate();
        DB::table('projets')->truncate();
        DB::table('formations')->truncate();
        DB::table('chapitres_smis')->truncate();
        DB::table('normes')->truncate();
        DB::table('consultants')->truncate();
        DB::table('clients')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // =============================================
        // 2. المستشارين (Consultants)
        // =============================================
        $consultantsData = [
            [
                'nom_complet' => 'FETOUH Meryem',
                'type_consultant' => 'Interne',
                'specialite' => 'QHSE, Systèmes Intégrés',
                'email' => 'meryem.fetouh@lmc-conseil.ma',
                'telephone' => '+212 6XX XXX XXX',
                'actif' => true
            ],
            [
                'nom_complet' => 'CHENNANI Hiba',
                'type_consultant' => 'Interne',
                'specialite' => 'Qualité, Audit interne',
                'email' => 'hiba.chennani@lmc-conseil.ma',
                'actif' => true
            ],
            [
                'nom_complet' => 'BENOUALA Hamid',
                'type_consultant' => 'Interne',
                'specialite' => 'Environnement, SST',
                'email' => 'hamid.benouala@lmc-conseil.ma',
                'actif' => true
            ],
            [
                'nom_complet' => 'RIFAK Wissam',
                'type_consultant' => 'Interne',
                'specialite' => 'Consultant QHSE',
                'email' => 'wissam.rifak@lmc-conseil.ma',
                'actif' => true
            ],
            [
                'nom_complet' => 'Mhammed EL YAGOUBI',
                'type_consultant' => 'Freelancer',
                'specialite' => 'Expert QHSE',
                'email' => 'mhammed.elyagoubi@example.com',
                'actif' => true
            ],
            [
                'nom_complet' => 'RIFAK Wisam', // ملاحظة: في الفيشي مكتوب مرة Wisam ومرة Wissam
                'type_consultant' => 'Interne',
                'specialite' => 'Consultant',
                'actif' => true
            ]
        ];

        foreach ($consultantsData as $data) {
            Consultant::create($data);
        }

        // جلب المستشارين بعد الإضافة
        $meryem = Consultant::where('nom_complet', 'FETOUH Meryem')->first();
        $hiba = Consultant::where('nom_complet', 'CHENNANI Hiba')->first();
        $hamid = Consultant::where('nom_complet', 'BENOUALA Hamid')->first();
        $wissam = Consultant::where('nom_complet', 'RIFAK Wissam')->first();
        $wisam = Consultant::where('nom_complet', 'RIFAK Wisam')->first();
        $mhammed = Consultant::where('nom_complet', 'Mhammed EL YAGOUBI')->first();

        // =============================================
        // 3. الزبائن (Clients) - 7 زبائن
        // =============================================
        $clientsData = [
            ['nom_client' => 'SOMADECO', 'secteur_activite' => 'Industrie'],
            ['nom_client' => 'AUTELEC', 'secteur_activite' => 'Électrique'],
            ['nom_client' => 'PETROFIB', 'secteur_activite' => 'Pétrochimie'],
            ['nom_client' => 'TSG', 'secteur_activite' => 'Services'],
            ['nom_client' => 'SOMATRIN', 'secteur_activite' => 'Transport'],
            ['nom_client' => 'SMTR CARRÉ', 'secteur_activite' => 'Transport'],
            ['nom_client' => 'PETROMIN', 'secteur_activite' => 'Minière']
        ];

        foreach ($clientsData as $data) {
            Client::create($data);
        }

        // جلب الزبائن
        $somadeco = Client::where('nom_client', 'SOMADECO')->first();
        $autelec = Client::where('nom_client', 'AUTELEC')->first();
        $petrofib = Client::where('nom_client', 'PETROFIB')->first();
        $tsg = Client::where('nom_client', 'TSG')->first();
        $somatrin = Client::where('nom_client', 'SOMATRIN')->first();
        $smtr = Client::where('nom_client', 'SMTR CARRÉ')->first();
        $petromin = Client::where('nom_client', 'PETROMIN')->first();

        // =============================================
        // 4. المعايير (Normes) - 3 معايير
        // =============================================
        $normesData = [
            ['code_norme' => 'ISO 9001:2015', 'description' => 'Système de management de la qualité'],
            ['code_norme' => 'ISO 14001:2015', 'description' => 'Système de management environnemental'],
            ['code_norme' => 'ISO 45001:2018', 'description' => 'Système de management de la santé et de la sécurité au travail']
        ];

        foreach ($normesData as $data) {
            Norme::create($data);
        }

        $iso9001 = Norme::where('code_norme', 'ISO 9001:2015')->first();
        $iso14001 = Norme::where('code_norme', 'ISO 14001:2015')->first();
        $iso45001 = Norme::where('code_norme', 'ISO 45001:2018')->first();
        $toutesNormes = [$iso9001->id, $iso14001->id, $iso45001->id];

        // =============================================
        // 5. الفصول (Chapitres SMI) - §4 إلى §10
        // =============================================
        $chapitresData = [
            [
                'code_chapitre' => '§4',
                'titre_chapitre' => 'Contexte de l\'organisme',
                'exigences_cles' => "• Analyse SWOT (forces, faiblesses, opportunités, menaces)\n• Identification des parties intéressées & leurs besoins\n• Cartographie des processus\n• Domaine d'application du SMI",
                'ordre' => 1
            ],
            [
                'code_chapitre' => '§5',
                'titre_chapitre' => 'Leadership & Engagement',
                'exigences_cles' => "• Politique QHSE intégrée (Q + E + SST)\n• Organigramme & rôles / responsabilités QSE\n• Engagement visible de la Direction",
                'ordre' => 2
            ],
            [
                'code_chapitre' => '§6',
                'titre_chapitre' => 'Planification',
                'exigences_cles' => "• Évaluation des risques & opportunités (Q + E + SST)\n• Registre des aspects environnementaux significatifs\n• Registre d'évaluation des risques professionnels (DUER)\n• Veille légale & réglementaire (env. + SST)\n• Objectifs QSE SMART & plan d'action",
                'ordre' => 3
            ],
            [
                'code_chapitre' => '§7',
                'titre_chapitre' => 'Support',
                'exigences_cles' => "• Matrice de compétences QSE & plan de formation\n• Habilitations réglementaires (SST / ENV)\n• Plan de communication interne & externe\n• Maîtrise documentaire (GED intégrée)",
                'ordre' => 4
            ],
            [
                'code_chapitre' => '§8',
                'titre_chapitre' => 'Réalisation des opérations',
                'exigences_cles' => "• Procédures & enregistrements de tous les processus\n• Maîtrise opérationnelle env. & SST (instructions)\n• Consignes HSE & Check-lists terrain\n• Audits terrain SST & ENV avec plan d'actions\n• Plan de préparation aux situations d'urgence",
                'ordre' => 5
            ],
            [
                'code_chapitre' => '§9',
                'titre_chapitre' => 'Évaluation des performances',
                'exigences_cles' => "• Indicateurs & CIP de l'ensemble des processus\n• Audit interne SMI avec plan d'actions\n• Évaluation de la conformité réglementaire\n• Revue de Direction QSE",
                'ordre' => 6
            ],
            [
                'code_chapitre' => '§10',
                'titre_chapitre' => 'Amélioration',
                'exigences_cles' => "• Gestion des non-conformités QSE\n• Actions correctives & préventives intégrées\n• Amélioration continue du SMI",
                'ordre' => 7
            ]
        ];

        foreach ($chapitresData as $data) {
            ChapitreSmi::create($data);
        }

        $chapitre4 = ChapitreSmi::where('code_chapitre', '§4')->first();
        $chapitre5 = ChapitreSmi::where('code_chapitre', '§5')->first();
        $chapitre6 = ChapitreSmi::where('code_chapitre', '§6')->first();
        $chapitre7 = ChapitreSmi::where('code_chapitre', '§7')->first();
        $chapitre8 = ChapitreSmi::where('code_chapitre', '§8')->first();
        $chapitre9 = ChapitreSmi::where('code_chapitre', '§9')->first();
        $chapitre10 = ChapitreSmi::where('code_chapitre', '§10')->first();

        // =============================================
        // 6. التكوينات (Formations)
        // =============================================
        $formationsData = [
            ['titre_formation' => 'Formation Introduction aux 3 normes ISO 9001/ISO 45001/ISO 14001'],
            ['titre_formation' => 'Formation Audit interne'],
            ['titre_formation' => 'Formation impact environnemental'],
            ['titre_formation' => 'Formation évaluation des risques professionnels']
        ];

        foreach ($formationsData as $data) {
            Formation::create($data);
        }

        $formationIntro = Formation::where('titre_formation', 'LIKE', '%Introduction%')->first();
        $formationAudit = Formation::where('titre_formation', 'LIKE', '%Audit%')->first();
        $formationImpact = Formation::where('titre_formation', 'LIKE', '%impact%')->first();
        $formationRisques = Formation::where('titre_formation', 'LIKE', '%risques%')->first();

        // =============================================
        // 7. المشاريع (Projets) - PRJ-001 إلى PRJ-007
        // =============================================

        // PRJ-001 - SOMADECO (Finalisé)
        $projet1 = Projet::create([
            'reference_projet' => 'PRJ-001',
            'client_id' => $somadeco->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'Finalisé',
            'jours_prevus' => 17,
            'jours_realises' => 17,
            'avancement_percent' => 100,
            'blocage' => 'RAS',
            'commentaire' => 'Projet finalisé avec succès ✓',
            'date_debut' => '2025-01-15',
            'date_fin_prevue' => '2025-02-15',
            'date_fin_reelle' => '2025-02-10'
        ]);
        $projet1->normes()->attach($toutesNormes);

        // Affectations pour PRJ-001
        Affectation::create(['projet_id' => $projet1->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 15, 'jours_realises' => 15]);
        Affectation::create(['projet_id' => $projet1->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 15, 'jours_realises' => 15]);
        Affectation::create(['projet_id' => $projet1->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 3, 'jours_realises' => 3]);
        Affectation::create(['projet_id' => $projet1->id, 'consultant_id' => $wissam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 1, 'jours_realises' => 1]);

        // Suivi des chapitres pour PRJ-001
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 3, 'statut_livrables' => 'Finalisé', 'observations' => '—']);
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 3, 'statut_livrables' => 'Finalisé', 'observations' => '—']);
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 5, 'statut_livrables' => 'Finalisé', 'observations' => '—']);
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 4, 'statut_livrables' => '—', 'observations' => '—']);
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 5, 'statut_livrables' => 'Finalisé', 'observations' => '—']);
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 4, 'statut_livrables' => 'Finalisé', 'observations' => '—']);
        SuiviChapitre::create(['projet_id' => $projet1->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 2, 'statut_livrables' => '—', 'observations' => '—']);

        // Formations pour PRJ-001
        ProjetFormation::create(['projet_id' => $projet1->id, 'formation_id' => $formationIntro->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet1->id, 'formation_id' => $formationAudit->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet1->id, 'formation_id' => $formationImpact->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet1->id, 'formation_id' => $formationRisques->id, 'statut' => 'Finalisée']);

        // PRJ-002 - AUTELEC (En retard)
        $projet2 = Projet::create([
            'reference_projet' => 'PRJ-002',
            'client_id' => $autelec->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'En retard',
            'jours_prevus' => 45,
            'jours_realises' => 16,
            'avancement_percent' => 35,
            'blocage' => 'Attente de la présence du DG pour reprendre les ateliers',
            'commentaire' => 'En retard — attente présence DG pour reprendre les ateliers',
            'date_debut' => '2025-01-10'
        ]);
        $projet2->normes()->attach($toutesNormes);

        Affectation::create(['projet_id' => $projet2->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 7, 'jours_realises' => 7]);
        Affectation::create(['projet_id' => $projet2->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 7, 'jours_realises' => 7]);
        Affectation::create(['projet_id' => $projet2->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 2, 'jours_realises' => 2]);
        Affectation::create(['projet_id' => $projet2->id, 'consultant_id' => $wissam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);

        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => '—', 'observations' => 'Attente de la présence du DG pour reprendre les ateliers']);
        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 25, 'phase' => '⏳ Démarré', 'jours_intervention' => 3, 'statut_livrables' => 'Attente validation DG / —', 'observations' => 'Attente de la présence du DG pour reprendre les ateliers']);
        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 42, 'phase' => '⏳ Démarré', 'jours_intervention' => 5, 'statut_livrables' => 'Attente revue pilotes & DG / En cours / À planifier']);
        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet2->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 2, 'statut_livrables' => '—']);

        ProjetFormation::create(['projet_id' => $projet2->id, 'formation_id' => $formationIntro->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet2->id, 'formation_id' => $formationAudit->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet2->id, 'formation_id' => $formationImpact->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet2->id, 'formation_id' => $formationRisques->id, 'statut' => 'Finalisée']);

        // PRJ-003 - PETROFIB (En cours)
        $projet3 = Projet::create([
            'reference_projet' => 'PRJ-003',
            'client_id' => $petrofib->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'En cours',
            'jours_prevus' => 80,
            'jours_realises' => 35,
            'avancement_percent' => 40,
            'blocage' => 'RAS',
            'commentaire' => 'Plusieurs livrables en attente de validation DG',
            'date_debut' => '2025-02-01'
        ]);
        $projet3->normes()->attach($toutesNormes);

        Affectation::create(['projet_id' => $projet3->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 16.5, 'jours_realises' => 16.5]);
        Affectation::create(['projet_id' => $projet3->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 2, 'jours_realises' => 2]);
        Affectation::create(['projet_id' => $projet3->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 2, 'jours_realises' => 2]);
        Affectation::create(['projet_id' => $projet3->id, 'consultant_id' => $wissam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet3->id, 'consultant_id' => $mhammed->id, 'role_dans_projet' => 'Consultant Ext.', 'jours_alloues' => 14.5, 'jours_realises' => 14.5]);

        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 3, 'statut_livrables' => 'Finalisé']);
        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 100, 'phase' => '✅ Terminé', 'jours_intervention' => 3, 'statut_livrables' => 'Finalisé']);
        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 70, 'phase' => '🔄 En cours', 'jours_intervention' => 5, 'statut_livrables' => 'Finalisé / En cours / Attente validation DG']);
        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 52, 'phase' => '⏳ Démarré', 'jours_intervention' => 5, 'statut_livrables' => 'Attente revue pilotes & DG / En cours de finalisation / En cours / À planifier']);
        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 25, 'phase' => '⏳ Démarré', 'jours_intervention' => 4, 'statut_livrables' => 'Attente validation DG / —']);
        SuiviChapitre::create(['projet_id' => $projet3->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 2, 'statut_livrables' => '—']);

        ProjetFormation::create(['projet_id' => $projet3->id, 'formation_id' => $formationIntro->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet3->id, 'formation_id' => $formationAudit->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet3->id, 'formation_id' => $formationImpact->id, 'statut' => 'Finalisée']);
        ProjetFormation::create(['projet_id' => $projet3->id, 'formation_id' => $formationRisques->id, 'statut' => 'Finalisée']);

        // PRJ-004 - TSG (En cours)
        $projet4 = Projet::create([
            'reference_projet' => 'PRJ-004',
            'client_id' => $tsg->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'En cours',
            'jours_prevus' => 80,
            'jours_realises' => 11,
            'avancement_percent' => 10,
            'blocage' => 'RAS',
            'commentaire' => 'Mise à jour d\'un SMI existant — avancement initial',
            'date_debut' => '2025-03-01'
        ]);
        $projet4->normes()->attach($toutesNormes);

        Affectation::create(['projet_id' => $projet4->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 2, 'jours_realises' => 2]);
        Affectation::create(['projet_id' => $projet4->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 2, 'jours_realises' => 2]);
        Affectation::create(['projet_id' => $projet4->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 7, 'jours_realises' => 7]);
        Affectation::create(['projet_id' => $projet4->id, 'consultant_id' => $wisam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);

        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 20, 'phase' => '⏳ Démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À implémenter / Aucune modification / À modifier']);
        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'Aucune modification']);
        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 76, 'phase' => '🔄 En cours', 'jours_intervention' => 5, 'statut_livrables' => 'À modifier / En cours de finalisation']);
        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 67, 'phase' => '🔄 En cours', 'jours_intervention' => 5, 'statut_livrables' => 'Attente revue pilotes / En cours de finalisation / En cours']);
        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet4->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 2, 'statut_livrables' => '—']);

        ProjetFormation::create(['projet_id' => $projet4->id, 'formation_id' => $formationIntro->id, 'statut' => 'Réalisée']);
        ProjetFormation::create(['projet_id' => $projet4->id, 'formation_id' => $formationAudit->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet4->id, 'formation_id' => $formationImpact->id, 'statut' => 'Réalisée']);
        ProjetFormation::create(['projet_id' => $projet4->id, 'formation_id' => $formationRisques->id, 'statut' => 'Réalisée']);

        // PRJ-005 - SOMATRIN (En cours - 0% avancement)
        $projet5 = Projet::create([
            'reference_projet' => 'PRJ-005',
            'client_id' => $somatrin->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'En cours',
            'jours_prevus' => 80,
            'jours_realises' => 0,
            'avancement_percent' => 0,
            'blocage' => 'RAS',
            'commentaire' => 'Démarrage à planifier'
        ]);
        $projet5->normes()->attach($toutesNormes);

        Affectation::create(['projet_id' => $projet5->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet5->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet5->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet5->id, 'consultant_id' => $wisam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);

        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet5->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 2, 'statut_livrables' => '—']);

        ProjetFormation::create(['projet_id' => $projet5->id, 'formation_id' => $formationIntro->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet5->id, 'formation_id' => $formationAudit->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet5->id, 'formation_id' => $formationImpact->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet5->id, 'formation_id' => $formationRisques->id, 'statut' => 'À planifier']);

        // PRJ-006 - SMTR CARRÉ (Planifié)
        $projet6 = Projet::create([
            'reference_projet' => 'PRJ-006',
            'client_id' => $smtr->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'Planifié',
            'jours_prevus' => 80,
            'jours_realises' => 0,
            'avancement_percent' => 0,
            'blocage' => 'RAS',
            'commentaire' => 'Projet planifié — démarrage à confirmer'
        ]);
        $projet6->normes()->attach($toutesNormes);

        Affectation::create(['projet_id' => $projet6->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet6->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet6->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet6->id, 'consultant_id' => $wisam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);

        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet6->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 2, 'statut_livrables' => '—']);

        ProjetFormation::create(['projet_id' => $projet6->id, 'formation_id' => $formationIntro->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet6->id, 'formation_id' => $formationAudit->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet6->id, 'formation_id' => $formationImpact->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet6->id, 'formation_id' => $formationRisques->id, 'statut' => 'À planifier']);

        // PRJ-007 - PETROMIN (Planifié)
        $projet7 = Projet::create([
            'reference_projet' => 'PRJ-007',
            'client_id' => $petromin->id,
            'chef_projet_id' => $meryem->id,
            'type_projet' => 'SMI — Système de Management Intégré',
            'statut' => 'Planifié',
            'jours_prevus' => 80,
            'jours_realises' => 0,
            'avancement_percent' => 0,
            'blocage' => 'RAS',
            'commentaire' => 'Projet planifié — démarrage à confirmer'
        ]);
        $projet7->normes()->attach($toutesNormes);

        Affectation::create(['projet_id' => $projet7->id, 'consultant_id' => $meryem->id, 'role_dans_projet' => 'Chef de Projet', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet7->id, 'consultant_id' => $hiba->id, 'role_dans_projet' => 'Consultante', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet7->id, 'consultant_id' => $hamid->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);
        Affectation::create(['projet_id' => $projet7->id, 'consultant_id' => $wisam->id, 'role_dans_projet' => 'Consultant', 'jours_alloues' => 0, 'jours_realises' => 0]);

        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre4->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre5->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 3, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre6->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre7->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => '—']);
        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre8->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 5, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre9->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 4, 'statut_livrables' => 'À planifier']);
        SuiviChapitre::create(['projet_id' => $projet7->id, 'chapitre_id' => $chapitre10->id, 'avancement_percent' => 0, 'phase' => '⬜ Non démarré', 'jours_intervention' => 2, 'statut_livrables' => '—']);

        ProjetFormation::create(['projet_id' => $projet7->id, 'formation_id' => $formationIntro->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet7->id, 'formation_id' => $formationAudit->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet7->id, 'formation_id' => $formationImpact->id, 'statut' => 'À planifier']);
        ProjetFormation::create(['projet_id' => $projet7->id, 'formation_id' => $formationRisques->id, 'statut' => 'À planifier']);
    }
}