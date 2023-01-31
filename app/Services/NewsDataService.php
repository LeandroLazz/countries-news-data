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
     * 
     * @return array
     */
    public function getNewsData($countryCode, $languageCode, $category, $page)
    {
        try {
            // Validate input data
            $this->validateInput($countryCode, $languageCode, $category, $page);

            $newsdataApiObj = new NewsdataApi($this->apiKey);

            // Get news data and next page from cache or API
            $newsData = $this->getNewsDataFromCacheOrAPI($newsdataApiObj, $countryCode, $languageCode, $category, $page);

            return $newsData;

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->validator->messages()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get news data from cache or API.
     * 
     * @param NewsdataApi $newsdataApiObj
     * @param string $countryCode
     * @param string $languageCode
     * @param string $category
     * @param int $page
     * 
     * @return array
     */
    private function getNewsDataFromCacheOrAPI($newsdataApiObj, $countryCode, $languageCode, $category, $page)
    {
        // Cache key for redis
        $cacheKey = "news-data-{$countryCode}-{$languageCode}-{$category}-";

        // Get news data from cache if exists
        if (Redis::exists($cacheKey.$page)) {
            $newsDataCachePage = json_decode(Redis::get($cacheKey.$page));

            return $newsDataCachePage;
        }

        // Request data to be sent to API
        $requestData = [
            'country' => $countryCode,
            'language' => $languageCode,
            'category' => $category
        ];

        $newsData = $this->getNewsDataFromAPIAndStoreInCache($newsdataApiObj, $requestData, $cacheKey, $page);
        
        return $newsData;
    }

    /**
     * Get news data from API and store all pages in cache
     * 
     * @param NewsdataApi $newsdataApiObj
     * @param array $requestData
     * @param string $cacheKey
     * @param int $page
     * @param int $currentPageIndex
     * 
     * @return array
     */
    private function getNewsDataFromAPIAndStoreInCache($newsdataApiObj, $requestData, $cacheKey, $page, $currentPageIndex = 1)
    {
        // Get news data page from API
        $newsData = $newsdataApiObj->get_latest_news($requestData);
        $nextPage = $newsData->nextPage;
        $newsDataJsonEncode = json_encode($newsData);

        // Store news data in cache if exists
        $this->storeNewsDataInCacheIfExistsTest($cacheKey, $currentPageIndex, $newsDataJsonEncode);

        // Recursively call if next page exists and current page is smaller than page 
        if ($nextPage && $currentPageIndex < $page) {
            $currentPageIndex++;
            $requestData['page'] = $nextPage;
            
            // Recursively call this method until no next page exists
            return $this->getNewsDataFromAPIAndStoreInCache($newsdataApiObj, $requestData, $cacheKey, $page, $currentPageIndex);
        }

        // Validate page
        if (!$nextPage && $currentPageIndex < $page) {
            throw new \Exception('This page is not an available page for this request');
        }

        return $newsData;
    }

    /**
     * Store news data in cache.
     * 
     * @param string $cacheKey
     * @param int $pageIndex
     * @param string $newsData
     * 
     * @return void
     */
    private function storeNewsDataInCacheIfExistsTest($cacheKey, $pageIndex, $newsData)
    {
        if ($newsData) {
            Redis::set($cacheKey.$pageIndex, $newsData);
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