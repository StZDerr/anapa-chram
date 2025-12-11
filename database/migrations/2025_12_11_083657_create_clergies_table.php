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
        Schema::create('clergies', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable()->comment('Путь к изображению');
            $table->string('full_name')->comment('ФИО');
            $table->string('position')->nullable()->comment('Должность');
            $table->unsignedInteger('order')->default(0)->comment('Порядок отображения');
            $table->enum('category', ['ДУХОВЕНСТВО ХРАМА', 'ПЕРСОНАЛ ХРАМА'])
                ->default('ДУХОВЕНСТВО ХРАМА')
                ->comment('Категория человека');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clergies');
    }
};
