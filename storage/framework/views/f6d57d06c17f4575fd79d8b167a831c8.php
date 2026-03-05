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
    <section class="hero">
        <h1>Welkom bij MakersMarkt</h1>
        <p class="muted">
            Een basisstartpunt voor jouw platform waar makers hun producten aanbieden,
            klanten bestellingen plaatsen en reviews/credits samenkomen.
        </p>
        <div class="stats">
            <article class="card">
                <h3>Producten</h3>
                <p class="muted">Verken handgemaakte items per categorie.</p>
            </article>
            <article class="card">
                <h3>Makers</h3>
                <p class="muted">Profielen met bio, portfolio en expertise.</p>
            </article>
            <article class="card">
                <h3>Bestellingen</h3>
                <p class="muted">Orderstatus en feedback in een overzicht.</p>
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