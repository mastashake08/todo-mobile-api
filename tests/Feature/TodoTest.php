<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class TodoTest extends TestCase
{
  use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
          ->postJson('/api/todos', ['content' => $this->faker->paragraph]);
          $response->assertStatus(200)
              ->assertJson([
                  'user_id' => $user->id,
              ]);
        return $response['id'];

    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
          ->postJson('/api/todos', ['content' => $this->faker->paragraph]);
          $response->assertStatus(200)
              ->assertJson([
                  'user_id' => $user->id,
              ]);
          $todoId = $response['id'];
          $res2 = $this->actingAs($user)
            ->deleteJson('/api/todos/'.$response['id']);
          $res2->assertStatus(200);

    }

    public function test_put()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
          ->postJson('/api/todos', ['content' => $this->faker->paragraph]);
          $response->assertStatus(200)
              ->assertJson([
                  'user_id' => $user->id,
              ]);
          $todoId = $response['id'];
          $content = $this->faker->paragraph;
          $response = $this->actingAs($user)
            ->putJson('/api/todos/'.$todoId, ['content' => $content]);
          $response->assertStatus(200)
            ->assertJson([
              'content' => $content
            ]);

    }

    public function test_show() {
      $user = User::factory()->create();
      $response = $this->actingAs($user)
        ->postJson('/api/todos', ['content' => $this->faker->paragraph]);
        $response->assertStatus(200)
            ->assertJson([
                'user_id' => $user->id,
            ]);
        $todoId = $response['id'];
        $content = $this->faker->paragraph;
        $response = $this->actingAs($user)
          ->postJson('/api/todos', ['content' => $content]);
          $response->assertStatus(200)
              ->assertJson([
                  'user_id' => $user->id,
                  'content' => $content
              ]);
    }
}
