<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    protected $table='products';

    protected $fillable =[

        "name","name_ar", "code", "type", "barcode_symbology", "brand_id", "category_id", "unit_id",
        "purchase_unit_id", "sale_unit_id", "cost", "price", "qty", "alert_quantity", "promotion", "promotion_price",
        "starting_date", "last_date", "tax_id", "tax_method", "image", "file", "is_variant", "is_diffPrice","is_diffAlertQty",
        "featured", "mini_shop_featured","best_sale_featured","product_list", "qty_list", "price_list", "product_details",
        "product_details_ar","ingredients_ar","how_to_use_ar",
        "ingredients", "how_to_use", "is_active"
    ];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function brand()
    {
    	return $this->belongsTo('App\Brand');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function tax()
    {
        return $this->belongsTo('App\Tax');
    }

    public function variant()
    {
        return $this->belongsToMany('App\Variant', 'product_variants')->withPivot('id', 'item_code', 'additional_price');
    }

    public function scopeActiveStandard($query)
    {
        return $query->where([
            ['is_active', true],
            ['type', 'standard']
        ]);
    }

    public function scopeActiveFeatured($query)
    {
        return $query->where([
            ['is_active', true],
            ['featured', 1]
        ]);
    }

}
