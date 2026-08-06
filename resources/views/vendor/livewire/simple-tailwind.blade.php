@php
    $pageName = $paginator->getPageName();
@endphp

@if ($paginator->hasPages())
<nav class="pagination-nav" aria-label="Navigasi halaman">
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <span class="page-item disabled">
                <span class="page-link">&laquo; Sebelumnya</span>
            </span>
        @else
            <button type="button"
                wire:click="previousPage('{{ $pageName }}')"
                wire:loading.attr="disabled"
                class="page-item">
                <span class="page-link">&laquo; Sebelumnya</span>
            </button>
        @endif

        @if ($paginator->hasMorePages())
            <button type="button"
                wire:click="nextPage('{{ $pageName }}')"
                wire:loading.attr="disabled"
                class="page-item">
                <span class="page-link">Berikutnya &raquo;</span>
            </button>
        @else
            <span class="page-item disabled">
                <span class="page-link">Berikutnya &raquo;</span>
            </span>
        @endif
    </div>
</nav>
@endif
