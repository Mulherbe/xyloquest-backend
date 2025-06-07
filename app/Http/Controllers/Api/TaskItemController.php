<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskItem\StoreTaskItemRequest;
use App\Http\Requests\TaskItem\UpdateTaskItemRequest;
use App\Http\Resources\TaskItemResource;
use App\Models\TaskItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskItemResource::collection(TaskItem::all());
    }

    public function store(StoreTaskItemRequest $request): TaskItemResource
    {
        $data = $request->validated();
        $item = TaskItem::create($data);
        return new TaskItemResource($item);
    }

    public function show(TaskItem $taskItem): TaskItemResource
    {
        return new TaskItemResource($taskItem);
    }

    public function update(UpdateTaskItemRequest $request, TaskItem $taskItem): TaskItemResource
    {
        $data = $request->validated();
        $taskItem->update($data);
        return new TaskItemResource($taskItem);
    }

    public function destroy(TaskItem $taskItem): JsonResponse
    {
        $taskItem->delete();
        return response()->json(['message' => 'TaskItem deleted successfully.']);
    }
}
