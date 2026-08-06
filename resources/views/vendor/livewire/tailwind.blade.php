@php
    $pageName = $paginator->getPageName();
@endphp

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
            <span class="page-item disabled">
                <span class="page-link">&laquo;</span>
            </span>
        @else
            <button type="button"
                wire:click="previousPage('{{ $pageName }}')"
                wire:loading.attr="disabled"
                class="page-item"
                aria-label="Sebelumnya">
                <span class="page-link">&laquo;</span>
            </button>
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
                        <button type="button"
                            wire:click="gotoPage({{ $page }}, '{{ $pageName }}')"
                            wire:loading.attr="disabled"
                            class="page-item"
                            aria-label="Halaman {{ $page }}">
                            <span class="page-link">{{ $page }}</span>
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <button type="button"
                wire:click="nextPage('{{ $pageName }}')"
                wire:loading.attr="disabled"
                class="page-item"
                aria-label="Berikutnya">
                <span class="page-link">&raquo;</span>
            </button>
        @else
            <span class="page-item disabled">
                <span class="page-link">&raquo;</span>
            </span>
        @endif
    </div>
</nav>
@endif
