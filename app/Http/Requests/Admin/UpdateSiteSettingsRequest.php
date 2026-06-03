<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'instagram_profile_url' => ['required', 'url', 'max:2048'],
            'appointment_notification_email' => ['nullable', 'email', 'max:255'],
        ];
    }
}
