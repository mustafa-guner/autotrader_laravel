<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenderController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $genders = Gender::orderBy('definition')->get();
        return GenderResource::collection($genders);
    }
}
