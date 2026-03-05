<?php if($paginator->hasPages()): ?>
    <nav style="display:flex; gap:0.5rem; align-items:center; justify-content:center; margin-top:1.5rem;">
        <?php if($paginator->onFirstPage()): ?>
            <span style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; color:#94a2b8; cursor:not-allowed;">
                &larr; Previous
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68; background:#fff;">
                &larr; Previous
            </a>
        <?php endif; ?>

        <span style="padding:0.5rem 0.85rem; color:#334e68;">
            Showing <?php echo e($paginator->firstItem()); ?> to <?php echo e($paginator->lastItem()); ?> of <?php echo e($paginator->total()); ?> results
        </span>

        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68; background:#fff;">
                Next &rarr;
            </a>
        <?php else: ?>
            <span style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; color:#94a2b8; cursor:not-allowed;">
                Next &rarr;
            </span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\daalm\DrinkOrDare\DrinkOrDare\MakersMarkt\resources\views/vendor/pagination/simple.blade.php ENDPATH**/ ?>