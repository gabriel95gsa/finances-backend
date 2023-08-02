<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return NotificationResource::collection(Notification::where('user_id', auth()->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Notification $notification
     * @return JsonResource
     */
    public function show(Notification $notification): JsonResource
    {
        $this->authorize('view', $notification);

        return new NotificationResource($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification): JsonResponse
    {
        $this->authorize('update', $notification);

        $validated = $request->safe()->only(['read']);

        $notification->update($validated);

        return response()->json([
            'message' => 'Notification updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
