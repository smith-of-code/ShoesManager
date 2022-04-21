<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weathers')->insert(
            [
                ["name"=>'сухо'],
                ["name"=>'дождь'],
                ["name"=>'снег']
            ]
        );
    }
}
