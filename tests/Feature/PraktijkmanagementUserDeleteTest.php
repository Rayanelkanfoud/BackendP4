<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PraktijkmanagementUserDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_praktijkmanagement_can_update_another_users_role(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $patient = User::factory()->create([
            'rolename' => 'patient',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->patch(route('praktijkmanagement.users.role', $patient), [
                'rolename' => 'assistent',
            ]);

        $response->assertRedirect(route('praktijkmanagement.index'));
        $this->assertDatabaseHas('users', [
            'id' => $patient->id,
            'rolename' => 'assistent',
        ]);
    }

    public function test_praktijkmanagement_cannot_update_own_role_from_users_table(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->patch(route('praktijkmanagement.users.role', $praktijkmanagement), [
                'rolename' => 'patient',
            ]);

        $response->assertRedirect(route('praktijkmanagement.index'));
        $this->assertDatabaseHas('users', [
            'id' => $praktijkmanagement->id,
            'rolename' => 'praktijkmanagement',
        ]);
    }

    public function test_other_roles_do_not_see_gebruikersrollen_link(): void
    {
        $patient = User::factory()->create([
            'rolename' => 'patient',
        ]);

        $response = $this->actingAs($patient)->get(route('patient.index'));

        $response->assertOk();
        $response->assertDontSee('Gebruikersrollen');
    }

    public function test_praktijkmanagement_can_delete_a_user(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $patient = User::factory()->create([
            'rolename' => 'patient',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->delete(route('praktijkmanagement.users.destroy', $patient));

        $response->assertRedirect(route('praktijkmanagement.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $patient->id,
        ]);
    }

    public function test_patient_cannot_delete_a_user(): void
    {
        $patient = User::factory()->create([
            'rolename' => 'patient',
        ]);

        $otherUser = User::factory()->create();

        $response = $this
            ->actingAs($patient)
            ->delete(route('praktijkmanagement.users.destroy', $otherUser));

        $response->assertForbidden();
        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
        ]);
    }

    public function test_praktijkmanagement_cannot_delete_own_account(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->delete(route('praktijkmanagement.users.destroy', $praktijkmanagement));

        $response->assertRedirect(route('praktijkmanagement.index'));
        $this->assertDatabaseHas('users', [
            'id' => $praktijkmanagement->id,
        ]);
    }
}
