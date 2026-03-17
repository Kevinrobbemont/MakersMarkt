<x-layouts.app :title="'MakersMarkt - Order #'.$order->id">
    <section class="stack">
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

        <article class="card order-detail-card">
            <div class="section-head">
                <div>
                    <h1 style="margin-bottom: .35rem;">Order #{{ $order->id }}</h1>
                    <p class="muted" style="margin:0;">Overzicht van de bestelling en actuele status</p>
                </div>

                <div class="btn-row">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Terug naar bestellingen</a>
                </div>
            </div>

            <hr class="divider">

            <div class="order-summary-grid">
                <div class="info-card">
                    <span class="info-label">Product</span>
                    <p class="info-value">
                        <a href="{{ route('products.show', $order->product) }}" class="subtle-link">
                            {{ $order->product?->name ?? 'Verwijderd' }}
                        </a>
                    </p>
                </div>

                <div class="info-card">
                    <span class="info-label">Koper</span>
                    <p class="info-value">{{ $order->buyer?->name ?? 'Onbekend' }}</p>
                </div>

                <div class="info-card">
                    <span class="info-label">Maker</span>
                    <p class="info-value">{{ $order->product?->maker?->name ?? 'Onbekend' }}</p>
                </div>

                <div class="info-card">
                    <span class="info-label">Bedrag</span>
                    <p class="info-value">€{{ number_format($order->product?->price ?? 0, 2, ',', '.') }}</p>
                </div>

                <div class="info-card">
                    <span class="info-label">Status</span>
                    <p class="info-value">
                        <span class="pill">{{ method_exists($order, 'getStatusLabel') ? $order->getStatusLabel() : $order->status }}</span>
                    </p>
                </div>

                <div class="info-card info-card-wide">
                    <span class="info-label">Opmerking</span>
                    <p class="info-value">{{ $order->status_description ?: 'N.v.t.' }}</p>
                </div>
            </div>

            @if (isset($isOwnerMaker) && $isOwnerMaker)
                <hr class="divider">

                <section class="status-update-box">
                    <div class="status-update-head">
                        <div>
                            <h3 style="margin-bottom: .35rem;">Status wijzigen</h3>
                            <p class="muted" style="margin:0;">Alleen de maker van dit product mag de bestelstatus aanpassen.</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <article class="alert alert-error" style="margin-top: 1rem;">
                            <ul style="margin:0;padding-left:1.2rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </article>
                    @endif

                    <form method="POST" action="{{ route('orders.updateStatus', $order) }}" class="form-card status-form">
                        @csrf
                        @method('PATCH')

                        <div class="field">
                            <label for="status">Status</label>
                            <select name="status" id="status" required>
                                @if (isset($statusOptions))
                                    @foreach ($statusOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="in_productie" @selected(old('status', $order->status) === 'in_productie')>In productie</option>
                                    <option value="verzonden" @selected(old('status', $order->status) === 'verzonden')>Verzonden</option>
                                    <option value="geweigerd" @selected(old('status', $order->status) === 'geweigerd')>Geweigerd</option>
                                @endif
                            </select>
                        </div>

                        <div class="field">
                            <label for="status_description">Statusbeschrijving</label>
                            <textarea
                                name="status_description"
                                id="status_description"
                                rows="5"
                                placeholder="Voeg hier een korte toelichting toe voor de koper, bijvoorbeeld: het pakket is onderweg of de bestelling is geweigerd en wordt terugbetaald."
                            >{{ old('status_description', $order->status_description) }}</textarea>
                        </div>

                        <div class="status-form-actions">
                            <button type="submit" class="btn btn-primary">Status opslaan</button>
                        </div>
                    </form>
                </section>
            @endif

            <hr class="divider">

            <div class="order-meta-grid">
                <div class="info-card">
                    <span class="info-label">Geplaatst op</span>
                    <p class="info-value">{{ $order->created_at?->format('d-m-Y H:i') }}</p>
                </div>

                <div class="info-card">
                    <span class="info-label">Laatst bijgewerkt</span>
                    <p class="info-value">{{ $order->updated_at?->format('d-m-Y H:i') }}</p>
                </div>
            </div>

            <hr class="divider">

            <section>
                <h3>Review</h3>

                @if ($order->review)
                    <p><strong>Beoordeling:</strong> {{ str_repeat('⭐', (int) $order->review->rating) }}</p>
                    <p><strong>Commentaar:</strong> {{ $order->review->comment ?: 'Geen commentaar toegevoegd.' }}</p>
                    <p><strong>Datum:</strong> {{ $order->review->created_at?->format('d-m-Y') }}</p>
                @elseif ($order->status !== 'geweigerd' && (!isset($isOwnerMaker) || !$isOwnerMaker))
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
            </section>
        </article>
    </section>
</x-layouts.app>