<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountriesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries_categories')->insert([
            // country_id(1) => Belgium, category_id(1) => business, category_id(2) => entertainment
            ['country_id' => 1, 'category_id' => 1],
            ['country_id' => 1, 'category_id' => 2],

            // country_id(2) => Canada, category_id(3) => environment, category_id(4) => food, category_id(5) => health
            ['country_id' => 2, 'category_id' => 3],
            ['country_id' => 2, 'category_id' => 4],
            ['country_id' => 2, 'category_id' => 5],

            // country_id(3) => France, category_id(6) => politics, category_id(7) => science
            ['country_id' => 3, 'category_id' => 6],
            ['country_id' => 3, 'category_id' => 7],

            // country_id(4) => Germany, category_id(8) => sports, category_id(9) => technology
            ['country_id' => 4, 'category_id' => 8],
            ['country_id' => 4, 'category_id' => 9],
            
            // country_id(5) => United kingdom, category_id(10) => top, category_id(11) => world
            ['country_id' => 5, 'category_id' => 10],
            ['country_id' => 5, 'category_id' => 11],
        ]);
    }
}
