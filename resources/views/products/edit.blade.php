<x-layouts.app :title="'MakersMarkt - Product Aanpassen'">
    <section>
        <h1>Product aanpassen</h1>
        <p class="muted">Alleen de eigenaar van dit product kan wijzigingen opslaan.</p>

        @if ($errors->any())
        <article class="alert alert-error">
            <h3 style="margin:0 0 0.5rem;">Controleer je invoer</h3>
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </article>
        @endif

        <form method="POST" action="{{ route('products.update', $product) }}" class="card form-card">
            @csrf
            @method('PATCH')

            <label class="field">
                <strong>Naam *</strong><br>
                <input name="name" value="{{ old('name', $product->name) }}" required>
            </label>

            <label class="field">
                <strong>Beschrijving *</strong><br>
                <textarea name="description" required rows="4">{{ old('description', $product->description) }}</textarea>
            </label>

            <label class="field">
                <strong>Categorie *</strong><br>
                <select name="category_id" required>
                    <option value="">Kies een categorie</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === (int) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="field">
                <strong>Prijs in euro's *</strong><br>
                <input name="price" type="number" step="0.01" min="0.01" value="{{ old('price', $product->price) }}" placeholder="Bijv. 25.99" required>
            </label>

            <label class="field">
                <strong>Type</strong><br>
                <input name="type" value="{{ old('type', $product->material) }}" placeholder="Bijv. keramiek, hout, textiel">
            </label>

            <label class="field">
                <strong>Productietijd</strong><br>
                <input name="production_time" value="{{ old('production_time', $product->production_time) }}" placeholder="Bijv. 1-2 weken, 3-5 dagen">
            </label>

            <label class="field">
                <strong>Complexiteit</strong><br>
                <select name="complexity">
                    <option value="">Kies complexiteit</option>
                    <option value="Laag" @selected(old('complexity', $product->complexity)=='Laag')>Laag</option>
                    <option value="Gemiddeld" @selected(old('complexity', $product->complexity)=='Gemiddeld')>Gemiddeld</option>
                    <option value="Hoog" @selected(old('complexity', $product->complexity)=='Hoog')>Hoog</option>
                </select>
            </label>

            <label class="field">
                <strong>Specificaties</strong><br>
                <textarea name="specifications" rows="3" placeholder="Extra details over afwerking, formaat, materiaal...">{{ old('specifications', $product->unique_features) }}</textarea>
            </label>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">Wijzigingen opslaan</button>
                <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
    </section>
</x-layouts.app>