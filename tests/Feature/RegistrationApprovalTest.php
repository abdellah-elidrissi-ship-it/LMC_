<?php

namespace Tests\Feature;

use App\Models\Consultant;
use App\Models\User;
use App\Notifications\CompteApprouveNotification;
use App\Notifications\CompteRefuseNotification;
use App\Notifications\VerifyAccountNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegistrationApprovalTest extends TestCase
{
    use RefreshDatabase;

    private function signedVerifyUrl(User $user): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
    }

    public function test_inscription_cree_un_compte_en_attente_non_verifie(): void
    {
        Notification::fake();

        $response = $this->post('/register', [
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');

        $user = User::where('email', 'jean.dupont@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('Jean Dupont', $user->name);
        $this->assertSame('en_attente', $user->statut_compte);
        $this->assertNull($user->email_verified_at);
        $this->assertGuest();

        Notification::assertSentTo($user, VerifyAccountNotification::class);
    }

    public function test_connexion_refusee_tant_que_le_compte_est_en_attente(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'statut_compte' => 'en_attente',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_connexion_refusee_si_le_compte_est_refuse(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'statut_compte' => 'refuse',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_compte_non_verifie_invisible_dans_la_liste_admin(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $pending = User::factory()->create([
            'statut_compte' => 'en_attente',
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($superAdmin)->get('/admin/users');

        $response->assertOk();
        $response->assertDontSee($pending->email);
    }

    public function test_lien_de_verification_marque_lemail_verifie_et_fait_apparaitre_la_demande(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $pending = User::factory()->create([
            'statut_compte' => 'en_attente',
            'email_verified_at' => null,
        ]);

        $response = $this->get($this->signedVerifyUrl($pending));
        $response->assertRedirect('/login');

        $this->assertNotNull($pending->fresh()->email_verified_at);

        $adminView = $this->actingAs($superAdmin)->get('/admin/users');
        $adminView->assertSee($pending->email);
    }

    public function test_lien_de_verification_invalide_est_rejete(): void
    {
        $pending = User::factory()->create(['email_verified_at' => null]);

        $response = $this->get('/email/verify/' . $pending->id . '/hash-invalide?expires=9999999999&signature=fake');

        $response->assertForbidden();
        $this->assertNull($pending->fresh()->email_verified_at);
    }

    public function test_approbation_assigne_role_et_consultant_existant_puis_permet_la_connexion(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $consultant = Consultant::factory()->create();
        $pending = User::factory()->create([
            'password' => bcrypt('password123'),
            'statut_compte' => 'en_attente',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($superAdmin)->put("/admin/users/{$pending->id}/approuver", [
            'role' => 'consultant',
            'permissions' => ['voir_details' => 'yes'],
            'consultant_mode' => 'existing',
            'consultant_id' => $consultant->id,
        ]);

        $response->assertRedirect();

        $pending->refresh();
        $this->assertSame('approuve', $pending->statut_compte);
        $this->assertSame('consultant', $pending->role);
        $this->assertSame($consultant->id, $pending->consultant_id);

        Notification::assertSentTo($pending, CompteApprouveNotification::class);

        $login = $this->post('/login', ['email' => $pending->email, 'password' => 'password123']);
        $login->assertRedirect('/');
        $this->assertAuthenticatedAs($pending);
    }

    public function test_approbation_peut_creer_un_nouveau_profil_consultant(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $pending = User::factory()->create([
            'statut_compte' => 'en_attente',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($superAdmin)->put("/admin/users/{$pending->id}/approuver", [
            'role' => 'chef_projet',
            'consultant_mode' => 'nouveau',
            'nouveau_type_consultant' => 'Interne',
            'nouveau_specialite' => 'ISO 14001',
        ]);

        $response->assertRedirect();

        $pending->refresh();
        $this->assertSame('approuve', $pending->statut_compte);
        $this->assertNotNull($pending->consultant_id);
        $this->assertSame($pending->name, $pending->consultant->nom_complet);
    }

    public function test_refus_bloque_la_connexion_et_notifie(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $pending = User::factory()->create([
            'password' => bcrypt('password123'),
            'statut_compte' => 'en_attente',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($superAdmin)->put("/admin/users/{$pending->id}/refuser", [
            'motif_refus' => 'Profil ne correspond pas à un besoin actuel.',
        ]);

        $response->assertRedirect();

        $pending->refresh();
        $this->assertSame('refuse', $pending->statut_compte);
        Notification::assertSentTo($pending, CompteRefuseNotification::class);

        $login = $this->post('/login', ['email' => $pending->email, 'password' => 'password123']);
        $login->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
