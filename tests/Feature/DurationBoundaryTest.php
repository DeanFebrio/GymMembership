<?php

namespace Tests\Feature;

use Tests\TestCase;

class DurationBoundaryTest extends TestCase
{
    public function test_duration_1_is_valid(): void
    {
        $response = $this->postJson('/membership', [
            'duration' => 1,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Membership duration is valid.',
                'data' => ['duration' => 1],
            ]);
    }

    public function test_duration_12_is_valid(): void
    {
        $response = $this->postJson('/membership', [
            'duration' => 12,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Membership duration is valid.',
                'data' => ['duration' => 12],
            ]);
    }

    public function test_duration_0_is_invalid(): void
    {
        $response = $this->postJson('/membership', [
            'duration' => 0,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('duration')
            ->assertJsonFragment([
                'message' => 'The duration field must be between 1 and 12.',
            ]);
    }

    public function test_duration_13_is_invalid(): void
    {
        $response = $this->postJson('/membership', [
            'duration' => 13,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('duration')
            ->assertJsonFragment([
                'message' => 'The duration field must be between 1 and 12.',
            ]);
    }
}
