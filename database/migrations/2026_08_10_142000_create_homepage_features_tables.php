<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_features', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('section', 20)->default('main');
            $table->string('title', 180)->nullable();
            $table->text('description')->nullable();
            $table->integer('position')->unsigned()->default(0);
        });

        Schema::create('homepage_feature_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'homepage_feature');
        });

        $sections = [
            'homepage_main_features' => 'main',
            'homepage_secondary_features' => 'secondary',
            'homepage_additional_features' => 'additional',
        ];

        DB::table('twill_features')
            ->whereIn('bucket_key', array_keys($sections))
            ->orderBy('bucket_key')
            ->orderBy('position')
            ->get()
            ->each(function (object $feature) use ($sections): void {
                DB::table('homepage_features')->insert([
                    'project_id' => (int) $feature->featured_id,
                    'section' => $sections[$feature->bucket_key],
                    'published' => true,
                    'position' => $feature->position,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_feature_revisions');
        Schema::dropIfExists('homepage_features');
    }
};
