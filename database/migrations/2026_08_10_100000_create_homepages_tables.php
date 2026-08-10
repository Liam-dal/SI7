<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepages', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
        });

        Schema::create('homepage_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'homepage');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_revisions');
        Schema::dropIfExists('homepages');
    }
};
