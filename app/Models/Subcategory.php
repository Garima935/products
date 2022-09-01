<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'sub_cat_id';
    protected $table = 'sub_category';

    protected $fillable=[
        'cat_id','sub_cat'
    ];

    public function category()
    {
        return $this->hasOne(Category::class,'cat_id','cat_id');
    }
}
