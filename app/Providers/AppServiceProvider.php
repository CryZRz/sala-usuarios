<?php

namespace App\Providers;

use App\Observers\PersonalAccessTokenObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Token;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        Token::observe(PersonalAccessTokenObserver::class);
    }
}
