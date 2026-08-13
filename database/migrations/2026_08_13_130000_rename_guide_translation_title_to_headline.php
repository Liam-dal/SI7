<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // guide_translations.title(번역되던 제목) → headline 으로 이름 변경.
    // 이제 번역 제목은 headline 이 담당하고, guides.title 은 번역 없는 permalink 전용이 된다.
    public function up(): void
    {
        Schema::table('guide_translations', function (Blueprint $table) {
            $table->renameColumn('title', 'headline');
        });
    }

    public function down(): void
    {
        Schema::table('guide_translations', function (Blueprint $table) {
            $table->renameColumn('headline', 'title');
        });
    }
};
