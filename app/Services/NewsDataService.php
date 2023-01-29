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
     * @param string $countryCode 
     * @param string $languageCode
     * @param string $category
     * @param string $page
     * @return array
     * @throws ValidationException
     */
    public function getNewsData($countryCode, $languageCode, $category, $page)
    {
        try {
            $this->validateInput($countryCode, $languageCode, $category, $page);

            $newsdataApiObj = new NewsdataApi($this->apiKey);
            
            // Pass your desired strings in an array
            $data = [
                'country' => $countryCode,
                'language' => $languageCode,
                'category' => $category
            ];
            
            $newsData = $newsdataApiObj->get_latest_news($data);

            // $pageArray = $newsData->nextPage;

            // while (true) {
            //     $response = $newsdataApiObj->get_latest_news(array_merge($data, ['page' => $pageArray]));
            //     // Do something with the response, such as adding it to an array or storing it in a variable
            //     $pageArray = $response->nextPage;

            //     dd($pageArray);
            //     if (!$page) {
            //         break;
            //     }
            // }



            
            return $newsData;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->messages()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve news data from API'
            ], 500);
        }
    }

    /**
     * Validate the input parameters.
     *
     * @param string $countryCode
     * @param string $languageCode
     * @param string $category
     * @param string $page
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
            'language' => 'required|string',
            'category' => 'required|string',
            'page' => 'string',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

}