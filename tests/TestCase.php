<?php

namespace Mint\Translatable\Tests;

use Illuminate\Foundation\Application;
use Mint\Translatable\TranslatableServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     * @return void
     */
    protected function tearDown(): void
    {
        if (config('database.default') === 'mongodb') {
            $conn = app('db')->connection('mongodb');
            $db   = $conn->getMongoClient()->selectDatabase($conn->getDatabaseName());
            foreach (['posts', 'translations'] as $col) {
                $db->selectCollection($col)->deleteMany([]);
            }
        }
        parent::tearDown();
    }


    /**
     * Get package providers.
     * @param Application $app
     * @return array<int, class-string<mixed>>
     */
    protected function getPackageProviders($app)
    {
        if (env('DB_CONNECTION', 'sqlite') === 'mongodb') {
            return [
                \MongoDB\Laravel\MongoDBBusServiceProvider::class,
                \MongoDB\Laravel\MongoDBServiceProvider::class,
                TranslatableServiceProvider::class,
            ];
        } else {
            return [
                TranslatableServiceProvider::class,
            ];
        }
    }

    /**
     * Define environment setup.
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $driver = env('DB_CONNECTION', 'sqlite');
        $app['config']->set('database.default', $driver);

        $app['config']->set('translatable.test_model', \Mint\Translatable\Tests\Fixtures\Models\Post::class);
        switch ($driver) {
            case 'mysql':
                $app['config']->set('database.connections.mysql', [
                    'driver'    => 'mysql',
                    'host'      => env('DB_HOST', '127.0.0.1'),
                    'port'      => env('DB_PORT', 3306),
                    'database'  => env('DB_DATABASE', 'testing'),
                    'username'  => env('DB_USERNAME', 'root'),
                    'password'  => env('DB_PASSWORD', ''),
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                ]);
                break;
            case 'mariadb':
                $app['config']->set('database.connections.mariadb', [
                    'driver'    => 'mysql',
                    'host'      => env('DB_HOST', '127.0.0.1'),
                    'port'      => env('DB_PORT', 3306),
                    'database'  => env('DB_DATABASE', 'testing'),
                    'username'  => env('DB_USERNAME', 'root'),
                    'password'  => env('DB_PASSWORD', ''),
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                ]);
                break;
            case 'pgsql':
                $app['config']->set('database.connections.pgsql', [
                    'driver'   => 'pgsql',
                    'host'     => env('DB_HOST', '127.0.0.1'),
                    'port'     => env('DB_PORT', 5432),
                    'database' => env('DB_DATABASE', 'testing'),
                    'username' => env('DB_USERNAME', 'postgres'),
                    'password' => env('DB_PASSWORD', 'postgres'),
                    'charset'  => 'utf8',
                    'prefix'   => '',
                    'schema'   => 'public',
                ]);
                break;
            case 'mongodb':
                $app['config']->set('database.connections.mongodb', [
                    'driver'   => 'mongodb',
                    'host'     => env('DB_HOST', '127.0.0.1'),
                    'port'     => env('DB_PORT', 27017),
                    'database' => env('DB_DATABASE', 'testing'),
                    'username' => env('DB_USERNAME', null),
                    'password' => env('DB_PASSWORD', null),
                ]);
                $app['config']->set('translatable.translatable_model', \Mint\Translatable\Collections\Translation::class);
                $app['config']->set('translatable.test_model', \Mint\Translatable\Tests\Fixtures\Collections\Post::class);
                break;
            default:
                $app['config']->set('database.connections.sqlite', [
                    'driver'   => 'sqlite',
                    'database' => ':memory:',
                    'prefix'   => '',
                    'foreign_key_constraints' => true,
                ]);
        }

        // Optionale Locale für Tests
        $app['config']->set('translatable.array_like_attributes', ['options']);
        $app['config']->set('app.fallback_locale', 'en');
        $app['config']->set('app.locale', 'en');
    }

    /**
     * Define database migrations.
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/Fixtures/migrations');
    }
}
