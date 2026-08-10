<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->foreignId('team_role_id')->nullable()->constrained('team_roles')->nullOnDelete();
            $table->text('biography')->nullable();
            $table->unsignedSmallInteger('start_year')->nullable();
            $table->string('office', 200)->nullable();
            $table->unsignedInteger('position')->nullable();
        });
        Schema::create('person_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'person');
        });
        Schema::create('person_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'person');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_revisions');
        Schema::dropIfExists('person_slugs');
        Schema::dropIfExists('people');
    }
};
