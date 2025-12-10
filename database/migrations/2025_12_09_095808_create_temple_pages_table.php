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
        Schema::create('temple_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique(); // 'temple_main'
            $table->string('title')->nullable();
            $table->text('about_text')->nullable();
            $table->text('opening_title')->nullable();
            $table->text('opening_text')->nullable();
            $table->text('opening_details')->nullable();
            $table->json('gallery_1_images')->nullable(); // JSON массив путей к изображениям первого свайпера
            $table->json('gallery_2_images')->nullable(); // JSON массив путей к изображениям второго свайпера
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temple_pages');
    }
};
