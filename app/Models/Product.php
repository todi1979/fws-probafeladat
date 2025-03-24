<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Azok a mezők, amelyek tömegesen kitölthetők.
     *
     * @var array
     */
    protected $fillable = ['product_name', 'price'];

    /**
     * A termékhez tartozó kategóriák.
     *
     * A kapcsolatot egy köztes tábla (`product_to_product_category`) kezeli,
     * amely lehetővé teszi a több-a-többhöz viszonyt a termékek és kategóriák között.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_to_product_category');
    }
}

