<x-layouts.app :title="'MakersMarkt - Makers'">
    <section>
        <h1>Makers</h1>
        <p class="muted">Basispagina met makers en profielsamenvatting.</p>

        <div class="analytics-grid" style="margin-top:1rem;">
            @foreach ($makers as $maker)
            <article class="panel span-4">
                <h3>{{ $maker['name'] }}</h3>
                <p><span class="muted-chip">@{{ $maker['username'] }}</span></p>
                <p>{{ $maker['bio'] }}</p>
            </article>
            @endforeach
        </div>
    </section>
</x-layouts.app>