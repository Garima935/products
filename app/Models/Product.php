<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    protected $table = 'product';

    protected $fillable=[
        'size_id','product_name'
    ];

    public function apparelsize()
    {
        return $this->hasOne(Apparelsize::class,'size_id','size_id');
    }

    public function pro_colors()
    {
        return $this->hasMany(ProductColor::class,'product_id','product_id');
    }

    public function pro_categories()
    {
        return $this->hasMany(ProductCategory::class,'product_id','product_id');
    }
}
