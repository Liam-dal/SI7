<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('twill_features')
            ->where('featured_type', 'App\\Models\\Project')
            ->update(['featured_type' => 'projects']);
    }

    public function down(): void
    {
        DB::table('twill_features')
            ->where('featured_type', 'projects')
            ->update(['featured_type' => 'App\\Models\\Project']);
    }
};
