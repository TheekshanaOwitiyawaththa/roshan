@props(['appointment'])

@php
    $status = $appointment->status;
    $statusBg = $status->calendarColor();
    $statusBorder = $status->calendarBorderColor();
@endphp

<table class="detail-card" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="detail-card-inner">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td style="padding-bottom: 16px;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<p class="detail-card-eyebrow">Booking summary</p>
<p class="detail-card-ref">Reference #{{ str_pad((string) $appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
</td>
<td align="right" valign="middle">
<span class="status-badge" style="background-color: {{ $statusBg }}; border: 1px solid {{ $statusBorder }}; border-radius: 9999px; color: #ffffff; display: inline-block; font-size: 11px; font-weight: 600; letter-spacing: 0.06em; padding: 6px 14px; text-transform: uppercase; white-space: nowrap;">
{{ $status->label() }}
</span>
</td>
</tr>
</table>
</td>
</tr>
</table>

<table class="detail-rows" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr class="detail-row">
<td class="detail-label" width="38%">Client</td>
<td class="detail-value" width="62%">{{ $appointment->name }}</td>
</tr>
<tr class="detail-row">
<td class="detail-label">Email</td>
<td class="detail-value"><a href="mailto:{{ $appointment->email }}" style="color: #01261f; text-decoration: none;">{{ $appointment->email }}</a></td>
</tr>
@if ($appointment->phone)
<tr class="detail-row">
<td class="detail-label">Phone</td>
<td class="detail-value">{{ $appointment->phone }}</td>
</tr>
@endif
<tr class="detail-row">
<td class="detail-label">Program</td>
<td class="detail-value"><strong style="color: #01261f; font-weight: 600;">{{ $appointment->coachingProgram?->title ?? '—' }}</strong></td>
</tr>
<tr class="detail-row">
<td class="detail-label">Location</td>
<td class="detail-value">{{ $appointment->location?->name ?? '—' }}</td>
</tr>
<tr class="detail-row">
<td class="detail-label">Preferred date</td>
<td class="detail-value">{{ $appointment->preferred_date?->format('l, F j, Y') ?? '—' }}</td>
</tr>
@if ($appointment->preferred_time)
<tr class="detail-row">
<td class="detail-label">Preferred time</td>
<td class="detail-value">{{ $appointment->preferred_time }}</td>
</tr>
@endif
</table>

@if ($appointment->message)
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top: 20px;">
<tr>
<td class="detail-note-box">
<p class="detail-note-title">Your message</p>
<p class="detail-note-body">{{ $appointment->message }}</p>
</td>
</tr>
</table>
@endif

@if ($appointment->admin_notes)
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top: 16px;">
<tr>
<td class="detail-coach-note">
<p class="detail-note-title">Note from your coach</p>
<p class="detail-note-body">{{ $appointment->admin_notes }}</p>
</td>
</tr>
</table>
@endif
</td>
</tr>
</table>
