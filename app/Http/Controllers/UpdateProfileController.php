<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateProfileController extends Controller
{
    public function update(UpdateProfileRequest $request)
    {
        try {
            /**
             * @var User $user
             */
            $user = auth()->user();
            $fields = $request->validated();
            if (isset($fields['new_password'])) {
                $fields['new_password'] = bcrypt($fields['new_password']);
            }
            DB::beginTransaction();
            $user->update($fields);
            DB::commit();
            Log::info('User with id ' . $user->id . ' updated his profile');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User profile is NOT UPDATED. Error: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
