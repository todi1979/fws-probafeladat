<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * Azok a mezők, amelyek tömegesen kitölthetők.
     *
     * @var array
     */
    protected $fillable = ['category_name'];

    /**
     * A kategóriához tartozó termékek.
     *
     * A kapcsolatot egy köztes tábla (`product_to_product_category`) kezeli,
     * amely lehetővé teszi a több-a-többhöz viszonyt a termékek és kategóriák között.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_to_product_category');
    }
}
