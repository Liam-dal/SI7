<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('seo_title_prefix', 255)->nullable();
            $table->string('seo_title_suffix', 255)->nullable();
            $table->text('seo_description_prefix')->nullable();
            $table->text('seo_description_suffix')->nullable();
            $table->string('homepage_title', 255)->nullable();
            $table->text('homepage_description')->nullable();
            $table->string('projects_sectors_title', 255)->nullable();
            $table->text('projects_sectors_description')->nullable();
            $table->string('projects_disciplines_title', 255)->nullable();
            $table->text('projects_disciplines_description')->nullable();
            $table->string('projects_all_title', 255)->nullable();
            $table->text('projects_all_description')->nullable();
            $table->string('projects_alphabetical_title', 255)->nullable();
            $table->text('projects_alphabetical_description')->nullable();
            $table->string('about_page_title', 255)->nullable();
            $table->text('about_page_description')->nullable();
            $table->string('contact_page_title', 255)->nullable();
            $table->text('contact_page_description')->nullable();
            $table->string('downloads_page_title', 255)->nullable();
            $table->text('downloads_page_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title_prefix', 'seo_title_suffix', 'seo_description_prefix', 'seo_description_suffix',
                'homepage_title', 'homepage_description', 'projects_sectors_title', 'projects_sectors_description',
                'projects_disciplines_title', 'projects_disciplines_description', 'projects_all_title', 'projects_all_description',
                'projects_alphabetical_title', 'projects_alphabetical_description', 'about_page_title', 'about_page_description',
                'contact_page_title', 'contact_page_description', 'downloads_page_title', 'downloads_page_description',
            ]);
        });
    }
};
