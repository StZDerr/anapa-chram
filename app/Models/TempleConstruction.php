<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempleConstruction extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Изображения строительства (много)
     */
    public function images()
    {
        return $this->hasMany(TempleConstructionImage::class)
            ->orderBy('order');
    }
}
