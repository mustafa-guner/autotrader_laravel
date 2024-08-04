<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionStatusResource;
use App\Models\TransactionStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionStatusController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $transaction_statuses = TransactionStatus::orderBy('definition')->get();
        return TransactionStatusResource::collection($transaction_statuses);
    }
}
