<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Str::random(5),
            'content' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
            'source' => 'NewsAPI',
            'author' => $this->faker->name(),
            'category' => 'Technology',
            'published_at' => now(),
        ];
    }
}
