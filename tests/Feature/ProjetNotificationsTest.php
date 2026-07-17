<?php

namespace Tests\Feature;

use App\Models\Affectation;
use App\Models\Consultant;
use App\Models\Projet;
use App\Models\User;
use App\Notifications\CompteApprouveNotification;
use App\Notifications\ProjetAssigneNotification;
use App\Notifications\ProjetRetireNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProjetNotificationsTest extends TestCase
{
    use RefreshDatabase;

    private function basePayload(Projet $projet): array
    {
        return [
            'reference_projet' => $projet->reference_projet,
            'client_nom' => $projet->client->nom_client,
            'chef_projet_id' => $projet->chef_projet_id,
            'statut' => 'En cours',
            'type_projet' => 'SMI — Système de Management Intégré',
            'jours_prevus' => 20,
        ];
    }

    public function test_ajout_consultant_notifie_son_compte_lie(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $projet = Projet::factory()->create();
        $consultant = Consultant::factory()->create();
        $consultantUser = User::factory()->create(['role' => 'consultant', 'consultant_id' => $consultant->id]);

        $payload = array_merge($this->basePayload($projet), [
            'consultants' => [
                ['id' => $consultant->id, 'role' => 'Auditeur', 'jours_alloues' => 5],
            ],
        ]);

        $this->actingAs($superAdmin)->put("/projets/{$projet->id}", $payload)->assertRedirect();

        Notification::assertSentTo($consultantUser, ProjetAssigneNotification::class);
    }

    public function test_retrait_consultant_notifie_son_compte_lie(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $projet = Projet::factory()->create();
        $consultant = Consultant::factory()->create();
        $consultantUser = User::factory()->create(['role' => 'consultant', 'consultant_id' => $consultant->id]);

        Affectation::create([
            'projet_id' => $projet->id,
            'consultant_id' => $consultant->id,
            'role_dans_projet' => 'Consultant',
            'jours_alloues' => 5,
            'jours_realises' => 0,
        ]);

        $payload = array_merge($this->basePayload($projet), [
            'deleted_consultants' => [$consultant->id],
        ]);

        $this->actingAs($superAdmin)->put("/projets/{$projet->id}", $payload)->assertRedirect();

        Notification::assertSentTo($consultantUser, ProjetRetireNotification::class);
    }

    public function test_changement_de_chef_notifie_ancien_et_nouveau(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $ancienChef = Consultant::factory()->create();
        $nouveauChef = Consultant::factory()->create();
        $ancienChefUser = User::factory()->create(['role' => 'chef_projet', 'consultant_id' => $ancienChef->id]);
        $nouveauChefUser = User::factory()->create(['role' => 'chef_projet', 'consultant_id' => $nouveauChef->id]);

        $projet = Projet::factory()->create(['chef_projet_id' => $ancienChef->id]);

        $payload = array_merge($this->basePayload($projet), [
            'chef_projet_id' => $nouveauChef->id,
        ]);

        $this->actingAs($superAdmin)->put("/projets/{$projet->id}", $payload)->assertRedirect();

        Notification::assertSentTo($ancienChefUser, ProjetRetireNotification::class);
        Notification::assertSentTo($nouveauChefUser, ProjetAssigneNotification::class);
    }

    public function test_consultant_sans_compte_ne_plante_pas(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $projet = Projet::factory()->create();
        $consultantSansCompte = Consultant::factory()->create();

        $payload = array_merge($this->basePayload($projet), [
            'consultants' => [
                ['id' => $consultantSansCompte->id, 'role' => 'Consultant', 'jours_alloues' => 5],
            ],
        ]);

        $response = $this->actingAs($superAdmin)->put("/projets/{$projet->id}", $payload);
        $response->assertRedirect();

        Notification::assertNothingSent();
    }

    public function test_acces_direct_notifie_ajout_et_retrait(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $consultant = Consultant::factory()->create();
        $user = User::factory()->create(['role' => 'consultant', 'consultant_id' => $consultant->id]);
        $projet = Projet::factory()->create();

        $this->actingAs($superAdmin)->put("/admin/users/{$user->id}/projets", [
            'projets' => [$projet->id],
        ])->assertRedirect();

        Notification::assertSentTo($user, ProjetAssigneNotification::class);

        $this->actingAs($superAdmin)->put("/admin/users/{$user->id}/projets", [
            'projets' => [],
        ])->assertRedirect();

        Notification::assertSentTo($user, ProjetRetireNotification::class);
    }

    public function test_notifications_compte_multi_canal(): void
    {
        Notification::fake();

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

        Notification::assertSentTo(
            $pending,
            CompteApprouveNotification::class,
            function ($notification, $channels) {
                return in_array('database', $channels) && in_array('mail', $channels);
            }
        );
    }
}
