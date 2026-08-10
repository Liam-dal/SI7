<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);
            
            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('title', 200)->nullable();

            $table->text('description')->nullable();
            $table->string('role', 255)->nullable();
            $table->string('client', 255)->nullable();
            $table->string('technologies', 500)->nullable();
            $table->string('external_url', 2048)->nullable();
            $table->date('project_started_at')->nullable();
            $table->date('project_completed_at')->nullable();
            $table->boolean('featured')->default(false);

            $table->integer('position')->unsigned()->nullable();
            
            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('project_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'project');
        });

        Schema::create('project_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'project');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_revisions');
        Schema::dropIfExists('project_slugs');
        Schema::dropIfExists('projects');
    }
};
