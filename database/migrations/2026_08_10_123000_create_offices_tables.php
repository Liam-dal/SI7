<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->unsignedInteger('position')->nullable();
        });
        Schema::create('office_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'office');
        });
        Schema::create('office_project', function (Blueprint $table) {
            $table->foreignId('office_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position')->nullable();
            $table->primary(['office_id', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('office_project');
        Schema::dropIfExists('office_revisions');
        Schema::dropIfExists('offices');
    }
};
