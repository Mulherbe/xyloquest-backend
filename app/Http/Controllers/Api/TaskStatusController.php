<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStatus\StoreTaskStatusRequest;
use App\Http\Requests\TaskStatus\UpdateTaskStatusRequest;
use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskStatusController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskStatusResource::collection(TaskStatus::all());
    }

    public function store(StoreTaskStatusRequest $request): TaskStatusResource
    {
        $data = $request->validated();
        $item = TaskStatus::create($data);
        return new TaskStatusResource($item);
    }

    public function show(TaskStatus $taskStatus): TaskStatusResource
    {
        return new TaskStatusResource($taskStatus);
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus): TaskStatusResource
    {
        $data = $request->validated();
        $taskStatus->update($data);
        return new TaskStatusResource($taskStatus);
    }

    public function destroy(TaskStatus $taskStatus): JsonResponse
    {
        $taskStatus->delete();
        return response()->json(['message' => 'TaskStatus deleted successfully.']);
    }
}
