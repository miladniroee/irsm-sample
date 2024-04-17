<?php

namespace Tests\Feature\Blog;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_posts()
    {
        Post::factory()->count(21)->create();

        $response = $this->getJson('/api/blog');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next',
                    ],
                    'meta' => [
                        'current_page',
                        'last_page',
                        'total',
                    ],
                    'posts' => [
                        '*' => [
                            'slug',
                            'title',
                            'excerpt',
                            'thumbnail',
                            'view_count',
                            'comment_count',
                        ]
                    ]
                ]
            ]);

        $this->assertCount(20, $response->json('data.posts'));
    }

    public function test_category_returns_posts_for_given_category()
    {
        $category = Category::factory()->create(['slug' => 'laravel']);
        $postInCategory = Post::factory()->count(3)->create();

        $category->posts()->attach($postInCategory);

        $response = $this->getJson("/api/blog/category/{$category->slug}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next',
                    ],
                    'meta' => [
                        'current_page',
                        'last_page',
                        'total',
                    ],
                    'posts' => [
                        '*' => [
                            'slug',
                            'title',
                            'excerpt',
                            'thumbnail',
                            'view_count',
                            'comment_count',
                        ]
                    ]
                ]
            ]);
    }

    public function test_search_returns_matched_posts()
    {
        $post1 = Post::factory()->create(['title' => 'Laravel Post 1']);
        $post2 = Post::factory()->create(['title' => 'VueJS Post 2']);

        $response = $this->getJson('/api/blog/search?q=Laravel');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next',
                    ],
                    'meta' => [
                        'current_page',
                        'last_page',
                        'total',
                    ],
                    'posts' => [
                        '*' => [
                            'slug',
                            'title',
                            'excerpt',
                            'thumbnail',
                            'view_count',
                            'comment_count',
                        ]
                    ]
                ]
            ]);

        $this->assertEquals($post1->title, $response->json('data.posts.0.title'));
    }
}
