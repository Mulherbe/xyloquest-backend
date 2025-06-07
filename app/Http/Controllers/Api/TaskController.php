<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function byProject(Project $project): AnonymousResourceCollection
    {
        return TaskResource::collection(
            $project->tasks()->with('taskStatus')->get()
        );
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $data = $request->validated();
        $item = Task::create($data);
        return new TaskResource($item);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $data = $request->validated();
        $oldCompleted = $task->task_status_id === 3; // Check if it was completed
        $newCompleted = ($data['task_status_id'] ?? $task->task_status_id) === 3; // Check if will be completed

        $task->update($data);

        // Task is being marked as complete (status 3)
        if ($newCompleted && !$oldCompleted) {
            // Add points to project
            $task->project->increment('current_points', $task->points);
        }
        // Task is being unmarked as complete (moved from status 3 to another status)
        elseif (!$newCompleted && $oldCompleted) {
            // Remove points from project
            $task->project->decrement('current_points', $task->points);
        }

        return new TaskResource($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully.']);
    }

    public function linkActivity(Request $request, Task $task): JsonResponse
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'activity_type_id' => 'required|exists:activity_types,id',
        ]);

        $activity = Activity::create([
            'user_id' => $task->project->user_id ?? Auth::id(),
            'title' => 'Tâche planifiée : ' . $task->title,
            'description' => $task->description ?? '',
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'is_recurring' => false,
            'recurrence_rule' => null,
            'completed_at' => null,
            'activity_type_id' => $data['activity_type_id'],
            'status' => 'pending',
            'earned_points' => $task->points,
        ]);

        $task->update(['activité_id' => $activity->id]);

        return response()->json([
            'message' => 'Activité liée à la tâche.',
            'activity_id' => $activity->id,
        ]);
    }
}
