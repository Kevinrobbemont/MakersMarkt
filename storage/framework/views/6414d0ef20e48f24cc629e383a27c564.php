<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'MakersMarkt - Producten']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MakersMarkt - Producten')]); ?>
    <section>
        <h1>Producten</h1>
        <p class="muted">Catalogus met zoeken en filteren. Kopers zien enkel goedgekeurde producten.</p>

        <?php if(session('status')): ?>
            <article class="card" style="margin-bottom:1rem; border-color:#86efac;">
                <p style="margin:0; color:#166534;"><?php echo e(session('status')); ?></p>
            </article>
        <?php endif; ?>

        <?php if(auth()->user()?->role?->name === 'maker' || auth()->user()?->role?->name === 'admin'): ?>
            <p style="margin-bottom:1rem;">
                <a href="<?php echo e(route('products.create')); ?>" style="display:inline-block; padding:0.55rem 0.9rem; border-radius:8px; background:#0f766e; color:#fff; font-weight:700; text-decoration:none;">
                    Product toevoegen
                </a>
            </p>
        <?php endif; ?>

        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="card" style="display:grid; gap:0.8rem; margin-bottom:1rem;">
            <label>
                <strong>Zoeken</strong><br>
                <input name="q" value="<?php echo e($search); ?>" placeholder="Naam, beschrijving of specificaties" style="width:100%; padding:0.55rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
            </label>

            <label>
                <strong>Categorie</strong><br>
                <select name="category_id" style="width:100%; padding:0.55rem; margin-top:0.3rem; border:1px solid #cbd2d9; border-radius:8px;">
                    <option value="">Alle categorieen</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php if($selectedCategory === $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            <div style="display:flex; gap:0.6rem; flex-wrap:wrap;">
                <button type="submit" style="padding:0.5rem 0.85rem; border:0; border-radius:8px; background:#0f766e; color:#fff; font-weight:700; cursor:pointer;">Filter toepassen</button>
                <a href="<?php echo e(route('products.index')); ?>" style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68;">Reset</a>
            </div>
        </form>

        <div class="grid cols-3">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="card">
                    <span class="pill"><?php echo e($product->category?->name ?? 'Onbekend'); ?></span>
                    <h3><?php echo e($product->name); ?></h3>
                    <p class="muted">Maker: <?php echo e($product->maker?->name ?? 'Onbekend'); ?></p>
                    <p><?php echo e($product->description); ?></p>
                    <p class="muted">
                        Status:
                        <?php echo e($product->is_approved ? 'goedgekeurd' : 'niet goedgekeurd'); ?>

                    </p>

                    <p style="margin-top:0.7rem;">
                        <a href="<?php echo e(route('products.show', $product)); ?>" style="color:#0f766e; font-weight:700; text-decoration:none;">Bekijk details</a>
                    </p>

                    <?php if(($isMaker && (int) $product->maker_id === (int) auth()->id()) || $isAdmin): ?>
                        <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-top:0.5rem;">
                            <a href="<?php echo e(route('products.edit', $product)); ?>" style="padding:0.4rem 0.65rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68;">Aanpassen</a>
                            <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="padding:0.4rem 0.65rem; border:0; border-radius:8px; background:#b91c1c; color:#fff; cursor:pointer;">Verwijderen</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($products->isEmpty()): ?>
            <article class="card" style="margin-top:1rem;">
                <p class="muted" style="margin:0;">Nog geen producten beschikbaar.</p>
            </article>
        <?php else: ?>
            <?php echo e($products->links('pagination::simple')); ?>

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
<?php endif; ?><?php /**PATH C:\Users\daalm\DrinkOrDare\DrinkOrDare\MakersMarkt\resources\views/products/index.blade.php ENDPATH**/ ?>