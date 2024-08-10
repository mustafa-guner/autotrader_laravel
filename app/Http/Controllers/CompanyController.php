<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SaveCompanyRequest;
use App\Http\Resources\BankResource;
use App\Models\Company;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $company = Company::orderBy('name')->get();
        return BankResource::collection($company);
    }

    public function store(SaveCompanyRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $company = Company::create($validated_fields);
            DB::commit();
            Log::info('Company with the ID ' . $company->id . ' has been created by ' . auth()->user()->id);
            return ResponseService::success($company, trans('commons.success'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating company: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    /**
     * @param SaveCompanyRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(SaveCompanyRequest $request, $id): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            $company = Company::find($id);
            if (!$company) {
                throw new NotFoundException();
            }
            DB::beginTransaction();
            $company = $company->update($validated_fields);
            DB::commit();
            Log::info('Company with the ID ' . $company->id . ' has been updated by ' . auth()->user()->id);
            return ResponseService::success($company, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating bank: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $company = Company::find($id);
            if (!$company) {
                throw new NotFoundException();
            }
            DB::beginTransaction();
            $company->delete();
            DB::commit();
            Log::info('Company with the ID ' . $company->id . ' has been deleted by ' . auth()->user()->id);
            return ResponseService::success(null, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting company: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
