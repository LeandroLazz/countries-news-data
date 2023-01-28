<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

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
        ]);
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
        ->where('code', $code)->firstOrFail();

        return response()->json([
            'country' => $country
        ]);
    }
}
