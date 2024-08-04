<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionStatusResource;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionTypeController extends Controller
{
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $transaction_types = TransactionType::orderBy('definition')->get();
        return TransactionStatusResource::collection($transaction_types);
    }
}
