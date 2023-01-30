<?php

namespace App\Services;

use GuzzleHttp\Client;
use NewsdataIO\NewsdataApi;
use Illuminate\Support\Facades\Redis;

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
     * @param int $page
     * @return array
     * @throws ValidationException
     */
    public function getNewsData($countryCode, $languageCode, $category, $page)
    {
        try {
            // Validate if that inputs are in the correct format
            $this->validateInput($countryCode, $languageCode, $category, $page);

            $newsdataApiObj = new NewsdataApi($this->apiKey);

            // Check if the page is already in cache
            $cacheKey = "news-data-{$countryCode}-{$languageCode}-{$category}-";

             // Pass your desired strings in an array
            $data = [
                'country' => $countryCode,
                'language' => $languageCode,
                'category' => $category
            ];

            if ($page == 1) {
                $newsData = $newsdataApiObj->get_latest_news($data);
                $nextPage = $newsData->nextPage;

                if ($nextPage) {
                    $nextPageIndex = $page + 1;
                    Redis::set($cacheKey.$nextPageIndex, $nextPage);
                }

                return $newsData;
            }

            $cacheDataPage = Redis::get($cacheKey.$page);

            if ($cacheDataPage) {
                $newsData = $newsdataApiObj->get_latest_news(array_merge($data, ['page' => $cacheDataPage]));
                $nextPage = $newsData->nextPage;

                if ($nextPage) {
                    $nextPageIndex = $page + 1;
                    Redis::set($cacheKey.$nextPageIndex, $nextPage);
                }

                return $newsData;
            }

            $newsData = $newsdataApiObj->get_latest_news($data);
            
            $nextPage = $newsData->nextPage;

            if ($nextPage) {
                $pageIndex = 2;
                
                Redis::set($cacheKey.$pageIndex, $nextPage);
    
                while (true) {
                    $newsData = $newsdataApiObj->get_latest_news(array_merge($data, ['page' => $nextPage]));
                    
                    $nextPage = $newsData->nextPage;

                    if ($nextPage) {
                        $nextPageIndex = $pageIndex+1;
                        Redis::set($cacheKey.$nextPageIndex, $nextPage);
                    }
    
                    if (!$nextPage || $pageIndex == $page) {
                        break;
                    }
    
                    $pageIndex++;
                }
    
                if ($pageIndex < $page) {
                    return response()->json([
                        'error' => 'This page is not an available page for this request'
                    ], 400);
                }
    
                return $newsData;
            } else {
                return response()->json([
                    'error' => 'This page is not an available page for this request'
                ], 400);
            }

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
            'language' => 'required|string',
            'category' => 'required|string',
            'page' => 'numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

}