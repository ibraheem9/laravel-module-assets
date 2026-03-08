<?php

namespace App\Helpers;

/**
 * Module Asset Helper
 * 
 * Provides helper functions for loading module assets
 */
class ModuleAssetHelper
{
    /**
     * Get the URL to a module asset.
     *
     * @param string $module Module name (e.g., 'dashboard')
     * @param string $type Asset type (e.g., 'js', 'css')
     * @param string $filename Asset filename (e.g., 'dashboard.js')
     * @return string
     */
    public static function asset($module, $type, $filename)
    {
        return asset("modules/{$module}/{$type}/{$filename}");
    }

    /**
     * Get the URL to a module JavaScript file.
     *
     * @param string $module Module name
     * @param string $filename Filename
     * @return string
     */
    public static function js($module, $filename)
    {
        return self::asset($module, 'js', $filename);
    }

    /**
     * Get the URL to a module CSS file.
     *
     * @param string $module Module name
     * @param string $filename Filename
     * @return string
     */
    public static function css($module, $filename)
    {
        return self::asset($module, 'css', $filename);
    }

    /**
     * Get all asset files for a module.
     *
     * @param string $module Module name
     * @param string $type Asset type
     * @return array
     */
    public static function getAssets($module, $type)
    {
        $path = public_path("modules/{$module}/{$type}");
        
        if (!is_dir($path)) {
            return [];
        }

        $files = scandir($path);
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
    public static function getJsAssets($module)
    {
        return self::getAssets($module, 'js');
    }

    /**
     * Get all CSS files for a module.
     *
     * @param string $module Module name
     * @return array
     */
    public static function getCssAssets($module)
    {
        return self::getAssets($module, 'css');
    }
}
