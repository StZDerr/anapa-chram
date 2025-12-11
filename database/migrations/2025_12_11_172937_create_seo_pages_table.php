<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique()->comment('URL страницы (без ведущего /, например about или about/us)');
            $table->string('title')->nullable()->comment('SEO заголовок');
            $table->text('description')->nullable()->comment('SEO описание');
            $table->string('keywords')->nullable()->comment('Ключевые слова (через запятую)');
            $table->string('h1')->nullable()->comment('H1 заголовок');

            // Продвинутое SEO
            $table->string('canonical')->nullable()->comment('Канонический URL');
            $table->string('robots')->default('noindex, follow')->comment('Инструкции для поисковых систем (по умолчанию noindex, follow)');

            // Open Graph
            $table->string('og_title')->nullable()->comment('Open Graph заголовок');
            $table->text('og_description')->nullable()->comment('Open Graph описание');
            $table->string('og_image')->nullable()->comment('Open Graph изображение (URL или путь)');

            // JSON-LD структурированные данные
            $table->json('structured_data')->nullable()->comment('JSON-LD (структурированные данные)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
