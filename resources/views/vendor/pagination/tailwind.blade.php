@if ($paginator->hasPages())
<nav class="pagination-nav" aria-label="Navigasi halaman">
    <div class="pagination-info">
        @if ($paginator->firstItem())
            Menampilkan <strong>{{ $paginator->firstItem() }}</strong> &ndash; <strong>{{ $paginator->lastItem() }}</strong>
            dari <strong>{{ $paginator->total() }}</strong> data
        @else
            {{ $paginator->count() }} data
        @endif
    </div>

    <div class="pagination">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled" aria-disabled="true">
                <span class="page-link">&laquo;</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-item" aria-label="Sebelumnya">
                <span class="page-link">&laquo;</span>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-item disabled"><span class="page-link">{{ $element }}</span></span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </span>
                    @else
                        <a href="{{ $url }}" class="page-item" aria-label="Halaman {{ $page }}">
                            <span class="page-link">{{ $page }}</span>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-item" aria-label="Berikutnya">
                <span class="page-link">&raquo;</span>
            </a>
        @else
            <span class="page-item disabled" aria-disabled="true">
                <span class="page-link">&raquo;</span>
            </span>
        @endif
    </div>
</nav>
@endif
