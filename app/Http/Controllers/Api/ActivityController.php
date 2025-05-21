<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\ActivityType;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ActivityController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ActivityResource::collection(
            Activity::with(['activityType', 'user'])->get()
        );
    }

    public function store(StoreActivityRequest $request): ActivityResource
    {
        $data = $request->validated();

        $data['status'] = $data['status'] ?? 'pending';

        $data['earned_points'] = $this->calculatePoints(
            $data['start_date'],
            $data['end_date'],
            $data['activity_type_id']
        );

        /** @var Activity $activity */
        $activity = Activity::query()->create($data);

        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }

    public function show(Activity $activity): ActivityResource
    {
        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }

    public function update(UpdateActivityRequest $request, Activity $activity): ActivityResource
    {
        $data = $request->validated();

        $start = $data['start_date'] ?? $activity->start_date;
        $end = $data['end_date'] ?? $activity->end_date;
        $typeId = $data['activity_type_id'] ?? $activity->activity_type_id;

        $data['earned_points'] = $this->calculatePoints(
            $start,
            $end,
            $typeId
        );

        $activity->update($data);

        return new ActivityResource(
            $activity->load(['activityType', 'user'])
        );
    }

    public function destroy(Activity $activity): JsonResponse
    {
        $userId = $activity->user_id;
        $year = Carbon::parse($activity->start_date)->year;
        $month = Carbon::parse($activity->start_date)->month;

        $activity->delete();

        $updatedPoints = Activity::query()
            ->where('user_id', $userId)
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

        $durationInMinutes = $start->diffInMinutes($end);
        $durationInHours = $durationInMinutes / 60;

        $type = ActivityType::query()->find($activityTypeId);
        $pointsPerHour = $type ? $type->default_points_per_hour : 0;

        return (int) round($durationInHours * $pointsPerHour);
    }
}
