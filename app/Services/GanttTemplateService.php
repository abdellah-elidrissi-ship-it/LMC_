<?php

namespace App\Services;

use App\Models\GanttPhase;
use App\Models\GanttTache;

class GanttTemplateService
{
    /**
     * Base standard des phases/tâches d'un accompagnement SMI (ISO 9001/14001/45001).
     */
    public static function phasesTaches(): array
    {
        return [
            [
                'nom' => "1. Cadrage et lancement du projet",
                'taches' => [
                    'Réunion de lancement (kick-off) avec la direction',
                    "Définition du périmètre et du domaine d'application du SMI (sites, activités, processus)",
                    'Constitution du comité de pilotage QHSE',
                    'Nomination du Représentant de la Direction / Responsable QHSE',
                    'Élaboration de la lettre de mission et de la feuille de route projet',
                ],
            ],
            [
                'nom' => '2. Diagnostic initial (état des lieux)',
                'taches' => [
                    "Analyse du contexte de l'organisme (enjeux internes/externes)",
                    'Identification des parties intéressées et de leurs attentes',
                    'Diagnostic documentaire par rapport aux exigences des référentiels',
                    'Diagnostic terrain (visites de sites, observations, entretiens)',
                    'Revue des processus et de la cartographie existante',
                    'Restitution du diagnostic à la direction',
                ],
            ],
            [
                'nom' => '3. Planification du SMI',
                'taches' => [
                    'Élaboration / révision de la politique QHSE intégrée',
                    'Définition des objectifs et cibles QHSE',
                    'Identification et évaluation des risques et opportunités',
                    "Identification des aspects environnementaux et évaluation de leur importance",
                    'Identification des dangers et évaluation des risques SST',
                    'Consultation et participation des travailleurs (SST)',
                    'Identification des exigences légales et autres exigences (veille réglementaire)',
                    "Élaboration du plan d'actions / programme de management QHSE (objectifs-moyens-délais)",
                    'Planification des changements',
                ],
            ],
            [
                'nom' => '4. Support (ressources, compétences, communication, documentation)',
                'taches' => [
                    'Détermination des ressources nécessaires (humaines, techniques, financières)',
                    'Analyse des besoins en compétences et élaboration du plan de formation QHSE',
                    'Réalisation des actions de sensibilisation du personnel',
                    'Conception de la structure documentaire du SMI (procédures, instructions)',
                    'Rédaction/mise à jour des procédures',
                    'Rédaction des procédures spécifiques Qualité',
                    'Rédaction des procédures spécifiques Environnement',
                    'Rédaction des procédures spécifiques SST',
                ],
            ],
            [
                'nom' => '5. Réalisation / mise en œuvre opérationnelle',
                'taches' => [
                    'Déploiement du système',
                    "Préparation et réponse aux situations d'urgence (environnement et SST)",
                    'Maîtrise des équipements de surveillance et de mesure (étalonnage/vérification)',
                ],
            ],
            [
                'nom' => '6. Évaluation des performances',
                'taches' => [
                    'Formation des auditeurs internes SMI',
                    "Élaboration du programme d'audit interne",
                    'Réalisation des audits internes SMI (9001/14001/45001)',
                    'Préparation et tenue de la revue de direction',
                ],
            ],
            [
                'nom' => '7. Amélioration',
                'taches' => [
                    'Traitement des non-conformités et mise en œuvre des actions correctives',
                    "Mise en œuvre des actions d'amélioration continue issues des audits/revue de direction",
                ],
            ],
            [
                'nom' => '8. Préparation à la certification',
                'taches' => [
                    "Sélection de l'organisme certificateur et planification de l'audit",
                    "Réalisation d'un audit blanc global du SMI",
                    "Traitement des écarts relevés lors de l'audit blanc",
                    'Audit de certification',
                ],
            ],
        ];
    }

    /**
     * Crée les 8 phases et leurs tâches pour un projet donné.
     * N'agit pas si ce projet a déjà des phases Gantt (évite les doublons).
     */
    public static function creerPour(int $projetId): void
    {
        if (GanttPhase::where('projet_id', $projetId)->exists()) {
            return;
        }

        $ordre = 0;
        $numero = 0;

        foreach (self::phasesTaches() as $phaseData) {
            $ordre++;

            $phase = GanttPhase::create([
                'projet_id' => $projetId,
                'nom' => $phaseData['nom'],
                'ordre' => $ordre,
            ]);

            foreach ($phaseData['taches'] as $designation) {
                $numero++;

                GanttTache::create([
                    'projet_id' => $projetId,
                    'phase_id' => $phase->id,
                    'numero' => $numero,
                    'designation' => $designation,
                    'unite' => 'H/J',
                    'ct_prevue' => 0,
                    'ct_realisee' => 0,
                    'avancement' => 0,
                ]);
            }
        }
    }
}
