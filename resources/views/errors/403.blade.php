<x-layouts.app :title="'Toegang geweigerd'">
    <section>
        <article class="alert alert-error">
            <h1 style="margin-bottom:0.35rem;">403 - Toegang geweigerd</h1>
            <p>{{ $exception->getMessage() ?: 'Je hebt geen rechten om deze actie uit te voeren.' }}</p>
            <p>
                <a href="{{ route('products.index') }}" class="subtle-link">Terug naar productoverzicht</a>
            </p>
        </article>
    </section>
</x-layouts.app>