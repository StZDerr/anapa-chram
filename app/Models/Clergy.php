<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clergy extends Model
{
    use SoftDeletes;

    protected $table = 'clergies';

    /**
     * Атрибуты, которые можно массово назначать.
     */
    protected $fillable = [
        'image',
        'full_name',
        'position',
        'order',
        'category',
    ];

    /**
     * Атрибуты, которые нужно приводить к типам.
     */
    protected $casts = [
        'order' => 'integer',
    ];
}
