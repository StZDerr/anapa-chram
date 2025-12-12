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
        Schema::create('temple_construction_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('temple_construction_id')
                ->constrained()
                ->onDelete('cascade')
                ->comment('ID карточки строительства храма');

            $table->string('image')
                ->comment('Путь к изображению (webp)');

            $table->integer('order')
                ->default(0)
                ->comment('Порядок сортировки изображений');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temple_construction_images');
    }
};
