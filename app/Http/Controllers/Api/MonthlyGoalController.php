<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MonthlyGoal\StoreMonthlyGoalRequest;
use App\Http\Requests\MonthlyGoal\UpdateMonthlyGoalRequest;
use App\Http\Resources\MonthlyGoalResource;
use App\Models\MonthlyGoal;

class MonthlyGoalController extends Controller
{
    public function index()
    {
        return MonthlyGoalResource::collection(
            MonthlyGoal::all()
        );
    }

    public function store(StoreMonthlyGoalRequest $request)
    {
        $monthlyGoal = MonthlyGoal::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'year' => $request->year,
                'month' => $request->month,
            ],
            [
                'goal_points' => $request->goal_points,
            ]
        );

        return new MonthlyGoalResource($monthlyGoal);
    }

    public function show(MonthlyGoal $monthlyGoal)
    {
        return new MonthlyGoalResource($monthlyGoal);
    }

    public function update(UpdateMonthlyGoalRequest $request, MonthlyGoal $monthlyGoal)
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
