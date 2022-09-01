<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $primaryKey = 'pro_color_id';
    protected $table = 'product_colors';

    protected $fillable=[
        'product_id','color_id'
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'product_id','product_id');
    }

    public function color()
    {
        return $this->hasOne(Color::class,'color_id','color_id');
    }
}
