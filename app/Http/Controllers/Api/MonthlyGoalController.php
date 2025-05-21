<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MonthlyGoal\StoreMonthlyGoalRequest;
use App\Http\Requests\MonthlyGoal\UpdateMonthlyGoalRequest;
use App\Http\Resources\MonthlyGoalResource;
use App\Models\MonthlyGoal;
use Illuminate\Support\Carbon;
use App\Models\Activity;
use Illuminate\Http\Request;

class MonthlyGoalController extends Controller
{
    public function index()
    {
        return MonthlyGoalResource::collection(MonthlyGoal::all());
    }
    public function summary(Request $request)
    {
        $now = Carbon::now();
        $userId = $request->user()->id;

        $goal = MonthlyGoal::where('user_id', $userId)
            ->where('year', $now->year)
            ->where('month', $now->month)
            ->first();

       $points = Activity::where('user_id', $userId)
        ->whereYear('start_date', $now->year)
        ->whereMonth('start_date', $now->month)
        ->where('status', 'done') // Ajout de la condition sur le statut
        ->sum('earned_points');

        return response()->json([
            'goal_points' => $goal?->goal_points ?? 0,
            'earned_points' => $points,
        ]);
    }
    public function store(StoreMonthlyGoalRequest $request): MonthlyGoalResource
    {
        $data = $request->validated();

        $monthlyGoal = MonthlyGoal::query()->updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'year' => $data['year'],
                'month' => $data['month'],
            ],
            [
                'goal_points' => $data['goal_points'],
            ]
        );

        return new MonthlyGoalResource($monthlyGoal);
    }

    public function show(MonthlyGoal $monthlyGoal): MonthlyGoalResource
    {
        return new MonthlyGoalResource($monthlyGoal);
    }

    public function update(UpdateMonthlyGoalRequest $request, MonthlyGoal $monthlyGoal): MonthlyGoalResource
    {
        $monthlyGoal->update($request->validated());

        return new MonthlyGoalResource($monthlyGoal);
    }

    public function destroy(MonthlyGoal $monthlyGoal)
    {
        $monthlyGoal->delete();

        return response()->noContent();
    }
}
