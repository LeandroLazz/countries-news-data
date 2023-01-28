<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
       $countries = Country::with(['languages', 'categories'])
        ->select('id', 'name', 'code')
        ->get();
       
       return response()->json([
            'countries' => $countries
        ]);
    }
}
