<?php

namespace DavideCasiraghi\LaravelSmartBlog;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class LaravelSmartBlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-smart-blog');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-smart-blog');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->app['router']->aliasMiddleware('admin', \DavideCasiraghi\LaravelSmartBlog\Http\Middleware\Admin::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-smart-blog.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-smart-blog'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-smart-blog'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-smart-blog'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
            
            /* - Migrations -
               create a migration instance for each .php.stub file eg.
               create_continents_table.php.stub --->  2019_04_28_190434761474_create_continents_table.php
            */
            $migrations = [
                     'CreateCategoriesTable' => 'create_categories_table',
                     'CreateCategoryTranslationsTable' => 'create_category_translations_table',
                     'CreatePostsTable' => 'create_posts_table',
                     'CreatePostTranslationsTable' => 'post_translations',
                 ];
                 
             foreach ($migrations as $migrationFunctionName => $migrationFileName) {
                 if (! class_exists($migrationFunctionName)) {
                     $this->publishes([
                             __DIR__.'/../database/migrations/'.$migrationFileName.'.php.stub' => database_path('migrations/'.Carbon::now()->format('Y_m_d_Hmsu').'_'.$migrationFileName.'.php'),
                         ], 'migrations');
                 }
             }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-smart-blog');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-smart-blog', function () {
            return new LaravelSmartBlog;
        });
    }
}
