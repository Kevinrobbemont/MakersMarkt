<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MakersMarkt' }}</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --paper: #ffffff;
            --ink: #162033;
            --muted: #61708a;
            --brand: #1663c7;
            --brand-dark: #124d9d;
            --line: #d9e2ef;
            --accent: #00a88f;
            --soft-blue: #eef5ff;
            --soft-mint: #ecfbf6;
            --soft-warm: #fff8e8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Avenir Next', 'Trebuchet MS', 'Century Gothic', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 8% 8%, rgba(22, 99, 199, 0.12), transparent 36%),
                radial-gradient(circle at 92% 14%, rgba(0, 168, 143, 0.13), transparent 34%),
                var(--bg);
            min-height: 100vh;
        }

        .container {
            width: min(1240px, 94vw);
            margin: 0 auto;
        }

        .topbar {
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.92);
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
            color: #0c3b7a;
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
            color: #0c3b7a;
            background: rgba(22, 99, 199, 0.12);
        }

        main {
            padding: 2rem 0 3rem;
        }

        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 1.05rem;
            box-shadow: 0 8px 24px rgba(35, 54, 88, 0.06);
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
            color: #0f213f;
        }

        .analytics-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .panel {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 1rem;
            box-shadow: 0 8px 24px rgba(35, 54, 88, 0.06);
        }

        .span-3 { grid-column: span 3; }
        .span-4 { grid-column: span 4; }
        .span-5 { grid-column: span 5; }
        .span-6 { grid-column: span 6; }
        .span-7 { grid-column: span 7; }
        .span-8 { grid-column: span 8; }
        .span-12 { grid-column: span 12; }

        .kpi-card {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            min-height: 120px;
            justify-content: space-between;
            background: linear-gradient(160deg, #ffffff 0%, var(--soft-blue) 100%);
        }

        .kpi-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            font-weight: 700;
            margin: 0;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 0.01em;
            margin: 0;
            color: #0f213f;
        }

        .kpi-sub {
            margin: 0;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .hero-panel {
            background: linear-gradient(125deg, #ecf4ff 0%, #f8fffd 62%, #fff7ea 100%);
            border: 1px solid #cfe0fb;
        }

        .cta {
            display: inline-block;
            padding: 0.62rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(100deg, #0d4fa6 0%, #1663c7 100%);
            font-weight: 700;
            box-shadow: 0 10px 18px rgba(22, 99, 199, 0.25);
        }

        .meter-track {
            width: 100%;
            height: 9px;
            background: #e8edf5;
            border-radius: 999px;
            overflow: hidden;
        }

        .meter-fill {
            height: 100%;
            width: var(--fill, 0%);
            border-radius: 999px;
            background: linear-gradient(90deg, #1b7be8 0%, #00a88f 100%);
        }

        .stat-list {
            display: grid;
            gap: 0.8rem;
        }

        .stat-item {
            display: grid;
            grid-template-columns: 1.4fr 0.8fr 1fr;
            gap: 0.8rem;
            align-items: center;
            padding: 0.7rem 0.8rem;
            border: 1px solid #e5ebf4;
            border-radius: 10px;
            background: #fbfdff;
        }

        .muted-chip {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            background: #edf2fa;
            color: #4b5b76;
            font-size: 0.76rem;
            font-weight: 700;
        }

        .mini-bars {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 0.4rem;
            align-items: end;
            min-height: 140px;
            padding: 0.6rem 0.1rem 0.2rem;
        }

        .mini-bar {
            height: var(--h, 30%);
            border-radius: 8px 8px 4px 4px;
            background: linear-gradient(180deg, #6db0ff 0%, #2a79df 100%);
        }

        .donut {
            width: 130px;
            height: 130px;
            border-radius: 999px;
            background: conic-gradient(#1b7be8 var(--p, 0%), #e5ecf6 0%);
            position: relative;
            margin: 0 auto;
        }

        .donut::after {
            content: attr(data-label);
            position: absolute;
            inset: 18px;
            border-radius: 999px;
            background: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
            color: #1a365d;
        }

        .trend-grid {
            display: grid;
            gap: 0.8rem;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .trend {
            border: 1px solid #e6edf7;
            border-radius: 10px;
            padding: 0.7rem;
            background: #fcfeff;
        }

        .trend .up {
            color: #0e9f6e;
            font-weight: 700;
        }

        .trend .down {
            color: #ce3a3a;
            font-weight: 700;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.55rem 0.9rem;
            border-radius: 10px;
            font-weight: 700;
            border: 1px solid transparent;
            text-decoration: none;
            cursor: pointer;
            font: inherit;
            line-height: 1;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(100deg, #0d4fa6 0%, #1663c7 100%);
            box-shadow: 0 10px 18px rgba(22, 99, 199, 0.25);
        }

        .btn-secondary {
            color: #23385f;
            background: #fff;
            border-color: #cfdaea;
        }

        .btn-danger {
            color: #fff;
            background: linear-gradient(100deg, #bf3131 0%, #9f1d1d 100%);
            box-shadow: 0 8px 16px rgba(191, 49, 49, 0.2);
        }

        .btn-ghost {
            color: #35507a;
            background: #eef3fb;
            border-color: #d7e2f2;
        }

        .btn-row {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .form-card {
            display: grid;
            gap: 0.9rem;
        }

        .field {
            display: grid;
            gap: 0.35rem;
        }

        .field label,
        .field strong {
            font-weight: 700;
            color: #1c3254;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            padding: 0.62rem 0.65rem;
            border: 1px solid #cfdaea;
            border-radius: 10px;
            background: #fff;
            color: #12213b;
            font: inherit;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: #1b7be8;
            box-shadow: 0 0 0 3px rgba(27, 123, 232, 0.14);
        }

        .alert {
            border-radius: 12px;
            border: 1px solid;
            padding: 0.8rem 0.9rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            border-color: #b4e8d9;
            background: #effcf8;
            color: #10624d;
        }

        .alert-error {
            border-color: #efc1c1;
            background: #fff4f4;
            color: #8f1f1f;
        }

        .stack {
            display: grid;
            gap: 1rem;
        }

        .list-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .notification-unread {
            border-left: 4px solid #1663c7;
            background: linear-gradient(90deg, #f1f7ff 0%, #ffffff 38%);
        }

        .table-like {
            display: grid;
            gap: 0.75rem;
        }

        .subtle-link {
            color: #0f57b8;
            font-weight: 700;
            text-decoration: none;
        }

        .subtle-link:hover {
            text-decoration: underline;
        }

        .divider {
            border: 0;
            border-top: 1px solid #e1e9f4;
            margin: 1rem 0;
        }

        .pagination {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 0.48rem 0.8rem;
            border: 1px solid #cfdaea;
            border-radius: 9px;
            color: #35507a;
            background: #fff;
            text-decoration: none;
            font-size: 0.92rem;
        }

        .pagination .disabled {
            color: #95a5bf;
            cursor: not-allowed;
            background: #f8fbff;
        }

        .pagination .meta {
            border-color: transparent;
            background: transparent;
            color: var(--muted);
        }

        .muted {
            color: var(--muted);
        }

        .pill {
            display: inline-flex;
            align-items: center;
            padding: 0.38rem 0.75rem;
            border-radius: 999px;
            background: #eaf2ff;
            color: #114c9b;
            font-size: 0.85rem;
            font-weight: 700;
            border: 1px solid #cfe0fb;
        }

        /* NIEUWE STYLING VOOR ORDER DETAIL / STATUS FORM */
        .order-detail-card {
            padding: 1.4rem;
        }

        .order-summary-grid,
        .order-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .info-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border: 1px solid #dbe6f2;
            border-radius: 14px;
            padding: 1rem 1.05rem;
        }

        .info-card-wide {
            grid-column: span 2;
        }

        .info-label {
            display: block;
            margin-bottom: 0.35rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #667791;
        }

        .info-value {
            margin: 0;
            font-size: 1rem;
            color: #12213b;
            line-height: 1.5;
        }

        .status-update-box {
            border: 1px solid #d9e5f2;
            border-radius: 16px;
            background: linear-gradient(180deg, #f7fbff 0%, #ffffff 100%);
            padding: 1.15rem;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .status-update-head {
            margin-bottom: 1rem;
        }

        .status-form {
            max-width: 720px;
        }

        .status-form .field textarea {
            min-height: 130px;
            resize: vertical;
            line-height: 1.5;
        }

        .status-form-actions {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-top: 0.25rem;
        }

        @media (max-width: 980px) {
            .span-3,
            .span-4,
            .span-5,
            .span-6,
            .span-7,
            .span-8 {
                grid-column: span 12;
            }

            .trend-grid {
                grid-template-columns: 1fr;
            }

            .stat-item {
                grid-template-columns: 1fr;
            }

            .section-head {
                align-items: flex-start;
            }

            .order-summary-grid,
            .order-meta-grid {
                grid-template-columns: 1fr;
            }

            .info-card-wide {
                grid-column: span 1;
            }
        }

        .hero {
            display: grid;
            gap: 1rem;
        }
    </style>
</head>

<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a href="{{ route('dashboard') }}" class="brand">MakersMarkt</a>

            <nav class="nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Producten</a>
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">Bestellingen</a>
                <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">Meldingen</a>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">Profiel</a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit">Uitloggen</button>
                </form>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            {{ $slot }}
        </div>
    </main>
</body>

</html>