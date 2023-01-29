<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsDataService;
use App\Models\Country;

class NewsDataController extends Controller
{
    protected $newsDataService;

    public function __construct(NewsDataService $newsDataService)
    {
        $this->newsDataService = $newsDataService;
    }

    /**
     * Retrieve news data from https://newsdata.io/ based on the given country, 
     * language, and category.
     * 
     * This function does't use any database informations
     *
     * @param string $countryCode
     * @param string $languageCode
     * @param string $category
     * @param string $page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($countryCode, $languageCode, $category, $page = "")
    {
        $newsData = $this->newsDataService->getNewsData(
            $countryCode, 
            $languageCode, 
            $category, 
            $page
        );

        return response()->json([
            'news' => $newsData
        ], 200);
    }

    /**
     * Retrieve news data from https://newsdata.io/ based on the given country
     * 
     * This function uses information from the database to request a response
     * from newsData.io API
     *
     * @param string $countryCode
     * @param string $page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countryNewsData($countryCode, $page = "")
    {
        $country = Country::where('code', $countryCode)->first();

        // Check if the country exists
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

         // Check if the country has a category
         if(!$country->categories()->exists()){
            return response()->json([
                'error' => 'Country does not have any category to search'
            ], 400);
        }  

        // Create a string of languageCode and category
        $languageCode = $country->languages()->pluck('language')->implode(',');
        $category = $country->categories()->pluck('name')->implode(',');

        $newsData = $this->newsDataService->getNewsData(
            $countryCode, 
            $languageCode, 
            $category, 
            $page
        );

        return response()->json([
            'news' => $newsData
        ], 200);
    }
}
