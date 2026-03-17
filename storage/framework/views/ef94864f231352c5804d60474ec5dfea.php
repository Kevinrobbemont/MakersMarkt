<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'MakersMarkt - Producten modereren']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MakersMarkt - Producten modereren')]); ?>
    <section>
        <div class="section-head">
            <div>
                <h1>Producten modereren</h1>
                <p class="muted">Hier zie je alle producten die nog niet zijn goedgekeurd.</p>
            </div>

            <div class="btn-row">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Terug naar catalogus</a>
            </div>
        </div>

        <?php if(session('status')): ?>
            <article class="alert alert-success">
                <p style="margin:0;"><?php echo e(session('status')); ?></p>
            </article>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <article class="alert alert-error">
                <p style="margin:0;"><?php echo e(session('error')); ?></p>
            </article>
        <?php endif; ?>

        <?php if($products->isEmpty()): ?>
            <article class="card">
                <p class="muted" style="margin:0;">Er staan op dit moment geen producten te wachten op goedkeuring.</p>
            </article>
        <?php else: ?>
            <div class="grid cols-3">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card">
                        <span class="pill"><?php echo e($product->category?->name ?? 'Onbekend'); ?></span>
                        <h3><?php echo e($product->name); ?></h3>
                        <p class="muted">Maker: <?php echo e($product->maker?->name ?? 'Onbekend'); ?></p>
                        <p><?php echo e($product->description); ?></p>

                        <p style="color: #2ecc71; font-weight: bold; margin: 0.5rem 0;">
                            €<?php echo e(number_format($product->price, 2, ',', '.')); ?>

                        </p>

                        <p class="muted">Status: niet goedgekeurd</p>

                        <?php if($product->has_external_links): ?>
                            <p style="color:#b45309; font-weight:700;">Bevat mogelijk externe links</p>
                        <?php endif; ?>

                        <div class="btn-row" style="margin-top:1rem;">
                            <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-secondary">Bekijken</a>

                            <form method="POST" action="<?php echo e(route('products.approve', $product)); ?>" style="margin:0;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-primary">Goedkeuren</button>
                            </form>

                            <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">Verwijderen</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div style="margin-top:1rem;">
                <?php echo e($products->links('pagination::simple')); ?>

            </div>
        <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\MakersMarkt\resources\views/products/moderation.blade.php ENDPATH**/ ?>