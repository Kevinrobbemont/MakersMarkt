<x-layouts.app :title="'MakersMarkt - Product Aanpassen'">
    <section>
        <h1>Product aanpassen</h1>
        <p class="muted">Alleen de eigenaar van dit product kan wijzigingen opslaan.</p>

        @if ($errors->any())
        <article class="card" style="border-color:#fca5a5; margin-bottom:1rem;">
            <h3 style="color:#b91c1c;">Controleer je invoer</h3>
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </article>
        @endif

        <form method="POST" action="{{ route('products.update', $product) }}" class="card" style="display:grid; gap:0.9rem;">
            @csrf
            @method('PATCH')

            <label>
                <strong>Naam *</strong><br>
                <input name="name" value="{{ old('name', $product->name) }}" required style="width:100%; padding:0.6rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
            </label>

            <label>
                <strong>Beschrijving *</strong><br>
                <textarea name="description" required rows="4" style="width:100%; padding:0.6rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">{{ old('description', $product->description) }}</textarea>
            </label>

            <label>
                <strong>Categorie *</strong><br>
                <select name="category_id" required style="width:100%; padding:0.6rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
                    <option value="">Kies een categorie</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === (int) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <label>
                <strong>Type</strong><br>
                <input name="type" value="{{ old('type', $product->material) }}" placeholder="Bijv. keramiek, hout, textiel" style="width:100%; padding:0.6rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
            </label>

            <label>
                <strong>Specificaties</strong><br>
                <textarea name="specifications" rows="3" placeholder="Extra details over afwerking, formaat, materiaal..." style="width:100%; padding:0.6rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">{{ old('specifications', $product->unique_features) }}</textarea>
            </label>

            <div style="display:flex; gap:0.7rem; flex-wrap:wrap;">
                <button type="submit" style="padding:0.55rem 0.9rem; border:0; border-radius:8px; background:#0f766e; color:#fff; font-weight:700; cursor:pointer;">Wijzigingen opslaan</button>
                <a href="{{ route('products.show', $product) }}" style="padding:0.55rem 0.9rem; border-radius:8px; border:1px solid #cbd2d9; color:#334e68; text-decoration:none;">Annuleren</a>
            </div>
        </form>
    </section>
</x-layouts.app>