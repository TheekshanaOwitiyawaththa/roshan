import Chart from 'chart.js/auto';

const CHART_PRIMARY = '#01261f';
const CHART_PRIMARY_SOFT = 'rgba(1, 38, 31, 0.08)';

function initSidebar() {
    const root = document.documentElement;
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-sidebar-overlay');
    const toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');
    const closeButtons = document.querySelectorAll('[data-sidebar-close]');
    const isDesktop = () => window.matchMedia('(min-width: 1024px)').matches;
    const isCollapsed = () => root.dataset.sidebarCollapsed === 'true';

    const setCollapsed = (collapsed) => {
        if (collapsed) {
            root.dataset.sidebarCollapsed = 'true';
            localStorage.setItem('admin-sidebar-collapsed', 'true');
        } else {
            delete root.dataset.sidebarCollapsed;
            localStorage.setItem('admin-sidebar-collapsed', 'false');
        }
    };

    if (localStorage.getItem('admin-sidebar-collapsed') === 'true' && isDesktop()) {
        setCollapsed(true);
    }

    const setMobileOpen = (open) => {
        if (isDesktop()) {
            return;
        }

        sidebar?.classList.toggle('-translate-x-full', !open);
        sidebar?.classList.toggle('translate-x-0', open);
        overlay?.classList.toggle('hidden', !open);
        document.body.classList.toggle('overflow-hidden', open);
    };

    const toggleSidebar = () => {
        if (!isDesktop()) {
            setMobileOpen(sidebar?.classList.contains('-translate-x-full') ?? true);

            return;
        }

        setCollapsed(!isCollapsed());
    };

    toggleButtons.forEach((button) => button.addEventListener('click', toggleSidebar));
    closeButtons.forEach((button) => button.addEventListener('click', () => setMobileOpen(false)));
    overlay?.addEventListener('click', () => setMobileOpen(false));

    if (isDesktop()) {
        sidebar?.classList.remove('-translate-x-full');
        sidebar?.classList.add('translate-x-0');
    } else {
        setMobileOpen(false);
    }

    window.addEventListener('resize', () => {
        if (isDesktop()) {
            overlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            sidebar?.classList.remove('-translate-x-full');
            sidebar?.classList.add('translate-x-0');

            if (localStorage.getItem('admin-sidebar-collapsed') === 'true') {
                setCollapsed(true);
            }
        } else {
            delete root.dataset.sidebarCollapsed;
            setMobileOpen(false);
        }
    });
}

function initUserMenu() {
    const button = document.getElementById('admin-user-menu-button');
    const menu = document.getElementById('admin-user-menu');

    if (!button || !menu) {
        return;
    }

    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', (event) => {
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
}

function initCharts() {
    document.querySelectorAll('[data-chart]').forEach((canvas) => {
        const type = canvas.dataset.chart;
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const values = JSON.parse(canvas.dataset.values || '[]');
        const colors = JSON.parse(canvas.dataset.colors || '[]');

        if (type === 'line') {
            new Chart(canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        {
                            label: 'Booking requests',
                            data: values,
                            borderColor: CHART_PRIMARY,
                            backgroundColor: CHART_PRIMARY_SOFT,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: CHART_PRIMARY,
                            borderWidth: 2,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: '#64748b', font: { size: 12 } },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#64748b', font: { size: 12 } },
                            grid: { color: '#f1f5f9' },
                            border: { display: false },
                        },
                    },
                },
            });

            return;
        }

        if (type === 'doughnut') {
            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{ data: values, backgroundColor: colors, borderWidth: 0 }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: { legend: { display: false } },
                },
            });
        }
    });
}

function initIconPickers() {
    document.querySelectorAll('[data-icon-picker]').forEach((root) => {
        const input = root.querySelector('[data-icon-picker-input]');
        const search = root.querySelector('[data-icon-picker-search]');
        const previewIcon = root.querySelector('[data-icon-picker-preview-icon]');
        const previewLabel = root.querySelector('[data-icon-picker-preview-label]');
        const previewName = root.querySelector('[data-icon-picker-preview-name]');
        const emptyState = root.querySelector('[data-icon-picker-empty]');
        const options = root.querySelectorAll('[data-icon-picker-option]');
        const groups = root.querySelectorAll('[data-icon-picker-group]');

        if (!input || options.length === 0) {
            return;
        }

        const formatLabel = (icon) => icon.replace(/_/g, ' ');

        const setSelected = (icon) => {
            input.value = icon;

            if (previewIcon) {
                previewIcon.textContent = icon;
            }

            if (previewLabel) {
                previewLabel.textContent = formatLabel(icon);
            }

            if (previewName) {
                previewName.textContent = icon;
            }

            options.forEach((button) => {
                const isSelected = button.dataset.iconPickerOption === icon;

                button.classList.toggle('border-primary', isSelected);
                button.classList.toggle('bg-primary/10', isSelected);
                button.classList.toggle('text-primary', isSelected);
                button.classList.toggle('ring-2', isSelected);
                button.classList.toggle('ring-primary/20', isSelected);
                button.classList.toggle('border-transparent', !isSelected);
                button.classList.toggle('bg-slate-50', !isSelected);
                button.classList.toggle('text-slate-600', !isSelected);
            });
        };

        const applySearch = () => {
            const query = (search?.value ?? '').trim().toLowerCase();
            let visibleCount = 0;

            groups.forEach((group) => {
                let groupVisible = 0;

                group.querySelectorAll('[data-icon-picker-option]').forEach((button) => {
                    const icon = button.dataset.iconPickerOption ?? '';
                    const matches = query === '' || icon.includes(query);

                    button.classList.toggle('hidden', !matches);

                    if (matches) {
                        groupVisible += 1;
                        visibleCount += 1;
                    }
                });

                group.classList.toggle('hidden', groupVisible === 0);
            });

            emptyState?.classList.toggle('hidden', visibleCount > 0);
        };

        options.forEach((button) => {
            button.addEventListener('click', () => {
                const icon = button.dataset.iconPickerOption;

                if (icon) {
                    setSelected(icon);
                }
            });
        });

        search?.addEventListener('input', applySearch);
        applySearch();
    });
}

const TOAST_DURATION_MS = 5000;

function dismissToast(toast) {
    if (!toast || toast.classList.contains('is-leaving')) {
        return;
    }

    toast.classList.remove('is-visible');
    toast.classList.add('is-leaving');

    toast.addEventListener(
        'animationend',
        () => {
            toast.remove();

            const stack = document.getElementById('admin-toast-stack');

            if (stack && stack.children.length === 0) {
                stack.remove();
            }
        },
        { once: true },
    );
}

function mountToast(toast) {
    const duration = Number.parseInt(toast.dataset.duration || String(TOAST_DURATION_MS), 10);
    const progress = toast.querySelector('[data-admin-toast-progress]');

    if (progress) {
        progress.style.setProperty('--toast-duration', `${duration}ms`);
    }

    requestAnimationFrame(() => {
        toast.classList.add('is-visible');
    });

    const closeButton = toast.querySelector('[data-admin-toast-close');
    closeButton?.addEventListener('click', () => dismissToast(toast));

    window.setTimeout(() => dismissToast(toast), duration);
}

function createToastElement(variant, title, message, duration = TOAST_DURATION_MS) {
    const variants = {
        success: {
            defaultTitle: 'Success',
            icon: 'check_circle',
            iconBg: 'bg-emerald-50',
            iconColor: 'text-emerald-500',
            progress: 'bg-emerald-500',
        },
        warning: {
            defaultTitle: 'Warning',
            icon: 'warning',
            iconBg: 'bg-amber-50',
            iconColor: 'text-amber-500',
            progress: 'bg-amber-500',
        },
        error: {
            defaultTitle: 'Error',
            icon: 'close',
            iconBg: 'bg-rose-50',
            iconColor: 'text-rose-500',
            progress: 'bg-rose-500',
        },
    };

    const config = variants[variant] ?? variants.success;

    const toast = document.createElement('div');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('data-admin-toast', '');
    toast.dataset.duration = String(duration);
    toast.className =
        'pointer-events-auto relative w-full overflow-hidden rounded-admin-surface border border-slate-200/90 bg-white shadow-admin-card-hover translate-x-8 opacity-0';

    toast.innerHTML = `
        <div class="flex gap-3 p-4 pr-10">
            <span class="flex size-10 shrink-0 items-center justify-center rounded-admin-control ${config.iconBg} ${config.iconColor}">
                <span class="material-symbols-outlined material-symbol text-[22px]">${config.icon}</span>
            </span>
            <div class="min-w-0 pt-0.5">
                <p class="text-sm font-semibold text-slate-900"></p>
                <p class="mt-0.5 text-sm text-slate-500"></p>
            </div>
        </div>
        <button type="button" data-admin-toast-close class="absolute top-3 right-3 rounded-admin-control p-1 text-slate-400 transition-colors hover:bg-slate-50 hover:text-slate-600" aria-label="Dismiss notification">
            <span class="material-symbols-outlined material-symbol text-lg">close</span>
        </button>
        <div class="h-1 bg-slate-100">
            <div data-admin-toast-progress class="h-full ${config.progress}"></div>
        </div>
    `;

    const [titleEl, messageEl] = toast.querySelectorAll('p');
    titleEl.textContent = title || config.defaultTitle;
    messageEl.textContent = message;

    return toast;
}

function ensureToastStack() {
    let stack = document.getElementById('admin-toast-stack');

    if (!stack) {
        stack = document.createElement('div');
        stack.id = 'admin-toast-stack';
        stack.className =
            'pointer-events-none fixed top-20 right-4 z-[60] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3 sm:right-6';
        stack.setAttribute('aria-live', 'polite');
        stack.setAttribute('aria-atomic', 'true');
        document.body.appendChild(stack);
    }

    return stack;
}

function showAdminToast(variant, message, title = null, duration = TOAST_DURATION_MS) {
    const stack = ensureToastStack();
    const toast = createToastElement(variant, title, message, duration);

    stack.appendChild(toast);
    mountToast(toast);
}

function initToasts() {
    document.querySelectorAll('[data-admin-toast]').forEach(mountToast);
}

window.showAdminToast = showAdminToast;

const DATA_TABLE_SEARCH_DELAY_MS = 350;

function submitAdminDataTableForm() {
    const form = document.getElementById('admin-data-table-form');

    if (!form) {
        return;
    }

    form.requestSubmit();
}

function initDataTables() {
    const form = document.getElementById('admin-data-table-form');

    if (!form) {
        return;
    }

    let searchTimer;

    form.querySelectorAll('[data-admin-data-table-search]').forEach((input) => {
        input.addEventListener('input', () => {
            window.clearTimeout(searchTimer);
            searchTimer = window.setTimeout(submitAdminDataTableForm, DATA_TABLE_SEARCH_DELAY_MS);
        });

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                window.clearTimeout(searchTimer);
                submitAdminDataTableForm();
            }
        });
    });

    document.querySelectorAll('[data-admin-data-table-filter], [data-admin-data-table-per-page]').forEach((control) => {
        control.addEventListener('change', submitAdminDataTableForm);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initUserMenu();
    initCharts();
    initIconPickers();
    initToasts();
    initDataTables();
});
