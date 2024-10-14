<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreated;
use App\Http\Requests\BuyShareRequest;
use App\Http\Requests\SellShareRequest;
use App\Http\Resources\ShareResource;
use App\Models\NotificationUser;
use App\Models\User;
use App\Models\UserShare;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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


    public function buy(BuyShareRequest $request): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $user = auth()->user();
            $fields = $request->validated();

            //check if user has enough balance
            $balance = $user->userBalance->balance;

            if ($balance < $fields['amount'] * $fields['price']) {
                return ResponseService::fail(trans('shares.buy.insufficient_balance'));
            }

            DB::beginTransaction();

            $share = UserShare::create([
                'quantity' => $fields['amount'],
                'action_type' => 'buy',
                'name' => $fields['name'],
                'symbol' => $fields['symbol'],
                'exchange' => $fields['exchange'],
                'price' => $fields['price'],
                'user_id' => $user->id
            ]);

            $user->userBalance->update([
                'balance' => $balance - ($fields['amount'] * $fields['price'])
            ]);

            //create notification and fire the event
            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => trans('shares.buy.success'),
                'is_read' => false
            ]);

            $data = [
                'balance' => $user->userBalance->balance,
            ];

            DB::commit();
            broadcast(new NotificationCreated($notification, $data))->toOthers();
            Log::info('Share with id ' . $share->id . ' has been bought by user with id ' . $user->id);
            return ResponseService::success(null, trans('shares.buy.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Share is could not be bought. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('shares.buy.error'));
        }
    }

    public function sell(SellShareRequest $request): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $fields = $request->validated();
            $user = auth()->user();
            $balance = $user->userBalance->balance;

            $shares = $user->shares()->where('name', $fields['name'])->get();

            if ($shares->count() === 0) {
                return ResponseService::fail(trans('shares.sell.no_shares'));
            }

            $totalQuantity = $shares->sum('quantity');
            if ($totalQuantity < $fields['amount']) {
                return ResponseService::fail(trans('shares.sell.insufficient_shares'));
            }

            DB::beginTransaction();

            $totalValue = 0;
            /**
             * @var UserShare $share
             */
            foreach ($shares as $share) {
                if ($fields['amount'] > 0) {
                    $quantity = min($fields['amount'], $share->quantity);
                    $fields['amount'] -= $quantity;
                    $share->update([
                        'quantity' => $share->quantity - $quantity
                    ]);
                    $totalValue += ($quantity * $fields['price']);
                }
            }

            $user->userBalance->update([
                'balance' => $balance + $totalValue
            ]);

            $notification = NotificationUser::create([
                'user_id' => $user->id,
                'message' => trans('shares.sell.success'),
                'is_read' => false
            ]);

            $data = [
                'balance' => $user->userBalance->balance,
            ];

            DB::commit();
            broadcast(new NotificationCreated($notification, $data))->toOthers();
            Log::info('Shares have been sold by user with id ' . $user->id);
            return ResponseService::success(null, trans('shares.sell.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Share could not be sold. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('shares.sell.error'));
        }
    }
}
