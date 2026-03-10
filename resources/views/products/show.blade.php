<x-layouts.app :title="'MakersMarkt - '.$product->name">
    <section>
        @if (session('status'))
        <article class="card" style="margin-bottom:1rem; border-color:#86efac;">
            <p style="margin:0; color:#166534;">{{ session('status') }}</p>
        </article>
        @endif

        <article class="card">
            <p class="pill">{{ $product->category?->name ?? 'Onbekend' }}</p>
            <h1>{{ $product->name }}</h1>
            <p class="muted">Maker: {{ $product->maker?->name ?? 'Onbekend' }}</p>

            <p>{{ $product->description }}</p>

            <hr style="border:0; border-top:1px solid #d9e2ec; margin:1rem 0;">

            <h3>Specificaties</h3>
            <p><strong>Type:</strong> {{ $product->material ?: 'Niet ingevuld' }}</p>
            <p><strong>Productietijd:</strong> {{ $product->production_time ?: 'Niet ingevuld' }}</p>
            <p><strong>Complexiteit:</strong> {{ $product->complexity ?: 'Niet ingevuld' }}</p>
            <p><strong>Duurzaamheid:</strong> {{ $product->sustainability ?: 'Niet ingevuld' }}</p>
            <p><strong>Unieke kenmerken:</strong> {{ $product->unique_features ?: 'Niet ingevuld' }}</p>

            @if ((int) $product->maker_id === (int) auth()->id())
            <hr style="border:0; border-top:1px solid #d9e2ec; margin:1rem 0;">

            <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
                <a href="{{ route('products.edit', $product) }}" style="padding:0.5rem 0.8rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68;">Product aanpassen</a>
                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding:0.5rem 0.8rem; border:0; border-radius:8px; background:#b91c1c; color:#fff; cursor:pointer;">Product verwijderen</button>
                </form>
            </div>
            @endif
        </article>
    </section>
</x-layouts.app>