<?php

namespace App\Models;

use App\Support\PublicImageStorage;
use Database\Factories\LinkPostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'image_path',
    'image_url',
    'image_alt',
    'instagram_url',
    'is_active',
    'sort_order',
])]
class LinkPost extends Model
{
    /** @use HasFactory<LinkPostFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (LinkPost $linkPost): void {
            PublicImageStorage::delete($linkPost->getRawOriginal('image_path'));
        });
    }

    /**
     * @return Attribute<?string, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (?string $value, array $attributes): ?string {
            if (! empty($attributes['image_path'])) {
                return PublicImageStorage::url($attributes['image_path']);
            }

            return $value;
        });
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $like = '%'.$term.'%';

        return $query->where(function (Builder $query) use ($like): void {
            $query->where('image_alt', 'like', $like)
                ->orWhere('image_url', 'like', $like)
                ->orWhere('instagram_url', 'like', $like);
        });
    }
}
