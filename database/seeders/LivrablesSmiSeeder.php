<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LivrablesSmiSeeder extends Seeder
{
    /**
     * 90 livrables extraits de Livrables_SMI_1.docx
     * Structure: [chapitre_code, clause, libelle, phase_smi]
     */
    public function run(): void
    {
        // Éviter les doublons si on re-run le seeder
        if (DB::table('livrables_smi')->count() > 0) {
            $this->command->info('livrables_smi déjà peuplé — skip.');
            return;
        }

        $livrables = [
            // ── PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX ──────────────────────
            ['§4', '4.1 / 4.2', 'Rapport de diagnostic initial (gap analysis) ISO 9001, 14001, 45001',                          'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['§4', '4.1',       'Analyse du contexte interne et externe (SWOT / PESTEL) — volets Q, E et SST',                  'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['§4', '4.2',       'Matrice consolidée des parties intéressées et de leurs exigences (Q + E + SST)',                'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['§4', '4.4',       'Cartographie des processus existants',                                                          'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['§6', '6.1.3',     'Matrice de conformité réglementaire applicable (Q + E + SST)',                                  'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['§6', '6.1.2',     'Revue environnementale initiale (aspects/impacts, état réglementaire E)',                       'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['§6', '6.1.2',     'État des lieux SST initial (dangers, conformité réglementaire SST, statistiques AT/MP)',        'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['Transversal', '', 'Rapport d\'évaluation de la maturité organisationnelle',                                        'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],
            ['Transversal', '', 'Plan d\'action issu du diagnostic avec priorisation',                                           'PHASE 1 — DIAGNOSTIC ET ÉTAT DES LIEUX'],

            // ── PHASE 2 — PLANIFICATION DU SMI ──────────────────────────────
            ['§5', '5.2',       'Politique QSE intégrée (ou politiques distinctes Q, E, SST)',                                   'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.2',       'Objectifs QSE mesurables avec cibles, indicateurs, responsables et échéances',                 'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.2',       'Programmes de management QSE (plans d\'actions pour atteindre les objectifs)',                  'PHASE 2 — PLANIFICATION DU SMI'],
            ['§4', '4.4',       'Cartographie des processus SMI (pilotes, interactions, E/S, KPI)',                              'PHASE 2 — PLANIFICATION DU SMI'],
            ['§5', '5.3',       'Matrice des rôles, responsabilités et autorités QSE',                                          'PHASE 2 — PLANIFICATION DU SMI'],
            ['§7', '7.4',       'Plan de communication interne et externe QSE',                                                  'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.1.1',     'Registre intégré des risques et opportunités par processus (Q + E + SST)',                     'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.1.2',     'Registre des aspects et impacts environnementaux significatifs (AES) avec cotation',           'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.1.2',     'Document unique d\'évaluation des risques professionnels (DUERP ou équivalent)',               'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.1.2',     'Hiérarchie des mesures de prévention SST',                                                     'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.1.3',     'Registre consolidé des exigences légales et autres (E + SST)',                                  'PHASE 2 — PLANIFICATION DU SMI'],
            ['§5', '5.4',       'Processus de consultation et participation des travailleurs (ISO 45001)',                       'PHASE 2 — PLANIFICATION DU SMI'],
            ['§6', '6.3',       'Procédure de planification des modifications du SMI',                                           'PHASE 2 — PLANIFICATION DU SMI'],
            ['Transversal', '', 'Plan de projet de mise en œuvre du SMI (jalons, délais, responsabilités)',                     'PHASE 2 — PLANIFICATION DU SMI'],

            // ── PHASE 3 — SUPPORT ET RESSOURCES ─────────────────────────────
            ['§7', '7.5',       'Procédure unique de maîtrise des informations documentées',                                     'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.5',       'Liste maîtresse des documents et enregistrements du SMI',                                      'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.2',       'Matrice de compétences QSE par poste / fonction',                                               'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.2',       'Plan de formation QSE intégré',                                                                 'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.2',       'Plan de formation SST spécifique (habilitations, CACES, travail en hauteur, etc.)',            'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.2',       'Registre des formations réalisées (Q + E + SST)',                                               'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.3',       'Plan de sensibilisation QSE (thèmes, publics, fréquences)',                                     'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.3',       'Supports de sensibilisation SST (accueil sécurité, affichage, toolbox meetings)',              'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.1',       'Inventaire des infrastructures et ressources nécessaires',                                      'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.1.5',     'Procédure de gestion des ressources de surveillance et mesure (étalonnage / vérification)',    'PHASE 3 — SUPPORT ET RESSOURCES'],
            ['§7', '7.1.6',     'Procédure de gestion des connaissances organisationnelles',                                     'PHASE 3 — SUPPORT ET RESSOURCES'],

            // ── PHASE 4 — RÉALISATION OPÉRATIONNELLE ────────────────────────
            ['§8', '8.1',       'Procédures et instructions opérationnelles par processus',                                      'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§4', '4.4',       'Fiches processus complètes intégrant les dimensions Q, E et SST',                              'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Matrice de maîtrise opérationnelle intégrée',                                                   'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.4',       'Procédure de gestion des prestataires externes (critères Q + E + SST)',                        'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Procédure de gestion des modifications opérationnelles',                                        'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.2',       'Procédure de détermination et revue des exigences clients (ISO 9001)',                         'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.3',       'Procédure de conception et développement (si applicable — ISO 9001)',                          'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.7',       'Procédure de maîtrise des éléments de sortie non conformes (ISO 9001)',                        'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.5',       'Procédure de maîtrise de la production / prestation de service (ISO 9001)',                    'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.6',       'Critères de libération des produits / services (ISO 9001)',                                     'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.5.3',     'Procédure de gestion de la propriété du client (ISO 9001)',                                     'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.5.4',     'Procédure de préservation des produits (ISO 9001)',                                             'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.5.5',     'Dispositions pour les activités après livraison (ISO 9001)',                                    'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Procédures de maîtrise opérationnelle environnementale (déchets, rejets, énergie, eau, substances dangereuses)', 'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Plan de gestion des déchets (ISO 14001)',                                                       'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Perspective du cycle de vie intégrée (ISO 14001)',                                              'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Procédures de maîtrise opérationnelle SST (consignation, hauteur, espaces confinés, chimiques, etc.)', 'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1.4',     'Plan de prévention pour les entreprises extérieures (ISO 45001)',                               'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Protocoles de sécurité et permis de travail (ISO 45001)',                                       'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Fiches de poste intégrant risques et mesures de prévention (ISO 45001)',                       'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.1',       'Registre des EPI et procédure de gestion des EPI (ISO 45001)',                                  'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.2',       'Plan d\'urgence intégré (environnemental + SST) : évacuation, déversements, incendie, premiers secours', 'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],
            ['§8', '8.2',       'Programme d\'exercices de simulation d\'urgence',                                               'PHASE 4 — RÉALISATION OPÉRATIONNELLE'],

            // ── PHASE 5 — ÉVALUATION DES PERFORMANCES ───────────────────────
            ['§9', '9.1',       'Tableau de bord intégré des indicateurs QSE (par processus et global)',                        'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.1',       'Procédure de surveillance, mesure, analyse et évaluation (Q + E + SST)',                       'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.1.2',     'Procédure et outils de mesure de la satisfaction client (ISO 9001)',                           'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.1.2',     'Procédure d\'évaluation de la conformité aux exigences légales (E + SST)',                    'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.1.2',     'Rapport d\'évaluation de conformité environnementale périodique',                              'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.1.2',     'Rapport d\'évaluation de conformité SST périodique',                                           'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.1',       'Indicateurs SST spécifiques (TF, TG, presqu\'accidents, etc.)',                                'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.2',       'Procédure d\'audit interne unique (SMI)',                                                      'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.2',       'Programme d\'audit interne annuel SMI',                                                        'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.2',       'Rapports d\'audit interne',                                                                    'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.2',       'Plan d\'actions correctives post-audit',                                                       'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.3',       'Trame de revue de direction intégrée (éléments d\'entrée/sortie des 3 normes)',               'PHASE 5 — ÉVALUATION DES PERFORMANCES'],
            ['§9', '9.3',       'Compte rendu de revue de direction',                                                           'PHASE 5 — ÉVALUATION DES PERFORMANCES'],

            // ── PHASE 6 — AMÉLIORATION ───────────────────────────────────────
            ['§10', '10.2',     'Procédure unique de gestion des non-conformités et actions correctives',                        'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.2',     'Registre des non-conformités et actions correctives (analyse des causes)',                      'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.2',     'Procédure de gestion des réclamations clients (ISO 9001)',                                      'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.2',     'Registre des réclamations clients et suivi du traitement (ISO 9001)',                           'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.2',     'Procédure de déclaration, enquête et analyse des incidents / accidents (ISO 45001)',            'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.2',     'Registre des incidents et accidents (ISO 45001)',                                               'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.2',     'Arbre des causes ou méthode d\'analyse systématique (ISO 45001)',                              'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.3',     'Registre des actions d\'amélioration continue',                                                'PHASE 6 — AMÉLIORATION'],
            ['§10', '10.3',     'Revue de l\'efficacité des actions correctives et d\'amélioration',                           'PHASE 6 — AMÉLIORATION'],

            // ── PHASE 7 — PRÉPARATION À LA CERTIFICATION ────────────────────
            ['Transversal', '', 'Rapport d\'audit blanc (pré-audit de certification)',                                           'PHASE 7 — PRÉPARATION À LA CERTIFICATION'],
            ['Transversal', '', 'Plan d\'actions de mise en conformité résiduelle',                                             'PHASE 7 — PRÉPARATION À LA CERTIFICATION'],
            ['Transversal', '', 'Dossier de revue documentaire complet (manuel SMI ou dossier structuré)',                      'PHASE 7 — PRÉPARATION À LA CERTIFICATION'],
            ['Transversal', '', 'Matrice de correspondance croisée ISO 9001 / 14001 / 45001',                                   'PHASE 7 — PRÉPARATION À LA CERTIFICATION'],
            ['§4',          '4.3', 'Déclaration de domaine d\'application du SMI',                                             'PHASE 7 — PRÉPARATION À LA CERTIFICATION'],
            ['Transversal', '', 'Check-list de vérification pré-certification',                                                  'PHASE 7 — PRÉPARATION À LA CERTIFICATION'],

            // ── DOCUMENTS TRANSVERSAUX ───────────────────────────────────────
            ['Transversal', '',    'Manuel SMI (optionnel mais recommandé)',                                                     'DOCUMENTS TRANSVERSAUX DU SMI'],
            ['Transversal', '5.3', 'Organigramme fonctionnel et nominatif',                                                     'DOCUMENTS TRANSVERSAUX DU SMI'],
            ['Transversal', '',    'Matrice d\'intégration des exigences communes et spécifiques (clause par clause)',          'DOCUMENTS TRANSVERSAUX DU SMI'],
            ['Transversal', '',    'Charte de projet SMI',                                                                      'DOCUMENTS TRANSVERSAUX DU SMI'],
            ['Transversal', '',    'Planning général du projet',                                                                 'DOCUMENTS TRANSVERSAUX DU SMI'],
        ];

        $now = now();
        $rows = [];
        foreach ($livrables as $ordre => [$chapitre_code, $clause, $libelle, $phase_smi]) {
            $rows[] = [
                'chapitre_code' => $chapitre_code,
                'clause'        => $clause ?: null,
                'libelle'       => $libelle,
                'phase_smi'     => $phase_smi,
                'ordre'         => $ordre + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::table('livrables_smi')->insert($rows);
        $this->command->info('✅ ' . count($rows) . ' livrables SMI insérés.');
    }
}