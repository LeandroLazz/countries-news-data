<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Country,
    Category
};

class CountryController extends Controller
{
    /**
     * Returns a list of all countries including their languages and categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
       $countries = Country::with(['languages', 'categories'])
       ->select('id', 'name', 'code')
       ->get();
       
       return response()->json([
            'countries' => $countries
        ], 200);
    }

    /**
     * Show the details of a specific country by its code
     *
     * @param string $code the country code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($code)
    {
        $country = Country::with(['languages', 'categories'])
        ->select('id', 'name', 'code')
        ->where('code', $code)->first();

        // Check if the country exists
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        return response()->json([
            'country' => $country
        ], 200);
    }

    /**
     * Add a new country category 
     *
     * @param string $code the country code
     * @param string $categoryName the category name
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory($code, $categoryName)
    {
        // Check if the country exists
        $country = Country::where('code', $code)->first();
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }
        
        // Check if the category exists
        $category = Category::where('name', $categoryName)->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Check if the country already has the category
        if($country->categories()->where('category_id', $category->id)->exists()){
            return response()->json(['error' => 'Category already exists in the country'], 400);
        }        

        // Add a new country category and return a response
        $country->categories()->attach($category);

        return response()->json([
            'message' => 'Category successfully added to country'
        ], 201);
    }

    /**
     * Remove a country category
     *
     * @param string $code the country code
     * @param string $categoryName the category name
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCategory($code, $categoryName)
    {
        // Check if the country exists
        $country = Country::where('code', $code)->first();
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        // Check if the category exists
        $category = Category::where('name', $categoryName)->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Check if the country has the category
        if(!$country->categories()->where('category_id', $category->id)->exists()){
            return response()->json(['error' => 'Country does not have this category'], 400);
        }  

        // Remove the country category and return a response
        $country->categories()->detach($category);

        return response()->json([
            'message' => 'Category successfully removed from country'
        ], 200);
    }
}
