<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Interfaces\AuthenticationInterface;
use App\Http\Interfaces\TweetInterface;

use App\Http\Repositories\UserRepository;
use App\Http\Repositories\TweetRepository;

use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthenticationInterface::class, function ($app) {
            return new UserRepository(new User);
        });

        $this->app->singleton(TweetInterface::class, function ($app) {
            return new TweetRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
