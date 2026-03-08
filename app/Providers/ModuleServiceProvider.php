<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModules();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadModuleRoutes();
        $this->loadModuleViews();
    }

    /**
     * Register all modules.
     *
     * @return void
     */
    protected function registerModules()
    {
        $modulesPath = base_path('Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $this->registerModule($modulePath, $moduleName);
        }
    }

    /**
     * Register a single module.
     *
     * @param string $modulePath
     * @param string $moduleName
     * @return void
     */
    protected function registerModule($modulePath, $moduleName)
    {
        // Register module service provider if exists
        $providerPath = $modulePath . '/src/Providers/' . $moduleName . 'ServiceProvider.php';
        
        if (File::exists($providerPath)) {
            $namespace = "Modules\\$moduleName\\Providers\\{$moduleName}ServiceProvider";
            $this->app->register($namespace);
        }
    }

    /**
     * Load module routes.
     *
     * @return void
     */
    protected function loadModuleRoutes()
    {
        $modulesPath = base_path('Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $routesFile = $modulePath . '/src/Routes/web.php';
            
            if (File::exists($routesFile)) {
                $this->loadRoutesFrom($routesFile);
            }
        }
    }

    /**
     * Load module views.
     *
     * @return void
     */
    protected function loadModuleViews()
    {
        $modulesPath = base_path('Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        $modules = File::directories($modulesPath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $viewsPath = $modulePath . '/src/Views';
            
            if (File::exists($viewsPath)) {
                $this->loadViewsFrom($viewsPath, strtolower($moduleName));
            }
        }
    }
}
