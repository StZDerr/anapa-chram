<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'img_preview', 'status', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Связь с изображениями
    public function images()
    {
        return $this->hasMany(ActivityImage::class);
    }

    // Автоматическая генерация slug при создании/обновлении
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->title);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->title, $model->id);
            }
        });
    }

    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title, '-');
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = static::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (! $query->exists()) {
                break;
            }

            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    public function getStatusNameAttribute()
    {
        return match ($this->status) {
            'draft' => 'Черновик',
            'pending' => 'Ждёт публикации',
            'published' => 'Опубликовано',
            default => 'Неизвестно',
        };
    }
}
