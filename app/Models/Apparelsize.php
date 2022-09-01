<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apparelsize extends Model
{
    use HasFactory;

    protected $primaryKey = 'size_id';
    protected $table = 'apparel_size';

    protected $fillable=[
        'size_code'
    ];

}
