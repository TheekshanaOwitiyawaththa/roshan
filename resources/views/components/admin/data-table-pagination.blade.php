@if ($paginator->hasPages())
    <nav class="flex items-center gap-1" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="flex size-9 items-center justify-center rounded-admin-control text-slate-300" aria-hidden="true">
                <span class="material-symbols-outlined material-symbol text-xl">chevron_left</span>
            </span>
        @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="flex size-9 items-center justify-center rounded-admin-control text-slate-600 transition-colors hover:bg-slate-100"
                aria-label="Previous page"
            >
                <span class="material-symbols-outlined material-symbol text-xl">chevron_left</span>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="flex size-9 items-center justify-center text-sm text-slate-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="flex size-9 items-center justify-center rounded-admin-control bg-primary text-sm font-semibold text-on-primary" aria-current="page">{{ $page }}</span>
                    @else
                        <a
                            href="{{ $url }}"
                            class="flex size-9 items-center justify-center rounded-admin-control text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100"
                        >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="flex size-9 items-center justify-center rounded-admin-control text-slate-600 transition-colors hover:bg-slate-100"
                aria-label="Next page"
            >
                <span class="material-symbols-outlined material-symbol text-xl">chevron_right</span>
            </a>
        @else
            <span class="flex size-9 items-center justify-center rounded-admin-control text-slate-300" aria-hidden="true">
                <span class="material-symbols-outlined material-symbol text-xl">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
