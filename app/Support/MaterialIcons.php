<?php

namespace App\Support;

class MaterialIcons
{
    /**
     * @return array<string, list<string>>
     */
    public static function pickerGroups(): array
    {
        /** @var array<string, list<string>> $groups */
        $groups = config('material-icons.picker', []);

        return $groups;
    }

    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return collect(static::pickerGroups())
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return array<string, list<string>>
     */
    public static function pickerGroupsWith(string $icon): array
    {
        $groups = static::pickerGroups();

        if (collect($groups)->flatten()->contains($icon)) {
            return $groups;
        }

        $groups['Current selection'] = [$icon];

        return $groups;
    }
}
