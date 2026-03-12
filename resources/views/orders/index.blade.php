<x-layouts.app :title="'MakersMarkt - Bestellingen'">
    <section>
        <h1>Bestellingen</h1>
        @if ($isMaker)
            <p class="muted">Orders voor je producten</p>
        @elseif ($isAdmin)
            <p class="muted">Alle orders in het systeem</p>
        @else
            <p class="muted">Je bestellingen</p>
        @endif

        @if ($orders->isEmpty())
            <article class="alert">
                <p>Geen bestellingen gevonden.</p>
            </article>
        @else
            <div class="stack" style="margin-top:1rem;">
                @foreach ($orders as $order)
                <article class="panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <h3>Order #{{ $order->id }}</h3>
                            <p><strong>Product:</strong> {{ $order->product?->name ?? 'Verwijderd' }}</p>
                            <p><strong>@if ($isMaker)Koper@else Maker @endif:</strong> 
                                @if ($isMaker)
                                    {{ $order->buyer?->name ?? 'Onbekend' }}
                                @else
                                    {{ $order->product?->maker?->name ?? 'Onbekend' }}
                                @endif
                            </p>
                            <p><strong>Bedrag:</strong> €{{ number_format($order->product?->price ?? 0, 2, ',', '.') }}</p>
                            <p><strong>Status:</strong> <span class="pill">{{ $order->status }}</span></p>
                            <p class="muted">{{ $order->status_description }}</p>
                        </div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Bekijken</a>
                    </div>
                </article>
                @endforeach
            </div>

            {{ $orders->links() }}
        @endif
    </section>
</x-layouts.app>