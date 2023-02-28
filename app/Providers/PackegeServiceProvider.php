<?php

namespace Danshin\Comment\Providers;

use Illuminate\Support\ServiceProvider;
use Danshin\Comment\Console\Commands\Cut as CutCommand;
use Danshin\Comment\Console\Commands\Clear as ClearCommand;

class PackegeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/danshin-comment.php' => config_path('danshin-comment.php')]);
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'danshin/comment');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'danshin/comment');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CutCommand::class,
                ClearCommand::class
            ]);
        }
    }
}
