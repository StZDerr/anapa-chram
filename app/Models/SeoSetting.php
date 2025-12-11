<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;

    protected $table = 'seo_settings';

    protected $fillable = [
        'global_indexing',
    ];

    protected $casts = [
        'global_indexing' => 'boolean',
    ];

    /**
     * Быстрый доступ к единственной записи настроек.
     */
    public static function current(): ?self
    {
        return self::first();
    }

    /**
     * Возвращает true, если глобальная индексация включена.
     */
    public static function isIndexingEnabled(): bool
    {
        $s = self::current();

        return $s ? (bool) $s->global_indexing : false;
    }
}
