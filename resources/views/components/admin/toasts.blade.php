@php
    $toasts = [];

    if (session('status')) {
        $toasts[] = ['variant' => 'success', 'message' => session('status')];
    }

    if (session('success')) {
        $toasts[] = ['variant' => 'success', 'message' => session('success')];
    }

    if (session('warning')) {
        $toasts[] = ['variant' => 'warning', 'message' => session('warning')];
    }

    if (session('error')) {
        $toasts[] = ['variant' => 'error', 'message' => session('error')];
    }

    if ($errors->any()) {
        $toasts[] = [
            'variant' => 'error',
            'message' => $errors->count() === 1
                ? $errors->first()
                : collect($errors->all())->implode(' '),
        ];
    }
@endphp

@if (count($toasts) > 0)
    <div
        id="admin-toast-stack"
        class="pointer-events-none fixed top-20 right-4 z-[60] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3 sm:right-6"
        aria-live="polite"
        aria-atomic="true"
    >
        @foreach ($toasts as $toast)
            <x-admin.toast
                :variant="$toast['variant']"
                :message="$toast['message']"
                :title="$toast['title'] ?? null"
            />
        @endforeach
    </div>
@endif
