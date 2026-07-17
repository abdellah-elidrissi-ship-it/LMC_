<?php

namespace Tests\Feature;

use App\Models\AccesAuditLog;
use App\Models\Affectation;
use App\Models\Consultant;
use App\Models\Projet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccesTest extends TestCase
{
    use RefreshDatabase;

    public function test_approbation_cree_une_entree_d_audit(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $consultant = Consultant::factory()->create();
        $pending = User::factory()->create([
            'statut_compte' => 'en_attente',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($superAdmin)->put("/admin/users/{$pending->id}/approuver", [
            'role' => 'consultant',
            'consultant_mode' => 'existing',
            'consultant_id' => $consultant->id,
        ])->assertRedirect();

        $entry = AccesAuditLog::where('user_id', $pending->id)->first();
        $this->assertNotNull($entry);
        $this->assertSame('approuve', $entry->action);
        $this->assertSame($superAdmin->id, $entry->performed_by);
    }

    public function test_refus_cree_une_entree_d_audit(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $pending = User::factory()->create([
            'statut_compte' => 'en_attente',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($superAdmin)->put("/admin/users/{$pending->id}/refuser", [
            'motif_refus' => 'Motif de test',
        ])->assertRedirect();

        $entry = AccesAuditLog::where('user_id', $pending->id)->first();
        $this->assertSame('refuse', $entry->action);
        $this->assertSame('Motif de test', $entry->details);
        $this->assertSame($superAdmin->id, $entry->performed_by);
    }

    public function test_acces_direct_rend_le_projet_visible(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $consultant = Consultant::factory()->create();
        $user = User::factory()->create(['role' => 'consultant', 'consultant_id' => $consultant->id]);
        $projet = Projet::factory()->create();

        $this->assertFalse(Projet::visiblesPour($user)->whereKey($projet->id)->exists());

        $this->actingAs($superAdmin)->put("/admin/users/{$user->id}/projets", [
            'projets' => [$projet->id],
        ])->assertRedirect();

        $this->assertTrue(Projet::visiblesPour($user->fresh())->whereKey($projet->id)->exists());
    }

    public function test_revocation_retire_l_acces_direct(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $consultant = Consultant::factory()->create();
        $user = User::factory()->create(['role' => 'consultant', 'consultant_id' => $consultant->id]);
        $projet = Projet::factory()->create();

        $user->projetsAccesDirect()->attach($projet->id);
        $this->assertTrue(Projet::visiblesPour($user->fresh())->whereKey($projet->id)->exists());

        $this->actingAs($superAdmin)->put("/admin/users/{$user->id}/projets", [
            'projets' => [],
        ])->assertRedirect();

        $this->assertFalse(Projet::visiblesPour($user->fresh())->whereKey($projet->id)->exists());
    }

    public function test_gestion_acces_direct_ne_touche_pas_affectations(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $consultant = Consultant::factory()->create();
        $user = User::factory()->create(['role' => 'consultant', 'consultant_id' => $consultant->id]);
        $projetAffecte = Projet::factory()->create();

        Affectation::create([
            'projet_id' => $projetAffecte->id,
            'consultant_id' => $consultant->id,
            'role_dans_projet' => 'Consultant',
            'jours_alloues' => 5,
            'jours_realises' => 0,
        ]);

        $this->actingAs($superAdmin)->put("/admin/users/{$user->id}/projets", [
            'projets' => [],
        ])->assertRedirect();

        $this->assertDatabaseHas('affectations', [
            'projet_id' => $projetAffecte->id,
            'consultant_id' => $consultant->id,
        ]);
        $this->assertTrue(Projet::visiblesPour($user->fresh())->whereKey($projetAffecte->id)->exists());
    }
}
