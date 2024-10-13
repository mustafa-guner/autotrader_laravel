<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShareRequest;
use App\Http\Resources\ShareResource;
use App\Models\User;
use App\Models\UserShare;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShareController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        /**
         * @var User $user
         */
        $user = auth()->user();
        $shares = $user->shares()->with('share')->get();
        return ShareResource::collection($shares);
    }


    public function store(ShareRequest $request): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $user = auth()->user();
            $fields = $request->validated();

            //check if user has enough balance
            $balance = $user->userBalance->balance;

            if ($balance < $fields['quantity'] * $fields['price']) {
                return ResponseService::fail(trans('shares.buy.insufficient_balance'));
            }

            DB::beginTransaction();

            $share = UserShare::create([
                'quantity' => $fields['quantity'],
                'action_type' => 'buy',
                'name' => $fields['name'],
                'symbol' => $fields['symbol'],
                'exchange' => $fields['exchange'],
                'price' => $fields['price'],
                'user_id' => $user->id
            ]);

            DB::commit();
            Log::info('Share with id ' . $share->id . ' has been bought by user with id ' . $user->id);
            return ResponseService::success(null, trans('shares.buy.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Share is could not be bought. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('shares.buy.error'));
        }
    }
}
