<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'origin_name',
        'slug',
        'content',
        'thumb_url',
        'poster_url',
        'type',
        'status',
        'trailer_url',
        'episode_time',
        'episode_current',
        'episode_total',
        'quality',
        'language',
        'notify',
        'showtimes',
        'publish_year',
        'is_shown_in_theater',
        'is_recommended',
        'is_copyright',
        'is_sensitive_content',
        'episode_server_count',
        'episode_data_count',
        'view_total',
        'view_day',
        'view_week',
        'view_month',
        'rating_count',
        'rating_star',
        'update_handler',
        'update_identity',
        'update_checksum',
        'user_id',
        'user_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_movie');
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'region_movie');
    }

    public function directors()
    {
        return $this->belongsToMany(Director::class, 'director_movie');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_movie');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_movie');
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function studios()
    {
        return $this->belongsToMany(Studio::class, 'studio_movie');
    }
}
