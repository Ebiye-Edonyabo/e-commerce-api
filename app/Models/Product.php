<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    
    public function links(): BelongsToMany
    {
        return $this->belongsToMany(Link::class, 'link_product', 'product_id', 'link_id');
    }

    // // scope
    // public function scopeSearch($query)
    // {
    //     re
    // }
}
