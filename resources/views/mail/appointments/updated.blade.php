<x-mail::message>
# Your booking has been updated

<p class="lead">Hi {{ $appointment->name }}, we have updated your lesson request. The summary below reflects the latest information on file.</p>

@include('mail.components.appointment-details', ['appointment' => $appointment])

<p class="sub">Questions about these changes? Reply to this email and we will be happy to help.</p>

@include('mail.components.email-signature')
</x-mail::message>
