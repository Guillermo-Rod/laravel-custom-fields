<?php 

namespace GuillermoRod\CustomFields;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    /**
     * Get config path.
     */
    private string $configPath = __DIR__.'/../config/custom-fields.php';

    /**
     * Get config name.
     */
    private string $configName = 'custom-fields';

    /**
     * Get migration path.
     */
    private string $migrationPath = __DIR__.'/../migrations/';

    /**
     * Register files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom($this->migrationPath);
        // $this->mergeConfigFrom($this->configPath, $this->configName);
        $this->publishPackageFiles();
    }

    /**
     * Load package files.
     *
     * @return void
     */
    private function publishPackageFiles()
    {
        // // Publish config
        // $this->publishes([
        //     $this->configPath => config_path("$this->configName.php"),
        // ], 'laravel-custom-fields-config');

        // Publish migrations
        $this->publishes([
            $this->migrationPath => database_path('migrations'),
        ], 'laravel-custom-fields-migrations');
    }
}