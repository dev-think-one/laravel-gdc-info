<?php

namespace GDCInfo\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            \GDCInfo\ServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/Fixtures/migrations');
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // $app['config']->set('gdc-info.some_key', 'some_value');
    }
}
