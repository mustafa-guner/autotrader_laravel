<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CountryController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $countries = Country::orderBy('name')->get();
        return CountryResource::collection($countries);
    }
}
