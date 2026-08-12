<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('guide_page_title')->nullable()->after('downloads_page_description');
            $table->text('guide_page_description')->nullable()->after('guide_page_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['guide_page_title', 'guide_page_description']);
        });
    }
};
