<?php

namespace Tests\Feature\Blog;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_post_resource_when_given_a_valid_slug()
    {
        // Arrange: Create a post with a specific slug
        $post = Post::factory()->create(['slug' => 'my-awesome-post']);

        // Act: Make a request to the index method with the slug
        $response = $this->get(route('blog.posts.index', ['slug' => 'my-awesome-post']));

        // Assert: Check if the response contains the post title and resource
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => $post->title,
                    // Add other expected attributes here
                ],
            ]);
    }

    public function test_sidebar_returns_related_data()
    {
        $post = Post::factory()->create();
        $relatedPost = Post::factory()->create();
        $post->categories()->attach($relatedPost->categories->first());

        $response = $this->getJson("/api/posts/{$post->slug}/sidebar");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'related' => [
                        '*' => [/* post fields */],
                    ],
                    'latest' => [
                        '*' => [/* post fields */],
                    ],
                    'mostViewed' => [
                        '*' => [/* post fields */],
                    ],
                    'comments' => [
                        '*' => [/* comment fields */],
                    ],
                ]
            ]);
    }

    public function test_related_posts_excludes_given_post()
    {
        $post = Post::factory()->create();
        $relatedPost = Post::factory()->create();

        $post->categories()->attach($relatedPost->categories->first());

        $response = $this->getJson("/api/posts/{$post->slug}/sidebar");

        $response->assertJsonMissing([
            'id' => $post->id,
        ]);
    }

    public function test_latest_posts_excludes_given_and_related_posts()
    {
        // Arrange
        $post = Post::factory()->create();
        $relatedPost = Post::factory()->create();
        $latestPost = Post::factory()->create();

        $post->categories()->attach($relatedPost->categories->first());

        // Act
        $response = $this->getJson("/api/posts/{$post->slug}/sidebar");

        // Assert
        $response->assertJsonMissing([
            'id' => $post->id,
            'id' => $relatedPost->id,
        ]);
    }

    public function test_most_viewed_posts_returns_correct_order()
    {
        // Arrange
        $post1 = Post::factory()->create(['views' => 100]);
        $post2 = Post::factory()->create(['views' => 200]);
        $post3 = Post::factory()->create(['views' => 50]);

        // Act
        $response = $this->getJson('/api/posts/fake-slug/sidebar');

        // Assert
        $views = collect($response->json('data.mostViewed'))
            ->pluck('views')
            ->toArray();

        $this->assertEquals([200, 100, 50], $views);
    }
}
