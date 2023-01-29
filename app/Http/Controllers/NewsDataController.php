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

    public function index($countryCode, $languageCode, $category, $page = 1)
    {
        $newsData = $this->newsDataService->getNewsData($countryCode, $languageCode, $category, $page);

        return response()->json([
            'news' => $newsData
        ], 200);
    }

    public function countryNewsData($countryCode, $page = 1)
    {
        $country = Country::where('code', $countryCode)->first();

        // Check if the country exists
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $languageCode = $country->languages()->pluck('language')->implode(',');
        $category = $country->categories()->pluck('name')->implode(',');

        $newsData = $this->newsDataService->getNewsData($countryCode, $languageCode, $category, $page);

        return response()->json([
            'news' => $newsData
        ], 200);
    }
}
