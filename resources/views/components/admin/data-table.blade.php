@props([
    'title',
    'description' => null,
    'paginator',
    'search' => '',
    'perPage' => 10,
    'formAction' => null,
    'createHref' => null,
    'createLabel' => 'Add',
    'minWidth' => '640px',
])

@php
    use App\Support\AdminCsvExport;

    $formAction = $formAction ?? url()->current();
    $query = request()->except(['page', 'export']);
    $exportUrl = $formAction.'?'.http_build_query([...$query, 'export' => 'csv']);
    $perPageOptions = AdminCsvExport::PER_PAGE_OPTIONS;
@endphp

<div {{ $attributes->class(['overflow-hidden rounded-admin-surface border border-slate-200/90 bg-white shadow-admin-card']) }}>
    <div class="border-b border-slate-100 px-6 py-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-slate-900">{{ $title }}</h2>
                @if ($description)
                    <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
                @endif
            </div>
            @if ($createHref)
                <x-admin.button :href="$createHref" variant="primary" class="shrink-0">
                    <span class="material-symbols-outlined material-symbol text-lg">add</span>
                    {{ $createLabel }}
                </x-admin.button>
            @endif
        </div>

        <form
            id="admin-data-table-form"
            method="GET"
            action="{{ $formAction }}"
            class="mt-5 flex flex-col gap-3 lg:flex-row lg:items-center"
        >
            <div class="relative min-w-0 flex-1">
                <span class="material-symbols-outlined material-symbol pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-[20px] text-slate-400">search</span>
                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Search…"
                    class="admin-input pl-10"
                    data-admin-data-table-search
                    autocomplete="off"
                >
            </div>

            @isset($filters)
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    {{ $filters }}
                </div>
            @endisset

            <a
                href="{{ $exportUrl }}"
                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-admin-control border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 lg:ml-auto"
            >
                <span class="material-symbols-outlined material-symbol text-lg">download</span>
                Download CSV
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm" style="min-width: {{ $minWidth }}">
            <thead class="border-b border-slate-100 bg-slate-50/80 text-slate-500">
                {{ $head ?? '' }}
            </thead>
            <tbody class="divide-y divide-slate-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        <x-admin.data-table-footer :paginator="$paginator" :per-page="$perPage" :per-page-options="$perPageOptions" />
    @endif
</div>
