<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Consultant;
use App\Models\Tache;
use App\Models\User;
use App\Notifications\TacheAssigneeNotification;
use App\Notifications\TacheRepondueNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CalendrierTest extends TestCase
{
    use RefreshDatabase;

    private function consultantUser(Consultant $consultant): User
    {
        return User::factory()->create([
            'role' => 'consultant',
            'consultant_id' => $consultant->id,
        ]);
    }

    public function test_un_consultant_ne_voit_que_ses_propres_taches(): void
    {
        $consultantA = Consultant::factory()->create();
        $consultantB = Consultant::factory()->create();
        $userA = $this->consultantUser($consultantA);

        $tacheA = Tache::factory()->create(['consultant_id' => $consultantA->id, 'titre' => 'Tache A']);
        Tache::factory()->create(['consultant_id' => $consultantB->id, 'titre' => 'Tache B']);

        $response = $this->actingAs($userA)->getJson('/calendrier/events');

        $response->assertOk();
        $ids = collect($response->json())->pluck('id');
        $this->assertTrue($ids->contains($tacheA->id));
        $this->assertCount(1, $ids);
    }

    public function test_un_consultant_ne_peut_pas_repondre_a_la_tache_dun_autre(): void
    {
        $consultantA = Consultant::factory()->create();
        $consultantB = Consultant::factory()->create();
        $userA = $this->consultantUser($consultantA);

        $tacheB = Tache::factory()->create(['consultant_id' => $consultantB->id]);

        $response = $this->actingAs($userA)->postJson("/calendrier/taches/{$tacheB->id}/repondre", [
            'statut' => 'Acceptée',
        ]);

        $response->assertNotFound();
    }

    public function test_super_admin_et_chef_projet_accedent_au_calendrier_admin(): void
    {
        $consultant = Consultant::factory()->create();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $chefProjet = User::factory()->create(['role' => 'chef_projet']);
        $consultantUser = $this->consultantUser($consultant);

        $this->actingAs($superAdmin)->get("/admin/calendrier/{$consultant->id}")->assertOk();
        $this->actingAs($chefProjet)->get("/admin/calendrier/{$consultant->id}")->assertOk();
        $this->actingAs($consultantUser)->get("/admin/calendrier/{$consultant->id}")->assertRedirect('/');
    }

    public function test_assigner_une_tache_declenche_la_notification_email(): void
    {
        Notification::fake();

        $consultant = Consultant::factory()->create();
        $consultantUser = $this->consultantUser($consultant);
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $client = Client::factory()->create();

        $response = $this->actingAs($superAdmin)->post("/admin/calendrier/{$consultant->id}/taches", [
            'client_id' => $client->id,
            'titre' => 'Audit ISO 9001',
            'objectif' => 'Vérifier le chapitre 6',
            'date' => now()->addDays(3)->toDateString(),
            'heure_debut' => '09:00',
            'heure_fin' => '11:00',
        ]);

        $response->assertRedirect();

        Notification::assertSentTo($consultantUser, TacheAssigneeNotification::class);
    }

    public function test_repondre_a_une_tache_met_a_jour_le_statut_et_notifie_lassigneur(): void
    {
        Notification::fake();

        $consultant = Consultant::factory()->create();
        $consultantUser = $this->consultantUser($consultant);
        $superAdmin = User::factory()->create(['role' => 'super_admin']);

        $tache = Tache::factory()->create([
            'consultant_id' => $consultant->id,
            'assigned_by' => $superAdmin->id,
            'statut' => 'Lue',
        ]);

        $response = $this->actingAs($consultantUser)->postJson("/calendrier/taches/{$tache->id}/repondre", [
            'statut' => 'Acceptée',
            'commentaire' => 'Bien reçu.',
        ]);

        $response->assertOk();
        $this->assertSame('Acceptée', $tache->fresh()->statut);
        $this->assertSame('Bien reçu.', $tache->fresh()->commentaire);

        Notification::assertSentTo($superAdmin, TacheRepondueNotification::class);
    }

    public function test_la_notification_ignore_le_canal_mail_si_le_notifiable_na_pas_demail(): void
    {
        $tache = Tache::factory()->make(['id' => 1]);
        $notifiableSansEmail = new User(['email' => null]);

        $canaux = (new TacheAssigneeNotification($tache))->via($notifiableSansEmail);

        $this->assertSame(['database'], $canaux);
    }
}
