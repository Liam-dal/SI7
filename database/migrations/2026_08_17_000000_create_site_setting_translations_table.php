<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** 번역 대상: 사용자에게 보이는 텍스트만 (URL·색상·크기 토큰은 제외). */
    private array $fields = [
        'seo_title_prefix', 'seo_title_suffix', 'seo_description_prefix', 'seo_description_suffix',
        'homepage_eyebrow', 'homepage_title', 'homepage_description',
        'projects_page_title', 'projects_page_description',
        'projects_sectors_title', 'projects_sectors_description',
        'projects_disciplines_title', 'projects_disciplines_description',
        'projects_all_title', 'projects_all_description',
        'projects_alphabetical_title', 'projects_alphabetical_description',
        'about_page_title', 'about_page_description',
        'guide_page_title', 'guide_page_description',
        'contact_page_title', 'contact_page_description',
        'downloads_page_title', 'downloads_page_description',
        'footer_text', 'copyright_text',
    ];

    public function up(): void
    {
        $fields = $this->fields;

        Schema::create('site_setting_translations', function (Blueprint $table) use ($fields) {
            createDefaultTranslationsTableFields($table, 'site_setting');
            foreach ($fields as $field) {
                $table->text($field)->nullable();
            }
        });

        // 기존 site_settings 값들을 fallback 로케일로 복사 → 텍스트가 사라지지 않게.
        // (fallback=true 라 다른 로케일은 이 값으로 폴백되므로, 번역 전까지 기존 텍스트가 양쪽에 보임)
        $locale = config('translatable.fallback_locale', 'ko');

        foreach (DB::table('site_settings')->get() as $row) {
            $data = [
                'site_setting_id' => $row->id,
                'locale' => $locale,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            foreach ($fields as $field) {
                $data[$field] = $row->$field ?? null;
            }
            DB::table('site_setting_translations')->insert($data);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_setting_translations');
    }
};
