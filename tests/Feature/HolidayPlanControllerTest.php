<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\HolidayPlan;
use App\Models\User;

class HolidayPlanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Criar um usuário e autenticar
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    /** @test */
    public function it_can_create_a_holiday_plan()
    {
        $data = [
            'title' => 'Férias em Cancun',
            'description' => 'Viagem de uma semana para Cancun.',
            'date' => '2025-01-10',
            'location' => 'Cancun, México',
        ];

        $response = $this->postJson('/api/holidays', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('holiday_plans', ['title' => 'Férias em Cancun']);
    }

    /** @test */
    public function it_can_retrieve_all_holiday_plans()
    {
        HolidayPlan::truncate();
        HolidayPlan::factory()->count(3)->create();

        $response = $this->getJson('/api/holidays');

        $response->assertStatus(200);
        $response->assertJsonCount(3, '0');
    }

    /** @test */
    public function it_can_retrieve_a_single_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create([
            'date' => '2025-01-10',
        ]);

        $response = $this->getJson('/api/holidays/' . $holidayPlan->id);

        $response->assertStatus(200);
        $response->assertJson([
            'title' => $holidayPlan->title,
            'description' => $holidayPlan->description,
            // 'date' => $holidayPlan->date->format('Y-m-d'),
            'date' => '2025-01-10',
            'location' => $holidayPlan->location,
        ]);
    }

    /** @test */
    public function it_can_update_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();

        $data = [
            'title' => 'Férias Atualizadas',
            'description' => 'Viagem atualizada para Cancun.',
            'date' => '2025-12-25',
            'location' => 'Rio de Janeiro, Brasil',
        ];

        $response = $this->putJson('/api/holidays/' . $holidayPlan->id, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('holiday_plans', ['title' => 'Férias Atualizadas']);
    }

    /** @test */
    public function it_can_delete_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();

        $response = $this->deleteJson('/api/holidays/' . $holidayPlan->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('holiday_plans', ['id' => $holidayPlan->id]);
    }

    /** @test */
    public function it_can_generate_a_pdf_for_a_holiday_plan()
    {
        $holidayPlan = HolidayPlan::factory()->create();

        $response = $this->getJson('/api/holidays/' . $holidayPlan->id . '/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
