<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'MakersMarkt - Admin Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MakersMarkt - Admin Dashboard')]); ?>
    <?php
        $statMap = collect($stats)->pluck('value', 'label');
        $totalProducts = (int) ($statMap['Totaal producten'] ?? 0);
        $completedOrders = (int) ($statMap['Afgeronde orders'] ?? 0);
        $reviewCount = (int) ($statMap['Geplaatste reviews'] ?? 0);
        $makerCount = (int) ($statMap['Actieve makers'] ?? 0);
        $reviewCoverage = $completedOrders > 0 ? min(100, round(($reviewCount / $completedOrders) * 100)) : 0;
        $productsPerMaker = $makerCount > 0 ? round($totalProducts / $makerCount, 1) : 0;
    ?>

    <section>
        <h1>Admin / Moderator Dashboard</h1>
        <p class="muted">Live overzicht van platformprestaties en snelle toegang tot rapportage.</p>

        <div class="analytics-grid" style="margin-top:1rem;">
            <article class="panel hero-panel span-8">
                <p class="kpi-label">Rapportagecentrum</p>
                <h2 style="margin-bottom:0.45rem;">Diepgaande statistieken bekijken</h2>
                <p class="muted" style="margin-bottom:1rem;">Open de uitgebreide statistiekenpagina met categorieverdeling, maker ratings en populairste producttypes.</p>
                <div class="trend-grid">
                    <div class="trend">
                        <p class="kpi-label">Producten per maker</p>
                        <p class="kpi-value" style="font-size:1.45rem;"><?php echo e(number_format($productsPerMaker, 1)); ?></p>
                    </div>
                    <div class="trend">
                        <p class="kpi-label">Review dekking</p>
                        <p class="kpi-value" style="font-size:1.45rem;"><?php echo e($reviewCoverage); ?>%</p>
                    </div>
                    <div class="trend">
                        <p class="kpi-label">Orders afgerond</p>
                        <p class="kpi-value" style="font-size:1.45rem;"><?php echo e($completedOrders); ?></p>
                    </div>
                </div>
                <div style="margin-top:1rem;">
                    <a href="<?php echo e(route('statistics.index')); ?>" class="cta">Open statistieken</a>
                </div>
            </article>

            <article class="panel span-4" style="display:grid; place-items:center; background:linear-gradient(160deg, #ffffff 0%, #f0f7ff 100%);">
                <p class="kpi-label" style="margin-bottom:0.5rem;">Review Coverage</p>
                <div class="donut" style="--p: <?php echo e($reviewCoverage); ?>%;" data-label="<?php echo e($reviewCoverage); ?>%"></div>
                <p class="kpi-sub" style="margin-top:0.8rem;">Reviews t.o.v. afgeronde orders</p>
            </article>

            <article class="panel kpi-card span-3">
                <p class="kpi-label">Totaal producten</p>
                <p class="kpi-value"><?php echo e($totalProducts); ?></p>
                <p class="kpi-sub">Actieve items op het platform</p>
            </article>

            <article class="panel kpi-card span-3" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-mint) 100%);">
                <p class="kpi-label">Afgeronde orders</p>
                <p class="kpi-value"><?php echo e($completedOrders); ?></p>
                <p class="kpi-sub">Succesvol opgeleverd</p>
            </article>

            <article class="panel kpi-card span-3" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-warm) 100%);">
                <p class="kpi-label">Geplaatste reviews</p>
                <p class="kpi-value"><?php echo e($reviewCount); ?></p>
                <p class="kpi-sub">Feedback van kopers</p>
            </article>

            <article class="panel kpi-card span-3">
                <p class="kpi-label">Actieve makers</p>
                <p class="kpi-value"><?php echo e($makerCount); ?></p>
                <p class="kpi-sub">Geverifieerde makers</p>
            </article>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\Users\daalm\DrinkOrDare\DrinkOrDare\MakersMarkt\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>