<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'includes', 'sort_order'];

    protected function casts(): array
    {
        return ['includes' => 'array'];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
