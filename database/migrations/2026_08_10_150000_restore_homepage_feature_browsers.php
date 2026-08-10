<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $homepageId = DB::table('homepages')->orderBy('id')->value('id');

        if (! $homepageId) {
            return;
        }

        $browserNames = [
            'main' => 'main_features',
            'secondary' => 'secondary_features',
            'additional' => 'additional_features',
        ];

        foreach ($browserNames as $section => $browserName) {
            $hasItems = DB::table('twill_related')
                ->where('subject_id', $homepageId)
                ->where('subject_type', 'App\\Models\\Homepage')
                ->where('browser_name', $browserName)
                ->exists();

            if ($hasItems) {
                continue;
            }

            DB::table('homepage_features')
                ->where('section', $section)
                ->where('published', true)
                ->whereNull('deleted_at')
                ->orderBy('position')
                ->get()
                ->each(function (object $feature, int $index) use ($homepageId, $browserName): void {
                    DB::table('twill_related')->insert([
                        'subject_id' => $homepageId,
                        'subject_type' => 'App\\Models\\Homepage',
                        'related_id' => $feature->project_id,
                        'related_type' => 'App\\Models\\Project',
                        'browser_name' => $browserName,
                        'position' => $index + 1,
                    ]);
                });
        }
    }

    public function down(): void
    {
        // 기존 피처 데이터는 유지합니다. 이 이관은 되돌려도 안전하게 남겨 둡니다.
    }
};
