<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->text('short_description')->nullable()->after('title');
            $table->string('email')->nullable()->after('short_description');
            $table->string('phone')->nullable()->after('email');
            $table->string('street')->nullable()->after('phone');
            $table->string('city')->nullable()->after('street');
            $table->string('zipcode')->nullable()->after('city');
            $table->string('country')->nullable()->after('zipcode');
            $table->string('directions_url', 2048)->nullable()->after('country');
            $table->string('timezone')->nullable()->after('directions_url');
        });
    }

    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn([
                'short_description',
                'email',
                'phone',
                'street',
                'city',
                'zipcode',
                'country',
                'directions_url',
                'timezone',
            ]);
        });
    }
};
