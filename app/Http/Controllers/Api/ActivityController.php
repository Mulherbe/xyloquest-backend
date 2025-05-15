<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        return ActivityResource::collection(
            Activity::with(['activityType', 'user'])->get()
        );
    }

   public function store(StoreActivityRequest $request)
    {
        $data = $request->validated();

        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }

        $activity = Activity::create($data);

        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }


    public function show(Activity $activity)
    {
        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());

        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->noContent();
    }
}
