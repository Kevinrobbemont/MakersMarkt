<?php if($paginator->hasPages()): ?>
<nav class="pagination">
    <?php if($paginator->onFirstPage()): ?>
    <span class="disabled">
        &larr; Previous
    </span>
    <?php else: ?>
    <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
        &larr; Previous
    </a>
    <?php endif; ?>

    <span class="meta">
        Showing <?php echo e($paginator->firstItem()); ?> to <?php echo e($paginator->lastItem()); ?> of <?php echo e($paginator->total()); ?> results
    </span>

    <?php if($paginator->hasMorePages()): ?>
    <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
        Next &rarr;
    </a>
    <?php else: ?>
    <span class="disabled">
        Next &rarr;
    </span>
    <?php endif; ?>
</nav>
<?php endif; ?><?php /**PATH C:\Users\daalm\DrinkOrDare\DrinkOrDare\MakersMarkt\resources\views/vendor/pagination/simple.blade.php ENDPATH**/ ?>