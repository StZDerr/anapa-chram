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
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        // Заполнить slug для существующих записей
        \App\Models\ContentBlock::chunkById(100, function ($blocks) {
            foreach ($blocks as $block) {
                $base = \Illuminate\Support\Str::slug($block->title ?: 'block');
                $slug = $base;
                $i = 1;
                while (\App\Models\ContentBlock::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $block->updateQuietly(['slug' => $slug]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
