<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // 헤더 메뉴 항목별 노출 토글. 기존 메뉴 4개는 그대로 보이도록 기본 on,
    // 지금까지 메뉴에 없던 Guides 만 기본 off.
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('menu_projects_enabled')->default(true);
            $table->boolean('menu_about_enabled')->default(true);
            $table->boolean('menu_guides_enabled')->default(false);
            $table->boolean('menu_downloads_enabled')->default(true);
            $table->boolean('menu_contact_enabled')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'menu_projects_enabled',
                'menu_about_enabled',
                'menu_guides_enabled',
                'menu_downloads_enabled',
                'menu_contact_enabled',
            ]);
        });
    }
};
