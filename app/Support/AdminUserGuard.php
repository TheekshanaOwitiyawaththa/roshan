<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class AdminUserGuard
{
    public static function adminCount(): int
    {
        return User::query()->where('is_admin', true)->count();
    }

    public static function isLastAdmin(User $user): bool
    {
        return $user->is_admin && static::adminCount() <= 1;
    }

    /**
     * @throws ValidationException
     */
    public static function ensureCanRemoveAdminAccess(User $user): void
    {
        if (static::isLastAdmin($user)) {
            throw ValidationException::withMessages([
                'is_admin' => 'At least one admin user is required.',
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public static function ensureCanDelete(User $user): void
    {
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'user' => 'You cannot delete your own account.',
            ]);
        }

        if (static::isLastAdmin($user)) {
            throw ValidationException::withMessages([
                'user' => 'You cannot delete the last admin user.',
            ]);
        }
    }
}
