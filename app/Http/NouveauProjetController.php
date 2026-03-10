<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Projet;
use App\Models\Client;
use App\Models\Consultant;
use App\Models\Affectation;
use App\Models\SuiviChapitre;
use App\Models\ProjetFormation;

class NouveauProjetController extends Controller
{
    /**
     * عرض صفحة إضافة مشروع جديد
     */
    public function create()
    {
        // جلب الزبائن
        $clients = Client::orderBy('nom_client')->get();
        
        // ============================================
        // جلب المستشارين - فقط Meryem
        // ============================================
        $consultants = Consultant::where('actif', true)
            ->where('nom_complet', 'LIKE', '%Meryem%')
            ->orderBy('nom_complet')
            ->get();

        // إذا ما لقيتش Meryem، جيب أول مستشار
        if($consultants->isEmpty()) {
            $consultants = Consultant::where('actif', true)
                ->orderBy('nom_complet')
                ->limit(1)
                ->get();
        }
        
        // جلب النورمات (من قاعدة البيانات)
        $normes = DB::table('normes')->orderBy('code_norme')->get();
        
        // جلب الفصول
        $chapitres = DB::table('chapitres_smis')->orderBy('ordre')->get();
        
        // جلب التكوينات
        $formations = DB::table('formations')->orderBy('titre_formation')->get();
        
        // إنشاء référence تلقائي
        $lastProjet = Projet::latest('id')->first();
        if($lastProjet) {
            $lastNum = intval(substr($lastProjet->reference_projet, 4));
            $newNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNum = '001';
        }
        $newReference = 'PRJ-' . $newNum;

        return view('nouveau-projet', compact(
            'clients', 
            'consultants', 
            'normes', 
            'chapitres', 
            'formations', 
            'newReference'
        ));
    }

    /**
     * حفظ مشروع جديد
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'reference_projet' => 'required|unique:projets',
            'client_nom' => 'required|string|max:255',
            'chef_projet_nom' => 'required|string|max:255',
            'statut' => 'required|in:Planifié,En cours,En retard,Finalisé',
            'type_projet' => 'required|string',
            'jours_prevus' => 'required|integer|min:0',
            'jours_realises' => 'required|integer|min:0',
            'avancement_percent' => 'required|integer|min:0|max:100',
            'date_debut' => 'nullable|date',
            'date_fin_prevue' => 'nullable|date',
            'date_fin_reelle' => 'nullable|date',
            'blocage' => 'nullable|string',
            'commentaire' => 'nullable|string',
            'normes' => 'array',
            'consultants' => 'array',
            'chapitres' => 'array',
            'formations' => 'array',
        ]);

        DB::beginTransaction();

        try {
            // ============================================
            // 1. إنشاء CLIENT جديد
            // ============================================
            $client = Client::create([
                'nom_client' => $request->client_nom,
            ]);
            $client_id = $client->id;

// ============================================
// 2. معالجة Consultant (Chef de Projet) - من radio
// ============================================
if ($request->has('chef_projet_id') && $request->chef_projet_id) {
    $chef_projet_id = $request->chef_projet_id;
} else {
    return back()->with('error', 'Veuillez sélectionner un chef de projet')->withInput();
}

            // ============================================
            // 3. إنشاء المشروع (Projet)
            // ============================================
            $projet = Projet::create([
                'reference_projet' => $request->reference_projet,
                'client_id' => $client_id,
                'chef_projet_id' => $chef_projet_id,
                'type_projet' => $request->type_projet,
                'statut' => $request->statut,
                'jours_prevus' => $request->jours_prevus,
                'jours_realises' => $request->jours_realises,
                'avancement_percent' => $request->avancement_percent,
                'blocage' => $request->blocage,
                'commentaire' => $request->commentaire,
                'date_debut' => $request->date_debut,
                'date_fin_prevue' => $request->date_fin_prevue,
                'date_fin_reelle' => $request->date_fin_reelle
            ]);

            // ============================================
            // 4. ربط النورمات (Normes)
            // ============================================
            if($request->has('normes') && !empty($request->normes)) {
                $projet->normes()->sync($request->normes);
            }

            // ============================================
            // 5. إضافة المستشارين (Affectations)
            // ============================================
            if($request->has('consultants')) {
                foreach($request->consultants as $consData) {
                    if(isset($consData['id']) && ($consData['jours_alloues'] > 0 || $consData['jours_realises'] > 0)) {
                        Affectation::create([
                            'projet_id' => $projet->id,
                            'consultant_id' => $consData['id'],
                            'role_dans_projet' => $consData['role'] ?? 'Consultant',
                            'jours_alloues' => $consData['jours_alloues'] ?? 0,
                            'jours_realises' => $consData['jours_realises'] ?? 0
                        ]);
                    }
                }
            }

            // ============================================
            // 6. إضافة الفصول (Suivi Chapitres)
            // ============================================
            if($request->has('chapitres')) {
                foreach($request->chapitres as $chapData) {
                    if(isset($chapData['chapitre_id'])) {
                        SuiviChapitre::create([
                            'projet_id' => $projet->id,
                            'chapitre_id' => $chapData['chapitre_id'],
                            'avancement_percent' => $chapData['avancement'] ?? 0,
                            'phase' => $chapData['phase'] ?? '⬜ Non démarré',
                            'jours_intervention' => $chapData['jours'] ?? 0,
                            'statut_livrables' => $chapData['livrables'] ?? null,
                            'observations' => $chapData['observations'] ?? null
                        ]);
                    }
                }
            }

            // ============================================
            // 7. إضافة التكوينات (Formations)
            // ============================================
            if($request->has('formations')) {
                foreach($request->formations as $formData) {
                    if(isset($formData['id'])) {
                        ProjetFormation::create([
                            'projet_id' => $projet->id,
                            'formation_id' => $formData['id'],
                            'statut' => $formData['statut'] ?? 'À planifier',
                            'observations' => $formData['observations'] ?? null
                        ]);
                    }
                }
            }

// ============================================
// 8. إضافة المستشارين الجدد (new_consultants)
// ============================================
if($request->has('new_consultants')) {
    foreach($request->new_consultants as $newCons) {
        if(!empty($newCons['nom'])) {
            // إنشاء consultant جديد
            $newConsultant = Consultant::create([
                'nom_complet' => $newCons['nom'],
                'type_consultant' => 'Interne',
                'actif' => true
            ]);
            
            // إضافة التأثير للمشروع
            Affectation::create([
                'projet_id' => $projet->id,
                'consultant_id' => $newConsultant->id,
                'role_dans_projet' => $newCons['role'] ?? 'Consultant',
                'jours_alloues' => $newCons['jours_alloues'] ?? 0,
                'jours_realises' => $newCons['jours_realises'] ?? 0
            ]);
        }
    }
}
}

            DB::commit();

            return redirect('/')->with('success', '✅ Projet créé avec succès! Référence: ' . $projet->reference_projet);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', '❌ Erreur: ' . $e->getMessage())->withInput();
        }

    }
}