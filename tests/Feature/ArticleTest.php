<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_it_can_fetch_articles(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        Article::factory()->count(5)->create();

        $response = $this->getJson('/api/articles');

        $response->assertOk();
        $response->assertJsonCount(5, 'data.data');
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'content',
                        'author',
                        'source',
                        'category',
                        'url',
                        'published_at',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }

    /**
     * @return void
     */
    public function test_it_can_fetch_a_single_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $article = Article::factory()->create();

        $response = $this->getJson("/api/articles/{$article->id}");

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'title' => $article->title,
                'content' => $article->content,
            ],
        ]);
    }

    /**
     * @return void
     */
    public function test_it_can_search_articles_by_keyword()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        Article::factory()->create(['title' => 'Tech News']);
        Article::factory()->create(['title' => 'World News']);

        $response = $this->getJson('/api/articles?keyword=Tech');

        $response->assertOk();
        $response->assertJsonCount(1, 'data.data');
        $response->assertJsonFragment(['title' => 'Tech News']);
    }
}
