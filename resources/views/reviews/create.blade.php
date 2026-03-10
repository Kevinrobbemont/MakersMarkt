<x-layouts.app :title="'MakersMarkt - Review plaatsen'">
    <section>
        <h1>Review plaatsen</h1>
        <p class="muted">Deel je ervaring met dit product</p>

        @if ($errors->any())
        <article class="alert alert-error">
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </article>
        @endif

        <form method="POST" action="{{ route('reviews.store') }}" class="card form-card">
            @csrf

            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div>
                <p><strong>Product:</strong> {{ $order->product->name }}</p>
                <p class="muted">Maker: {{ $order->product->maker->name }}</p>
            </div>

            <label class="field">
                <strong>Beoordeling *</strong><br>
                <select name="rating" required>
                    <option value="">Selecteer een beoordeling</option>
                    <option value="5">⭐⭐⭐⭐⭐ Uitstekend</option>
                    <option value="4">⭐⭐⭐⭐ Goed</option>
                    <option value="3">⭐⭐⭐ Voldoende</option>
                    <option value="2">⭐⭐ Matig</option>
                    <option value="1">⭐ Slecht</option>
                </select>
            </label>

            <label class="field">
                <strong>Commentaar</strong><br>
                <textarea name="comment" rows="5" placeholder="Deel je ervaring met dit product...">{{ old('comment') }}</textarea>
            </label>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">
                    Review plaatsen
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    Annuleren
                </a>
            </div>
        </form>
    </section>
</x-layouts.app>
