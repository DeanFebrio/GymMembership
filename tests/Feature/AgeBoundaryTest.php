<?php

namespace Tests\Feature;

use Tests\TestCase;

class AgeBoundaryTest extends TestCase
{
    // TC-008: age = 12 diterima
    public function test_age_12_allowed(): void
    {
        $response = $this->postJson('/api/membership', [
            'age' => 12,
            'membership_type' => 'Basic',
            'access_day' => 'Weekday',
            'membership_duration' => 3,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Registration successful. Minimum age accepted.'
                 ]);
    }

    // TC-009: age = 11 ditolak
    public function test_age_11_rejected(): void
    {
        $response = $this->postJson('/api/membership', [
            'age' => 11,
            'membership_type' => 'Basic',
            'access_day' => 'Weekday',
            'membership_duration' => 3,
        ]);

        $response->assertStatus(400)
                 ->assertJson([
                     'message' => 'Error: Age below 12 is not allowed.'
                 ]);
    }

    // TC-010: age = 60 mendapat senior discount
    public function test_age_60_senior_discount(): void
    {
        $response = $this->postJson('/api/membership', [
            'age' => 60,
            'membership_type' => 'Basic',
            'access_day' => 'Weekday',
            'membership_duration' => 3,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Registration successful. 30% senior discount applied.'
                 ]);
    }
}
