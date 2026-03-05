<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'MakersMarkt - '.$product->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MakersMarkt - '.$product->name)]); ?>
    <section>
        <?php if(session('status')): ?>
            <article class="card" style="margin-bottom:1rem; border-color:#86efac;">
                <p style="margin:0; color:#166534;"><?php echo e(session('status')); ?></p>
            </article>
        <?php endif; ?>

        <article class="card">
            <p class="pill"><?php echo e($product->category?->name ?? 'Onbekend'); ?></p>
            <h1><?php echo e($product->name); ?></h1>
            <p class="muted">Maker: <?php echo e($product->maker?->name ?? 'Onbekend'); ?></p>

            <p><?php echo e($product->description); ?></p>

            <hr style="border:0; border-top:1px solid #d9e2ec; margin:1rem 0;">

            <h3>Specificaties</h3>
            <p><strong>Type:</strong> <?php echo e($product->material ?: 'Niet ingevuld'); ?></p>
            <p><strong>Productietijd:</strong> <?php echo e($product->production_time ?: 'Niet ingevuld'); ?></p>
            <p><strong>Complexiteit:</strong> <?php echo e($product->complexity ?: 'Niet ingevuld'); ?></p>
            <p><strong>Duurzaamheid:</strong> <?php echo e($product->sustainability ?: 'Niet ingevuld'); ?></p>
            <p><strong>Unieke kenmerken:</strong> <?php echo e($product->unique_features ?: 'Niet ingevuld'); ?></p>

            <?php if((int) $product->maker_id === (int) auth()->id()): ?>
                <hr style="border:0; border-top:1px solid #d9e2ec; margin:1rem 0;">

                <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
                    <a href="<?php echo e(route('products.edit', $product)); ?>" style="padding:0.5rem 0.8rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68;">Product aanpassen</a>
                    <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="padding:0.5rem 0.8rem; border:0; border-radius:8px; background:#b91c1c; color:#fff; cursor:pointer;">Product verwijderen</button>
                    </form>
                </div>
            <?php endif; ?>
        </article>
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
<?php /**PATH C:\Users\daalm\DrinkOrDare\DrinkOrDare\MakersMarkt\resources\views/products/show.blade.php ENDPATH**/ ?>