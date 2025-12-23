<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentBlockImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_block_id',
        'img',
        'sort',
    ];

    /**
     * Родительский блок
     */
    public function contentBlock()
    {
        return $this->belongsTo(ContentBlock::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/'.$this->img);
    }
}
