<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('home_hero_builder')->default(false);
            $table->unsignedBigInteger('home_hero_default_category_id')->nullable();
            $table->unsignedBigInteger('home_hero_default_sector_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['home_hero_builder', 'home_hero_default_category_id', 'home_hero_default_sector_id']);
        });
    }
};
