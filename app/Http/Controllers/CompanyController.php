<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CompanyController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $company = Company::orderBy('name')->get();
        return CompanyResource::collection($company);
    }
}
