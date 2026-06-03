<x-mail::message>
# New booking received

<p class="lead">A new lesson request was submitted through the website. Review the details below and follow up from the admin panel when ready.</p>

@include('mail.components.appointment-details', ['appointment' => $appointment])

<x-mail::button :url="route('admin.appointments.show', $appointment)">
Open in admin
</x-mail::button>

@include('mail.components.email-signature')
</x-mail::message>
