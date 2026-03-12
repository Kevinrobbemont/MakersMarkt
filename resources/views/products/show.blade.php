<x-layouts.app :title="'MakersMarkt - '.$product->name">
    <section>
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

        <article class="card">
            <p class="pill">{{ $product->category?->name ?? 'Onbekend' }}</p>
            <h1>{{ $product->name }}</h1>
            <p class="muted">Maker: {{ $product->maker?->name ?? 'Onbekend' }}</p>

            <h2 style="color: #2ecc71; margin: 1rem 0;">€{{ number_format($product->price, 2, ',', '.') }}</h2>

            <p>{{ $product->description }}</p>

            <hr class="divider">

            <h3>Specificaties</h3>
            <p><strong>Type:</strong> {{ $product->material ?: 'Niet ingevuld' }}</p>
            <p><strong>Productietijd:</strong> {{ $product->production_time ?: 'Niet ingevuld' }}</p>
            <p><strong>Complexiteit:</strong> {{ $product->complexity ?: 'Niet ingevuld' }}</p>
            <p><strong>Duurzaamheid:</strong> {{ $product->sustainability ?: 'Niet ingevuld' }}</p>
            <p><strong>Unieke kenmerken:</strong> {{ $product->unique_features ?: 'Niet ingevuld' }}</p>

            <hr class="divider">

            <div class="btn-row">
                @if ((int) $product->maker_id === (int) auth()->id())
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">Product aanpassen</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Product verwijderen</button>
                    </form>
                @elseif (auth()->user())
                    <form method="POST" action="{{ route('orders.store') }}" style="margin:0;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary">Bestellen</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Inloggen om te bestellen</a>
                @endif
            </div>
        </article>
    </section>
</x-layouts.app>