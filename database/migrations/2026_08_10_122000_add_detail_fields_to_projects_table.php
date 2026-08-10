<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('subtitle', 255)->nullable()->after('title');
            $table->text('case_study_text')->nullable()->after('description');
            $table->date('publication_date')->nullable()->after('technologies');
            $table->string('tags', 500)->nullable()->after('technologies');
            $table->string('external_link_label', 255)->nullable()->after('external_url');
            $table->string('video_url', 2048)->nullable()->after('external_link_label');
            $table->boolean('video_autoplay')->default(false)->after('video_url');
            $table->boolean('video_autoloop')->default(false)->after('video_autoplay');
        });

        Schema::create('person_project', function (Blueprint $table) {
            $table->foreignId('person_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->nullable();
            $table->primary(['person_id', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_project');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'subtitle', 'case_study_text', 'publication_date', 'tags', 'external_link_label',
                'video_url', 'video_autoplay', 'video_autoloop',
            ]);
        });
    }
};
