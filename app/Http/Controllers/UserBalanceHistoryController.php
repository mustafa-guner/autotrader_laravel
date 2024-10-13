<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserBalanceHistoryResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserBalanceHistoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $balanceHistory = auth()->user()->userBalanceHistory()->take(10)->orderBy('created_at','desc')->get();
        return UserBalanceHistoryResource::collection($balanceHistory);
    }
}
