<x-layouts.app :title="'MakersMarkt - Dashboard'">
    <section>
        <h1>Dashboard</h1>
        <p class="muted">Kerncijfers als basis voor admin/maker inzichten.</p>

        <div class="grid cols-3">
            @foreach ($stats as $item)
                <article class="card">
                    <p class="muted">{{ $item['label'] }}</p>
                    <h2>{{ $item['value'] }}</h2>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.app>
