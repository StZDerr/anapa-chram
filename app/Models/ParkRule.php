<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkRule extends Model
{
    protected $fillable = [
        'allowed_title',
        'allowed_subtitle',
        'prohibited_title',
        'prohibited_subtitle',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    /**
     * Получить только правила (allowed)
     */
    public function getAllowedItemsAttribute()
    {
        return collect($this->items ?? [])->filter(function ($item) {
            return ($item['category'] ?? '') === 'allowed';
        })->values();
    }

    /**
     * Получить только запреты (prohibited)
     */
    public function getProhibitedItemsAttribute()
    {
        return collect($this->items ?? [])->filter(function ($item) {
            return ($item['category'] ?? '') === 'prohibited';
        })->values();
    }

    /**
     * Получить URL SVG иконки
     */
    public function getSvgUrl($svgPath)
    {
        return $svgPath ? asset('storage/'.$svgPath) : null;
    }
}
