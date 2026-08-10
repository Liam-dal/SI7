<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_feature_sections', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('section_key')->unique();
            $table->string('title', 120);
            $table->text('description')->nullable();
            $table->integer('position')->unsigned()->default(0);
        });

        Schema::create('homepage_feature_section_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'homepage_feature_section');
        });

        DB::table('homepage_feature_sections')->insert([
            ['section_key' => 'main', 'title' => 'Featured work', 'description' => '주요 프로젝트를 슬라이드로 보여줍니다.', 'published' => true, 'position' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['section_key' => 'secondary', 'title' => 'More featured work', 'description' => '보조 피처 프로젝트입니다.', 'published' => true, 'position' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['section_key' => 'additional', 'title' => 'Additional features', 'description' => '추가 피처 프로젝트입니다.', 'published' => true, 'position' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_feature_section_revisions');
        Schema::dropIfExists('homepage_feature_sections');
    }
};
