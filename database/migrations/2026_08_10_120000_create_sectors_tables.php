<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sectors', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->unsignedInteger('position')->nullable();
        });

        Schema::create('sector_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'sector');
        });

        Schema::create('sector_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'sector');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sector_revisions');
        Schema::dropIfExists('sector_slugs');
        Schema::dropIfExists('sectors');
    }
};
