<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            
            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('title', 200)->nullable();

            // 목록/상세 상단에 표시되는 짧은 소개 문구
            $table->text('description')->nullable();

            // 발행일 (정렬·표시용)
            $table->timestamp('publication_date')->nullable();

            $table->integer('position')->unsigned()->nullable();
            
            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('guide_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'guide');
        });

        Schema::create('guide_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'guide');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guide_revisions');
        Schema::dropIfExists('guide_slugs');
        Schema::dropIfExists('guides');
    }
};
