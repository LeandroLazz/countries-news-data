<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'business'],
            ['name' => 'entertainment'],
            ['name' => 'environment'],
            ['name' => 'food'],
            ['name' => 'health'],
            ['name' => 'politics'],
            ['name' => 'science'],
            ['name' => 'sports'],
            ['name' => 'technology'],
            ['name' => 'top'],
            ['name' => 'world'],
        ]);
    }
}
