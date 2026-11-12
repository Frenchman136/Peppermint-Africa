<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'body', 'cover_image',
        'author_name', 'published_at', 'is_published', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    /** Published, and not scheduled for the future. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(fn (Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    protected function url(): Attribute
    {
        return Attribute::get(fn () => route('blog.show', $this->slug));
    }

    protected function coverUrl(): Attribute
    {
        return Attribute::get(fn () => Project::fileUrl($this->cover_image));
    }

    /** Markdown rendered to HTML. Raw HTML typed into the body is stripped, so posts are safe to display. */
    protected function bodyHtml(): Attribute
    {
        return Attribute::get(fn () => Str::markdown($this->body ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]));
    }

    protected function readingTime(): Attribute
    {
        return Attribute::get(fn () => max(1, (int) ceil(str_word_count(strip_tags($this->body ?? '')) / 200)));
    }

    protected function summary(): Attribute
    {
        return Attribute::get(fn () => $this->excerpt ?: Str::limit(strip_tags(Str::markdown($this->body ?? '')), 160));
    }
}
