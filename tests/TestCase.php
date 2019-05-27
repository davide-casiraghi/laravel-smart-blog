<?php

namespace DavideCasiraghi\LaravelSmartBlog\Tests;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase as BaseTestCase;
use DavideCasiraghi\LaravelSmartBlog\Facades\LaravelSmartBlog;
use DavideCasiraghi\LaravelSmartBlog\LaravelSmartBlogServiceProvider;

//use Illuminate\Foundation\Testing\TestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadLaravelMigrations(['--database' => 'testbench']);
        $this->withFactories(__DIR__.'/database/factories');
        $this->createUser();

        //$this->artisan('db:seed', ['--class' => 'ContinentsTableSeeder']);
        //$this->artisan('db:seed', ['--database'=>'testbench','--class'=>'ContinentsTableSeeder']);

        //$this->artisan('db:seed', ['--database'=>'testbench','--class'=>'LaravelSmartBlog\\LaravelSmartBlog\\ContinentsTableSeeder']);
        //$this->artisan('db:seed', ['--database'=>'testbench','--class'=>'ContinentsTableSeeder', '--path'=>'/database/seeds/']);
        //$this->seed('ContinentsTableSeeder');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSmartBlogServiceProvider::class,
            \Mews\Purifier\PurifierServiceProvider::class,
            \Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
            \Dimsav\Translatable\TranslatableServiceProvider::class,
            \DavideCasiraghi\BootstrapAccordion\AccordionServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelSmartBlog' => LaravelSmartBlog::class, // facade called PhpResponsiveQuote and the name of the facade class
            'Purifier' => \Mews\Purifier\Facades\Purifier::class,
            'LaravelLocalization' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
            'BootstrapAccordion' => \DavideCasiraghi\BootstrapAccordion\Facades\BootstrapAccordion::class,
        ];
    }

    // Authenticate the user
    public function authenticate()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);
    }

    // Authenticate the admin
    public function authenticateAsAdmin()
    {
        $user = factory(User::class)->make([
                'group' => 2,
            ]);

        $this->actingAs($user);
    }

    // Authenticate the super admin
    public function authenticateAsSuperAdmin()
    {
        $user = factory(User::class)->make([
                'group' => 1,
            ]);

        $this->actingAs($user);
    }

    protected function createUser()
    {
        User::forceCreate([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => 'test',
        ]);
    }
}
