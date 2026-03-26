<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PMODashboardController extends Controller
{
    public function index()
    {
        // 1. Les projets avec leurs relations
        $projets = DB::select("
            SELECT 
                p.id,
                p.reference_projet,
                p.statut,
                p.jours_prevus,
                p.jours_realises,
                p.avancement_percent,
                p.date_debut,
                p.date_fin_prevue,
                c.nom_client,
                cons.nom_complet as chef_nom,
                cons.type_consultant as chef_type
            FROM projets p
            LEFT JOIN clients c ON p.client_id = c.id
            LEFT JOIN consultants cons ON p.chef_projet_id = cons.id
            ORDER BY p.reference_projet
        ");

        // 2. Calcul des KPI
        $totalProjets = count($projets);
        
        $finalises = 0;
        $enRetard = 0;
        $enCours = 0;
        $planifies = 0;
        
        $totalAvancement = 0;
        $totalJoursPrevus = 0;
        $totalJoursRealises = 0;
        $totalChargeRestante = 0;
        
        // Jours internes et externes
        $joursInternes = DB::selectOne("
            SELECT COALESCE(SUM(a.jours_realises), 0) as total
            FROM affectations a
            JOIN consultants c ON a.consultant_id = c.id
            WHERE c.type_consultant = 'Interne'
        ")->total;
        
        $joursExternes = DB::selectOne("
            SELECT COALESCE(SUM(a.jours_realises), 0) as total
            FROM affectations a
            JOIN consultants c ON a.consultant_id = c.id
            WHERE c.type_consultant IN ('Externe', 'Freelancer')
        ")->total;
        
        $totalJoursConsommes = $joursInternes + $joursExternes;
        $tauxExterne = $totalJoursConsommes > 0 ? round(($joursExternes / $totalJoursConsommes) * 100) : 0;
        
        foreach($projets as $p) {
            $totalJoursPrevus += $p->jours_prevus;
            $totalJoursRealises += $p->jours_realises;
            $totalAvancement += $p->avancement_percent;
            $totalChargeRestante += ($p->jours_prevus - $p->jours_realises);
            
            switch($p->statut) {
                case 'Finalisé': $finalises++; break;
                case 'En retard': $enRetard++; break;
                case 'En cours': $enCours++; break;
                default: $planifies++; break;
            }
        }
        
        $avancementGlobal = $totalProjets > 0 ? round($totalAvancement / $totalProjets) : 0;
        $tauxConsommation = $totalJoursPrevus > 0 ? round(($totalJoursRealises / $totalJoursPrevus) * 100) : 0;
        
        // 3. Avancement par client
        $avancementParClient = DB::select("
            SELECT 
                c.nom_client,
                ROUND(AVG(p.avancement_percent)) as avancement,
                COUNT(p.id) as nb_projets
            FROM projets p
            JOIN clients c ON p.client_id = c.id
            GROUP BY c.id, c.nom_client
            ORDER BY avancement DESC
        ");
        
        // 4. Jours prévus vs réalisés par projet
        $joursParProjet = DB::select("
            SELECT 
                reference_projet,
                jours_prevus,
                jours_realises
            FROM projets
            ORDER BY reference_projet
        ");
        
        // 5. Jours par consultant
        $joursParConsultant = DB::select("
            SELECT 
                c.nom_complet,
                c.type_consultant,
                COALESCE(SUM(a.jours_realises), 0) as jours
            FROM consultants c
            LEFT JOIN affectations a ON c.id = a.consultant_id
            WHERE c.type_consultant IN ('Interne', 'Externe', 'Freelancer')
            GROUP BY c.id, c.nom_complet, c.type_consultant
            HAVING SUM(a.jours_realises) > 0 OR c.type_consultant = 'Interne'
            ORDER BY jours DESC
            LIMIT 10
        ");
        
        // 6. Heatmap santé projets (CORRIGÉE - sans ??)
        $heatmapProjets = DB::select("
            SELECT 
                p.id,
                p.reference_projet,
                COALESCE(p.nom_projet, p.reference_projet) as nom_projet,
                c.nom_client,
                p.statut,
                p.avancement_percent,
                p.blocage,
                p.jours_prevus,
                p.jours_realises,
                CASE 
                    WHEN p.avancement_percent >= 80 THEN 'Sain'
                    WHEN p.avancement_percent >= 40 THEN 'Risque'
                    WHEN p.avancement_percent < 40 AND p.statut != 'Planifié' THEN 'Critique'
                    ELSE 'Planifié'
                END as bilan_global,
                CASE 
                    WHEN p.blocage IS NOT NULL AND p.blocage LIKE '%périmètre%' THEN 'Risque'
                    WHEN p.avancement_percent >= 70 THEN 'Sain'
                    ELSE 'Risque'
                END as perimetre,
                CASE 
                    WHEN p.statut = 'En retard' THEN 'Critique'
                    WHEN p.avancement_percent >= 70 THEN 'Sain'
                    ELSE 'Risque'
                END as planning,
                CASE 
                    WHEN (p.jours_realises > p.jours_prevus * 1.1) THEN 'Critique'
                    WHEN (p.jours_realises > p.jours_prevus) THEN 'Risque'
                    ELSE 'Sain'
                END as budget,
                CASE 
                    WHEN p.statut = 'En retard' THEN 'Risque'
                    ELSE 'Sain'
                END as ressources,
                CASE 
                    WHEN p.avancement_percent >= 90 THEN 'Sain'
                    WHEN p.avancement_percent >= 50 THEN 'Risque'
                    ELSE 'Critique'
                END as qualite
            FROM projets p
            JOIN clients c ON p.client_id = c.id
            ORDER BY p.reference_projet
        ");
        
        // 7. Risques
        $risques = DB::select("
            SELECT 
                p.reference_projet,
                c.nom_client,
                p.statut,
                p.blocage,
                p.avancement_percent,
                p.jours_prevus,
                p.jours_realises,
                CASE 
                    WHEN p.statut = 'En retard' THEN 'Critique'
                    WHEN p.jours_realises > p.jours_prevus THEN 'Élevé'
                    WHEN p.blocage IS NOT NULL THEN 'Modéré'
                    ELSE 'Faible'
                END as niveau_risque,
                CASE 
                    WHEN p.statut = 'En retard' THEN 'Glissement planning'
                    WHEN p.jours_realises > p.jours_prevus THEN 'Dépassement budgétaire'
                    WHEN p.blocage IS NOT NULL AND p.blocage LIKE '%ressource%' THEN 'Goulet ressource critique'
                    WHEN p.blocage IS NOT NULL THEN 'Blocage détecté'
                    ELSE 'À surveiller'
                END as type_risque
            FROM projets p
            JOIN clients c ON p.client_id = c.id
            WHERE p.statut IN ('En retard', 'En cours')
            AND (p.blocage IS NOT NULL OR p.jours_realises > p.jours_prevus OR p.statut = 'En retard')
            ORDER BY 
                CASE niveau_risque
                    WHEN 'Critique' THEN 1
                    WHEN 'Élevé' THEN 2
                    ELSE 3
                END
            LIMIT 5
        ");
        
        // 8. Charge externe par projet
        $chargeExterneParProjet = DB::select("
            SELECT 
                p.reference_projet,
                COALESCE(SUM(a.jours_realises), 0) as jours_externes
            FROM projets p
            LEFT JOIN affectations a ON p.id = a.projet_id
            LEFT JOIN consultants c ON a.consultant_id = c.id
            WHERE c.type_consultant IN ('Externe', 'Freelancer')
            GROUP BY p.id, p.reference_projet
            HAVING SUM(a.jours_realises) > 0
            ORDER BY jours_externes DESC
            LIMIT 5
        ");
        
        // 9. Clients et chefs projet pour filtres
        $clients = DB::select("SELECT id, nom_client FROM clients ORDER BY nom_client");
        $chefsProjet = DB::select("
            SELECT DISTINCT cons.id, cons.nom_complet 
            FROM consultants cons
            JOIN projets p ON p.chef_projet_id = cons.id
            ORDER BY cons.nom_complet
        ");
        
        // Vue
        return view('tableau-de-bord', compact(
            'projets',
            'totalProjets',
            'finalises',
            'enRetard',
            'enCours',
            'planifies',
            'avancementGlobal',
            'totalJoursPrevus',
            'totalJoursRealises',
            'totalChargeRestante',
            'joursInternes',
            'joursExternes',
            'tauxExterne',
            'tauxConsommation',
            'avancementParClient',
            'joursParProjet',
            'joursParConsultant',
            'heatmapProjets',
            'risques',
            'chargeExterneParProjet',
            'clients',
            'chefsProjet'
        ));
    }
    
    public function filter(Request $request)
    {
        $query = DB::table('projets as p')
            ->leftJoin('clients as c', 'p.client_id', '=', 'c.id')
            ->leftJoin('consultants as cons', 'p.chef_projet_id', '=', 'cons.id')
            ->select('p.*', 'c.nom_client', 'cons.nom_complet as chef_nom');
        
        if ($request->client) {
            $query->where('p.client_id', $request->client);
        }
        if ($request->pm) {
            $query->where('p.chef_projet_id', $request->pm);
        }
        if ($request->status) {
            $query->where('p.statut', $request->status);
        }
        if ($request->resource) {
            if ($request->resource == 'Interne') {
                $query->where('cons.type_consultant', 'Interne');
            } elseif ($request->resource == 'Externe') {
                $query->whereIn('cons.type_consultant', ['Externe', 'Freelancer']);
            }
        }
        
        $projets = $query->get();
        
        return response()->json($projets);
    }
}