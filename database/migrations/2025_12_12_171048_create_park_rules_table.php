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
        Schema::create('park_rules', function (Blueprint $table) {
            $table->id();

            // Для блока "Правила посещения"
            $table->string('allowed_title')->default('Правила посещения')
                ->comment('Заголовок блока правил');
            $table->string('allowed_subtitle')->nullable()
                ->comment('Подзаголовок правил');

            // Для блока "Запрещается"
            $table->string('prohibited_title')->default('Запрещается')
                ->comment('Заголовок блока запретов');
            $table->string('prohibited_subtitle')->nullable()
                ->comment('Подзаголовок запретов');

            // JSON массив со всеми пунктами правил и запретов
            $table->json('items')->nullable()
                ->comment('Массив пунктов: [{title, category, svg}]');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('park_rules');
    }
};
