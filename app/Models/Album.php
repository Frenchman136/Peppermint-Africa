<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'event_date', 'photos', 'is_published', 'sort_order'];

    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'event_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /** @return array<int, string> */
    protected function photoUrls(): Attribute
    {
        return Attribute::get(fn () => collect($this->photos ?? [])
            ->map(fn ($path) => Project::fileUrl($path))
            ->filter()
            ->values()
            ->all());
    }
}
