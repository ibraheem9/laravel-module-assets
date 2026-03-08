<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Module Assets — Interactive Developer Manual</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:        #0d1117;
            --bg2:       #161b22;
            --bg3:       #21262d;
            --border:    #30363d;
            --text:      #e6edf3;
            --muted:     #8b949e;
            --accent:    #f05340;
            --accent2:   #ff7b6b;
            --green:     #3fb950;
            --blue:      #58a6ff;
            --yellow:    #d29922;
            --purple:    #bc8cff;
            --radius:    8px;
            --mono: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        }
        html { scroll-behavior: smooth; }
        body { background: var(--bg); color: var(--text); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.7; }

        /* Layout */
        .layout { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 255px; flex-shrink: 0; background: var(--bg2); border-right: 1px solid var(--border); position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 100; display: flex; flex-direction: column; }
        .sidebar-logo { padding: 18px 18px 14px; border-bottom: 1px solid var(--border); }
        .logo-badge { display: inline-flex; align-items: center; gap: 6px; background: var(--accent); color: #fff; font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 3px 9px; border-radius: 20px; margin-bottom: 7px; }
        .sidebar-logo h1 { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.3; }
        .sidebar-logo p { font-size: 11px; color: var(--muted); margin-top: 2px; }
        .sidebar-nav { padding: 10px 0; flex: 1; }
        .nav-section-title { font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); padding: 10px 18px 3px; }
        .nav-link { display: flex; align-items: center; gap: 7px; padding: 6px 18px; color: var(--muted); text-decoration: none; font-size: 13px; transition: all .15s; border-left: 2px solid transparent; }
        .nav-link:hover { color: var(--text); background: var(--bg3); }
        .nav-link.active { color: var(--accent2); border-left-color: var(--accent); background: rgba(240,83,64,.08); }
        .nav-icon { font-size: 13px; width: 16px; text-align: center; }
        .sidebar-footer { padding: 14px 18px; border-top: 1px solid var(--border); font-size: 11px; color: var(--muted); }
        .sidebar-footer a { color: var(--blue); text-decoration: none; }

        /* Main */
        .main { margin-left: 255px; flex: 1; min-width: 0; }

        /* Hero */
        .hero { background: linear-gradient(135deg, #0d1117 0%, #161b22 50%, #1a1f2e 100%); border-bottom: 1px solid var(--border); padding: 60px 48px 52px; position: relative; overflow: hidden; }
        .hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(240,83,64,.12) 0%, transparent 70%); pointer-events: none; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(240,83,64,.15); border: 1px solid rgba(240,83,64,.3); color: var(--accent2); font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; margin-bottom: 18px; }
        .hero h1 { font-size: 40px; font-weight: 800; line-height: 1.15; margin-bottom: 14px; background: linear-gradient(135deg, #fff 0%, #c9d1d9 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero h1 span { -webkit-text-fill-color: var(--accent); }
        .hero p { font-size: 16px; color: var(--muted); max-width: 600px; margin-bottom: 28px; line-height: 1.7; }
        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; border-radius: var(--radius); font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: all .2s; }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent2); transform: translateY(-1px); }
        .btn-outline { background: transparent; color: var(--text); border: 1px solid var(--border); }
        .btn-outline:hover { background: var(--bg3); border-color: var(--muted); }
        .hero-stats { display: flex; gap: 28px; margin-top: 36px; padding-top: 28px; border-top: 1px solid var(--border); }
        .hero-stat .value { font-size: 26px; font-weight: 800; color: var(--accent); }
        .hero-stat .label { font-size: 11px; color: var(--muted); margin-top: 2px; }

        /* Sections */
        .section { padding: 52px 48px; border-bottom: 1px solid var(--border); }
        .section:last-child { border-bottom: none; }
        .section-header { margin-bottom: 28px; }
        .section-number { display: inline-block; background: var(--accent); color: #fff; font-size: 11px; font-weight: 800; width: 22px; height: 22px; border-radius: 50%; text-align: center; line-height: 22px; margin-right: 9px; }
        .section-header h2 { font-size: 24px; font-weight: 700; color: var(--text); margin-bottom: 7px; }
        .section-header p { color: var(--muted); font-size: 14px; max-width: 620px; }

        /* Problem / Solution */
        .problem-solution { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 28px; }
        .ps-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; }
        .ps-card.problem { border-top: 3px solid #da3633; }
        .ps-card.solution { border-top: 3px solid var(--green); }
        .ps-card h3 { font-size: 13px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 7px; }
        .ps-card.problem h3 { color: #f85149; }
        .ps-card.solution h3 { color: var(--green); }
        .ps-card ul { list-style: none; }
        .ps-card ul li { font-size: 13px; color: var(--muted); padding: 3px 0; display: flex; align-items: flex-start; gap: 7px; }
        .ps-card ul li::before { flex-shrink: 0; margin-top: 2px; }
        .ps-card.problem ul li::before { content: '✗'; color: #f85149; }
        .ps-card.solution ul li::before { content: '✓'; color: var(--green); }

        /* Flow diagram */
        .flow-diagram { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 28px; text-align: center; margin: 20px 0; }
        .flow-row { display: flex; align-items: center; justify-content: center; gap: 0; flex-wrap: wrap; }
        .flow-box { background: var(--bg3); border: 1px solid var(--border); border-radius: var(--radius); padding: 12px 18px; font-size: 12px; font-family: var(--mono); min-width: 150px; text-align: center; }
        .flow-box .flow-label { font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 3px; }
        .flow-box .flow-path { color: var(--blue); font-weight: 600; }
        .flow-box.highlight { border-color: var(--accent); background: rgba(240,83,64,.08); }
        .flow-box.highlight .flow-path { color: var(--accent2); }
        .flow-arrow { font-size: 18px; color: var(--muted); padding: 0 10px; }
        .flow-command { background: rgba(240,83,64,.1); border: 1px dashed var(--accent); border-radius: var(--radius); padding: 9px 18px; font-family: var(--mono); font-size: 13px; color: var(--accent2); margin: 18px auto; display: inline-block; }

        /* Code blocks */
        .code-wrapper { position: relative; margin: 14px 0; border-radius: var(--radius); overflow: hidden; border: 1px solid var(--border); }
        .code-header { display: flex; align-items: center; justify-content: space-between; background: var(--bg3); padding: 7px 14px; border-bottom: 1px solid var(--border); }
        .file-name { font-size: 11px; color: var(--muted); font-family: var(--mono); display: flex; align-items: center; gap: 5px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; }
        .dot-r { background: #ff5f56; } .dot-y { background: #ffbd2e; } .dot-g { background: #27c93f; }
        .copy-btn { background: var(--bg2); border: 1px solid var(--border); color: var(--muted); font-size: 11px; padding: 3px 9px; border-radius: 4px; cursor: pointer; transition: all .2s; font-family: var(--mono); }
        .copy-btn:hover { background: var(--bg3); color: var(--text); }
        .copy-btn.copied { color: var(--green); border-color: var(--green); }
        pre { background: #0d1117; padding: 18px; overflow-x: auto; font-family: var(--mono); font-size: 13px; line-height: 1.7; margin: 0; }
        .ic { background: var(--bg3); border: 1px solid var(--border); padding: 1px 6px; border-radius: 4px; font-size: 12px; font-family: var(--mono); color: var(--accent2); }

        /* Syntax tokens */
        .t-kw  { color: #ff7b72; } .t-fn  { color: #d2a8ff; } .t-str { color: #a5d6ff; }
        .t-cm  { color: #8b949e; font-style: italic; } .t-cl  { color: #ffa657; }
        .t-ns  { color: #79c0ff; } .t-num { color: #79c0ff; }

        /* Steps */
        .steps { display: flex; flex-direction: column; gap: 0; }
        .step { display: flex; gap: 22px; position: relative; }
        .step:not(:last-child)::after { content: ''; position: absolute; left: 18px; top: 44px; bottom: 0; width: 2px; background: var(--border); }
        .step-num { flex-shrink: 0; width: 38px; height: 38px; background: var(--bg3); border: 2px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 800; color: var(--accent); position: relative; z-index: 1; }
        .step-content { flex: 1; padding-bottom: 28px; }
        .step-content h3 { font-size: 15px; font-weight: 700; margin-bottom: 7px; padding-top: 7px; }
        .step-content p { color: var(--muted); font-size: 13px; margin-bottom: 10px; }

        /* Tree */
        .tree { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 22px; font-family: var(--mono); font-size: 13px; line-height: 2; }
        .td { color: var(--blue); font-weight: 600; } .tf { color: var(--text); } .tn { color: var(--muted); font-style: italic; } .tg { color: var(--green); } .tc { color: var(--accent2); }

        /* Compare table */
        .compare-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .compare-table th { background: var(--bg3); padding: 9px 14px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); border-bottom: 1px solid var(--border); }
        .compare-table td { padding: 9px 14px; border-bottom: 1px solid var(--border); color: var(--muted); }
        .compare-table tr:last-child td { border-bottom: none; }
        .compare-table tr:hover td { background: var(--bg2); }
        .good { color: var(--green); font-weight: 600; } .bad { color: #f85149; } .ok { color: var(--yellow); }
        .row-hl td { background: rgba(240,83,64,.06); }
        .row-hl td:first-child { border-left: 2px solid var(--accent); }

        /* Demo tabs */
        .demo-area { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
        .demo-tabs { display: flex; border-bottom: 1px solid var(--border); background: var(--bg3); overflow-x: auto; }
        .demo-tab { padding: 9px 18px; font-size: 13px; color: var(--muted); cursor: pointer; border-bottom: 2px solid transparent; transition: all .2s; user-select: none; white-space: nowrap; }
        .demo-tab:hover { color: var(--text); }
        .demo-tab.active { color: var(--accent2); border-bottom-color: var(--accent); }
        .demo-panel { display: none; padding: 22px; }
        .demo-panel.active { display: block; }

        /* Terminal */
        .terminal { background: #010409; border-radius: var(--radius); overflow: hidden; font-family: var(--mono); font-size: 13px; }
        .terminal-bar { background: #1c2128; padding: 7px 14px; display: flex; align-items: center; gap: 7px; }
        .terminal-bar span { font-size: 11px; color: var(--muted); }
        .terminal-body { padding: 14px 18px; line-height: 2; }
        .tp { color: var(--green); } .tc2 { color: var(--text); } .to { color: var(--muted); }
        .tok { color: var(--green); } .twarn { color: var(--yellow); } .ti { color: var(--blue); }

        /* FAQ */
        .faq-item { border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 7px; overflow: hidden; }
        .faq-q { padding: 14px 18px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 600; background: var(--bg2); user-select: none; transition: background .2s; }
        .faq-q:hover { background: var(--bg3); }
        .faq-icon { color: var(--accent); font-size: 18px; transition: transform .3s; }
        .faq-item.open .faq-icon { transform: rotate(45deg); }
        .faq-a { display: none; padding: 14px 18px; font-size: 13px; color: var(--muted); border-top: 1px solid var(--border); line-height: 1.8; }
        .faq-item.open .faq-a { display: block; }

        /* Alerts */
        .alert { display: flex; gap: 10px; padding: 12px 16px; border-radius: var(--radius); margin: 14px 0; font-size: 13px; line-height: 1.7; }
        .alert-icon { font-size: 15px; flex-shrink: 0; margin-top: 1px; }
        .alert.tip    { background: rgba(56,139,253,.1);  border: 1px solid rgba(56,139,253,.3);  color: #79c0ff; }
        .alert.warn   { background: rgba(210,153,34,.1);  border: 1px solid rgba(210,153,34,.3);  color: #e3b341; }
        .alert.success{ background: rgba(63,185,80,.1);   border: 1px solid rgba(63,185,80,.3);   color: #56d364; }

        /* Module cards */
        .module-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .module-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px; transition: border-color .2s; }
        .module-card:hover { border-color: var(--accent); }
        .module-card .mi { font-size: 26px; margin-bottom: 10px; }
        .module-card h3 { font-size: 14px; font-weight: 700; margin-bottom: 5px; }
        .module-card p  { font-size: 12px; color: var(--muted); margin-bottom: 12px; }
        .module-files { display: flex; flex-direction: column; gap: 3px; }
        .module-file { display: flex; align-items: center; gap: 5px; font-size: 11px; font-family: var(--mono); color: var(--muted); padding: 3px 7px; background: var(--bg3); border-radius: 4px; }
        .module-file .ext { color: var(--accent2); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

        /* Mobile */
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); transition: transform .3s; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .hero { padding: 40px 20px; }
            .section { padding: 36px 20px; }
            .problem-solution, .module-grid { grid-template-columns: 1fr; }
            .hero h1 { font-size: 26px; }
            .hero-stats { gap: 18px; }
            .hamburger { display: flex; }
        }
        .hamburger { display: none; position: fixed; top: 14px; left: 14px; z-index: 200; background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius); padding: 7px 9px; cursor: pointer; flex-direction: column; gap: 4px; }
        .hamburger span { display: block; width: 18px; height: 2px; background: var(--text); border-radius: 2px; }
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 99; }
        .overlay.show { display: block; }
    </style>
</head>
<body>

<button class="hamburger" id="hamburger" aria-label="Open menu">
    <span></span><span></span><span></span>
</button>
<div class="overlay" id="overlay"></div>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">⚡ Laravel</div>
            <h1>Module Assets</h1>
            <p>Interactive Developer Manual</p>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section-title">Getting Started</div>
            <a href="#overview"     class="nav-link active"><span class="nav-icon">🏠</span> Overview</a>
            <a href="#problem"      class="nav-link"><span class="nav-icon">⚠️</span> The Problem</a>
            <a href="#how-it-works" class="nav-link"><span class="nav-icon">⚙️</span> How It Works</a>
            <div class="nav-section-title">Installation</div>
            <a href="#installation" class="nav-link"><span class="nav-icon">📦</span> Installation</a>
            <a href="#structure"    class="nav-link"><span class="nav-icon">📁</span> Module Structure</a>
            <a href="#command"      class="nav-link"><span class="nav-icon">🖥️</span> The Command</a>
            <div class="nav-section-title">Usage</div>
            <a href="#helper"       class="nav-link"><span class="nav-icon">🛠️</span> Asset Helper</a>
            <a href="#views"        class="nav-link"><span class="nav-icon">🎨</span> Using in Views</a>
            <a href="#demo-modules" class="nav-link"><span class="nav-icon">🧩</span> Demo Modules</a>
            <div class="nav-section-title">Reference</div>
            <a href="#comparison"   class="nav-link"><span class="nav-icon">📊</span> Comparison</a>
            <a href="#tests"        class="nav-link"><span class="nav-icon">✅</span> Tests</a>
            <a href="#deployment"   class="nav-link"><span class="nav-icon">🚀</span> Deployment</a>
            <a href="#faq"          class="nav-link"><span class="nav-icon">❓</span> FAQ</a>
        </nav>
        <div class="sidebar-footer">
            <a href="https://github.com/ibraheem9/laravel-module-assets" target="_blank">⭐ GitHub Repository</a><br>
            <span style="margin-top:4px;display:block;">Laravel 10 · PHP 8.1+</span>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">

        <!-- HERO -->
        <section class="hero" id="overview">
            <div class="hero-badge">🔗 Artisan Command</div>
            <h1>Laravel <span>Module</span> Assets</h1>
            <p>A zero-dependency Artisan command that solves the modular asset problem in Laravel. Keep your JavaScript and CSS files <strong style="color:var(--text)">inside each module</strong> and make them instantly web-accessible — no build tools, no copying, no config.</p>
            <div class="hero-actions">
                <a href="#installation" class="btn btn-primary">🚀 Get Started</a>
                <a href="https://github.com/ibraheem9/laravel-module-assets" target="_blank" class="btn btn-outline">⭐ GitHub</a>
                <a href="{{ route('modules.index') }}" class="btn btn-outline">🧩 Live Demo</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat"><div class="value">1</div><div class="label">Command</div></div>
                <div class="hero-stat"><div class="value">13</div><div class="label">Tests Passing</div></div>
                <div class="hero-stat"><div class="value">0</div><div class="label">Dependencies</div></div>
                <div class="hero-stat"><div class="value">∞</div><div class="label">Modules Supported</div></div>
            </div>
        </section>

        <!-- THE PROBLEM -->
        <section class="section" id="problem">
            <div class="section-header">
                <h2><span class="section-number">1</span>The Problem</h2>
                <p>In modular Laravel apps, assets must live in <span class="ic">public/</span> to be served — but this breaks module independence.</p>
            </div>
            <div class="problem-solution">
                <div class="ps-card problem">
                    <h3>❌ Without This Solution</h3>
                    <ul>
                        <li>Assets must be manually copied to <code>public/</code></li>
                        <li>Modules are not truly self-contained</li>
                        <li>Easy to forget copying on deploy</li>
                        <li>Stale files accumulate in <code>public/</code></li>
                        <li>Removing a module leaves orphaned files</li>
                    </ul>
                </div>
                <div class="ps-card solution">
                    <h3>✅ With This Solution</h3>
                    <ul>
                        <li>Assets stay inside their module directory</li>
                        <li>One command creates all symlinks instantly</li>
                        <li>Edit files — changes reflect immediately</li>
                        <li>Delete a module — symlink breaks cleanly</li>
                        <li>No build step required for plain JS/CSS</li>
                    </ul>
                </div>
            </div>
            <div class="alert tip">
                <span class="alert-icon">💡</span>
                <div>A <strong>symbolic link</strong> is a file system pointer. The web server sees files in <span class="ic">public/modules/</span> — but they physically live inside each module. Editing the source file is instantly reflected in the browser.</div>
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section class="section" id="how-it-works">
            <div class="section-header">
                <h2><span class="section-number">2</span>How It Works</h2>
                <p>The command scans your <span class="ic">Modules/</span> directory and creates a symbolic link for each asset subdirectory into <span class="ic">public/modules/</span>.</p>
            </div>
            <div class="flow-diagram">
                <div style="font-size:11px;color:var(--muted);margin-bottom:18px;text-transform:uppercase;letter-spacing:.08em;">Before running the command</div>
                <div class="flow-row">
                    <div class="flow-box"><div class="flow-label">Module Source</div><div class="flow-path">Modules/Dashboard/Assets/js/</div></div>
                    <div class="flow-arrow">✗</div>
                    <div class="flow-box"><div class="flow-label">Public (not accessible)</div><div class="flow-path" style="color:var(--muted)">public/modules/ (empty)</div></div>
                </div>
                <div class="flow-command">$ php artisan modules:symlink</div>
                <div style="font-size:11px;color:var(--muted);margin-bottom:18px;text-transform:uppercase;letter-spacing:.08em;">After running the command</div>
                <div class="flow-row">
                    <div class="flow-box"><div class="flow-label">Module Source</div><div class="flow-path">Modules/Dashboard/Assets/js/</div></div>
                    <div class="flow-arrow">🔗</div>
                    <div class="flow-box highlight"><div class="flow-label">Symlink (web-accessible)</div><div class="flow-path">public/modules/dashboard/js/</div></div>
                    <div class="flow-arrow">→</div>
                    <div class="flow-box highlight"><div class="flow-label">Browser URL</div><div class="flow-path">/modules/dashboard/js/dashboard.js</div></div>
                </div>
            </div>
            <div class="alert success">
                <span class="alert-icon">✅</span>
                <div>The file <strong>physically lives</strong> in <span class="ic">Modules/Dashboard/Assets/js/dashboard.js</span> but is accessible at <span class="ic">https://yourapp.com/modules/dashboard/js/dashboard.js</span>.</div>
            </div>
        </section>

        <!-- INSTALLATION -->
        <section class="section" id="installation">
            <div class="section-header">
                <h2><span class="section-number">3</span>Installation</h2>
                <p>Follow these steps to add the module asset system to any existing Laravel project.</p>
            </div>
            <div class="steps">

                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-content">
                        <h3>Copy the Command File</h3>
                        <p>Place <span class="ic">CreateModuleSymlinks.php</span> into <span class="ic">app/Console/Commands/</span>.</p>
                        <div class="code-wrapper">
                            <div class="code-header">
                                <div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> app/Console/Commands/CreateModuleSymlinks.php</div>
                                <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                            </div>
                            <pre><code><span class="t-kw">namespace</span> <span class="t-ns">App\Console\Commands</span>;

<span class="t-kw">use</span> <span class="t-cl">Illuminate\Console\Command</span>;
<span class="t-kw">use</span> <span class="t-cl">Illuminate\Support\Facades\File</span>;
<span class="t-kw">use</span> <span class="t-cl">Illuminate\Support\Str</span>;

<span class="t-kw">class</span> <span class="t-cl">CreateModuleSymlinks</span> <span class="t-kw">extends</span> <span class="t-cl">Command</span>
{
    <span class="t-kw">protected</span> <span class="t-ns">$signature</span>   = <span class="t-str">'modules:symlink'</span>;
    <span class="t-kw">protected</span> <span class="t-ns">$description</span> = <span class="t-str">'Create symlinks for module assets'</span>;

    <span class="t-kw">public function</span> <span class="t-fn">handle</span>()
    {
        <span class="t-ns">$modules</span> = <span class="t-ns">$this</span>-&gt;<span class="t-fn">getModuleNames</span>();
        <span class="t-kw">foreach</span> (<span class="t-ns">$modules</span> <span class="t-kw">as</span> <span class="t-ns">$module</span>) {
            <span class="t-ns">$this</span>-&gt;<span class="t-fn">createSymlinkForModule</span>(<span class="t-ns">$module</span>);
        }
        <span class="t-ns">$this</span>-&gt;<span class="t-fn">info</span>(<span class="t-str">'✓ Module symlinks created successfully!'</span>);
    }

    <span class="t-kw">protected function</span> <span class="t-fn">getModuleNames</span>()
    {
        <span class="t-ns">$dir</span> = <span class="t-fn">base_path</span>(<span class="t-str">'Modules'</span>);
        <span class="t-kw">return</span> <span class="t-fn">array_filter</span>(<span class="t-fn">scandir</span>(<span class="t-ns">$dir</span>), <span class="t-kw">fn</span>(<span class="t-ns">$i</span>) =&gt;
            <span class="t-fn">is_dir</span>(<span class="t-ns">$dir</span>.<span class="t-str">'/'</span>.<span class="t-ns">$i</span>) &amp;&amp; <span class="t-ns">$i</span> !== <span class="t-str">'.'</span> &amp;&amp; <span class="t-ns">$i</span> !== <span class="t-str">'..'</span>
        );
    }

    <span class="t-kw">protected function</span> <span class="t-fn">createSymlinkForModule</span>(<span class="t-ns">$module</span>)
    {
        <span class="t-ns">$source</span> = <span class="t-fn">base_path</span>(<span class="t-str">"Modules/<span class="t-ns">$module</span>/Assets"</span>);
        <span class="t-ns">$dest</span>   = <span class="t-fn">public_path</span>(<span class="t-str">"modules/"</span>.<span class="t-cl">Str</span>::<span class="t-fn">snake</span>(<span class="t-ns">$module</span>));

        <span class="t-kw">if</span> (!<span class="t-cl">File</span>::<span class="t-fn">exists</span>(<span class="t-ns">$source</span>)) {
            <span class="t-ns">$this</span>-&gt;<span class="t-fn">error</span>(<span class="t-str">"Source not found: <span class="t-ns">$source</span>"</span>); <span class="t-kw">return</span>;
        }
        <span class="t-kw">if</span> (!<span class="t-cl">File</span>::<span class="t-fn">exists</span>(<span class="t-ns">$dest</span>)) <span class="t-cl">File</span>::<span class="t-fn">makeDirectory</span>(<span class="t-ns">$dest</span>, <span class="t-num">0755</span>, <span class="t-kw">true</span>);

        <span class="t-kw">foreach</span> (<span class="t-cl">File</span>::<span class="t-fn">directories</span>(<span class="t-ns">$source</span>) <span class="t-kw">as</span> <span class="t-ns">$dir</span>) {
            <span class="t-ns">$link</span> = <span class="t-ns">$dest</span>.<span class="t-str">'/'</span>.<span class="t-fn">basename</span>(<span class="t-ns">$dir</span>);
            <span class="t-kw">if</span> (<span class="t-fn">is_link</span>(<span class="t-ns">$link</span>)) <span class="t-fn">unlink</span>(<span class="t-ns">$link</span>);
            <span class="t-cl">File</span>::<span class="t-fn">link</span>(<span class="t-ns">$dir</span>, <span class="t-ns">$link</span>);
            <span class="t-ns">$this</span>-&gt;<span class="t-fn">info</span>(<span class="t-str">"  ✓ Symlink: <span class="t-ns">$link</span>"</span>);
        }
    }
}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-content">
                        <h3>Register the Modules Namespace</h3>
                        <p>Add <span class="ic">Modules\\</span> to your <span class="ic">composer.json</span> autoload, then run <span class="ic">composer dump-autoload</span>.</p>
                        <div class="code-wrapper">
                            <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> composer.json</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                            <pre><code><span class="t-str">"autoload"</span>: {
    <span class="t-str">"psr-4"</span>: {
        <span class="t-str">"App\\"</span>:      <span class="t-str">"app/"</span>,
        <span class="t-str">"Modules\\"</span>: <span class="t-str">"Modules/"</span>   <span class="t-cm">// ← Add this</span>
    }
}</code></pre>
                        </div>
                        <div class="terminal" style="margin-top:10px">
                            <div class="terminal-bar"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span>Terminal</span></div>
                            <div class="terminal-body">
                                <div><span class="tp">$</span> <span class="tc2">composer dump-autoload</span></div>
                                <div class="tok">Generated optimized autoload files containing 6279 classes</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-content">
                        <h3>Create Your Module Structure</h3>
                        <p>Create the <span class="ic">Modules/</span> directory at the project root with your module's <span class="ic">Assets/</span> subdirectories.</p>
                        <div class="terminal">
                            <div class="terminal-bar"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span>Terminal</span></div>
                            <div class="terminal-body">
                                <div><span class="tp">$</span> <span class="tc2">mkdir -p Modules/Dashboard/Assets/{js,css,images}</span></div>
                                <div><span class="tp">$</span> <span class="tc2">mkdir -p Modules/Analytics/Assets/{js,css}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step">
                    <div class="step-num">4</div>
                    <div class="step-content">
                        <h3>Run the Command</h3>
                        <p>Execute the Artisan command. It scans all modules and creates the symlinks automatically.</p>
                        <div class="terminal">
                            <div class="terminal-bar"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span>Terminal</span></div>
                            <div class="terminal-body">
                                <div><span class="tp">$</span> <span class="tc2">php artisan modules:symlink</span></div>
                                <div class="ti">Creating symlinks for 3 module(s)...</div>
                                <div class="tok">  ✓ [Dashboard] js  → public/modules/dashboard/js</div>
                                <div class="tok">  ✓ [Dashboard] css → public/modules/dashboard/css</div>
                                <div class="tok">  ✓ [Analytics] js  → public/modules/analytics/js</div>
                                <div class="tok">  ✓ [Analytics] css → public/modules/analytics/css</div>
                                <div class="tok">✓ Module symlinks created successfully!</div>
                            </div>
                        </div>
                        <div class="alert success" style="margin-top:10px">
                            <span class="alert-icon">✅</span>
                            <div>Done! Assets are now accessible at <span class="ic">/modules/{module_name}/{type}/{file}</span>.</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- MODULE STRUCTURE -->
        <section class="section" id="structure">
            <div class="section-header">
                <h2><span class="section-number">4</span>Module Structure</h2>
                <p>The <span class="ic">Assets/</span> directory is the only required convention. Any subdirectory inside it becomes a symlink.</p>
            </div>
            <div class="demo-area">
                <div class="demo-tabs">
                    <div class="demo-tab active" onclick="switchTab(this,'tab-full')">Full Module</div>
                    <div class="demo-tab" onclick="switchTab(this,'tab-minimal')">Minimal</div>
                    <div class="demo-tab" onclick="switchTab(this,'tab-result')">Result in public/</div>
                </div>
                <div class="demo-panel active" id="tab-full">
                    <div class="tree">
<span class="td">Modules/</span>
└── <span class="td">Dashboard/</span>
    ├── <span class="td">Assets/</span>                  <span class="tn">← web-accessible assets</span>
    │   ├── <span class="td">js/</span>
    │   │   └── <span class="tf">dashboard.js</span>
    │   ├── <span class="td">css/</span>
    │   │   └── <span class="tf">dashboard.css</span>
    │   └── <span class="td">images/</span>
    │       └── <span class="tf">logo.png</span>
    ├── <span class="td">src/</span>                     <span class="tn">← PHP source code</span>
    │   ├── <span class="td">Controllers/</span>
    │   ├── <span class="td">Models/</span>
    │   ├── <span class="td">Routes/web.php</span>
    │   └── <span class="td">Views/</span>
    └── <span class="tf">module.json</span>              <span class="tn">← module metadata</span>
                    </div>
                </div>
                <div class="demo-panel" id="tab-minimal">
                    <div class="tree">
<span class="td">Modules/</span>
└── <span class="td">Dashboard/</span>
    └── <span class="td">Assets/</span>          <span class="tn">← only this is required</span>
        ├── <span class="td">js/</span>
        │   └── <span class="tf">dashboard.js</span>
        └── <span class="td">css/</span>
            └── <span class="tf">dashboard.css</span>
                    </div>
                    <div class="alert tip" style="margin-top:14px">
                        <span class="alert-icon">💡</span>
                        <div>You can add any subdirectories — <span class="ic">js/</span>, <span class="ic">css/</span>, <span class="ic">images/</span>, <span class="ic">fonts/</span>. Each one becomes its own symlink.</div>
                    </div>
                </div>
                <div class="demo-panel" id="tab-result">
                    <div class="tree">
<span class="td">public/</span>
└── <span class="td">modules/</span>
    └── <span class="td">dashboard/</span>           <span class="tn">← created by command</span>
        ├── <span class="tc">js/</span>      <span class="tn">→ symlink to Modules/Dashboard/Assets/js/</span>
        ├── <span class="tc">css/</span>     <span class="tn">→ symlink to Modules/Dashboard/Assets/css/</span>
        └── <span class="tc">images/</span>  <span class="tn">→ symlink to Modules/Dashboard/Assets/images/</span>
                    </div>
                    <div class="alert warn" style="margin-top:14px">
                        <span class="alert-icon">⚠️</span>
                        <div>Add <span class="ic">/public/modules</span> to your <span class="ic">.gitignore</span>. Symlinks should not be committed — they are regenerated on each deploy.</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- THE COMMAND DEEP DIVE -->
        <section class="section" id="command">
            <div class="section-header">
                <h2><span class="section-number">5</span>Command Deep Dive</h2>
                <p>Understanding what each method does inside <span class="ic">CreateModuleSymlinks</span>.</p>
            </div>
            <div class="demo-area">
                <div class="demo-tabs">
                    <div class="demo-tab active" onclick="switchTab(this,'cmd-handle')">handle()</div>
                    <div class="demo-tab" onclick="switchTab(this,'cmd-get')">getModuleNames()</div>
                    <div class="demo-tab" onclick="switchTab(this,'cmd-create')">createSymlinkForModule()</div>
                    <div class="demo-tab" onclick="switchTab(this,'cmd-assets')">createSymlinksForAssets()</div>
                </div>
                <div class="demo-panel active" id="cmd-handle">
                    <p style="color:var(--muted);font-size:13px;margin-bottom:14px">Entry point. Discovers all modules and delegates to <span class="ic">createSymlinkForModule()</span> for each.</p>
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> handle()</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code><span class="t-kw">public function</span> <span class="t-fn">handle</span>()
{
    <span class="t-ns">$modules</span> = <span class="t-ns">$this</span>-&gt;<span class="t-fn">getModuleNames</span>();   <span class="t-cm">// ['Dashboard', 'Analytics', 'Settings']</span>

    <span class="t-kw">if</span> (<span class="t-fn">empty</span>(<span class="t-ns">$modules</span>)) {
        <span class="t-ns">$this</span>-&gt;<span class="t-fn">warn</span>(<span class="t-str">'No modules found in the Modules directory'</span>);
        <span class="t-kw">return</span> <span class="t-num">0</span>;
    }

    <span class="t-kw">foreach</span> (<span class="t-ns">$modules</span> <span class="t-kw">as</span> <span class="t-ns">$module</span>) {
        <span class="t-ns">$this</span>-&gt;<span class="t-fn">createSymlinkForModule</span>(<span class="t-ns">$module</span>);
    }

    <span class="t-ns">$this</span>-&gt;<span class="t-fn">info</span>(<span class="t-str">'✓ Module symlinks created successfully!'</span>);
    <span class="t-kw">return</span> <span class="t-num">0</span>;
}</code></pre>
                    </div>
                </div>
                <div class="demo-panel" id="cmd-get">
                    <p style="color:var(--muted);font-size:13px;margin-bottom:14px">Scans the <span class="ic">Modules/</span> directory and returns an array of module names, filtering out <span class="ic">.</span> and <span class="ic">..</span>.</p>
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> getModuleNames()</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code><span class="t-kw">protected function</span> <span class="t-fn">getModuleNames</span>()
{
    <span class="t-ns">$modulesDirectory</span> = <span class="t-fn">base_path</span>(<span class="t-str">'Modules'</span>);

    <span class="t-kw">if</span> (!<span class="t-cl">File</span>::<span class="t-fn">exists</span>(<span class="t-ns">$modulesDirectory</span>)) {
        <span class="t-kw">return</span> [];   <span class="t-cm">// gracefully handle missing Modules/ dir</span>
    }

    <span class="t-kw">return</span> <span class="t-fn">array_filter</span>(
        <span class="t-fn">scandir</span>(<span class="t-ns">$modulesDirectory</span>),
        <span class="t-kw">function</span> (<span class="t-ns">$item</span>) <span class="t-kw">use</span> (<span class="t-ns">$modulesDirectory</span>) {
            <span class="t-kw">return</span> <span class="t-fn">is_dir</span>(<span class="t-ns">$modulesDirectory</span>.<span class="t-str">'/'</span>.<span class="t-ns">$item</span>)
                &amp;&amp; <span class="t-ns">$item</span> !== <span class="t-str">'.'</span>
                &amp;&amp; <span class="t-ns">$item</span> !== <span class="t-str">'..'</span>;
        }
    );
    <span class="t-cm">// Returns: ['Analytics', 'Dashboard', 'Settings']</span>
}</code></pre>
                    </div>
                </div>
                <div class="demo-panel" id="cmd-create">
                    <p style="color:var(--muted);font-size:13px;margin-bottom:14px">Resolves source and destination paths. Note: <span class="ic">Str::snake('UserProfile')</span> → <span class="ic">user_profile</span> for URL-friendly names.</p>
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> createSymlinkForModule()</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code><span class="t-kw">protected function</span> <span class="t-fn">createSymlinkForModule</span>(<span class="t-ns">$module</span>)
{
    <span class="t-cm">// e.g. /var/www/app/Modules/Dashboard/Assets</span>
    <span class="t-ns">$sourcePath</span> = <span class="t-fn">base_path</span>(<span class="t-str">"Modules/<span class="t-ns">$module</span>/Assets"</span>);

    <span class="t-cm">// e.g. /var/www/app/public/modules/dashboard</span>
    <span class="t-ns">$destinationPath</span> = <span class="t-fn">public_path</span>(
        <span class="t-str">"modules/"</span> . <span class="t-cl">Str</span>::<span class="t-fn">snake</span>(<span class="t-ns">$module</span>)
    );

    <span class="t-kw">if</span> (!<span class="t-cl">File</span>::<span class="t-fn">exists</span>(<span class="t-ns">$sourcePath</span>)) {
        <span class="t-ns">$this</span>-&gt;<span class="t-fn">error</span>(<span class="t-str">"Source folder does not exist: <span class="t-ns">$sourcePath</span>"</span>);
        <span class="t-kw">return</span>;
    }

    <span class="t-kw">if</span> (!<span class="t-cl">File</span>::<span class="t-fn">exists</span>(<span class="t-ns">$destinationPath</span>)) {
        <span class="t-cl">File</span>::<span class="t-fn">makeDirectory</span>(<span class="t-ns">$destinationPath</span>, <span class="t-num">0755</span>, <span class="t-kw">true</span>);
    }

    <span class="t-ns">$this</span>-&gt;<span class="t-fn">createSymlinksForAssets</span>(<span class="t-ns">$sourcePath</span>, <span class="t-ns">$destinationPath</span>);
}</code></pre>
                    </div>
                </div>
                <div class="demo-panel" id="cmd-assets">
                    <p style="color:var(--muted);font-size:13px;margin-bottom:14px">Creates one symlink per subdirectory in <span class="ic">Assets/</span>. Safely removes stale symlinks before recreating.</p>
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> createSymlinksForAssets()</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code><span class="t-kw">protected function</span> <span class="t-fn">createSymlinksForAssets</span>(<span class="t-ns">$sourcePath</span>, <span class="t-ns">$destinationPath</span>)
{
    <span class="t-kw">foreach</span> (<span class="t-cl">File</span>::<span class="t-fn">directories</span>(<span class="t-ns">$sourcePath</span>) <span class="t-kw">as</span> <span class="t-ns">$directory</span>) {
        <span class="t-ns">$dirName</span>     = <span class="t-fn">basename</span>(<span class="t-ns">$directory</span>);   <span class="t-cm">// 'js', 'css', 'images'</span>
        <span class="t-ns">$symlinkPath</span> = <span class="t-ns">$destinationPath</span>.<span class="t-str">'/'</span>.<span class="t-ns">$dirName</span>;

        <span class="t-kw">if</span> (<span class="t-fn">file_exists</span>(<span class="t-ns">$symlinkPath</span>)) {
            <span class="t-kw">if</span> (<span class="t-fn">is_link</span>(<span class="t-ns">$symlinkPath</span>)) {
                <span class="t-fn">unlink</span>(<span class="t-ns">$symlinkPath</span>);   <span class="t-cm">// remove stale symlink safely</span>
            } <span class="t-kw">else</span> {
                <span class="t-ns">$this</span>-&gt;<span class="t-fn">error</span>(<span class="t-str">"Conflict: <span class="t-ns">$symlinkPath</span> is a real directory"</span>);
                <span class="t-kw">continue</span>;
            }
        }

        <span class="t-cl">File</span>::<span class="t-fn">link</span>(<span class="t-ns">$directory</span>, <span class="t-ns">$symlinkPath</span>);
        <span class="t-ns">$this</span>-&gt;<span class="t-fn">info</span>(<span class="t-str">"Symlink created: <span class="t-ns">$symlinkPath</span>"</span>);
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </section>

        <!-- ASSET HELPER -->
        <section class="section" id="helper">
            <div class="section-header">
                <h2><span class="section-number">6</span>Asset Helper Class</h2>
                <p>An optional helper providing a clean API for referencing module assets in views.</p>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="code-wrapper">
                    <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> ModuleAssetHelper.php</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                    <pre><code><span class="t-kw">class</span> <span class="t-cl">ModuleAssetHelper</span>
{
    <span class="t-kw">public static function</span> <span class="t-fn">js</span>(<span class="t-ns">$module</span>, <span class="t-ns">$file</span>)
    {
        <span class="t-kw">return</span> <span class="t-fn">asset</span>(<span class="t-str">"modules/{$module}/js/{$file}"</span>);
    }

    <span class="t-kw">public static function</span> <span class="t-fn">css</span>(<span class="t-ns">$module</span>, <span class="t-ns">$file</span>)
    {
        <span class="t-kw">return</span> <span class="t-fn">asset</span>(<span class="t-str">"modules/{$module}/css/{$file}"</span>);
    }

    <span class="t-kw">public static function</span> <span class="t-fn">getJsAssets</span>(<span class="t-ns">$module</span>)
    {
        <span class="t-ns">$path</span> = <span class="t-fn">public_path</span>(<span class="t-str">"modules/{$module}/js"</span>);
        <span class="t-kw">return</span> <span class="t-cl">File</span>::<span class="t-fn">exists</span>(<span class="t-ns">$path</span>)
            ? <span class="t-fn">array_map</span>(
                <span class="t-kw">fn</span>(<span class="t-ns">$f</span>) =&gt; <span class="t-fn">asset</span>(<span class="t-str">"modules/{$module}/js/"</span>.<span class="t-fn">basename</span>(<span class="t-ns">$f</span>)),
                <span class="t-cl">File</span>::<span class="t-fn">files</span>(<span class="t-ns">$path</span>)
              )
            : [];
    }
}</code></pre>
                </div>
                <div class="code-wrapper">
                    <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> Usage Examples</div></div>
                    <pre><code><span class="t-cm">// Single JS file URL</span>
<span class="t-cl">ModuleAssetHelper</span>::<span class="t-fn">js</span>(<span class="t-str">'dashboard'</span>, <span class="t-str">'dashboard.js'</span>);
<span class="t-cm">// → /modules/dashboard/js/dashboard.js</span>

<span class="t-cm">// Single CSS file URL</span>
<span class="t-cl">ModuleAssetHelper</span>::<span class="t-fn">css</span>(<span class="t-str">'analytics'</span>, <span class="t-str">'analytics.css'</span>);
<span class="t-cm">// → /modules/analytics/css/analytics.css</span>

<span class="t-cm">// All JS files for a module</span>
<span class="t-cl">ModuleAssetHelper</span>::<span class="t-fn">getJsAssets</span>(<span class="t-str">'dashboard'</span>);
<span class="t-cm">// → ['/modules/dashboard/js/dashboard.js']</span>

<span class="t-cm">// Or use Laravel's asset() directly:</span>
<span class="t-fn">asset</span>(<span class="t-str">'modules/dashboard/js/dashboard.js'</span>);</code></pre>
                </div>
            </div>
        </section>

        <!-- USING IN VIEWS -->
        <section class="section" id="views">
            <div class="section-header">
                <h2><span class="section-number">7</span>Using Assets in Blade Views</h2>
                <p>Reference module assets in Blade templates using the helper class or the built-in <span class="ic">asset()</span> function.</p>
            </div>
            <div class="code-wrapper">
                <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> resources/views/modules/dashboard.blade.php</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                <pre><code>&lt;head&gt;
    &lt;<span class="t-kw">!-- Method 1: Asset Helper class --</span>&gt;
    &lt;<span class="t-kw">link</span> rel=<span class="t-str">"stylesheet"</span> href=<span class="t-str">"{{ \App\Helpers\ModuleAssetHelper::css('dashboard', 'dashboard.css') }}"</span>&gt;

    &lt;<span class="t-kw">!-- Method 2: Laravel asset() helper --</span>&gt;
    &lt;<span class="t-kw">link</span> rel=<span class="t-str">"stylesheet"</span> href=<span class="t-str">"{{ asset('modules/dashboard/css/dashboard.css') }}"</span>&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;<span class="t-kw">!-- Method 1: Asset Helper class --</span>&gt;
    &lt;<span class="t-kw">script</span> src=<span class="t-str">"{{ \App\Helpers\ModuleAssetHelper::js('dashboard', 'dashboard.js') }}"</span>&gt;&lt;/<span class="t-kw">script</span>&gt;

    &lt;<span class="t-kw">!-- Method 2: Laravel asset() helper --</span>&gt;
    &lt;<span class="t-kw">script</span> src=<span class="t-str">"{{ asset('modules/dashboard/js/dashboard.js') }}"</span>&gt;&lt;/<span class="t-kw">script</span>&gt;
&lt;/body&gt;</code></pre>
            </div>
        </section>

        <!-- DEMO MODULES -->
        <section class="section" id="demo-modules">
            <div class="section-header">
                <h2><span class="section-number">8</span>Demo Modules</h2>
                <p>This project ships with three fully working demo modules, each with its own JS, CSS, and dedicated page.</p>
            </div>
            <div class="module-grid">
                <div class="module-card">
                    <div class="mi">📊</div>
                    <h3>Dashboard</h3>
                    <p>Fetches live stats from the API and renders them with animated counters.</p>
                    <div class="module-files">
                        <div class="module-file"><span class="ext">JS</span> dashboard.js</div>
                        <div class="module-file"><span class="ext">CSS</span> dashboard.css</div>
                    </div>
                    <a href="{{ route('modules.dashboard') }}" class="btn btn-outline" style="margin-top:12px;font-size:12px;padding:5px 12px">View Demo →</a>
                </div>
                <div class="module-card">
                    <div class="mi">📈</div>
                    <h3>Analytics</h3>
                    <p>Event tracking system with real-time event logging and display.</p>
                    <div class="module-files">
                        <div class="module-file"><span class="ext">JS</span> analytics.js</div>
                        <div class="module-file"><span class="ext">CSS</span> analytics.css</div>
                    </div>
                    <a href="{{ route('modules.analytics') }}" class="btn btn-outline" style="margin-top:12px;font-size:12px;padding:5px 12px">View Demo →</a>
                </div>
                <div class="module-card">
                    <div class="mi">⚙️</div>
                    <h3>Settings</h3>
                    <p>Dynamic settings form that loads from and saves to the API.</p>
                    <div class="module-files">
                        <div class="module-file"><span class="ext">JS</span> settings.js</div>
                        <div class="module-file"><span class="ext">CSS</span> settings.css</div>
                    </div>
                    <a href="{{ route('modules.settings') }}" class="btn btn-outline" style="margin-top:12px;font-size:12px;padding:5px 12px">View Demo →</a>
                </div>
            </div>
        </section>

        <!-- COMPARISON -->
        <section class="section" id="comparison">
            <div class="section-header">
                <h2><span class="section-number">9</span>Approach Comparison</h2>
                <p>How this solution compares to other common approaches for managing assets in modular Laravel applications.</p>
            </div>
            <div style="overflow-x:auto;border:1px solid var(--border);border-radius:var(--radius)">
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Approach</th>
                            <th>Module Isolation</th>
                            <th>No Build Step</th>
                            <th>Auto-update on Edit</th>
                            <th>Deploy Complexity</th>
                            <th>Dependencies</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row-hl">
                            <td><strong style="color:var(--accent2)">🔗 modules:symlink</strong> <span style="background:rgba(240,83,64,.15);color:var(--accent2);font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;">This</span></td>
                            <td class="good">✓ Full</td><td class="good">✓ Yes</td><td class="good">✓ Instant</td><td class="good">1 command</td><td class="good">None</td>
                        </tr>
                        <tr>
                            <td>Store assets in <code>public/</code></td>
                            <td class="bad">✗ None</td><td class="good">✓ Yes</td><td class="good">✓ Yes</td><td class="good">None</td><td class="good">None</td>
                        </tr>
                        <tr>
                            <td>Copy assets on deploy</td>
                            <td class="ok">~ Partial</td><td class="good">✓ Yes</td><td class="bad">✗ Manual</td><td class="bad">Script needed</td><td class="good">None</td>
                        </tr>
                        <tr>
                            <td>Vite per-module config</td>
                            <td class="good">✓ Full</td><td class="bad">✗ Build required</td><td class="bad">✗ Rebuild needed</td><td class="bad">Complex</td><td class="bad">Node.js + Vite</td>
                        </tr>
                        <tr>
                            <td>nwidart/laravel-modules</td>
                            <td class="good">✓ Full</td><td class="ok">~ Partial</td><td class="ok">~ Depends</td><td class="ok">Medium</td><td class="bad">Heavy package</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- TESTS -->
        <section class="section" id="tests">
            <div class="section-header">
                <h2><span class="section-number">10</span>Test Suite</h2>
                <p>13 PHPUnit feature tests covering all scenarios. All tests pass.</p>
            </div>
            <div class="terminal" style="margin-bottom:20px">
                <div class="terminal-bar"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span><span>php artisan test</span></div>
                <div class="terminal-body">
                    <div><span class="tp">$</span> <span class="tc2">php artisan test tests/Feature/CreateModuleSymlinksTest.php</span></div>
                    <div>&nbsp;</div>
                    <div class="tok">   PASS  Tests\Feature\CreateModuleSymlinksTest</div>
                    <div class="tok">  ✓ command creates symlinks for modules                  0.13s</div>
                    <div class="tok">  ✓ symlinks point to correct directories                 0.01s</div>
                    <div class="tok">  ✓ command handles missing assets directory              0.01s</div>
                    <div class="tok">  ✓ command removes existing symlinks                    0.01s</div>
                    <div class="tok">  ✓ asset files are accessible through symlinks          0.01s</div>
                    <div class="tok">  ✓ module asset helper returns correct paths            0.01s</div>
                    <div class="tok">  ✓ module asset helper retrieves all assets             0.01s</div>
                    <div class="tok">  ✓ command creates public modules directory             0.01s</div>
                    <div class="tok">  ✓ all modules are processed                            0.01s</div>
                    <div class="tok">  ✓ command provides informative output                  0.01s</div>
                    <div class="tok">  ✓ module controller returns correct assets             0.03s</div>
                    <div class="tok">  ✓ module demo page loads                               0.02s</div>
                    <div class="tok">  ✓ individual module pages load                         0.02s</div>
                    <div>&nbsp;</div>
                    <div class="tok">  Tests:    13 passed (55 assertions)</div>
                    <div class="tok">  Duration: 0.35s</div>
                </div>
            </div>
            <div class="code-wrapper">
                <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> Run the tests</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                <pre><code><span class="t-cm"># Run all tests</span>
$ php artisan test

<span class="t-cm"># Run only module symlink tests</span>
$ php artisan test tests/Feature/CreateModuleSymlinksTest.php</code></pre>
            </div>
        </section>

        <!-- DEPLOYMENT -->
        <section class="section" id="deployment">
            <div class="section-header">
                <h2><span class="section-number">11</span>Deployment</h2>
                <p>Add the symlink command to your deployment pipeline. Symlinks are regenerated on every deploy.</p>
            </div>
            <div class="demo-area">
                <div class="demo-tabs">
                    <div class="demo-tab active" onclick="switchTab(this,'dep-git')">Git Setup</div>
                    <div class="demo-tab" onclick="switchTab(this,'dep-forge')">Laravel Forge</div>
                    <div class="demo-tab" onclick="switchTab(this,'dep-github')">GitHub Actions</div>
                    <div class="demo-tab" onclick="switchTab(this,'dep-envoyer')">Envoyer</div>
                </div>
                <div class="demo-panel active" id="dep-git">
                    <p style="color:var(--muted);font-size:13px;margin-bottom:14px">Add <span class="ic">/public/modules</span> to <span class="ic">.gitignore</span> — symlinks should not be committed.</p>
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> .gitignore</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code>/node_modules
/public/build
/public/storage
<span style="color:var(--green)">/public/modules</span>   <span class="t-cm"># ← Add this line</span>
/vendor
.env</code></pre>
                    </div>
                </div>
                <div class="demo-panel" id="dep-forge">
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> Forge Deployment Script</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code>cd /home/forge/your-app.com
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
<span style="color:var(--green)">php artisan modules:symlink</span>   <span class="t-cm"># ← Add this</span>
php artisan queue:restart</code></pre>
                    </div>
                </div>
                <div class="demo-panel" id="dep-github">
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> .github/workflows/deploy.yml</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code>- name: Install dependencies
  run: composer install --no-dev --optimize-autoloader

<span style="color:var(--green)">- name: Create module symlinks
  run: php artisan modules:symlink</span>

- name: Cache config
  run: php artisan config:cache</code></pre>
                    </div>
                </div>
                <div class="demo-panel" id="dep-envoyer">
                    <div class="code-wrapper">
                        <div class="code-header"><div class="file-name"><span class="dot dot-r"></span><span class="dot dot-y"></span><span class="dot dot-g"></span> Envoyer Hook</div><button class="copy-btn" onclick="copyCode(this)">Copy</button></div>
                        <pre><code>cd @{{ release }}
<span style="color:var(--green)">php artisan modules:symlink</span></code></pre>
                    </div>
                    <div class="alert tip" style="margin-top:12px">
                        <span class="alert-icon">💡</span>
                        <div>Set the hook to run <strong>After</strong> "Install Composer Dependencies" and <strong>Before</strong> "Activate Release".</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="section" id="faq">
            <div class="section-header">
                <h2><span class="section-number">12</span>Frequently Asked Questions</h2>
            </div>

            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">What happens if I add a new JS file to a module's Assets/js/ directory?<span class="faq-icon">+</span></div>
                <div class="faq-a">Because the symlink points to the entire <span class="ic">js/</span> <strong>directory</strong> (not individual files), the new file is immediately accessible. No command re-run is needed.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">What happens if I add a new subdirectory (e.g., Assets/images/)?<span class="faq-icon">+</span></div>
                <div class="faq-a">Re-run <span class="ic">php artisan modules:symlink</span> to create a symlink for the new subdirectory. Existing symlinks are safely removed and recreated.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Why does the module name get converted to snake_case?<span class="faq-icon">+</span></div>
                <div class="faq-a">Module names follow <span class="ic">PascalCase</span> (e.g., <span class="ic">UserProfile</span>). The <span class="ic">Str::snake()</span> conversion produces URL-friendly names (e.g., <span class="ic">user_profile</span>), accessible at <span class="ic">/modules/user_profile/js/...</span>.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Does this work on Windows?<span class="faq-icon">+</span></div>
                <div class="faq-a">Yes. On Windows, run the terminal as Administrator or enable Developer Mode. Laravel's <span class="ic">File::link()</span> handles Windows junction points automatically.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Can I use this with Vite or Laravel Mix?<span class="faq-icon">+</span></div>
                <div class="faq-a">Yes. The symlink approach is completely independent of build tools. Use Vite for modules requiring transpilation and the symlink approach for plain JS/CSS — they coexist without conflict.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">What happens when I delete a module?<span class="faq-icon">+</span></div>
                <div class="faq-a">The symlinks in <span class="ic">public/modules/</span> become broken. Re-running the command won't recreate them since the source no longer exists. Manually delete the broken symlinks from <span class="ic">public/modules/</span>.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q" onclick="toggleFaq(this)">Does this work on shared hosting?<span class="faq-icon">+</span></div>
                <div class="faq-a">Shared hosting often restricts symlink creation. In that case, adapt the command to use <span class="ic">File::copyDirectory()</span> instead of <span class="ic">File::link()</span>. The trade-off is you must re-run it after every asset change.</div>
            </div>

        </section>

    </main>
</div>

<script>
    // Active nav link on scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks  = document.querySelectorAll('.nav-link');
    const observer  = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(l => l.classList.remove('active'));
                const a = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
                if (a) a.classList.add('active');
            }
        });
    }, { rootMargin: '-20% 0px -70% 0px' });
    sections.forEach(s => observer.observe(s));

    // Copy code
    function copyCode(btn) {
        const text = btn.closest('.code-wrapper').querySelector('pre').innerText;
        navigator.clipboard.writeText(text).then(() => {
            btn.textContent = '✓ Copied!';
            btn.classList.add('copied');
            setTimeout(() => { btn.textContent = 'Copy'; btn.classList.remove('copied'); }, 2000);
        });
    }

    // Tab switcher
    function switchTab(tab, panelId) {
        const area = tab.closest('.demo-area');
        area.querySelectorAll('.demo-tab').forEach(t => t.classList.remove('active'));
        area.querySelectorAll('.demo-panel').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(panelId).classList.add('active');
    }

    // FAQ accordion
    function toggleFaq(el) { el.closest('.faq-item').classList.toggle('open'); }

    // Mobile sidebar
    const hamburger = document.getElementById('hamburger');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('overlay');
    hamburger.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('show'); });
    overlay.addEventListener('click',   () => { sidebar.classList.remove('open'); overlay.classList.remove('show'); });
    sidebar.querySelectorAll('.nav-link').forEach(l => l.addEventListener('click', () => {
        sidebar.classList.remove('open'); overlay.classList.remove('show');
    }));
</script>
</body>
</html>
