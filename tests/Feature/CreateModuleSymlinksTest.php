<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CreateModuleSymlinksTest extends TestCase
{
    /**
     * Test that the command creates symlinks for module assets.
     *
     * @return void
     */
    public function test_command_creates_symlinks_for_modules()
    {
        // Ensure modules directory exists
        $this->assertTrue(File::exists(base_path('Modules')));

        // Run the command
        $this->artisan('modules:symlink')
            ->assertExitCode(0);

        // Check if symlinks were created
        $this->assertTrue(is_link(public_path('modules/dashboard/js')));
        $this->assertTrue(is_link(public_path('modules/dashboard/css')));
        $this->assertTrue(is_link(public_path('modules/analytics/js')));
        $this->assertTrue(is_link(public_path('modules/analytics/css')));
        $this->assertTrue(is_link(public_path('modules/settings/js')));
        $this->assertTrue(is_link(public_path('modules/settings/css')));
    }

    /**
     * Test that symlinks point to the correct directories.
     *
     * @return void
     */
    public function test_symlinks_point_to_correct_directories()
    {
        $this->artisan('modules:symlink');

        $dashboardJsLink = public_path('modules/dashboard/js');
        $dashboardJsTarget = base_path('Modules/Dashboard/Assets/js');

        $this->assertEquals(
            realpath($dashboardJsTarget),
            realpath($dashboardJsLink),
            'Dashboard JS symlink does not point to the correct directory'
        );
    }

    /**
     * Test that the command handles non-existent source directories gracefully.
     *
     * @return void
     */
    public function test_command_handles_missing_assets_directory()
    {
        // Create a module without Assets directory
        $testModulePath = base_path('Modules/TestModule');
        File::makeDirectory($testModulePath, 0755, true);

        $this->artisan('modules:symlink')
            ->assertExitCode(0);

        // Clean up
        File::deleteDirectory($testModulePath);
    }

    /**
     * Test that the command removes existing symlinks before creating new ones.
     *
     * @return void
     */
    public function test_command_removes_existing_symlinks()
    {
        // Run command first time
        $this->artisan('modules:symlink');

        $dashboardJsLink = public_path('modules/dashboard/js');
        $this->assertTrue(is_link($dashboardJsLink));

        // Run command again
        $this->artisan('modules:symlink')
            ->assertExitCode(0);

        // Symlink should still exist and be valid
        $this->assertTrue(is_link($dashboardJsLink));
    }

    /**
     * Test that asset files are accessible through symlinks.
     *
     * @return void
     */
    public function test_asset_files_are_accessible_through_symlinks()
    {
        $this->artisan('modules:symlink');

        $dashboardJsFile = public_path('modules/dashboard/js/dashboard.js');
        $dashboardCssFile = public_path('modules/dashboard/css/dashboard.css');

        $this->assertTrue(File::exists($dashboardJsFile));
        $this->assertTrue(File::exists($dashboardCssFile));

        // Check that files contain expected content
        $jsContent = File::get($dashboardJsFile);
        $this->assertStringContainsString('class Dashboard', $jsContent);

        $cssContent = File::get($dashboardCssFile);
        $this->assertStringContainsString('.dashboard-container', $cssContent);
    }

    /**
     * Test that the module asset helper retrieves correct paths.
     *
     * @return void
     */
    public function test_module_asset_helper_returns_correct_paths()
    {
        $this->artisan('modules:symlink');

        $dashboardJsPath = \App\Helpers\ModuleAssetHelper::js('dashboard', 'dashboard.js');
        $dashboardCssPath = \App\Helpers\ModuleAssetHelper::css('dashboard', 'dashboard.css');

        $this->assertStringContainsString('modules/dashboard/js/dashboard.js', $dashboardJsPath);
        $this->assertStringContainsString('modules/dashboard/css/dashboard.css', $dashboardCssPath);
    }

    /**
     * Test that the module asset helper retrieves all assets.
     *
     * @return void
     */
    public function test_module_asset_helper_retrieves_all_assets()
    {
        $this->artisan('modules:symlink');

        $dashboardJsAssets = \App\Helpers\ModuleAssetHelper::getJsAssets('dashboard');
        $dashboardCssAssets = \App\Helpers\ModuleAssetHelper::getCssAssets('dashboard');

        $this->assertNotEmpty($dashboardJsAssets);
        $this->assertNotEmpty($dashboardCssAssets);

        $this->assertCount(1, $dashboardJsAssets);
        $this->assertCount(1, $dashboardCssAssets);
    }

    /**
     * Test that the command creates public/modules directory if it doesn't exist.
     *
     * @return void
     */
    public function test_command_creates_public_modules_directory()
    {
        // Remove the directory if it exists
        if (File::exists(public_path('modules'))) {
            File::deleteDirectory(public_path('modules'));
        }

        $this->artisan('modules:symlink');

        $this->assertTrue(File::exists(public_path('modules')));
    }

    /**
     * Test that all modules are processed.
     *
     * @return void
     */
    public function test_all_modules_are_processed()
    {
        $this->artisan('modules:symlink')
            ->assertExitCode(0);

        $modules = ['dashboard', 'analytics', 'settings'];

        foreach ($modules as $module) {
            $jsLink = public_path("modules/{$module}/js");
            $cssLink = public_path("modules/{$module}/css");

            $this->assertTrue(
                is_link($jsLink),
                "JS symlink for {$module} module not created"
            );

            $this->assertTrue(
                is_link($cssLink),
                "CSS symlink for {$module} module not created"
            );
        }
    }

    /**
     * Test that the command output is informative.
     *
     * @return void
     */
    public function test_command_provides_informative_output()
    {
        $this->artisan('modules:symlink')
            ->assertExitCode(0)
            ->expectsOutput('Creating symlinks for 3 module(s)...');
    }

    /**
     * Test module controller returns correct module assets.
     *
     * @return void
     */
    public function test_module_controller_returns_correct_assets()
    {
        $this->artisan('modules:symlink');

        $response = $this->get(route('modules.assets'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'modules' => [
                    'dashboard' => ['js', 'css'],
                    'analytics' => ['js', 'css'],
                    'settings' => ['js', 'css'],
                ],
            ]);
    }

    /**
     * Test that module demo page loads successfully.
     *
     * @return void
     */
    public function test_module_demo_page_loads()
    {
        $this->artisan('modules:symlink');

        $response = $this->get(route('modules.index'));

        $response->assertStatus(200)
            ->assertSee('Laravel Modules Demo')
            ->assertSee('Dashboard')
            ->assertSee('Analytics')
            ->assertSee('Settings');
    }

    /**
     * Test that individual module pages load successfully.
     *
     * @return void
     */
    public function test_individual_module_pages_load()
    {
        $this->artisan('modules:symlink');

        $modules = [
            'dashboard' => 'Dashboard Module',
            'analytics' => 'Analytics Module',
            'settings' => 'Settings Module',
        ];

        foreach ($modules as $module => $title) {
            $response = $this->get(route("modules.{$module}"));
            $response->assertStatus(200)
                ->assertSee($title);
        }
    }

    /**
     * Clean up after tests.
     *
     * @return void
     */
    public function tearDown(): void
    {
        // Remove symlinks created during tests
        if (File::exists(public_path('modules'))) {
            File::deleteDirectory(public_path('modules'));
        }

        parent::tearDown();
    }
}
