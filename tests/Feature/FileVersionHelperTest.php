<?php

namespace Tests\Feature;

use App\Helpers\ModuleAssetHelper;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Tests for the fileVersion() cache-busting helper.
 *
 * Covers both the global function in helpers.php and the
 * ModuleAssetHelper class methods that use it internally.
 */
class FileVersionHelperTest extends TestCase
{
    /** Temporary public asset path used across tests. */
    protected string $testAssetRelative = 'modules/dashboard/js/dashboard.js';
    protected string $testAssetAbsolute;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure symlinks exist so the asset file is accessible via public_path
        $this->artisan('modules:symlink');

        $this->testAssetAbsolute = public_path($this->testAssetRelative);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // ModuleAssetHelper::fileVersion()
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * fileVersion() returns a ?v= query string for an existing file.
     */
    public function test_file_version_returns_version_string_for_existing_file(): void
    {
        $version = ModuleAssetHelper::fileVersion($this->testAssetRelative);

        $this->assertStringStartsWith('?v=', $version);
        $this->assertMatchesRegularExpression('/^\?v=\d+$/', $version);
    }

    /**
     * fileVersion() returns an empty string when the file does not exist.
     */
    public function test_file_version_returns_empty_string_for_missing_file(): void
    {
        $version = ModuleAssetHelper::fileVersion('modules/nonexistent/js/ghost.js');

        $this->assertSame('', $version);
    }

    /**
     * The version timestamp matches the actual file modification time.
     */
    public function test_file_version_timestamp_matches_filemtime(): void
    {
        $version  = ModuleAssetHelper::fileVersion($this->testAssetRelative);
        $expected = '?v=' . filemtime($this->testAssetAbsolute);

        $this->assertSame($expected, $version);
    }

    /**
     * After touching (updating) the file, the version string changes.
     */
    public function test_file_version_changes_after_file_is_modified(): void
    {
        $versionBefore = ModuleAssetHelper::fileVersion($this->testAssetRelative);

        // Simulate a file modification by setting mtime 1 second in the future
        touch($this->testAssetAbsolute, time() + 1);
        clearstatcache(true, $this->testAssetAbsolute);

        $versionAfter = ModuleAssetHelper::fileVersion($this->testAssetRelative);

        $this->assertNotSame($versionBefore, $versionAfter);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // ModuleAssetHelper::moduleAsset() — versioned URL shortcut
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * moduleAsset() returns a full URL that includes the ?v= query string.
     */
    public function test_module_asset_returns_versioned_url(): void
    {
        $url = ModuleAssetHelper::moduleAsset('dashboard', 'js', 'dashboard.js');

        $this->assertStringContainsString('modules/dashboard/js/dashboard.js', $url);
        $this->assertStringContainsString('?v=', $url);
        $this->assertMatchesRegularExpression('/\?v=\d+$/', $url);
    }

    /**
     * jsVersioned() is a shorthand for moduleAsset() with type = 'js'.
     */
    public function test_js_versioned_returns_versioned_js_url(): void
    {
        $url = ModuleAssetHelper::jsVersioned('dashboard', 'dashboard.js');

        $this->assertStringContainsString('modules/dashboard/js/dashboard.js', $url);
        $this->assertStringContainsString('?v=', $url);
    }

    /**
     * cssVersioned() is a shorthand for moduleAsset() with type = 'css'.
     */
    public function test_css_versioned_returns_versioned_css_url(): void
    {
        $url = ModuleAssetHelper::cssVersioned('dashboard', 'dashboard.css');

        $this->assertStringContainsString('modules/dashboard/css/dashboard.css', $url);
        $this->assertStringContainsString('?v=', $url);
    }

    /**
     * moduleAsset() returns a URL without ?v= when the file does not exist.
     */
    public function test_module_asset_omits_version_for_missing_file(): void
    {
        $url = ModuleAssetHelper::moduleAsset('dashboard', 'js', 'nonexistent.js');

        $this->assertStringNotContainsString('?v=', $url);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Global fileVersion() function from helpers.php
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * The global fileVersion() function exists and is callable.
     */
    public function test_global_file_version_function_exists(): void
    {
        $this->assertTrue(function_exists('fileVersion'));
    }

    /**
     * Global fileVersion() with only a path returns a ?v= string.
     */
    public function test_global_file_version_with_path_returns_version(): void
    {
        $version = fileVersion($this->testAssetRelative);

        $this->assertStringStartsWith('?v=', $version);
        $this->assertMatchesRegularExpression('/^\?v=\d+$/', $version);
    }

    /**
     * Global fileVersion() with a missing file returns an empty string.
     */
    public function test_global_file_version_returns_empty_for_missing_file(): void
    {
        $version = fileVersion('modules/nonexistent/js/ghost.js');

        $this->assertSame('', $version);
    }

    /**
     * Global fileVersion() in line-parsing mode extracts the asset path
     * from the given source file and line number.
     */
    public function test_global_file_version_line_mode_parses_asset_path(): void
    {
        // Create a temporary PHP file that contains an asset() call
        $tmpFile = tempnam(sys_get_temp_dir(), 'fv_test_') . '.php';
        file_put_contents($tmpFile, "<?php\n\$url = asset('{$this->testAssetRelative}');\n");

        // Line 2 contains the asset() call
        $version = fileVersion($tmpFile, 2);

        @unlink($tmpFile);

        $this->assertStringStartsWith('?v=', $version);
        $this->assertMatchesRegularExpression('/^\?v=\d+$/', $version);
    }

    /**
     * Global fileVersion() in line-parsing mode returns '' for an invalid line.
     */
    public function test_global_file_version_line_mode_returns_empty_for_invalid_line(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'fv_test_') . '.php';
        file_put_contents($tmpFile, "<?php\n// no asset call here\n");

        $version = fileVersion($tmpFile, 2);

        @unlink($tmpFile);

        $this->assertSame('', $version);
    }

    /**
     * The global moduleAsset() function exists and returns a versioned URL.
     */
    public function test_global_module_asset_function_exists_and_returns_versioned_url(): void
    {
        $this->assertTrue(function_exists('moduleAsset'));

        $url = moduleAsset('dashboard', 'js', 'dashboard.js');

        $this->assertStringContainsString('modules/dashboard/js/dashboard.js', $url);
        $this->assertStringContainsString('?v=', $url);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Tear down
    // ──────────────────────────────────────────────────────────────────────────

    protected function tearDown(): void
    {
        if (File::exists(public_path('modules'))) {
            File::deleteDirectory(public_path('modules'));
        }

        parent::tearDown();
    }
}
