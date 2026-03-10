@if ($paginator->hasPages())
<nav class="pagination">
    @if ($paginator->onFirstPage())
    <span class="disabled">
        &larr; Previous
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
        &larr; Previous
    </a>
    @endif

    <span class="meta">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </span>

    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next">
        Next &rarr;
    </a>
    @else
    <span class="disabled">
        Next &rarr;
    </span>
    @endif
</nav>
@endif