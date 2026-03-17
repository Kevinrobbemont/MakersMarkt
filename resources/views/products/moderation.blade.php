<x-layouts.app :title="'MakersMarkt - Producten modereren'">
    <section>
        <div class="section-head">
            <div>
                <h1>Producten modereren</h1>
                <p class="muted">Hier zie je alle producten die nog niet zijn goedgekeurd.</p>
            </div>

            <div class="btn-row">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Terug naar catalogus</a>
            </div>
        </div>

        @if (session('status'))
            <article class="alert alert-success">
                <p style="margin:0;">{{ session('status') }}</p>
            </article>
        @endif

        @if (session('error'))
            <article class="alert alert-error">
                <p style="margin:0;">{{ session('error') }}</p>
            </article>
        @endif

        @if ($products->isEmpty())
            <article class="card">
                <p class="muted" style="margin:0;">Er staan op dit moment geen producten te wachten op goedkeuring.</p>
            </article>
        @else
            <div class="grid cols-3">
                @foreach ($products as $product)
                    <article class="card">
                        <span class="pill">{{ $product->category?->name ?? 'Onbekend' }}</span>
                        <h3>{{ $product->name }}</h3>
                        <p class="muted">Maker: {{ $product->maker?->name ?? 'Onbekend' }}</p>
                        <p>{{ $product->description }}</p>

                        <p style="color: #2ecc71; font-weight: bold; margin: 0.5rem 0;">
                            €{{ number_format($product->price, 2, ',', '.') }}
                        </p>

                        <p class="muted">Status: niet goedgekeurd</p>

                        @if ($product->has_external_links)
                            <p style="color:#b45309; font-weight:700;">Bevat mogelijk externe links</p>
                        @endif

                        <div class="btn-row" style="margin-top:1rem;">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">Bekijken</a>

                            <form method="POST" action="{{ route('products.approve', $product) }}" style="margin:0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">Goedkeuren</button>
                            </form>

                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Verwijderen</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top:1rem;">
                {{ $products->links('pagination::simple') }}
            </div>
        @endif
    </section>
</x-layouts.app>