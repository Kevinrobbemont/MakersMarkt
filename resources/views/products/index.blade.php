<x-layouts.app :title="'MakersMarkt - Producten'">
    <section>
        <div class="section-head">
            <div>
                <h1>Producten</h1>
                <p class="muted">Catalogus met zoeken en filteren. Kopers zien enkel goedgekeurde producten.</p>
            </div>

            @if (auth()->user()?->role?->name === 'maker' || auth()->user()?->role?->name === 'admin')
            <a href="{{ route('products.create') }}" class="btn btn-primary">Product toevoegen</a>
            @endif
        </div>

        @if (session('status'))
        <article class="alert alert-success">
            <p style="margin:0;">{{ session('status') }}</p>
        </article>
        @endif

        <form method="GET" action="{{ route('products.index') }}" class="card form-card" style="margin-bottom:1rem;">
            <label class="field">
                <strong>Zoeken</strong><br>
                <input name="q" value="{{ $search }}" placeholder="Naam, beschrijving of specificaties">
            </label>

            <label class="field">
                <strong>Categorie (Type)</strong><br>
                <select name="category_id">
                    <option value="">Alle categorieen</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategory===$category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="field">
                <strong>Materiaal</strong><br>
                <select name="material">
                    <option value="">Alle materialen</option>
                    @foreach ($materials as $material)
                    <option value="{{ $material }}" @selected($selectedMaterial===$material)>{{ $material }}</option>
                    @endforeach
                </select>
            </label>

            <label class="field">
                <strong>Productietijd</strong><br>
                <select name="production_time">
                    <option value="">Alle productietijden</option>
                    @foreach ($productionTimes as $time)
                    <option value="{{ $time }}" @selected($selectedProductionTime===$time)>{{ $time }}</option>
                    @endforeach
                </select>
            </label>

            <label class="field">
                <strong>Complexiteit</strong><br>
                <select name="complexity">
                    <option value="">Alle complexiteitsniveaus</option>
                    @foreach ($complexities as $complexity)
                    <option value="{{ $complexity }}" @selected($selectedComplexity===$complexity)>{{ $complexity }}</option>
                    @endforeach
                </select>
            </label>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">Filter toepassen</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

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
                <p class="muted">
                    Status:
                    {{ $product->is_approved ? 'goedgekeurd' : 'niet goedgekeurd' }}
                </p>

                <p style="margin-top:0.7rem;">
                    <a href="{{ route('products.show', $product) }}" class="subtle-link">Bekijk details</a>
                </p>

                @if (($isMaker && (int) $product->maker_id === (int) auth()->id()) || $isAdmin)
                <div class="btn-row" style="margin-top:0.5rem;">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-secondary">Aanpassen</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Verwijderen</button>
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