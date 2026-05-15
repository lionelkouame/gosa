<?php

declare(strict_types=1);

$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOSA — Galaxie Open Source Application</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #0d1117;
            --surface:  #161b22;
            --border:   #30363d;
            --accent:   #58a6ff;
            --accent2:  #3fb950;
            --muted:    #8b949e;
            --text:     #e6edf3;
            --radius:   8px;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .hero {
            text-align: center;
            max-width: 680px;
            width: 100%;
        }

        .badge {
            display: inline-block;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .25rem .85rem;
            font-size: .75rem;
            color: var(--accent2);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 700;
            letter-spacing: -.02em;
            line-height: 1.1;
            margin-bottom: .75rem;
        }

        h1 span { color: var(--accent); }

        .tagline {
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .stack {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .pill {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: .3rem .75rem;
            font-size: .8rem;
            color: var(--muted);
        }

        .pill strong { color: var(--text); }

        .quickstart {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            text-align: left;
            overflow: hidden;
            margin-bottom: 2.5rem;
        }

        .quickstart-header {
            padding: .6rem 1rem;
            border-bottom: 1px solid var(--border);
            font-size: .75rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot-red    { background: #ff5f57; }
        .dot-yellow { background: #febc2e; }
        .dot-green  { background: #28c840; }

        .quickstart pre {
            padding: 1.25rem 1.5rem;
            font-family: 'SFMono-Regular', Consolas, monospace;
            font-size: .85rem;
            line-height: 1.8;
            overflow-x: auto;
        }

        .cmd-comment { color: var(--muted); }
        .cmd-prompt  { color: var(--accent2); }
        .cmd-text    { color: var(--text); }

        .links {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .55rem 1.2rem;
            border-radius: var(--radius);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn:hover { opacity: .8; }

        .btn-primary {
            background: var(--accent);
            color: #0d1117;
        }

        .btn-secondary {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
        }

        footer {
            margin-top: 3.5rem;
            font-size: .78rem;
            color: var(--muted);
        }

        footer a { color: var(--muted); text-decoration: underline; }
    </style>
</head>
<body>

<main class="hero">
    <div class="badge">Open Source</div>

    <h1><span>GOSA</span><br>Galaxie Open Source Application</h1>

    <p class="tagline">
        A curated registry of open source applications.<br>
        Built with Clean Architecture, DDD, and Hexagonal Architecture — no framework.
    </p>

    <div class="stack">
        <div class="pill"><strong>PHP</strong> 8.5</div>
        <div class="pill"><strong>FrankenPHP</strong> 1.x</div>
        <div class="pill"><strong>PostgreSQL</strong> 17</div>
        <div class="pill"><strong>PHPStan</strong> level max</div>
        <div class="pill"><strong>PHPUnit</strong> 12</div>
        <div class="pill"><strong>No framework</strong></div>
    </div>

    <div class="quickstart">
        <div class="quickstart-header">
            <span class="dot dot-red"></span>
            <span class="dot dot-yellow"></span>
            <span class="dot dot-green"></span>
            Quick start
        </div>
        <pre><span class="cmd-comment"># clone &amp; start</span>
<span class="cmd-prompt">$</span> <span class="cmd-text">git clone https://github.com/YOUR_USERNAME/gosa.git &amp;&amp; cd gosa</span>
<span class="cmd-prompt">$</span> <span class="cmd-text">cp .env.example .env</span>
<span class="cmd-prompt">$</span> <span class="cmd-text">make up &amp;&amp; make install</span>

<span class="cmd-comment"># run the full CI pipeline</span>
<span class="cmd-prompt">$</span> <span class="cmd-text">make ci</span></pre>
    </div>

    <div class="links">
        <a class="btn btn-primary" href="https://github.com/YOUR_USERNAME/gosa">GitHub</a>
        <a class="btn btn-secondary" href="/docs">Documentation</a>
        <a class="btn btn-secondary" href="https://github.com/YOUR_USERNAME/gosa/blob/main/CONTRIBUTING.md">Contributing</a>
    </div>
</main>

<footer>
    MIT License &mdash; <a href="https://github.com/YOUR_USERNAME/gosa">github.com/YOUR_USERNAME/gosa</a>
</footer>

</body>
</html>
