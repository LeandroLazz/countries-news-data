<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Country,
    Language
};

class CountriesLanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an array of countryCode and language to associate
        $data = [
            ['countryCode' => 'be', 'language' => 'nl'],
            ['countryCode' => 'ca', 'language' => 'en'],
            ['countryCode' => 'ca', 'language' => 'fr'],
            ['countryCode' => 'fr', 'language' => 'fr'],
            ['countryCode' => 'de', 'language' => 'de'],
            ['countryCode' => 'gb', 'language' => 'en']
        ];
        
        // Iterate through the data array and attach a language to a country
        foreach ($data as $dat) {
            $country = Country::where('code', $dat['countryCode'])->first();
            $language = Language::where('language', $dat['language'])->first();
            $country->languages()->attach($language);
        }
    }
}
