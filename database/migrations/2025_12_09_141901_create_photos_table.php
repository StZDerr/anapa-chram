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
        // Таблица категорий
        Schema::create('photo_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название категории
            $table->timestamps();
        });

        // Таблица фотографий
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();      // Название
            $table->string('file_path');              // Путь к файлу
            $table->unsignedBigInteger('category_id')->nullable(); // Категория

            $table->foreign('category_id')
                ->references('id')
                ->on('photo_categories')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
        Schema::dropIfExists('photo_categories');
    }
};
