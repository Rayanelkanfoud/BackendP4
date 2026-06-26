<?php

namespace Tests\Feature;

use App\Models\AllergeenModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllergeenCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_praktijkmanagement_can_read_allergenen(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        AllergeenModel::create([
            'Naam' => 'Pinda',
            'Omschrijving' => 'Pinda allergie',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->get(route('allergenen.index'));

        $response->assertOk();
        $response->assertSee('Pinda');
        $response->assertSee('Pinda allergie');
    }

    public function test_praktijkmanagement_can_create_allergeen(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->post(route('allergenen.store'), [
                'Naam' => 'Gluten',
                'Omschrijving' => 'Gluten allergie',
            ]);

        $response->assertRedirect(route('allergenen.index'));
        $this->assertDatabaseHas('Allergenen', [
            'Naam' => 'Gluten',
            'Omschrijving' => 'Gluten allergie',
        ]);
    }

    public function test_praktijkmanagement_can_open_edit_form(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $allergeen = AllergeenModel::create([
            'Naam' => 'Melk',
            'Omschrijving' => 'Oud',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->post(route('allergenen.edit', $allergeen->Id), [
                '_method' => 'GET',
            ]);

        $response->assertOk();
        $response->assertSee('Melk');
        $response->assertSee('Oud');
    }

    public function test_praktijkmanagement_can_update_allergeen(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $allergeen = AllergeenModel::create([
            'Naam' => 'Melk',
            'Omschrijving' => 'Oud',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->put(route('allergenen.update', $allergeen->Id), [
                'Naam' => 'Lactose',
                'Omschrijving' => 'Nieuw',
            ]);

        $response->assertRedirect(route('allergenen.index'));
        $this->assertDatabaseHas('Allergenen', [
            'Id' => $allergeen->Id,
            'Naam' => 'Lactose',
            'Omschrijving' => 'Nieuw',
        ]);
    }

    public function test_praktijkmanagement_can_delete_allergeen(): void
    {
        $praktijkmanagement = User::factory()->create([
            'rolename' => 'praktijkmanagement',
        ]);

        $allergeen = AllergeenModel::create([
            'Naam' => 'Noten',
            'Omschrijving' => 'Noten allergie',
        ]);

        $response = $this
            ->actingAs($praktijkmanagement)
            ->delete(route('allergenen.destroy', $allergeen->Id));

        $response->assertRedirect(route('allergenen.index'));
        $this->assertDatabaseMissing('Allergenen', [
            'Id' => $allergeen->Id,
        ]);
    }

    public function test_patient_cannot_manage_allergenen(): void
    {
        $patient = User::factory()->create([
            'rolename' => 'patient',
        ]);

        $response = $this
            ->actingAs($patient)
            ->get(route('allergenen.index'));

        $response->assertForbidden();
    }
}
