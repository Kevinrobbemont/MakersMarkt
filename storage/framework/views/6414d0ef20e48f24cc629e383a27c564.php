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
        <div class="section-head">
            <div>
                <h1>Producten</h1>
                <p class="muted">Catalogus met zoeken en filteren. Kopers zien enkel goedgekeurde producten.</p>
            </div>

            <?php if(auth()->user()?->role?->name === 'maker' || auth()->user()?->role?->name === 'admin'): ?>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">Product toevoegen</a>
            <?php endif; ?>
        </div>

        <?php if(session('status')): ?>
        <article class="alert alert-success">
            <p style="margin:0;"><?php echo e(session('status')); ?></p>
        </article>
        <?php endif; ?>

        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="card form-card" style="margin-bottom:1rem;">
            <label class="field">
                <strong>Zoeken</strong><br>
                <input name="q" value="<?php echo e($search); ?>" placeholder="Naam, beschrijving of specificaties">
            </label>

            <label class="field">
                <strong>Categorie (Type)</strong><br>
                <select name="category_id">
                    <option value="">Alle categorieen</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if($selectedCategory===$category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            <label class="field">
                <strong>Materiaal</strong><br>
                <select name="material">
                    <option value="">Alle materialen</option>
                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($material); ?>" <?php if($selectedMaterial===$material): echo 'selected'; endif; ?>><?php echo e($material); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            <label class="field">
                <strong>Productietijd</strong><br>
                <select name="production_time">
                    <option value="">Alle productietijden</option>
                    <?php $__currentLoopData = $productionTimes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($time); ?>" <?php if($selectedProductionTime===$time): echo 'selected'; endif; ?>><?php echo e($time); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            <label class="field">
                <strong>Complexiteit</strong><br>
                <select name="complexity">
                    <option value="">Alle complexiteitsniveaus</option>
                    <?php $__currentLoopData = $complexities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complexity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($complexity); ?>" <?php if($selectedComplexity===$complexity): echo 'selected'; endif; ?>><?php echo e($complexity); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">Filter toepassen</button>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Reset</a>
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
                    <a href="<?php echo e(route('products.show', $product)); ?>" class="subtle-link">Bekijk details</a>
                </p>

                <?php if(($isMaker && (int) $product->maker_id === (int) auth()->id()) || $isAdmin): ?>
                <div class="btn-row" style="margin-top:0.5rem;">
                    <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-secondary">Aanpassen</a>
                    <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" onsubmit="return confirm('Weet je zeker dat je dit product wil verwijderen?');" style="margin:0;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">Verwijderen</button>
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