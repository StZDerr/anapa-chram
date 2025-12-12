<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    // Разрешенные для массового заполнения поля
    protected $fillable = [
        'title',
        'description',
        'image',
        'order',
    ];

    // Если нужно сортировать по order по умолчанию
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Можно добавить скоуп для активных, если добавим поле 'active'
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
