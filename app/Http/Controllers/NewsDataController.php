<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NewsDataService;

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
}
