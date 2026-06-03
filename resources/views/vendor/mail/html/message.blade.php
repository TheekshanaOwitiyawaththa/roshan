<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
<p style="margin: 0 0 8px;">
<strong style="color: #01261f;">Roshan Fernando Golf</strong>
</p>
<p style="margin: 0 0 12px;">
Elevating golf instruction in Western Australia through technical precision and practical experience.
</p>
<p style="margin: 0;">
© {{ date('Y') }} Roshan Fernando Golf · Perth, Western Australia<br>
<a href="{{ config('app.url') }}">{{ parse_url(config('app.url'), PHP_URL_HOST) ?: config('app.url') }}</a>
@if (filled($instagram = \App\Models\SiteSetting::instagramProfileUrl()))
&nbsp;·&nbsp;<a href="{{ $instagram }}">Instagram</a>
@endif
</p>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
