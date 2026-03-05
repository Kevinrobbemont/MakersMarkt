<x-layouts.app :title="'Toegang geweigerd'">
    <section>
        <article class="card" style="border-color:#fca5a5;">
            <h1 style="color:#b91c1c;">403 - Toegang geweigerd</h1>
            <p>{{ $exception->getMessage() ?: 'Je hebt geen rechten om deze actie uit te voeren.' }}</p>
            <p>
                <a href="{{ route('products.index') }}" style="color:#0f766e; font-weight:700; text-decoration:none;">Terug naar productoverzicht</a>
            </p>
        </article>
    </section>
</x-layouts.app>
