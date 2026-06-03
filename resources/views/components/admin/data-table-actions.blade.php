@props([
    'editHref',
    'deleteAction',
    'deleteConfirm' => 'Delete this record?',
])

<div class="flex items-center justify-end gap-1">
    <a
        href="{{ $editHref }}"
        class="flex size-8 items-center justify-center rounded-admin-control text-slate-500 transition-colors hover:bg-slate-100 hover:text-primary"
        aria-label="Edit"
    >
        <span class="material-symbols-outlined material-symbol text-lg">edit</span>
    </a>
    <form method="POST" action="{{ $deleteAction }}" class="inline" onsubmit="return confirm(@js($deleteConfirm))">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            class="flex size-8 items-center justify-center rounded-admin-control text-slate-500 transition-colors hover:bg-red-50 hover:text-red-600"
            aria-label="Delete"
        >
            <span class="material-symbols-outlined material-symbol text-lg">delete</span>
        </button>
    </form>
</div>
