<x-layouts.app :title="'MakersMarkt - Statistieken'">
    @php
        $totalProducts = $productsPerCategory->sum('count');
        $topCategory = $productsPerCategory->first();
        $topMaterial = $popularMaterials->first();
        $avgOfMakers = $averageRatingPerMaker->avg('average_rating') ?? 0;
        $ratingScore = min(100, round(($avgOfMakers / 5) * 100));
        $maxCategoryCount = max(1, (int) $productsPerCategory->max('count'));
        $maxMaterialCount = max(1, (int) $popularMaterials->max('count'));
    @endphp

    <section>
        <h1>Statistieken</h1>
        <p class="muted">Realtime overzicht van productmix, makerprestaties en bestellingspopulariteit.</p>

        <div class="analytics-grid" style="margin-top:1rem;">
            <article class="panel kpi-card span-3">
                <p class="kpi-label">Totaal producten</p>
                <p class="kpi-value">{{ $totalProducts }}</p>
                <p class="kpi-sub">Over alle categorieen</p>
            </article>

            <article class="panel kpi-card span-3" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-mint) 100%);">
                <p class="kpi-label">Top categorie</p>
                <p class="kpi-value" style="font-size:1.45rem;">{{ $topCategory['name'] ?? 'n.v.t.' }}</p>
                <p class="kpi-sub">{{ $topCategory['count'] ?? 0 }} producten</p>
            </article>

            <article class="panel kpi-card span-3" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-warm) 100%);">
                <p class="kpi-label">Gemiddelde maker rating</p>
                <p class="kpi-value">{{ number_format($avgOfMakers, 2) }}</p>
                <p class="kpi-sub">Op schaal van 5</p>
            </article>

            <article class="panel kpi-card span-3">
                <p class="kpi-label">Top producttype</p>
                <p class="kpi-value" style="font-size:1.45rem;">{{ $topMaterial->material ?? 'n.v.t.' }}</p>
                <p class="kpi-sub">{{ $topMaterial->count ?? 0 }} items</p>
            </article>

            <article class="panel span-8">
                <h2 style="margin-bottom:0.35rem;">Aantal producten per categorie</h2>
                <p class="muted" style="margin-top:0; margin-bottom:0.9rem;">Vergelijking op basis van absolute aantallen.</p>
                @if ($productsPerCategory->isEmpty())
                    <p class="muted">Nog geen producten aanwezig.</p>
                @else
                    <div class="stat-list">
                        @foreach ($productsPerCategory as $category)
                        <div class="stat-item">
                            <div>
                                <strong>{{ $category['name'] }}</strong>
                            </div>
                            <div>
                                <span class="muted-chip">{{ $category['count'] }} producten</span>
                            </div>
                            <div>
                                <div class="meter-track">
                                    <div class="meter-fill" style="--fill: {{ round(($category['count'] / $maxCategoryCount) * 100) }}%;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <article class="panel span-4" style="display:grid; place-items:center;">
                <h2 style="margin-bottom:0.35rem;">Maker Rating Health</h2>
                <p class="muted" style="margin-top:0; margin-bottom:0.8rem;">Geaggregeerde score op basis van alle maker ratings.</p>
                <div class="donut" style="--p: {{ $ratingScore }}%;" data-label="{{ $ratingScore }}%"></div>
                <p class="kpi-sub" style="margin-top:0.9rem;">Gemiddeld {{ number_format($avgOfMakers, 2) }} / 5</p>
            </article>

            <article class="panel span-6">
                <h2 style="margin-bottom:0.35rem;">Gemiddelde rating per maker</h2>
                <p class="muted" style="margin-top:0; margin-bottom:0.9rem;">Ranking van makers op reviewkwaliteit.</p>
                @if ($averageRatingPerMaker->isEmpty())
                    <p class="muted">Nog geen reviews beschikbaar.</p>
                @else
                    <div class="stat-list">
                        @foreach ($averageRatingPerMaker as $maker)
                        <div class="stat-item">
                            <div>
                                <strong>{{ $maker['name'] }}</strong><br>
                                <span class="muted">{{ $maker['review_count'] }} reviews</span>
                            </div>
                            <div>
                                <span class="muted-chip">{{ $maker['product_count'] }} producten</span>
                            </div>
                            <div>
                                <div class="meter-track">
                                    <div class="meter-fill" style="--fill: {{ round(($maker['average_rating'] / 5) * 100) }}%;"></div>
                                </div>
                                <p style="margin:0.35rem 0 0; font-weight:700; color:#1d3557;">{{ number_format($maker['average_rating'], 2) }} / 5</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <article class="panel span-6">
                <h2 style="margin-bottom:0.35rem;">Populairste producttypen</h2>
                <p class="muted" style="margin-top:0; margin-bottom:0.9rem;">Topmaterialen in de actuele catalogus.</p>
                @if ($popularMaterials->isEmpty())
                    <p class="muted">Geen materialen gevonden.</p>
                @else
                    <div class="mini-bars">
                        @foreach ($popularMaterials->take(8) as $material)
                        <div class="mini-bar" style="--h: {{ round(($material->count / $maxMaterialCount) * 100) }}%;" title="{{ $material->material }}"></div>
                        @endforeach
                    </div>
                    <div class="stat-list" style="margin-top:0.8rem;">
                        @foreach ($popularMaterials->take(6) as $material)
                        <div class="stat-item">
                            <div><strong>{{ $material->material }}</strong></div>
                            <div><span class="muted-chip">{{ $material->count }} items</span></div>
                            <div>
                                <div class="meter-track">
                                    <div class="meter-fill" style="--fill: {{ round(($material->count / $maxMaterialCount) * 100) }}%;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </article>

            <article class="panel span-12">
                <h2 style="margin-bottom:0.35rem;">Top 10 populairste producten (meeste orders)</h2>
                <p class="muted" style="margin-top:0; margin-bottom:0.9rem;">Producten met de hoogste orderfrequentie.</p>
                @if ($popularProducts->isEmpty())
                    <p class="muted">Nog geen orders geplaatst.</p>
                @else
                    <div class="stat-list">
                        @foreach ($popularProducts as $index => $product)
                        @php
                            $maxOrders = max(1, (int) $popularProducts->max('orders_count'));
                        @endphp
                        <div class="stat-item">
                            <div>
                                <span class="muted-chip">#{{ $index + 1 }}</span>
                                <strong style="margin-left:0.45rem;">{{ $product['name'] }}</strong><br>
                                <span class="muted">{{ $product['maker'] }} · {{ $product['category'] }}</span>
                            </div>
                            <div>
                                <span class="muted-chip">{{ $product['orders_count'] }} orders</span>
                            </div>
                            <div>
                                <div class="meter-track">
                                    <div class="meter-fill" style="--fill: {{ round(($product['orders_count'] / $maxOrders) * 100) }}%;"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </article>
        </div>
    </section>
</x-layouts.app>
