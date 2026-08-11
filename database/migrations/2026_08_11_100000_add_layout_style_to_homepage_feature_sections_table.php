<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_feature_sections', function (Blueprint $table) {
            $table->string('layout_style')->default('carousel')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('homepage_feature_sections', function (Blueprint $table) {
            $table->dropColumn('layout_style');
        });
    }
};
