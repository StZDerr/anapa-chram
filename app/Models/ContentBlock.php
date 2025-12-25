<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContentBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_desc',
        'desc',
        'block_2_title',
        'block_2_desc',
        'block_2_img',
        'slug',
        'price',
        'preview_img',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $base = Str::slug($model->title ?: 'block');
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Изображения первого блока
     */
    public function images()
    {
        return $this->hasMany(ContentBlockImage::class)
            ->orderBy('sort');
    }
}
