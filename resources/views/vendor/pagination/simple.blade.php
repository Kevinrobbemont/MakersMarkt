@if ($paginator->hasPages())
    <nav style="display:flex; gap:0.5rem; align-items:center; justify-content:center; margin-top:1.5rem;">
        @if ($paginator->onFirstPage())
            <span style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; color:#94a2b8; cursor:not-allowed;">
                &larr; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68; background:#fff;">
                &larr; Previous
            </a>
        @endif

        <span style="padding:0.5rem 0.85rem; color:#334e68;">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; text-decoration:none; color:#334e68; background:#fff;">
                Next &rarr;
            </a>
        @else
            <span style="padding:0.5rem 0.85rem; border:1px solid #cbd2d9; border-radius:8px; color:#94a2b8; cursor:not-allowed;">
                Next &rarr;
            </span>
        @endif
    </nav>
@endif
