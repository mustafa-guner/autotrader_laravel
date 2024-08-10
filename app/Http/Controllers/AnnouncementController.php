<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SaveAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $announcements = Announcement::all();
        return AnnouncementResource::collection($announcements);
    }

    public function store(SaveAnnouncementRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $announcement = Announcement::create($validated_fields);
            DB::commit();
            Log::info('Announcement with the ID ' . $announcement->id . ' has been created by ' . auth()->user()->id);
            return ResponseService::success($announcement, trans('commons.success'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating announcement: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function update(SaveAnnouncementRequest $request, $id): JsonResponse
    {
        try {
            $announcement = Announcement::find($id);
            if (!$announcement) {
                throw new NotFoundException();
            }
            $validated_fields = $request->validated();
            DB::beginTransaction();
            $announcement->update($validated_fields);
            DB::commit();
            Log::info('Announcement with the ID ' . $announcement->id . ' has been updated by ' . auth()->user()->id);
            return ResponseService::success($announcement, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating announcement: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $announcement = Announcement::find($id);
            if (!$announcement) {
                throw new NotFoundException();
            }
            DB::beginTransaction();
            $announcement->deleted_by = auth()->user()->id;
            $announcement->delete();
            DB::commit();
            Log::info('Announcement with the ID ' . $announcement->id . ' has been deleted by ' . auth()->user()->id);
            return ResponseService::success(null, trans('commons.success'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting announcement: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
