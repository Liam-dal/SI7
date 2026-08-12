<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepages', function (Blueprint $table) {
            $table->boolean('hero_builder')->default(false);
            $table->unsignedBigInteger('hero_default_category_id')->nullable();
            $table->unsignedBigInteger('hero_default_sector_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('homepages', function (Blueprint $table) {
            $table->dropColumn(['hero_builder', 'hero_default_category_id', 'hero_default_sector_id']);
        });
    }
};
