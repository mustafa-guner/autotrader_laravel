<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentMethodSetDefaultController extends Controller
{
    public function update(int $id): JsonResponse
    {
        try {
            /**
             * @var User $user
             */
            // Check if user is authenticated
            $user = auth()->user();
            DB::beginTransaction();
            $paymentMethod = $user->paymentMethods()->find($id);
            if (!$paymentMethod) {
                throw new NotFoundException('Payment method not found');
            }
            $paymentMethod->update(['is_default' => true]);
            $user->paymentMethods()->where('id', '!=', $id)->update(['is_default' => false]);
            DB::commit();
            return ResponseService::success(null, trans('payment_method_activation.updated'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment method activation is NOT UPDATED. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
