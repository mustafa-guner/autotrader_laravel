<?php

namespace App\Http\Controllers\Me;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class MyTransactionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $transactions =  auth()->user()->transactions();
        return TransactionResource::collection($transactions->paginate(10));
    }

    /**
     * @throws NotFoundException
     */
    public function show($id): TransactionResource|JsonResponse
    {
        try {
            $transaction = auth()->user()->transactions()->find($id);
            if (!$transaction) {
                throw new NotFoundException();
            }
            return TransactionResource::make($transaction);
        } catch (Exception $e) {
            Log::error('Error while fetching user: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
