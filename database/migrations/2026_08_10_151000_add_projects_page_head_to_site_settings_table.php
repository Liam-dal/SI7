<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('projects_page_title')->nullable()->after('homepage_regular_grid');
            $table->text('projects_page_description')->nullable()->after('projects_page_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['projects_page_title', 'projects_page_description']);
        });
    }
};
