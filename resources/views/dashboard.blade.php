<x-layouts.app :title="'MakersMarkt - Dashboard'">
    <section>
        <h1>Dashboard</h1>
        <p class="muted">Kerncijfers als basis voor admin/maker inzichten.</p>

        <div class="analytics-grid" style="margin-top:1rem;">
            @foreach ($stats as $item)
            <article class="panel kpi-card span-4">
                <p class="kpi-label">{{ $item['label'] }}</p>
                <p class="kpi-value">{{ $item['value'] }}</p>
            </article>
            @endforeach
        </div>
    </section>
</x-layouts.app>