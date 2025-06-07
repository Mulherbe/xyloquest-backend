<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskComment\StoreTaskCommentRequest;
use App\Http\Requests\TaskComment\UpdateTaskCommentRequest;
use App\Http\Resources\TaskCommentResource;
use App\Models\TaskComment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TaskCommentResource::collection(TaskComment::all());
    }
    public function getCommentByTask(Request $request)
    {
        $taskId = $request->query('task_id');

        return TaskCommentResource::collection(
            TaskComment::with('user')
                ->where('task_id', $taskId)
                ->latest()
                ->get()
        );
    }

    public function store(StoreTaskCommentRequest $request): TaskCommentResource
    {
        $data = $request->validated();
        $item = TaskComment::create($data);
        return new TaskCommentResource($item);
    }

    public function show(TaskComment $taskComment): TaskCommentResource
    {
        return new TaskCommentResource($taskComment);
    }

    public function update(UpdateTaskCommentRequest $request, TaskComment $taskComment): TaskCommentResource
    {
        $data = $request->validated();
        $taskComment->update($data);
        return new TaskCommentResource($taskComment);
    }

    public function destroy(TaskComment $taskComment): JsonResponse
    {
        $taskComment->delete();
        return response()->json(['message' => 'TaskComment deleted successfully.']);
    }
}
