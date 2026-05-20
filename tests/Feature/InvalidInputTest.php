<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvalidInputTest extends TestCase
{
    /**
     * Endpoint API untuk membership (Silakan disesuaikan dengan route sistem)
     */
    private string $endpoint = '/api/memberships';

    /**
     * Data payload default yang valid untuk testing
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'John Doe',
            'age' => 25,
            'membership_type' => 'Basic',
            'access_day' => 'Weekday',
        ], $overrides);
    }

    /**
     * TC-015: Age di bawah 12 ditolak
     */
    public function test_age_under_12_is_rejected(): void
    {
        $payload = $this->validPayload(['age' => 11]);

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['age'])
                 ->assertJsonPath('errors.age.0', 'The age field must be at least 12.');
    }

    /**
     * TC-016: Membership type "VIP" invalid
     */
    public function test_membership_type_vip_is_invalid(): void
    {
        $payload = $this->validPayload(['membership_type' => 'VIP']);

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['membership_type'])
                 ->assertJsonPath('errors.membership_type.0', 'The selected membership type is invalid.');
    }

    /**
     * TC-017: Access day "Holiday" invalid
     */
    public function test_access_day_holiday_is_invalid(): void
    {
        $payload = $this->validPayload(['access_day' => 'Holiday']);

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['access_day'])
                 ->assertJsonPath('errors.access_day.0', 'The selected access day is invalid.');
    }

    /**
     * TC-018: Age = 0 invalid
     */
    public function test_age_zero_is_invalid(): void
    {
        $payload = $this->validPayload(['age' => 0]);

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['age'])
                 ->assertJsonPath('errors.age.0', 'The age field must be at least 12.');
    }
}
