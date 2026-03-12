<x-layouts.app :title="'MakersMarkt - Bestellingen'">
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
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;">
                            <div>
                                <h3>Order #{{ $order->id }}</h3>
                                <p><strong>Product:</strong> {{ $order->product?->name ?? 'Verwijderd' }}</p>

                                <p>
                                    <strong>@if ($isMaker) Koper @else Maker @endif:</strong>
                                    @if ($isMaker)
                                        {{ $order->buyer?->name ?? 'Onbekend' }}
                                    @else
                                        {{ $order->product?->maker?->name ?? 'Onbekend' }}
                                    @endif
                                </p>

                                <p><strong>Bedrag:</strong> €{{ number_format($order->product?->price ?? 0, 2, ',', '.') }}</p>
                                <p><strong>Status:</strong> <span class="pill">{{ $order->status }}</span></p>
                                <p class="muted">{{ $order->status_description ?: 'Geen extra toelichting.' }}</p>

                                @if ($order->review)
                                    <p style="margin-top: .75rem;">
                                        <strong>Review:</strong>
                                        {{ str_repeat('⭐', (int) $order->review->rating) }}
                                        @if ($order->review->comment)
                                            – {{ $order->review->comment }}
                                        @endif
                                    </p>
                                @elseif ($order->status !== 'geweigerd')
                                    <p style="margin-top: .75rem;" class="muted">Voor deze bestelling kan een review geplaatst worden.</p>
                                @endif
                            </div>

                            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Bekijken</a>

                                @if (!$order->review && $order->status !== 'geweigerd')
                                    <a href="{{ route('reviews.create', ['order_id' => $order->id]) }}" class="btn btn-primary">
                                        Review plaatsen
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{ $orders->links() }}
        @endif
    </section>
</x-layouts.app>