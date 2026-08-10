<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_roles', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->unsignedInteger('position')->nullable();
        });
        Schema::create('team_role_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'team_role');
        });
        Schema::create('team_role_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'team_role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_role_revisions');
        Schema::dropIfExists('team_role_slugs');
        Schema::dropIfExists('team_roles');
    }
};
