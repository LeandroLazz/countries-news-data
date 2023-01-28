<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'Belgium', 'code' => 'be'],
            ['name' => 'Canada', 'code' => 'ca'],
            ['name' => 'France', 'code' => 'fr'],
            ['name' => 'Germany', 'code' => 'de'],
            ['name' => 'United kingdom', 'code' => 'gb']
        ]);
    }
}
