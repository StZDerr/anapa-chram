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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('title_desc')->nullable();
            $table->text('desc')->nullable();

            $table->string('block_2_title')->nullable();
            $table->text('block_2_desc')->nullable();
            $table->string('block_2_img')->nullable(); // одно изображение

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
