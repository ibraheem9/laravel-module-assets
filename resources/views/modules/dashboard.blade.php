<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Module</title>
    <link rel="stylesheet" href="{{ $css }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 1.5em;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            transition: opacity 0.2s;
        }
        .navbar a:hover {
            opacity: 0.7;
        }
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        .page-header {
            margin-bottom: 30px;
        }
        .page-header h2 {
            color: #333;
            margin-bottom: 5px;
        }
        .page-header p {
            color: #666;
        }
        .refresh-btn {
            background: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .refresh-btn:hover {
            background: #0052a3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📊 Dashboard Module</h1>
        <div>
            <a href="{{ route('modules.index') }}">← Back to Modules</a>
        </div>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h2>Dashboard Overview</h2>
            <p>This module demonstrates how to load separate JavaScript and CSS files from module assets.</p>
        </div>

        <button class="refresh-btn" onclick="window.dashboard && window.dashboard.refreshData()">
            🔄 Refresh Data
        </button>

        <div id="dashboard-stats"></div>

        <div style="margin-top: 40px; background: white; padding: 20px; border-radius: 8px;">
            <h3 style="margin-bottom: 15px;">Module Information</h3>
            <p><strong>Asset Files Loaded:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>CSS: <code>{{ $css }}</code></li>
                <li>JS: <code>{{ $js }}</code></li>
            </ul>
            <p style="margin-top: 15px; color: #666; font-size: 14px;">
                These files are loaded from the Dashboard module's Assets directory via symlinks created by the <code>modules:symlink</code> command.
            </p>
        </div>
    </div>

    <script src="{{ $js }}"></script>
</body>
</html>
