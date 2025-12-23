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
        Schema::create('content_block_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('content_block_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('img');
            $table->unsignedInteger('sort')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_block_images');
    }
};
