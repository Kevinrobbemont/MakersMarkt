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
            <p><strong>Product:</strong> 
                <a href="{{ route('products.show', $order->product) }}">{{ $order->product?->name ?? 'Verwijderd' }}</a>
            </p>
            <p><strong>Koper:</strong> {{ $order->buyer?->name ?? 'Onbekend' }}</p>
            <p><strong>Maker:</strong> 
                <a href="#">{{ $order->product?->maker?->name ?? 'Onbekend' }}</a>
            </p>
            <p><strong>Bedrag:</strong> €{{ number_format($order->product?->price ?? 0, 2, ',', '.') }}</p>
            <p><strong>Status:</strong> <span class="pill">{{ $order->status }}</span></p>
            <p><strong>Opmerking:</strong> {{ $order->status_description ?: 'N/A' }}</p>

            <hr class="divider">

            <h3>Tijdlijn</h3>
            <p><strong>Geplaatst op:</strong> {{ $order->created_at?->format('d-m-Y H:i') }}</p>
            <p><strong>Laatst bijgewerkt:</strong> {{ $order->updated_at?->format('d-m-Y H:i') }}</p>

            <hr class="divider">

            <div class="btn-row">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Terug naar bestellingen</a>
            </div>
        </article>
    </section>
</x-layouts.app>
