<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'phone',
        'address',
        'is_active',
        'settings',
        'plan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function isPro(): bool
    {
        return $this->plan === 'pro';
    }

    public function isFree(): bool
    {
        return $this->plan !== 'pro';
    }

    public function productLimit(): ?int
    {
        return $this->isPro() ? null : 20; // null = ilimitado
    }

    public function canAddProduct(): bool
    {
        $limit = $this->productLimit();

        if ($limit === null) {
            return true;
        }

        return $this->products()->count() < $limit;
    }
}
