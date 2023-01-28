<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Country,
    Category
};

class CountriesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Create an array of countryCode and categoryName to associate
       $data = [
            ['countryCode' => 'be', 'categoryName' => 'business'],
            ['countryCode' => 'ca', 'categoryName' => 'entertainment'],
            ['countryCode' => 'ca', 'categoryName' => 'environment'],
            ['countryCode' => 'fr', 'categoryName' => 'food'],
            ['countryCode' => 'de', 'categoryName' => 'health'],
            ['countryCode' => 'gb', 'categoryName' => 'politics']
        ];
        
        // Iterate through the data array and attach a category to a country
        foreach ($data as $dat) {
            $country = Country::where('code', $dat['countryCode'])->first();
            $category = Category::where('name', $dat['categoryName'])->first();
            $country->categories()->attach($category);
        }
    }
}
