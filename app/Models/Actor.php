<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_md5',
        'slug',
        'gender',
        'bio',
        'thumb_url',
        'seo_title',
        'seo_des',
        'seo_key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
