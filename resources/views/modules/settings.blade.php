<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings Module</title>
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
    </style>
</head>
<body>
    <div class="navbar">
        <h1>⚙️ Settings Module</h1>
        <div>
            <a href="{{ route('modules.index') }}">← Back to Modules</a>
        </div>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h2>Application Settings</h2>
            <p>Manage your application preferences and user settings.</p>
        </div>

        <div id="settings-form"></div>

        <div style="margin-top: 40px; background: white; padding: 20px; border-radius: 8px;">
            <h3 style="margin-bottom: 15px;">Module Information</h3>
            <p><strong>Asset Files Loaded:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>CSS: <code>{{ $css }}</code></li>
                <li>JS: <code>{{ $js }}</code></li>
            </ul>
            <p style="margin-top: 15px; color: #666; font-size: 14px;">
                This module demonstrates form handling and API integration. The form is dynamically rendered by the JavaScript module, and settings are saved via API calls.
            </p>
        </div>
    </div>

    <script src="{{ $js }}"></script>
</body>
</html>
