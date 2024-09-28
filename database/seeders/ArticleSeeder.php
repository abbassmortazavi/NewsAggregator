<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::query()->create([
            'title' => 'Sample Article 1',
            'content' => 'This is a description for Sample Article 1.',
            'url' => 'https://example.com/sample-article-1',
            'source' => 'NewsAPI',
            'author' => 'John Doe',
            'category' => 'Technology',
            'published_at' => now(),
        ]);
    }
}
