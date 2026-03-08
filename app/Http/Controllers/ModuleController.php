<?php

namespace App\Http\Controllers;

use App\Helpers\ModuleAssetHelper;

class ModuleController extends Controller
{
    /**
     * Show the module demo page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('modules.demo', [
            'dashboardJs' => ModuleAssetHelper::js('dashboard', 'dashboard.js'),
            'dashboardCss' => ModuleAssetHelper::css('dashboard', 'dashboard.css'),
            'analyticsJs' => ModuleAssetHelper::js('analytics', 'analytics.js'),
            'analyticsCss' => ModuleAssetHelper::css('analytics', 'analytics.css'),
            'settingsJs' => ModuleAssetHelper::js('settings', 'settings.js'),
            'settingsCss' => ModuleAssetHelper::css('settings', 'settings.css'),
        ]);
    }

    /**
     * Show dashboard module.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('modules.dashboard', [
            'js' => ModuleAssetHelper::js('dashboard', 'dashboard.js'),
            'css' => ModuleAssetHelper::css('dashboard', 'dashboard.css'),
        ]);
    }

    /**
     * Show analytics module.
     *
     * @return \Illuminate\View\View
     */
    public function analytics()
    {
        return view('modules.analytics', [
            'js' => ModuleAssetHelper::js('analytics', 'analytics.js'),
            'css' => ModuleAssetHelper::css('analytics', 'analytics.css'),
        ]);
    }

    /**
     * Show settings module.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('modules.settings', [
            'js' => ModuleAssetHelper::js('settings', 'settings.js'),
            'css' => ModuleAssetHelper::css('settings', 'settings.css'),
        ]);
    }

    /**
     * Get module assets as JSON (for API usage).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssets()
    {
        return response()->json([
            'modules' => [
                'dashboard' => [
                    'js' => ModuleAssetHelper::getJsAssets('dashboard'),
                    'css' => ModuleAssetHelper::getCssAssets('dashboard'),
                ],
                'analytics' => [
                    'js' => ModuleAssetHelper::getJsAssets('analytics'),
                    'css' => ModuleAssetHelper::getCssAssets('analytics'),
                ],
                'settings' => [
                    'js' => ModuleAssetHelper::getJsAssets('settings'),
                    'css' => ModuleAssetHelper::getCssAssets('settings'),
                ],
            ],
        ]);
    }
}
