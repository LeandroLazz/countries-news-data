<?php

namespace App\Services;

use GuzzleHttp\Client;
use NewsdataIO\NewsdataApi;

class NewsDataService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('NEWS_DATA_API_KEY');
    }

     /**
     * Retrieve news data from the newsdata.io API.
     *
     * @param string $Code
     * @param string $languageCode
     * @param string $category
     * @param int $page
     * @return array
     * @throws ValidationException
     */
    public function getNewsData($countryCode, $languageCode, $category, $page = 1)
    {
        try {
            $this->validateInput($countryCode, $languageCode, $category, $page);

            $newsdataApiObj = new NewsdataApi($this->apiKey);

            // Pass your desired strings in an array with unique key
            $data = [
                'country' => $countryCode,
                'language' => $languageCode,
                'category' => $category,
                'page' => $page
            ];

            $newsData = $newsdataApiObj->get_latest_news($data);
            
            return $newsData;
        } catch (\Exception $e) {
            // Log the error and return a message
            \Log::error($e);
            return response()->json(['error' => 'Failed to retrieve news data from API'], 500);
        }
    }

    /**
     * Validate the input parameters.
     *
     * @param string $countryCode
     * @param string $languageCode
     * @param string $category
     * @param int $page
     * @throws ValidationException
     */
    private function validateInput($countryCode, $languageCode, $category, $page)
    {
        $validator = \Validator::make([
            'country' => $countryCode,
            'language' => $languageCode,
            'category' => $category,
            'page' => $page,
        ], [
            'country' => 'required|string|size:2',
            'language' => 'required|string|size:2',
            'category' => 'required|string',
            'page' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

}