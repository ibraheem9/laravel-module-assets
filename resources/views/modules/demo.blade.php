<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Modules Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .module-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .module-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
        }

        .module-card-header h2 {
            font-size: 1.5em;
            margin-bottom: 5px;
        }

        .module-card-body {
            padding: 20px;
        }

        .module-card-body p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .module-card-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .info-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-top: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .info-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .info-section p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 10px;
        }

        .code-block {
            background: #f5f5f5;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            overflow-x: auto;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 13px;
        }

        .feature-list {
            list-style: none;
            margin: 15px 0;
        }

        .feature-list li {
            padding: 8px 0;
            color: #666;
        }

        .feature-list li:before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }

        .footer {
            text-align: center;
            color: white;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Laravel Modules Demo</h1>
            <p>Modular Architecture with Separate Asset Management</p>
        </div>

        <div class="modules-grid">
            <!-- Dashboard Module -->
            <div class="module-card">
                <div class="module-card-header">
                    <h2>📊 Dashboard</h2>
                </div>
                <div class="module-card-body">
                    <p>Display application statistics and overview. Each module has its own JavaScript and CSS files loaded via symlinks.</p>
                </div>
                <div class="module-card-footer">
                    <a href="{{ route('modules.dashboard') }}" class="btn btn-primary">View Module</a>
                    <a href="{{ $dashboardJs }}" class="btn btn-secondary" target="_blank">JS File</a>
                </div>
            </div>

            <!-- Analytics Module -->
            <div class="module-card">
                <div class="module-card-header">
                    <h2>📈 Analytics</h2>
                </div>
                <div class="module-card-body">
                    <p>Track user interactions and generate reports. Demonstrates event tracking and data visualization capabilities.</p>
                </div>
                <div class="module-card-footer">
                    <a href="{{ route('modules.analytics') }}" class="btn btn-primary">View Module</a>
                    <a href="{{ $analyticsJs }}" class="btn btn-secondary" target="_blank">JS File</a>
                </div>
            </div>

            <!-- Settings Module -->
            <div class="module-card">
                <div class="module-card-header">
                    <h2>⚙️ Settings</h2>
                </div>
                <div class="module-card-body">
                    <p>Manage application preferences and user settings. Shows form handling and API integration patterns.</p>
                </div>
                <div class="module-card-footer">
                    <a href="{{ route('modules.settings') }}" class="btn btn-primary">View Module</a>
                    <a href="{{ $settingsJs }}" class="btn btn-secondary" target="_blank">JS File</a>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h3>📚 How This Solution Works</h3>
            <p>This demo showcases a powerful solution to a common Laravel problem: managing assets for modular applications.</p>
            
            <h3 style="margin-top: 25px;">The Problem</h3>
            <p>In traditional Laravel applications, assets are typically stored in a single <code>resources/</code> directory. When building modular applications with multiple independent modules, this becomes problematic:</p>
            <ul class="feature-list">
                <li>Assets are scattered across the project</li>
                <li>Difficult to maintain module independence</li>
                <li>Hard to enable/disable modules without touching asset files</li>
                <li>Coupling between modules and main application</li>
            </ul>

            <h3 style="margin-top: 25px;">The Solution</h3>
            <p>The <code>CreateModuleSymlinks</code> command creates symbolic links from module asset directories to the public folder:</p>
            <div class="code-block">
php artisan modules:symlink
            </div>

            <h3 style="margin-top: 25px;">Project Structure</h3>
            <div class="code-block">
Modules/
├── Dashboard/
│   └── Assets/
│       ├── js/
│       │   └── dashboard.js
│       └── css/
│           └── dashboard.css
├── Analytics/
│   └── Assets/
│       ├── js/
│       │   └── analytics.js
│       └── css/
│           └── analytics.css
└── Settings/
    └── Assets/
        ├── js/
        │   └── settings.js
        └── css/
            └── settings.css

public/modules/
├── dashboard/
│   ├── js → ../../Modules/Dashboard/Assets/js
│   └── css → ../../Modules/Dashboard/Assets/css
├── analytics/
│   ├── js → ../../Modules/Analytics/Assets/js
│   └── css → ../../Modules/Analytics/Assets/css
└── settings/
    ├── js → ../../Modules/Settings/Assets/js
    └── css → ../../Modules/Settings/Assets/css
            </div>

            <h3 style="margin-top: 25px;">Benefits</h3>
            <ul class="feature-list">
                <li>Complete module independence</li>
                <li>Easy to enable/disable modules</li>
                <li>Assets stay with their modules</li>
                <li>Cleaner project organization</li>
                <li>Simplified deployment process</li>
                <li>Better for team collaboration</li>
            </ul>

            <h3 style="margin-top: 25px;">Usage in Views</h3>
            <div class="code-block">
@verbatim
&lt;!-- Using the helper function --&gt;
&lt;link rel="stylesheet" href="{{ \App\Helpers\ModuleAssetHelper::css('dashboard', 'dashboard.css') }}"&gt;
&lt;script src="{{ \App\Helpers\ModuleAssetHelper::js('dashboard', 'dashboard.js') }}"&gt;&lt;/script&gt;

&lt;!-- Or using the asset() helper directly --&gt;
&lt;link rel="stylesheet" href="{{ asset('modules/dashboard/css/dashboard.css') }}"&gt;
&lt;script src="{{ asset('modules/dashboard/js/dashboard.js') }}"&gt;&lt;/script&gt;
@endverbatim
            </div>

            <h3 style="margin-top: 25px;">Getting Started</h3>
            <ol style="margin-left: 20px; color: #666;">
                <li>Create your module structure in <code>Modules/</code> directory</li>
                <li>Place assets in <code>Modules/ModuleName/Assets/</code></li>
                <li>Run <code>php artisan modules:symlink</code></li>
                <li>Access assets via <code>asset('modules/module-name/...')</code></li>
            </ol>
        </div>

        <div class="footer">
            <p>Laravel Modules Demo • Demonstrating Modular Architecture Best Practices</p>
        </div>
    </div>
</body>
</html>
