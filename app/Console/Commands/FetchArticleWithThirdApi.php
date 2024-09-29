<?php

namespace App\Console\Commands;

use App\Repositories\Article\ArticleRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchArticleWithThirdApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Article From Other Resource...';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->fetchFromNewsApi();
        $this->fetchNewsFromGuardian();
        $this->info('Fetch article Successfully!!!');
    }

    /**
     * @return void
     */
    private function fetchFromNewsApi(): void
    {
        $newsApiUrl = config('services.news.newsapi.url');
        $newsApiKey = config('services.news.newsapi.api_key');
        $res = Http::get("$newsApiUrl?q=tesla&from=2024-08-29&sortBy=publishedAt&apiKey=$newsApiKey");

        $articles = $res->json()['articles'];
        foreach ($articles as $article) {
            //store article
            $article['url_to_image'] = $article['urlToImage'];
            $article['published_at'] = $article['publishedAt'];
            $article['type'] = "NewsApi";
            $this->storeArticle($article);
        }
    }

    /**
     * @param array $article
     * @return void
     */
    private function storeArticle(array $article): void
    {
        app(ArticleRepositoryInterface::class)->store($article);
    }

    /**
     * @return void
     */
    public function fetchNewsFromGuardian(): void
    {
        $guardianApiUrl = config('services.news.guardian.url');
        $guardianApiKey = config('services.news.guardian.api_key');

        $res = Http::get($guardianApiUrl, [
            'api-key' => $guardianApiKey,
            'section' => 'technology',
            'show-fields' => 'all',
        ]);

        $articles = $res->json('response.results');

        foreach ($articles as $article) {
            $arr['content'] = $article['content'] ?? null;
            $arr['author'] = $article['author'] ?? null;
            $arr['title'] = $article['webTitle'];
            $arr['type'] = "guardian";
            $arr['category'] = "Technology";
            $arr['url'] = $article['webUrl'];
            $arr['published_at'] = $article['webPublicationDate'];
            $this->storeArticle($arr);
        }
    }
}
