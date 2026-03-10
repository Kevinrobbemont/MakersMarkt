<x-layouts.app :title="'MakersMarkt - Home'">
    <section>
        <article class="panel hero-panel" style="margin-bottom:1rem;">
            <h1>Welkom bij MakersMarkt</h1>
            <p class="muted">
                Een modern platform waar makers hun producten aanbieden en kopers bestellingen plaatsen met reviews en meldingen.
            </p>
            <div class="btn-row" style="margin-top:0.8rem;">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Bekijk producten</a>
                <a href="{{ route('makers.index') }}" class="btn btn-secondary">Ontdek makers</a>
            </div>
        </article>

        <div class="analytics-grid">
            <article class="panel kpi-card span-4">
                <p class="kpi-label">Catalogus</p>
                <p class="kpi-value" style="font-size:1.6rem;">Producten</p>
                <p class="kpi-sub">Verken handgemaakte items per categorie.</p>
            </article>
            <article class="panel kpi-card span-4" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-mint) 100%);">
                <p class="kpi-label">Community</p>
                <p class="kpi-value" style="font-size:1.6rem;">Makers</p>
                <p class="kpi-sub">Profielen met bio, portfolio en expertise.</p>
            </article>
            <article class="panel kpi-card span-4" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-warm) 100%);">
                <p class="kpi-label">Flow</p>
                <p class="kpi-value" style="font-size:1.6rem;">Bestellingen</p>
                <p class="kpi-sub">Orderstatus en feedback in een overzicht.</p>
            </article>
        </div>
    </section>
</x-layouts.app>