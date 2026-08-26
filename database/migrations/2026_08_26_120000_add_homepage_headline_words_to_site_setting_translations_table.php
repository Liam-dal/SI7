<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 홈 헤드라인을 단어가 바뀌는 모핑 애니메이션으로 돌릴 때 쓰는 단어 목록.
     * 사용자에게 보이는 텍스트라 번역 대상 → site_setting_translations 에 둔다.
     */
    public function up(): void
    {
        Schema::table('site_setting_translations', function (Blueprint $table) {
            $table->text('homepage_headline_words')->nullable()->after('homepage_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_setting_translations', function (Blueprint $table) {
            $table->dropColumn('homepage_headline_words');
        });
    }
};
