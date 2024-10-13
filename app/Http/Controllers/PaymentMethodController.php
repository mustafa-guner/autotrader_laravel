<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SavePaymentMethodRequest;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentMethodController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $payment_details = auth()->user()->paymentDetails()->get();
        return PaymentMethodResource::collection($payment_details);

    }

    public function store(SavePaymentMethodRequest $request): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            $fields = $request->validated();
            $user = auth()->user();
            $fields['user_id'] = $user->id;
            DB::beginTransaction();
            $payment_detail = PaymentMethod::create($fields);
            DB::commit();
            Log::info('User with id ' . $user->id . ' has added a payment detail with id ' . $payment_detail->id);
            return ResponseService::success(null, trans('payment_detail.added'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT DEPOSITED. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }


    public function destroy(Request $request): JsonResponse
    {
        try {
            $payment_detail = PaymentMethod::where('id', $request->id)->first();
            if (!$payment_detail) {
                throw new NotFoundException(trans('payment_detail.not_found'));
            }
            DB::beginTransaction();
            $payment_detail->delete();
            DB::commit();
            Log::info('Payment detail with id ' . $payment_detail->id . ' has been deleted');
            return ResponseService::success(null, trans('payment_detail.removed'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User balance is NOT DEPOSITED. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
