<?php

namespace Database\Seeders;

use App\Models\Homepage;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        Homepage::query()->firstOrCreate(
            ['id' => 1],
            ['title' => 'Homepage', 'published' => true]
        );
    }
}
