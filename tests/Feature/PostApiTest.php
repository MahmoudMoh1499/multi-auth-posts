<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/user/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'status' => 'published',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Post']);
    }

    public function test_guest_cannot_create_post()
    {
        $response = $this->postJson('/api/user/posts', [
            'title' => 'Guest Post',
            'content' => 'Should not work.',
            'status' => 'draft',
        ]);

        $response->assertStatus(401);
    }

    public function test_post_validation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/user/posts', [
            'title' => '',
            'content' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_user_can_update_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/user/posts/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
            'status' => 'draft',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);
    }

    public function test_user_can_delete_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/user/posts/{$post->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_user_can_list_their_posts()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/user/posts');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_view_single_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/user/posts/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $post->title]);
    }

}
