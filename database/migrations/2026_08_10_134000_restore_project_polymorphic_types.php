<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Homepage feature records were stored using the module key. Keep their
     * relationship type consistent with the rest of the application's
     * polymorphic project relations, without changing block/media lookups.
     */
    public function up(): void
    {
        DB::table('twill_features')
            ->where('featured_type', 'projects')
            ->update(['featured_type' => 'App\\Models\\Project']);
    }

    public function down(): void
    {
        DB::table('twill_features')
            ->where('featured_type', 'App\\Models\\Project')
            ->update(['featured_type' => 'projects']);
    }
};
