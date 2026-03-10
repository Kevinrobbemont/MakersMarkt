<x-layouts.app :title="'MakersMarkt - Producten'">
    <section>
        <h1>Producten</h1>
        <p class="muted">Catalogus met zoeken en filteren. Kopers zien enkel goedgekeurde producten.</p>

        @if (session('status'))
        <article class="card" style="margin-bottom:1rem; border-color:#86efac;">
            <p style="margin:0; color:#166534;">{{ session('status') }}</p>
        </article>
        @endif

        @if (auth()->user()?->role?->name === 'maker' || auth()->user()?->role?->name === 'admin')
        <p style="margin-bottom:1rem;">
            <a href="{{ route('products.create') }}" style="display:inline-block; padding:0.55rem 0.9rem; border-radius:8px; background:#0f766e; color:#fff; font-weight:700; text-decoration:none;">
                Product toevoegen
            </a>
        </p>
        @endif

        <form method="GET" action="{{ route('products.index') }}" class="card" style="display:grid; gap:0.8rem; margin-bottom:1rem;">
            <label>
                <strong>Zoeken</strong><br>
                <input name="q" value="{{ $search }}" placeholder="Naam, beschrijving of specificaties" style="width:100%; padding:0.55rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
            </label>

            <label>
                <strong>Categorie</strong><br>
                <select name="category_id" style="width:100%; padding:0.55rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
                    <option value="">Alle categorieen</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategory===$category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
                <button type="submit" style="padding:0.5rem 0.85rem; border:0; border-radius:8px; background:#0f766e; color:#fff; font-weight:700; cursor:pointer;">Filter toepassen</button>
                <a href="{{ route('products.index') }}" style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68;">Reset</a>
            </div>
        </form>

        <div class="grid cols-3">
            @foreach ($products as $product)
            <article class="card">
                <span class="pill">{{ $product->category?->name ?? 'Onbekend' }}</span>
                <h3>{{ $product->name }}</h3>
                <p class="muted">Maker: {{ $product->maker?->name ?? 'Onbekend' }}</p>
                <p>{{ $product->description }}</p>
                <p class="muted">
                    Status:
                    {{ $product->is_approved ? 'goedgekeurd' : 'niet goedgekeurd' }}
                </p>

                <p style="margin-top:0.7rem;">
                    <a href="{{ route('products.show', $product) }}" style="color:#0f766e; font-weight:700; text-decoration:none;">Bekijk details</a>
                </p>

                @if (($isMaker && (int) $product->maker_id === (int) auth()->id()) || $isAdmin)
                <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-top:0.5rem;">
                    <a href="{{ route('products.edit', $product) }}" style="padding:0.4rem 0.65rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68;">Aanpassen</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding:0.4rem 0.65rem; border:0; border-radius:8px; background:#b91c1c; color:#fff; cursor:pointer;">Verwijderen</button>
                    </form>
                </div>
                @endif
            </article>
            @endforeach
        </div>

        @if ($products->isEmpty())
        <article class="card" style="margin-top:1rem;">
            <p class="muted" style="margin:0;">Nog geen producten beschikbaar.</p>
        </article>
        @else
        {{ $products->links('pagination::simple') }}
        @endif
    </section>
</x-layouts.app>