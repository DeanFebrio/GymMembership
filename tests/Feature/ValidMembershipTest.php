<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidMembershipTest extends TestCase
{
    use WithoutMiddleware;
    protected string $endpoint = '/api/memberships';

    public function test_basic_membership_success()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'basic',
            'is_student' => false,
            'age' => 30, // Normal adult
            'is_weekend' => false,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ]);
    }

    public function test_student_discount_20_percent()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'basic',
            'is_student' => true,
            'age' => 20,
            'is_weekend' => false,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ])
                 ->assertSeeText('discount'); 
    }

    public function test_senior_discount_30_percent()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'basic',
            'is_student' => false,
            'age' => 65,
            'is_weekend' => false,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ])
                 ->assertSeeText('discount');
    }

    public function test_weekend_fee_added()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'basic',
            'is_student' => false,
            'age' => 30,
            'is_weekend' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ])
                 ->assertSeeText('weekend');
    }
    public function test_premium_unlimited_access()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'premium',
            'is_student' => false,
            'age' => 30,
            'is_weekend' => false,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ])
                 ->assertSeeText('premium');
    }

    public function test_kombinasi_student_and_weekend()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'basic',
            'is_student' => true,
            'age' => 22,
            'is_weekend' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ]);
    }
    
    public function test_kombinasi_senior_premium_and_weekend()
    {
        $response = $this->postJson($this->endpoint, [
            'type' => 'premium',
            'is_student' => false,
            'age' => 70,
            'is_weekend' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ]);
    }
}
