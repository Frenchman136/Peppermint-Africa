<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'client', 'service_id', 'industry_id', 'year',
        'summary', 'challenge', 'approach', 'result',
        'cover_image', 'gallery', 'video_url',
        'is_featured', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /* ---- Accessors used by the templates (also readable as $project['category'] etc.) ---- */

    protected function category(): Attribute
    {
        return Attribute::get(fn () => $this->service?->title ?? 'Project');
    }

    protected function url(): Attribute
    {
        return Attribute::get(fn () => route('work.show', $this->slug));
    }

    protected function coverUrl(): Attribute
    {
        return Attribute::get(fn () => static::fileUrl($this->cover_image));
    }

    /** @return array<int, string> */
    protected function galleryUrls(): Attribute
    {
        return Attribute::get(fn () => collect($this->gallery ?? [])
            ->map(fn ($path) => static::fileUrl($path))
            ->filter()
            ->values()
            ->all());
    }

    /** YouTube / Vimeo link converted to a privacy-friendly embed URL (only used after a click). */
    protected function videoEmbedUrl(): Attribute
    {
        return Attribute::get(function () {
            $url = $this->video_url;

            if (! $url) {
                return null;
            }

            if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~', $url, $m)) {
                return 'https://www.youtube-nocookie.com/embed/'.$m[1].'?autoplay=1&rel=0';
            }

            if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
                return 'https://player.vimeo.com/video/'.$m[1].'?autoplay=1';
            }

            return null;
        });
    }

    /**
     * Resolve an image path to a public URL. Supports:
     *  - full URLs
     *  - files in public/images (e.g. "work/mango.webp")
     *  - files on the public storage disk (admin uploads in Phase 6)
     */
    public static function fileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (file_exists(public_path('images/'.$path))) {
            return asset('images/'.$path);
        }

        return Storage::disk('public')->url($path);
    }
}
