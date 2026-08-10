<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\SiteSettingRepository;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Create the database record for this singleton module.
     *
     * @return void
     */
    public function run()
    {
        if (SiteSetting::count() > 0) {
            return;
        }

        app(SiteSettingRepository::class)->create([
            'title' => 'Site Settings',
            'logo_text' => 'PORTFOLIO',
            'footer_text' => '',
            'copyright_text' => '© ' . date('Y'),
            'published' => true,
        ]);
    }
}
