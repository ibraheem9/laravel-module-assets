<?php

/**
 * Laravel Module Assets — Global Helper Functions
 *
 * These functions are auto-loaded globally via composer.json autoload.files
 * and are available everywhere in your application without any import.
 *
 * To enable, add the following to your composer.json and run composer dump-autoload:
 *
 *   "autoload": {
 *       "files": [
 *           "app/Helpers/helpers.php"
 *       ]
 *   }
 */

if (! function_exists('fileVersion')) {
    /**
     * Generate a cache-busting version query string for a public asset.
     *
     * Reads the last modification timestamp of the file on disk and returns
     * it as a ?v=timestamp query string. This forces browsers to fetch the
     * latest version of the file after each deployment instead of serving
     * a stale cached copy.
     *
     * ─── Original usage (parsing the calling file line) ──────────────────
     *
     *   // In a Blade template, pass __FILE__ and the line number:
     *   <script src="{{ asset('modules/dashboard/js/dashboard.js') . fileVersion(__FILE__, __LINE__) }}"></script>
     *
     * ─── Simplified usage (passing the path directly) ────────────────────
     *
     *   <script src="{{ asset('modules/dashboard/js/dashboard.js') . fileVersion('modules/dashboard/js/dashboard.js') }}"></script>
     *   → /modules/dashboard/js/dashboard.js?v=1741234567
     *
     * @param  string      $file  Either a source file path (used with $line) or a
     *                            public-relative asset path (used without $line).
     * @param  int|null    $line  Line number in $file where the asset() call appears.
     *                            When provided, the function parses the asset path
     *                            from that line automatically (original behaviour).
     *                            When omitted, $file is treated as the asset path directly.
     * @return string  Query string such as '?v=1741234567', or '' if file not found.
     */
    function fileVersion(string $file, ?int $line = null): string
    {
        // ── Mode 1: original behaviour — parse asset path from a source file line ──
        if ($line !== null) {
            $fileContents = @file($file);

            if ($fileContents === false || !isset($fileContents[$line - 1])) {
                return '';
            }

            $lineContent = $fileContents[$line - 1];

            // Extract the path between asset(' and ')
            $substring = strstr($lineContent, "asset('");
            if ($substring === false) {
                return '';
            }
            $substring = substr($substring, strlen("asset('"));
            $substring = strstr($substring, "')", true);

            if ($substring === false || $substring === '') {
                return '';
            }

            $absolutePath = public_path($substring);

            return file_exists($absolutePath) ? '?v=' . filemtime($absolutePath) : '';
        }

        // ── Mode 2: simplified — $file is already the public-relative asset path ──
        $absolutePath = public_path($file);

        return file_exists($absolutePath) ? '?v=' . filemtime($absolutePath) : '';
    }
}

if (! function_exists('moduleAsset')) {
    /**
     * Get the full versioned URL to a module asset.
     *
     * Combines asset() and fileVersion() into a single convenient call.
     *
     * Usage in Blade:
     *   <script src="{{ moduleAsset('dashboard', 'js', 'dashboard.js') }}"></script>
     *   → http://localhost/modules/dashboard/js/dashboard.js?v=1741234567
     *
     * @param  string $module    Module name in snake_case (e.g., 'dashboard')
     * @param  string $type      Asset type directory (e.g., 'js', 'css')
     * @param  string $filename  Asset filename (e.g., 'dashboard.js')
     * @return string
     */
    function moduleAsset(string $module, string $type, string $filename): string
    {
        $relativePath = "modules/{$module}/{$type}/{$filename}";
        return asset($relativePath) . fileVersion($relativePath);
    }
}
