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

            @if ($buyerCredit)
                <article class="alert" style="border-color:#cfe0fb;background:#f5f9ff;color:#173b6b;">
                    <p style="margin:0;">
                        <strong>Jouw actuele winkelkrediet:</strong>
                        €{{ number_format((float) $buyerCredit->balance, 2, ',', '.') }}
                    </p>
                </article>
            @endif

            <hr class="divider">

            <h3>Order Details</h3>
            <p>
                <strong>Product:</strong>
                <a href="{{ route('products.show', $order->product) }}">
                    {{ $order->product?->name ?? 'Verwijderd' }}
                </a>
            </p>
            <p><strong>Koper:</strong> {{ $order->buyer?->name ?? 'Onbekend' }}</p>
            <p><strong>Maker:</strong> {{ $order->product?->maker?->name ?? 'Onbekend' }}</p>
            <p><strong>Bedrag:</strong> €{{ number_format($order->product?->price ?? 0, 2, ',', '.') }}</p>
            <p><strong>Status:</strong> <span class="pill">{{ method_exists($order, 'getStatusLabel') ? $order->getStatusLabel() : $order->status }}</span></p>
            <p><strong>Opmerking:</strong> {{ $order->status_description ?: 'N.v.t.' }}</p>

            @if ($isOwnerMaker)
                <hr class="divider">

                <h3>Status wijzigen</h3>
                <p class="muted">Alleen de maker van dit product mag de bestelstatus aanpassen.</p>

                @if ($errors->any())
                    <article class="alert alert-error" style="margin-bottom:1rem;">
                        <ul style="margin:0;padding-left:1.2rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endif

                <form method="POST" action="{{ route('orders.updateStatus', $order) }}" class="stack" style="margin-top:1rem;">
                    @csrf
                    @method('PATCH')

                    <div class="field">
                        <label for="status"><strong>Status</strong></label>
                        <select name="status" id="status" required>
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label for="status_description"><strong>Statusbeschrijving</strong></label>
                        <textarea name="status_description" id="status_description" rows="4" placeholder="Voeg een korte toelichting toe voor de koper.">{{ old('status_description', $order->status_description) }}</textarea>
                    </div>

                    <div class="btn-row">
                        <button type="submit" class="btn btn-primary">Status opslaan</button>
                    </div>
                </form>
            @endif

            <hr class="divider">

            <h3>Tijdlijn</h3>
            <p><strong>Geplaatst op:</strong> {{ $order->created_at?->format('d-m-Y H:i') }}</p>
            <p><strong>Laatst bijgewerkt:</strong> {{ $order->updated_at?->format('d-m-Y H:i') }}</p>

            <hr class="divider">

            <h3>Transacties</h3>

            @if ($order->creditTransactions->isNotEmpty())
                <div class="stack" style="margin-top:1rem;">
                    @foreach ($order->creditTransactions->sortByDesc('created_at') as $transaction)
                        <article class="panel">
                            <p><strong>Van:</strong> {{ $transaction->fromUser?->name ?? 'Onbekend' }}</p>
                            <p><strong>Naar:</strong> {{ $transaction->toUser?->name ?? 'Onbekend' }}</p>
                            <p><strong>Bedrag:</strong> €{{ number_format((float) $transaction->amount, 2, ',', '.') }}</p>
                            <p><strong>Datum:</strong> {{ $transaction->created_at?->format('d-m-Y H:i') }}</p>
                        </article>
                    @endforeach
                </div>
            @else
                <p class="muted">Er zijn nog geen transacties gelogd voor deze bestelling.</p>
            @endif

            <hr class="divider">

            <h3>Review</h3>

            @if ($order->review)
                <p><strong>Beoordeling:</strong> {{ str_repeat('⭐', (int) $order->review->rating) }}</p>
                <p><strong>Commentaar:</strong> {{ $order->review->comment ?: 'Geen commentaar toegevoegd.' }}</p>
                <p><strong>Datum:</strong> {{ $order->review->created_at?->format('d-m-Y') }}</p>
            @elseif (!$isOwnerMaker && !$order->isRejected())
                <p class="muted">Er is nog geen review geplaatst voor deze bestelling.</p>

                <div class="btn-row" style="margin-top: 1rem;">
                    <a href="{{ route('reviews.create', ['order_id' => $order->id]) }}" class="btn btn-primary">
                        Review plaatsen
                    </a>
                </div>
            @elseif ($order->isRejected())
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