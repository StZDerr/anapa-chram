<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PhotoCategory::class, 'category_id');
    }
}
