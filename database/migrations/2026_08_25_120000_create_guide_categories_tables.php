<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_categories', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 60)->nullable();
            $table->unsignedInteger('position')->nullable();
        });

        Schema::create('guide_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'guide_category');
        });

        Schema::create('guide_category_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'guide_category');
        });

        Schema::table('guides', function (Blueprint $table) {
            $table->foreignId('guide_category_id')->nullable()->after('title')
                ->constrained('guide_categories')->nullOnDelete();
        });

        $this->migrateExistingCategories();

        Schema::table('guides', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->string('category')->nullable()->after('title');
        });

        // 되돌릴 때는 카테고리 제목을 문자열 컬럼으로 되돌려 놓는다.
        DB::table('guides')->whereNotNull('guide_category_id')->orderBy('id')
            ->each(function ($guide): void {
                $title = DB::table('guide_categories')->where('id', $guide->guide_category_id)->value('title');
                DB::table('guides')->where('id', $guide->id)->update(['category' => $title]);
            });

        Schema::table('guides', function (Blueprint $table) {
            $table->dropConstrainedForeignId('guide_category_id');
        });

        Schema::dropIfExists('guide_category_revisions');
        Schema::dropIfExists('guide_category_slugs');
        Schema::dropIfExists('guide_categories');
    }

    /**
     * 기존 자유입력 문자열(guides.category)을 카테고리 행으로 승격하고 각 글에 연결한다.
     * 같은 문자열은 대소문자·공백을 정규화해 하나로 합친다.
     */
    private function migrateExistingCategories(): void
    {
        $titles = DB::table('guides')->whereNotNull('category')->where('category', '!=', '')
            ->pluck('category')->map(fn ($t) => trim($t))->filter()->unique(fn ($t) => mb_strtolower($t))
            ->values();

        $now = now();
        $position = 0;

        foreach ($titles as $title) {
            $categoryId = DB::table('guide_categories')->insertGetId([
                'title' => $title,
                'position' => ++$position,
                'published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Twill 은 저장 시 슬러그 행을 만들지만 마이그레이션의 raw insert 는 거치지 않는다.
            // 한글 제목은 Str::slug 가 전부 버리므로 빈 값이면 id 기반으로 채운다.
            $slug = Str::slug($title) ?: 'category-' . $categoryId;
            foreach (config('translatable.locales', ['en']) as $locale) {
                DB::table('guide_category_slugs')->insert([
                    'guide_category_id' => $categoryId,
                    'slug' => $slug,
                    'locale' => $locale,
                    'active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('guides')
                ->whereRaw('LOWER(TRIM(category)) = ?', [mb_strtolower($title)])
                ->update(['guide_category_id' => $categoryId]);
        }
    }
};
