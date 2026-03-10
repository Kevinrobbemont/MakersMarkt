<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'MakersMarkt - Home']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MakersMarkt - Home')]); ?>
    <section>
        <article class="panel hero-panel" style="margin-bottom:1rem;">
            <h1>Welkom bij MakersMarkt</h1>
            <p class="muted">
                Een modern platform waar makers hun producten aanbieden en kopers bestellingen plaatsen met reviews en meldingen.
            </p>
            <div class="btn-row" style="margin-top:0.8rem;">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary">Bekijk producten</a>
                <a href="<?php echo e(route('makers.index')); ?>" class="btn btn-secondary">Ontdek makers</a>
            </div>
        </article>

        <div class="analytics-grid">
            <article class="panel kpi-card span-4">
                <p class="kpi-label">Catalogus</p>
                <p class="kpi-value" style="font-size:1.6rem;">Producten</p>
                <p class="kpi-sub">Verken handgemaakte items per categorie.</p>
            </article>
            <article class="panel kpi-card span-4" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-mint) 100%);">
                <p class="kpi-label">Community</p>
                <p class="kpi-value" style="font-size:1.6rem;">Makers</p>
                <p class="kpi-sub">Profielen met bio, portfolio en expertise.</p>
            </article>
            <article class="panel kpi-card span-4" style="background:linear-gradient(160deg, #ffffff 0%, var(--soft-warm) 100%);">
                <p class="kpi-label">Flow</p>
                <p class="kpi-value" style="font-size:1.6rem;">Bestellingen</p>
                <p class="kpi-sub">Orderstatus en feedback in een overzicht.</p>
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
<?php endif; ?><?php /**PATH C:\Users\daalm\DrinkOrDare\DrinkOrDare\MakersMarkt\resources\views/home.blade.php ENDPATH**/ ?>