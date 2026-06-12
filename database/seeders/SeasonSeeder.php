<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Season::create([
            'name' => '春',
        ]);
        Season::create([
            'name' => '夏',
        ]);
        Season::create([
            'name' => '秋',
        ]);
        Season::create([
            'name' => '冬',
        ]);
    }
}
