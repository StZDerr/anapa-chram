<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    use HasFactory;

    protected $table = 'seo_pages';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'keywords',
        'h1',
        'canonical',
        'robots',
        'og_title',
        'og_description',
        'og_image',
        'structured_data',
    ];

    protected $casts = [
        'structured_data' => 'array',
    ];

    /**
     * Получить SEO по текущему URL (path без ведущего '/').
     */
    public static function forCurrentUrl(): ?self
    {
        $slug = trim(request()->path(), '/'); // '' для главной

        if ($slug === '') {
            return self::whereNull('slug')->first();
        }

        return self::where('slug', $slug)->first();
    }

    public static function forUrl(string $path): ?self
    {
        $slug = trim($path, '/');

        if ($slug === '') {
            return self::whereNull('slug')->first();
        }

        return self::where('slug', $slug)->first();
    }
}
