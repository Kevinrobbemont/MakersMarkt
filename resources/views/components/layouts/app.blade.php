<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MakersMarkt' }}</title>
    <style>
        :root {
            --bg: #f6f4ee;
            --paper: #fffdf8;
            --ink: #1f2933;
            --muted: #52606d;
            --brand: #0f766e;
            --brand-dark: #115e59;
            --line: #d9e2ec;
            --accent: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 10%, rgba(15, 118, 110, 0.08), transparent 35%),
                radial-gradient(circle at 90% 20%, rgba(245, 158, 11, 0.12), transparent 32%),
                var(--bg);
            min-height: 100vh;
        }

        .container {
            width: min(1100px, 92vw);
            margin: 0 auto;
        }

        .topbar {
            border-bottom: 1px solid var(--line);
            background: rgba(255, 253, 248, 0.9);
            backdrop-filter: blur(4px);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 0;
            flex-wrap: wrap;
        }

        .brand {
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--brand-dark);
            text-decoration: none;
        }

        .nav {
            display: flex;
            gap: 0.9rem;
            flex-wrap: wrap;
        }

        .nav a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 600;
            padding: 0.4rem 0.6rem;
            border-radius: 0.4rem;
        }

        .nav button {
            color: var(--muted);
            font-weight: 600;
            padding: 0.4rem 0.6rem;
            border-radius: 0.4rem;
            border: 0;
            background: transparent;
            cursor: pointer;
            font: inherit;
        }

        .nav a:hover,
        .nav a.active,
        .nav button:hover {
            color: var(--brand-dark);
            background: rgba(15, 118, 110, 0.1);
        }

        main {
            padding: 2rem 0 3rem;
        }

        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 1rem;
            box-shadow: 0 6px 18px rgba(31, 41, 51, 0.06);
        }

        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid.cols-3 {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
            color: #102a43;
        }

        .hero {
            padding: 1.6rem;
            border-radius: 16px;
            border: 1px solid rgba(15, 118, 110, 0.25);
            background: linear-gradient(120deg, #d1fae5, #fef3c7);
        }

        .muted {
            color: var(--muted);
        }

        .pill {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #fff;
            font-size: 0.85rem;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .stats .card {
            flex: 1 1 180px;
        }

        footer {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a href="{{ route('home') }}" class="brand">MakersMarkt</a>
            <nav class="nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                @auth
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Producten</a>
                <a href="{{ route('makers.index') }}" class="{{ request()->routeIs('makers.*') ? 'active' : '' }}">Makers</a>
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Bestellingen</a>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit">Uitloggen</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Inloggen</a>
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Registreren</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container">
        {{ $slot }}

        <footer>
            <p>MakersMarkt basislayout - klaar om uit te breiden met echte data, auth en acties.</p>
        </footer>
    </main>
</body>

</html>