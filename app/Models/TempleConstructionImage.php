<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempleConstructionImage extends Model
{
    protected $fillable = [
        'temple_construction_id',
        'image',
        'order',
    ];

    /**
     * Связь с основной моделью строительства
     */
    public function construction()
    {
        return $this->belongsTo(TempleConstruction::class, 'temple_construction_id');
    }

    /**
     * Готовый URL для изображения
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/'.$this->image);
    }
}
