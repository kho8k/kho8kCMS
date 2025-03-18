<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($actor) {
            if ($actor->thumb_url) {
                Storage::disk('public')->delete($actor->thumb_url);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
