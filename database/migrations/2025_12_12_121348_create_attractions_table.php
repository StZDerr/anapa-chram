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
        Schema::create('attractions', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор достопримечательности');
            $table->string('title')->comment('Название достопримечательности');
            $table->text('description')->nullable()->comment('Подробное описание достопримечательности');
            $table->string('image')->nullable()->comment('Основное изображение слайда');
            $table->integer('order')->default(0)->comment('Порядок сортировки; чем меньше, тем выше в списке');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
