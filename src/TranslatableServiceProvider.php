<?php declare(strict_types=1);

namespace Rat\Translatable;

use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    /**
     * Register Translatable application services.
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/translatable.php',
            'translatable'
        );
    }

    /**
     * Boot Translatable application services.
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/translatable.php' => config_path('translatable.php'),
        ], 'laravel-translatable-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_translations_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_translations_table.php'),
        ], 'laravel-translatable-migrations');
    }
}
