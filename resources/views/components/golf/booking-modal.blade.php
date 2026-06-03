@props([
    'coachingPrograms',
    'locations',
])

<div
    id="booking-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="booking-modal-title"
    aria-hidden="true"
>
    <div
        data-booking-close
        class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
        aria-hidden="true"
    ></div>

    <div class="relative z-10 flex max-h-[min(90vh,52rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl border border-outline-variant/30 bg-surface shadow-2xl">
        <div class="flex shrink-0 items-start justify-between gap-4 border-b border-outline-variant/20 px-6 py-5 sm:px-8">
            <div>
                <p class="mb-1 font-display text-label-sm tracking-[0.15em] text-secondary uppercase">Book a lesson</p>
                <h2 id="booking-modal-title" class="font-display text-headline-sm text-primary">Request an appointment</h2>
                <p class="mt-1 text-sm text-on-surface-variant">We will confirm your booking by email or phone.</p>
            </div>
            <button
                type="button"
                data-booking-close
                class="flex size-10 shrink-0 items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container"
                aria-label="Close booking form"
            >
                <span class="material-symbols-outlined text-2xl leading-none">close</span>
            </button>
        </div>

        <div class="overflow-y-auto px-6 py-6 sm:px-8" data-lenis-prevent>
            <x-golf.appointment-form
                :coaching-programs="$coachingPrograms"
                :locations="$locations"
                form-id="booking-modal-form"
            />
        </div>
    </div>
</div>
