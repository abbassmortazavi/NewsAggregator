<?php

namespace App\Providers;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\ArticleRepositoryInterface;
use App\Repositories\Preference\PreferenceRepository;
use App\Repositories\Preference\PreferenceRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\VerificationCode\VerificationCodeRepository;
use App\Repositories\VerificationCode\VerificationCodeRepositoryInterface;
use App\Services\Article\ArticleService;
use App\Services\Article\ArticleServiceInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Preference\PreferenceService;
use App\Services\Preference\PreferenceServiceInterface;
use App\Services\VerificationCode\VerificationCodeService;
use App\Services\VerificationCode\VerificationCodeServiceInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(VerificationCodeServiceInterface::class, VerificationCodeService::class);
        $this->app->bind(VerificationCodeRepositoryInterface::class, VerificationCodeRepository::class);

        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);

        $this->app->bind(PreferenceServiceInterface::class, PreferenceService::class);
        $this->app->bind(PreferenceRepositoryInterface::class, PreferenceRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(2)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
