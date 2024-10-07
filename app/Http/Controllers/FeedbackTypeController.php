<?php

namespace App\Http\Controllers;


use App\Http\Resources\FeedbackTypeResource;
use App\Models\FeedbackType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FeedbackTypeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $feedback_types = FeedbackType::orderBy('name', 'asc')->get();
        return FeedbackTypeResource::collection($feedback_types);
    }
}
