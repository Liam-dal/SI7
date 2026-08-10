<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('background_color', 7)->default('#FFFFFF');
            $table->string('text_color', 7)->default('#111111');
            $table->string('muted_text_color', 7)->default('#6E6E6E');
            $table->unsignedSmallInteger('page_gutter')->default(16);
            $table->unsignedSmallInteger('section_spacing')->default(96);
            $table->unsignedSmallInteger('card_radius')->default(0);
            $table->string('link_hover_style', 20)->default('underline');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'background_color',
                'text_color',
                'muted_text_color',
                'page_gutter',
                'section_spacing',
                'card_radius',
                'link_hover_style',
            ]);
        });
    }
};
