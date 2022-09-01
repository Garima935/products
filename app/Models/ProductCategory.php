<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'pro_cat_id';
    protected $table = 'product_cat';

    protected $fillable=[
        'product_id','sub_cat_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'product_id','product_id');
    }

    public function sub_cat()
    {
        return $this->hasOne(Subcategory::class,'sub_cat_id','sub_cat_id');
    }
}
