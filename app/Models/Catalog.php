<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'paginate',
        'value',
        'seo_title',
        'seo_des',
        'seo_key'
    ];
}
