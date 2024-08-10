<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MyNotificationController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        $notifications = auth()->user()->notifications()->where('read_at', null)->paginate(10);
        return NotificationResource::collection($notifications);
    }
}
