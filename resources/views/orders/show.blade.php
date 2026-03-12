<x-layouts.app :title="'MakersMarkt - Order #'.$order->id">
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
            <h1>Order #{{ $order->id }}</h1>

            <hr class="divider">

            <h3>Order Details</h3>
            <p>
                <strong>Product:</strong>
                <a href="{{ route('products.show', $order->product) }}">
                    {{ $order->product?->name ?? 'Verwijderd' }}
                </a>
            </p>
            <p><strong>Koper:</strong> {{ $order->buyer?->name ?? 'Onbekend' }}</p>
            <p>
                <strong>Maker:</strong>
                <a href="#">{{ $order->product?->maker?->name ?? 'Onbekend' }}</a>
            </p>
            <p><strong>Bedrag:</strong> €{{ number_format($order->product?->price ?? 0, 2, ',', '.') }}</p>
            <p><strong>Status:</strong> <span class="pill">{{ $order->status }}</span></p>
            <p><strong>Opmerking:</strong> {{ $order->status_description ?: 'N.v.t.' }}</p>

            <hr class="divider">

            <h3>Tijdlijn</h3>
            <p><strong>Geplaatst op:</strong> {{ $order->created_at?->format('d-m-Y H:i') }}</p>
            <p><strong>Laatst bijgewerkt:</strong> {{ $order->updated_at?->format('d-m-Y H:i') }}</p>

            <hr class="divider">

            <h3>Review</h3>

            @if ($order->review)
                <p><strong>Beoordeling:</strong> {{ str_repeat('⭐', (int) $order->review->rating) }}</p>
                <p><strong>Commentaar:</strong> {{ $order->review->comment ?: 'Geen commentaar toegevoegd.' }}</p>
                <p><strong>Datum:</strong> {{ $order->review->created_at?->format('d-m-Y') }}</p>
            @elseif ($order->status !== 'geweigerd')
                <p class="muted">Er is nog geen review geplaatst voor deze bestelling.</p>

                <div class="btn-row" style="margin-top: 1rem;">
                    <a href="{{ route('reviews.create', ['order_id' => $order->id]) }}" class="btn btn-primary">
                        Review plaatsen
                    </a>
                </div>
            @elseif ($order->status === 'geweigerd')
                <p class="muted">Voor een geweigerde bestelling kan geen review worden geplaatst.</p>
            @else
                <p class="muted">Er is nog geen review geplaatst voor deze bestelling.</p>
            @endif

            <hr class="divider">

            <div class="btn-row">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Terug naar bestellingen</a>
            </div>
        </article>
    </section>
</x-layouts.app>