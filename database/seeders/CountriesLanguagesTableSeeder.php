<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountriesLanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries_languages')->insert([
            // country_id(1) => Belgium, language_id(1) => nl
            ['country_id' => 1, 'language_id' => 1],

            // country_id(2) => Canada, language_id(2) => en, language_id(3) => fr
            ['country_id' => 2, 'language_id' => 2],
            ['country_id' => 2, 'language_id' => 3],

            // country_id(3) => France, language_id(3) => fr
            ['country_id' => 3, 'language_id' => 3],

            // country_id(4) => Germany, language_id(4) => de
            ['country_id' => 4, 'language_id' => 4],
            
            // country_id(5) => United kingdom, language_id(2) => en
            ['country_id' => 5, 'language_id' => 2],
        ]);
    }
}
