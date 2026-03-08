<?php

namespace App\Helpers;

/**
 * Module Asset Helper
 *
 * Provides helper functions for loading module assets in a modular Laravel
 * application. Includes cache-busting via file modification timestamps so
 * browsers always load the latest version after a deployment.
 */
class ModuleAssetHelper
{
    /**
     * Get the URL to a module asset.
     *
     * @param string $module   Module name in snake_case (e.g., 'dashboard')
     * @param string $type     Asset type directory (e.g., 'js', 'css', 'images')
     * @param string $filename Asset filename (e.g., 'dashboard.js')
     * @return string
     */
    public static function asset(string $module, string $type, string $filename): string
    {
        return asset("modules/{$module}/{$type}/{$filename}");
    }

    /**
     * Get the URL to a module JavaScript file.
     *
     * @param string $module   Module name
     * @param string $filename Filename
     * @return string
     */
    public static function js(string $module, string $filename): string
    {
        return self::asset($module, 'js', $filename);
    }

    /**
     * Get the URL to a module CSS file.
     *
     * @param string $module   Module name
     * @param string $filename Filename
     * @return string
     */
    public static function css(string $module, string $filename): string
    {
        return self::asset($module, 'css', $filename);
    }

    /**
     * Get the URL to a module asset with a cache-busting version query string.
     *
     * The version string is derived from the file's last modification timestamp
     * on disk. This guarantees that browsers fetch the latest file after every
     * deployment without requiring a manual version bump.
     *
     * Usage in Blade:
     *   <script src="{{ \App\Helpers\ModuleAssetHelper::moduleAsset('dashboard', 'js', 'dashboard.js') }}"></script>
     *   → /modules/dashboard/js/dashboard.js?v=1741234567
     *
     * @param string $module   Module name in snake_case (e.g., 'dashboard')
     * @param string $type     Asset type directory (e.g., 'js', 'css')
     * @param string $filename Asset filename (e.g., 'dashboard.js')
     * @return string  Full URL with ?v={timestamp} appended
     */
    public static function moduleAsset(string $module, string $type, string $filename): string
    {
        $relativePath = "modules/{$module}/{$type}/{$filename}";
        $url          = asset($relativePath);
        $version      = self::fileVersion($relativePath);

        return $url . $version;
    }

    /**
     * Get a versioned URL to a module JavaScript file.
     *
     * Shorthand for moduleAsset($module, 'js', $filename).
     *
     * @param string $module   Module name
     * @param string $filename Filename
     * @return string
     */
    public static function jsVersioned(string $module, string $filename): string
    {
        return self::moduleAsset($module, 'js', $filename);
    }

    /**
     * Get a versioned URL to a module CSS file.
     *
     * Shorthand for moduleAsset($module, 'css', $filename).
     *
     * @param string $module   Module name
     * @param string $filename Filename
     * @return string
     */
    public static function cssVersioned(string $module, string $filename): string
    {
        return self::moduleAsset($module, 'css', $filename);
    }

    /**
     * Generate a cache-busting version query string for a public asset path.
     *
     * This is the core of the original fileVersion() helper, refactored into
     * the class so it can be called directly when needed.
     *
     * The function reads the file's last modification time from the filesystem
     * and returns it as a query string (?v=timestamp). Because the timestamp
     * changes whenever the file is saved, the browser treats the URL as new
     * and fetches the latest version instead of serving a cached copy.
     *
     * Original implementation by the package author:
     *
     *   function fileVersion($file, $line) {
     *       $file_contents = file($file);
     *       $line_content  = $file_contents[$line - 1];
     *       $substring     = strstr($line_content, "asset('");
     *       $substring     = substr($substring, strlen("asset('"));
     *       $substring     = strstr($substring, "')", true);
     *       return '?v=' . filemtime(public_path($substring));
     *   }
     *
     * This class method accepts the relative public path directly, which is
     * cleaner and more reliable than parsing a source file line.
     *
     * @param string $relativePath  Path relative to public_path() (e.g., 'modules/dashboard/js/dashboard.js')
     * @return string  Query string such as '?v=1741234567', or '' if file not found
     */
    public static function fileVersion(string $relativePath): string
    {
        $absolutePath = public_path($relativePath);

        if (!file_exists($absolutePath)) {
            return '';
        }

        return '?v=' . filemtime($absolutePath);
    }

    /**
     * Get all asset files for a module.
     *
     * @param string $module Module name
     * @param string $type   Asset type
     * @return array
     */
    public static function getAssets(string $module, string $type): array
    {
        $path = public_path("modules/{$module}/{$type}");

        if (!is_dir($path)) {
            return [];
        }

        $files  = scandir($path);
        $assets = [];

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && is_file($path . '/' . $file)) {
                $assets[] = self::asset($module, $type, $file);
            }
        }

        return $assets;
    }

    /**
     * Get all JavaScript files for a module.
     *
     * @param string $module Module name
     * @return array
     */
    public static function getJsAssets(string $module): array
    {
        return self::getAssets($module, 'js');
    }

    /**
     * Get all CSS files for a module.
     *
     * @param string $module Module name
     * @return array
     */
    public static function getCssAssets(string $module): array
    {
        return self::getAssets($module, 'css');
    }
}
