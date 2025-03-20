<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_md5',
        'slug',
        'seo_title',
        'seo_des',
        'seo_key'
    ];
}
