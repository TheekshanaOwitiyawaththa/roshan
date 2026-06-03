<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'instagram_profile_url',
        'appointment_notification_email',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'instagram_profile_url' => config('golf.instagram_profile_url'),
            'appointment_notification_email' => config('mail.from.address'),
        ]);
    }

    public static function instagramProfileUrl(): string
    {
        return static::current()->instagram_profile_url;
    }

    public static function appointmentNotificationEmail(): ?string
    {
        $email = static::current()->appointment_notification_email;

        return filled($email) ? $email : null;
    }
}
