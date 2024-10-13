<?php

namespace App\Http\Controllers;

use App\Models\Ticker;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;

class TickerController extends Controller
{
    public function index(): JsonResponse
    {
        $tickers = Ticker::orderBy('name')->get();
        return ResponseService::success($tickers, trans('common.success'));
    }

//    public function show():JsonResponse
//    {
//
//    }
}
