<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityImage extends Model
{
    protected $fillable = [
        'activity_id',
        'path',
    ];

    // Связь с мероприятием
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
