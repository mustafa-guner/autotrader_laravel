<?php

namespace App\Http\Controllers\Me;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveBankAccountRequest;
use App\Http\Resources\BankAccountResource;
use App\Models\BankAccount;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MyBankAccountController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $bank_accounts = auth()->user()->bankAccounts;
        return BankAccountResource::collection($bank_accounts);
    }

    public function store(SaveBankAccountRequest $request): JsonResponse
    {
//        $this->authorize('create', BankAccount::class);
        try {
            $validated_fields = $request->validated();
            $validated_fields['user_id'] = auth()->user()->id;
            DB::beginTransaction();
            $bank_account = BankAccount::create($validated_fields);
            DB::commit();
            Log::info('User with id ' . auth()->id() . ' created a bank account with id ' . $bank_account->id);
            return ResponseService::success(null, 'Bank account created successfully', Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating bank account for user with id ' . auth()->id() . ': ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $bank_account = BankAccount::find($id);
            if (!$bank_account) {
                throw new NotFoundException('Bank account not found');
            }
            DB::beginTransaction();
            $bank_account->delete();
            DB::commit();
            Log::info('User with id ' . auth()->id() . ' deleted a bank account with id ' . $bank_account->id);
            return ResponseService::success(null, 'Bank account deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting bank account for user with id ' . auth()->id() . ': ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
