<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Activity extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'img_preview', 'status', 'published_at'];

    protected $dates = ['published_at', 'deleted_at'];

    // Связь с изображениями
    public function images()
    {
        return $this->hasMany(ActivityImage::class);
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
