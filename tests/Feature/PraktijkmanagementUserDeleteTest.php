<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PraktijkmanagementUserDeleteTest extends TestCase
{
    use RefreshDatabase;

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
