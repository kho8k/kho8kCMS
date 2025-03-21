<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'server',
        'name',
        'slug',
        'type',
        'link',
        'has_report',
        'report_message',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
