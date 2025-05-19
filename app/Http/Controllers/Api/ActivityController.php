<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\ActivityType;
use Carbon\Carbon;

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

        $data['earned_points'] = $this->calculatePoints(
            $data['start_date'],
            $data['end_date'],
            $data['activity_type_id']
        );

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
        $data = $request->validated();

        $start = $data['start_date'] ?? $activity->start_date;
        $end = $data['end_date'] ?? $activity->end_date;
        $activityTypeId = $data['activity_type_id'] ?? $activity->activity_type_id;

        $data['earned_points'] = $this->calculatePoints(
            $start,
            $end,
            $activityTypeId
        );

        $activity->update($data);

        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }

    public function destroy(Activity $activity)
    {
        $userId = $activity->user_id;
        $year = Carbon::parse($activity->start_date)->year;
        $month = Carbon::parse($activity->start_date)->month;

        $activity->delete();

        $updatedPoints = Activity::where('user_id', $userId)
            ->whereYear('start_date', $year)
            ->whereMonth('start_date', $month)
            ->sum('earned_points');

        return response()->json([
            'message' => 'Activity deleted successfully.',
            'updated_monthly_points' => $updatedPoints,
        ]);
    }

private function calculatePoints(string $startDate, string $endDate, int $activityTypeId): int
{
    $start = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);

    // Important : calcule la différence dans le bon sens
    $durationInMinutes = $start->diffInMinutes($end); // ✅ pas besoin de 'false'
    $durationInHours = $durationInMinutes / 60;
    $pointsPerHour = ActivityType::find($activityTypeId)?->default_points_per_hour ?? 0;

    return round($durationInHours * $pointsPerHour);
}


}
