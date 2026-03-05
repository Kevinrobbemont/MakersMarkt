<x-layouts.app :title="'MakersMarkt - Makers'">
    <section>
        <h1>Makers</h1>
        <p class="muted">Basispagina met makers en profielsamenvatting.</p>

        <div class="grid cols-3">
            @foreach ($makers as $maker)
            <article class="card">
                <h3>{{ $maker['name'] }}</h3>
                <p class="muted">@{{ $maker['username'] }}</p>
                <p>{{ $maker['bio'] }}</p>
            </article>
            @endforeach
        </div>
    </section>
</x-layouts.app>