<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'value',
        'field',
        'group',
        'active',
    ];

    public static function getName($key, $default = null)
    {
        return self::where('key', $key)->value('name') ?? $default;
    }

    public static function getDescription($key, $default = null)
    {
        return self::where('key', $key)->value('description') ?? $default;
    }

    public static function getValue($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    public static function getField($key, $default = null)
    {
        return self::where('key', $key)->value('field') ?? $default;
    }

    public static function getGroup($key, $default = null)
    {
        return self::where('key', $key)->value('group') ?? $default;
    }

    public static function set($key, $name, $description, $value, $field, $group, $active)
    {
        return self::updateOrCreate(['key' => $key], [
            'name' => $name,
            'description' => $description,
            'value' => $value,
            'field' => $field,
            'group' => $group,
            'active' => $active,
        ]);
    }
}
