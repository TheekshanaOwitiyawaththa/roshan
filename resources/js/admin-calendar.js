import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

function initAdminCalendar() {
    const element = document.getElementById('admin-calendar');

    if (!element) {
        return;
    }

    const eventsUrl = element.dataset.eventsUrl;

    if (!eventsUrl) {
        return;
    }

    const calendar = new Calendar(element, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
        },
        height: 'auto',
        navLinks: true,
        nowIndicator: true,
        editable: false,
        selectable: false,
        dayMaxEvents: 3,
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short',
        },
        events: {
            url: eventsUrl,
            method: 'GET',
            failure() {
                window.showAdminToast?.(
                    'error',
                    'Could not load calendar events. Please refresh the page.',
                );
            },
        },
        eventClick(info) {
            if (info.event.url) {
                info.jsEvent.preventDefault();
                window.location.href = info.event.url;
            }
        },
        loading(isLoading) {
            element.classList.toggle('is-loading', isLoading);
        },
    });

    calendar.render();
}

document.addEventListener('DOMContentLoaded', initAdminCalendar);
