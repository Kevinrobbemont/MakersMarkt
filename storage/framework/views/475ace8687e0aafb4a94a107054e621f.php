<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'MakersMarkt - Product Aanpassen']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('MakersMarkt - Product Aanpassen')]); ?>
    <section>
        <h1>Product aanpassen</h1>
        <p class="muted">Alleen de eigenaar van dit product kan wijzigingen opslaan.</p>

        <?php if($errors->any()): ?>
        <article class="alert alert-error">
            <h3 style="margin:0 0 0.5rem;">Controleer je invoer</h3>
            <ul style="margin:0; padding-left:1.2rem;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </article>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('products.update', $product)); ?>" class="card form-card">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <label class="field">
                <strong>Naam *</strong><br>
                <input name="name" value="<?php echo e(old('name', $product->name)); ?>" required>
            </label>

            <label class="field">
                <strong>Beschrijving *</strong><br>
                <textarea name="description" required rows="4"><?php echo e(old('description', $product->description)); ?></textarea>
            </label>

            <label class="field">
                <strong>Categorie *</strong><br>
                <select name="category_id" required>
                    <option value="">Kies een categorie</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php if((int) old('category_id', $product->category_id) === (int) $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>

            <label class="field">
                <strong>Prijs in euro's *</strong><br>
                <input name="price" type="number" step="0.01" min="0.01" value="<?php echo e(old('price', $product->price)); ?>" placeholder="Bijv. 25.99" required>
            </label>

            <label class="field">
                <strong>Type</strong><br>
                <input name="type" value="<?php echo e(old('type', $product->material)); ?>" placeholder="Bijv. keramiek, hout, textiel">
            </label>

            <label class="field">
                <strong>Productietijd</strong><br>
                <input name="production_time" value="<?php echo e(old('production_time', $product->production_time)); ?>" placeholder="Bijv. 1-2 weken, 3-5 dagen">
            </label>

            <label class="field">
                <strong>Complexiteit</strong><br>
                <select name="complexity">
                    <option value="">Kies complexiteit</option>
                    <option value="Laag" <?php if(old('complexity', $product->complexity)=='Laag'): echo 'selected'; endif; ?>>Laag</option>
                    <option value="Gemiddeld" <?php if(old('complexity', $product->complexity)=='Gemiddeld'): echo 'selected'; endif; ?>>Gemiddeld</option>
                    <option value="Hoog" <?php if(old('complexity', $product->complexity)=='Hoog'): echo 'selected'; endif; ?>>Hoog</option>
                </select>
            </label>

            <label class="field">
                <strong>Specificaties</strong><br>
                <textarea name="specifications" rows="3" placeholder="Extra details over afwerking, formaat, materiaal..."><?php echo e(old('specifications', $product->unique_features)); ?></textarea>
            </label>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">Wijzigingen opslaan</button>
                <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-secondary">Annuleren</a>
            </div>
        </form>
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
<?php endif; ?><?php /**PATH C:\laragon\www\MakersMarkt\resources\views/products/edit.blade.php ENDPATH**/ ?>