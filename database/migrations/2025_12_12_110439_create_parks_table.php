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
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable()->comment('Основное изображение слайда');
            $table->string('logo')->nullable()->comment('Логотип (иконка) слайда');
            $table->string('title')->nullable()->comment('Заголовок слайда');
            $table->text('description')->nullable()->comment('Описание слайда');
            $table->string('link')->nullable()->comment('Ссылка "Узнать больше"');
            $table->string('link_text')->default('Узнать больше')->comment('Текст ссылки');
            $table->unsignedInteger('order')->default(0)->comment('Порядок отображения');
            $table->boolean('is_active')->default(true)->comment('Активен ли слайд');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parks');
    }
};
