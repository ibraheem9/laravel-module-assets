<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateModuleSymlinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:symlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create symlinks for module assets to public directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $modules = $this->getModuleNames();

        if (empty($modules)) {
            $this->warn('No modules found in the Modules directory');
            return 0;
        }

        $this->info('Creating symlinks for ' . count($modules) . ' module(s)...');
        $this->newLine();

        foreach ($modules as $module) {
            $this->createSymlinkForModule($module);
        }

        $this->newLine();
        $this->info('✓ Module symlinks created successfully!');
        return 0;
    }

    /**
     * Get all module names from the Modules directory.
     *
     * @return array
     */
    protected function getModuleNames()
    {
        $modulesDirectory = base_path('Modules');

        if (!File::exists($modulesDirectory)) {
            return [];
        }

        return array_filter(
            scandir($modulesDirectory),
            function ($item) use ($modulesDirectory) {
                return is_dir($modulesDirectory . '/' . $item) 
                    && $item !== '.' 
                    && $item !== '..';
            }
        );
    }

    /**
     * Create symlinks for a specific module.
     *
     * @param string $module
     * @return void
     */
    protected function createSymlinkForModule($module)
    {
        $sourcePath = base_path("Modules/$module/Assets");
        $destinationPath = public_path("modules/" . \Illuminate\Support\Str::snake($module));

        if (!File::exists($sourcePath)) {
            $this->warn("  ⚠ Source folder does not exist: $sourcePath");
            return;
        }

        // Create destination directory if it doesn't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
            $this->line("  ✓ Created directory: $destinationPath");
        }

        $this->createSymlinksForAssets($sourcePath, $destinationPath, $module);
    }

    /**
     * Create symlinks for asset subdirectories.
     *
     * @param string $sourcePath
     * @param string $destinationPath
     * @param string $module
     * @return void
     */
    protected function createSymlinksForAssets($sourcePath, $destinationPath, $module)
    {
        $directories = File::directories($sourcePath);

        if (empty($directories)) {
            $this->warn("  ⚠ No asset directories found in: $sourcePath");
            return;
        }

        foreach ($directories as $directory) {
            $dirName = basename($directory);
            $symlinkPath = $destinationPath . '/' . $dirName;

            // Handle existing symlinks or files
            if (file_exists($symlinkPath) || is_link($symlinkPath)) {
                if (is_link($symlinkPath)) {
                    unlink($symlinkPath);
                    $this->line("  ↻ Removed existing symlink: $symlinkPath");
                } else {
                    $this->error("  ✗ Conflict at: $symlinkPath. It exists as a file or directory.");
                    continue;
                }
            }

            // Create the symlink
            try {
                File::link($directory, $symlinkPath);
                $this->line("  ✓ [$module] $dirName → $symlinkPath");
            } catch (\Exception $e) {
                $this->error("  ✗ Failed to create symlink for $dirName: " . $e->getMessage());
            }
        }
    }
}
