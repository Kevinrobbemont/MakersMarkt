<x-layouts.app :title="'MakersMarkt - Admin Dashboard'">
    @php
        $statMap = collect($stats)->pluck('value', 'label');
        $totalProducts = (int) ($statMap['Totaal producten'] ?? 0);
        $completedOrders = (int) ($statMap['Afgeronde orders'] ?? 0);
        $reviewCount = (int) ($statMap['Geplaatste reviews'] ?? 0);
        $makerCount = (int) ($statMap['Actieve makers'] ?? 0);
        $reviewCoverage = $completedOrders > 0 ? min(100, round(($reviewCount / $completedOrders) * 100)) : 0;
        $productsPerMaker = $makerCount > 0 ? round($totalProducts / $makerCount, 1) : 0;
    @endphp

    <section>
        <h1>Admin / Moderator Dashboard</h1>
        <p class="muted">Live overzicht van platformprestaties en snelle toegang tot rapportage.</p>

        <div class="analytics-grid" style="margin-top:1rem;">
            <article class="panel hero-panel span-8">
                <p class="kpi-label">Rapportagecentrum</p>
                <h2 style="margin-bottom:0.45rem;">Diepgaande statistieken bekijken</h2>
                <p class="muted" style="margin-bottom:1rem;">Open de uitgebreide statistiekenpagina met categorieverdeling, maker ratings en populairste producttypes.</p>
                <div class="trend-grid">
                    <div class="trend">
                        <p class="kpi-label">Producten per maker</p>
                        <p class="kpi-value" style="font-size:1.45rem;">{{ number_format($productsPerMaker, 1) }}</p>
                    </div>
                    <div class="trend">
                        <p class="kpi-label">Review dekking</p>
                        <p class="kpi-value" style="font-size:1.45rem;">{{ $reviewCoverage }}%</p>
                    </div>
                    <div class="trend">
                        <p class="kpi-label">Orders afgerond</p>
                        <p class="kpi-value" style="font-size:1.45rem;">{{ $completedOrders }}</p>
                    </div>
                </div>
                <div style="margin-top:1rem;">
                    <a href="{{ route('statistics.index') }}" class="cta">Open statistieken</a>
                </div>
            </article>

            <article class="panel span-4" style="display:grid; place-items:center; background:linear-gradient(160deg, #ffffff 0%, #f0f7ff 100%);">
                <p class="kpi-label" style="margin-bottom:0.5rem;">Review Coverage</p>
                <div class="donut" style="--p: {{ $reviewCoverage }}%;" data-label="{{ $reviewCoverage }}%"></div>
                <p class="kpi-sub" style="margin-top:0.8rem;">Reviews t.o.v. afgeronde orders</p>
            </article>

            <article class="panel kpi-card span-3">
                <p class="kpi-label">Totaal producten</p>
                <p class="kpi-value">{{ $totalProducts }}</p>
                <p class="kpi-sub">Actieve items op het platform</p>
            </article>

            <article class="panel kpi-card span-3" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-mint) 100%);">
                <p class="kpi-label">Afgeronde orders</p>
                <p class="kpi-value">{{ $completedOrders }}</p>
                <p class="kpi-sub">Succesvol opgeleverd</p>
            </article>

            <article class="panel kpi-card span-3" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-warm) 100%);">
                <p class="kpi-label">Geplaatste reviews</p>
                <p class="kpi-value">{{ $reviewCount }}</p>
                <p class="kpi-sub">Feedback van kopers</p>
            </article>

            <article class="panel kpi-card span-3">
                <p class="kpi-label">Actieve makers</p>
                <p class="kpi-value">{{ $makerCount }}</p>
                <p class="kpi-sub">Geverifieerde makers</p>
            </article>

            <article class="panel span-4" style="display: grid; place-items: center; background: linear-gradient(160deg, #ffffff 0%, var(--soft-pink) 100%); text-decoration: none;">
                <a href="{{ route('admin.accounts.pending') }}" style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; text-decoration: none; color: inherit;">
                    <p class="kpi-label" style="margin-bottom: 0.5rem;">Accountgoedkeuring</p>
                    <p class="kpi-value" style="font-size: 1.5rem; margin-bottom: 0.5rem;">⟳</p>
                    <p class="kpi-sub">Keur nieuwe accounts goed</p>
                </a>
            </article>
        </div>
    </section>
</x-layouts.app>
