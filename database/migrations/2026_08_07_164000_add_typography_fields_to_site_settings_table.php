<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            foreach (['page_title', 'menu', 'hero_title', 'body', 'body_small', 'paragraph', 'caption'] as $style) {
                $table->unsignedSmallInteger("{$style}_size")->default(match ($style) {
                    'page_title' => 140,
                    'menu' => 14,
                    'hero_title' => 168,
                    'body' => 18,
                    'body_small' => 14,
                    'paragraph' => 22,
                    'caption' => 12,
                });
                $table->decimal("{$style}_line_height", 4, 2)->default(match ($style) {
                    'page_title' => 0.78,
                    'menu' => 1.00,
                    'hero_title' => 0.82,
                    'body' => 1.50,
                    'body_small' => 1.40,
                    'paragraph' => 1.35,
                    'caption' => 1.30,
                });
                $table->decimal("{$style}_tracking", 5, 3)->default(match ($style) {
                    'page_title' => -0.015,
                    'menu' => 0,
                    'hero_title' => -0.018,
                    'body' => 0,
                    'body_small' => 0,
                    'paragraph' => 0,
                    'caption' => 0.020,
                });
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $columns = [];
            foreach (['page_title', 'menu', 'hero_title', 'body', 'body_small', 'paragraph', 'caption'] as $style) {
                $columns = array_merge($columns, ["{$style}_size", "{$style}_line_height", "{$style}_tracking"]);
            }
            $table->dropColumn($columns);
        });
    }
};
