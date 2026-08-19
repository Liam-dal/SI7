<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// 홈 그리드 레이아웃은 featured_section 블록의 '표시 스타일'이 결정한다.
// 이 사이트 설정은 어떤 뷰에서도 읽지 않는 죽은 컬럼이라 제거한다.
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('site_settings', 'homepage_regular_grid')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->dropColumn('homepage_regular_grid');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('site_settings', 'homepage_regular_grid')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->string('homepage_regular_grid')->nullable()->after('homepage_description');
            });
        }
    }
};
