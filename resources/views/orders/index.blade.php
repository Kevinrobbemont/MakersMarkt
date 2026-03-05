<x-layouts.app :title="'MakersMarkt - Bestellingen'">
    <section>
        <h1>Bestellingen</h1>
        <p class="muted">Eenvoudige statuslijst voor orders als startpunt.</p>

        <div class="grid">
            @foreach ($orders as $order)
            <article class="card">
                <h3>Order #{{ $order['id'] }}</h3>
                <p><strong>Product:</strong> {{ $order['product'] }}</p>
                <p><strong>Koper:</strong> {{ $order['buyer'] }}</p>
                <p><strong>Status:</strong> <span class="pill">{{ $order['status'] }}</span></p>
                <p class="muted">{{ $order['description'] }}</p>
            </article>
            @endforeach
        </div>
    </section>
</x-layouts.app>