<x-mail::message>
# Thank you, {{ $appointment->name }}

<p class="lead">Your lesson booking request is confirmed on our side. A member of the coaching team will review your details and be in touch shortly.</p>

@include('mail.components.appointment-details', ['appointment' => $appointment])

<p class="sub">Need to update your request? Simply reply to this email and we will take care of it.</p>

@include('mail.components.email-signature')
</x-mail::message>
