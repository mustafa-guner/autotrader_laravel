<?php

namespace App\Http\Controllers\Feedback;

use App\Events\FeedbackSubmitted;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveFeedbackRequest;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FeedbackController extends Controller
{
    public function index(): FeedbackResource
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return FeedbackResource::make($feedbacks);
    }

    public function store(SaveFeedbackRequest $request): JsonResponse
    {
        try {
            $validated_fields = $request->validated();
            $validated_fields['user_id'] = auth()->user()->id;
            DB::beginTransaction();
            $feedback = Feedback::create($validated_fields);
            event(new FeedbackSubmitted($feedback));
            DB::commit();
            Log::info('Feedback with id ' . $feedback->id . ' has been created successfully by user: ' . auth()->user()->id);
           return ResponseService::success(null, trans('commons.success'), Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating feedback: ' . $e->getMessage());
            return ResponseService::fail(trans('commons.fail'));
        }
    }
}
