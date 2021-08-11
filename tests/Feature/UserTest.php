<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
  use RefreshDatabase, WithFaker;
    /**
     * Test to see if the register endpoint is working.
     *
     * @return void
     */
    public function test_registration()
    {
        $data = ['name' => $this->faker->firstName(), 'email' => $this->faker->email(), 'password' => 'n1nt3nd0'];
        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200)
            ->assertJson([
                'token' => true,
            ]);
        return $data;
    }

    /**
     * Test to see if the user can login and retrieve token.
     *
     * @return void
     */
    public function test_login()
    {
        $data = $this->test_registration();
        $response = $this->postJson('/api/token', ['email' => $data['email'], 'password' => $data['password']]);

        $response->assertStatus(200)
            ->assertJson([
                'token' => true,
            ]);
    }
}
