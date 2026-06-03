import Lenis from 'lenis';
import { animate, inView } from 'motion';

function initLenis() {
    const lenis = new Lenis({
        lerp: 0.08,
        duration: 1.2,
        smoothWheel: true,
        touchMultiplier: 1.5,
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }

    requestAnimationFrame(raf);

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            const href = anchor.getAttribute('href');

            if (!href || href === '#') {
                return;
            }

            const target = document.querySelector(href);

            if (!target) {
                return;
            }

            event.preventDefault();
            lenis.scrollTo(target, { offset: -80 });
        });
    });

    return lenis;
}

function initScrollAnimations() {
    document.querySelectorAll('[data-animate]').forEach((element) => {
        inView(
            element,
            () => {
                animate(
                    element,
                    { opacity: [0, 1], y: [28, 0] },
                    { duration: 0.6, easing: [0.2, 0, 0, 1] },
                );
            },
            { margin: '-80px' },
        );
    });
}

function initNavigation() {
    const navLinks = document.querySelectorAll('[data-nav-link]');
    const sections = Array.from(navLinks)
        .map((link) => {
            const href = link.getAttribute('href');

            if (!href?.startsWith('#')) {
                return null;
            }

            return document.querySelector(href);
        })
        .filter((section) => section instanceof HTMLElement);

    if (sections.length === 0) {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (!visible?.target.id) {
                return;
            }

            navLinks.forEach((link) => {
                const href = link.getAttribute('href');
                const isActive = href === `#${visible.target.id}`;

                link.classList.toggle('font-bold', isActive);
                link.classList.toggle('border-b-2', isActive);
                link.classList.toggle('border-primary', isActive);
                link.classList.toggle('pb-1', isActive);
                link.classList.toggle('text-primary', isActive);
                link.classList.toggle('text-on-surface-variant', !isActive);
            });
        },
        { rootMargin: '-30% 0px -55% 0px', threshold: [0, 0.25, 0.5] },
    );

    sections.forEach((section) => observer.observe(section));
}

function initTestimonials() {
    const track = document.getElementById('testimonial-track');

    if (!track) {
        return;
    }

    const cards = track.querySelectorAll('[data-testimonial-card]');

    if (cards.length === 0) {
        return;
    }

    let index = 0;

    const scroll = (direction) => {
        const cardWidth = cards[0].offsetWidth + 24;
        index = Math.max(0, Math.min(index + direction, cards.length - 1));

        animate(track, { x: -index * cardWidth }, { duration: 0.5, easing: [0.2, 0, 0, 1] });
    };

    document.querySelector('[data-testimonial-prev]')?.addEventListener('click', () => scroll(-1));
    document.querySelector('[data-testimonial-next]')?.addEventListener('click', () => scroll(1));
}

function initBookingModal() {
    const modal = document.getElementById('booking-modal');
    const programSelect = modal?.querySelector('[data-booking-program-select]');

    if (!modal) {
        return;
    }

    const openModal = (programId = null) => {
        if (programSelect) {
            programSelect.value = programId ? String(programId) : '';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        const firstField = modal.querySelector('input, select, textarea');

        window.setTimeout(() => firstField?.focus(), 50);
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    };

    document.querySelectorAll('[data-booking-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const programId = trigger.getAttribute('data-coaching-program-id');

            openModal(programId);
        });
    });

    modal.querySelectorAll('[data-booking-close]').forEach((element) => {
        element.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
            closeModal();
        }
    });

    if (document.body.hasAttribute('data-booking-open-on-load')) {
        openModal(document.querySelector('[data-booking-program-select]')?.value || null);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initLenis();
    initScrollAnimations();
    initNavigation();
    initTestimonials();
    initBookingModal();
});
