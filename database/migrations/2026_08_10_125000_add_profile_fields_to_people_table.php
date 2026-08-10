<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('first_name', 100)->nullable()->after('title');
            $table->string('last_name', 100)->nullable()->after('first_name');
            $table->foreignId('office_id')->nullable()->constrained('offices')->nullOnDelete()->after('team_role_id');
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropConstrainedForeignId('office_id');
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
