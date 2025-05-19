<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityType\StoreActivityTypeRequest;
use App\Http\Requests\ActivityType\UpdateActivityTypeRequest;
use App\Http\Resources\ActivityTypeResource;
use App\Models\ActivityType;

class ActivityTypeController extends Controller
{
    public function index()
    {
        return ActivityTypeResource::collection(ActivityType::all());
    }

    public function store(StoreActivityTypeRequest $request)
    {
        $type = ActivityType::create($request->validated());
        return new ActivityTypeResource($type);
    }

    public function show(ActivityType $activityType)
    {
        return new ActivityTypeResource($activityType);
    }

    public function update(UpdateActivityTypeRequest $request, ActivityType $activityType)
    {
        $activityType->update($request->validated());
        return new ActivityTypeResource($activityType);
    }

    public function destroy(ActivityType $activityType)
    {
        $activityType->delete();
        return response()->noContent();
    }
}
