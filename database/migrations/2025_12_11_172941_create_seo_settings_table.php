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
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            // Глобальная индексация: true = индексировать (использовать page->robots), false = принудительный noindex для всех страниц
            $table->boolean('global_indexing')->default(false)->comment('Если true — сайт индексируется, если false — глобальный noindex');
            // Доп. настройки при необходимости
            $table->timestamps();
        });

        // Создадим запись по умолчанию
        DB::table('seo_settings')->insert([
            'global_indexing' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
