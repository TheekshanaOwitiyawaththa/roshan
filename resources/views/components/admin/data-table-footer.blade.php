@props([
    'paginator',
    'perPage',
    'perPageOptions' => [5, 10, 15, 25, 50],
])

<div class="flex flex-col gap-4 border-t border-slate-100 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-sm text-slate-500">
        @if ($paginator->total() > 0)
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries
        @else
            Showing 0 entries
        @endif
    </p>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <span class="whitespace-nowrap">Rows per page</span>
            <select
                name="per_page"
                form="admin-data-table-form"
                data-admin-data-table-per-page
                class="rounded-admin-control border border-slate-200 bg-white py-1.5 pr-8 pl-2.5 text-sm text-slate-800 outline-none focus:border-primary focus:ring-2 focus:ring-primary/15"
            >
                @foreach ($perPageOptions as $option)
                    <option value="{{ $option }}" @selected((int) $perPage === $option)>{{ $option }}</option>
                @endforeach
            </select>
        </label>

        @if ($paginator->hasPages())
            {{ $paginator->links('components.admin.data-table-pagination') }}
        @endif
    </div>
</div>
