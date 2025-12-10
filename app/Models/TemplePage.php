<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplePage extends Model
{
    protected $fillable = [
        'page_key',
        'title',
        'about_text',
        'opening_title',
        'opening_text',
        'opening_details',
        'gallery_1_images',
        'gallery_2_images',
    ];

    protected $casts = [
        'gallery_1_images' => 'array',
        'gallery_2_images' => 'array',
    ];

    /**
     * Получить страницу по ключу
     */
    public static function getByKey($key)
    {
        return static::where('page_key', $key)->first();
    }
}
