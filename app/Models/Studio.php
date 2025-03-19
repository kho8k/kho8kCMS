<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_md5',
        'slug',
        'thumb_url',
        'seo_title',
        'seo_des',
        'seo_key'
    ];
}
