<table class="signature" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="signature-rule" style="border-top: 1px solid #e5e5e5; font-size: 0; height: 1px; line-height: 1px; margin: 28px 0 20px;">&nbsp;</td>
</tr>
</table>
<p style="color: #01261f; font-size: 15px; font-weight: 600; margin: 0 0 4px;">Roshan Fernando</p>
<p style="color: #717976; font-size: 13px; letter-spacing: 0.04em; margin: 0 0 12px; text-transform: uppercase;">Elite Performance Coaching</p>
<p style="color: #414846; font-size: 14px; line-height: 1.5; margin: 0;">
<a href="{{ config('app.url') }}" style="color: #01261f; font-weight: 600; text-decoration: none;">Visit our website</a>
@if (filled($instagram = \App\Models\SiteSetting::instagramProfileUrl()))
<span style="color: #c1c8c4;">&nbsp;·&nbsp;</span>
<a href="{{ $instagram }}" style="color: #01261f; font-weight: 600; text-decoration: none;">Instagram</a>
@endif
</p>
</td>
</tr>
</table>
