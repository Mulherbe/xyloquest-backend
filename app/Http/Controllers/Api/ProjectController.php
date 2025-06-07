<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection(Project::all());
    }

    public function store(StoreProjectRequest $request): ProjectResource
    {
        $data = $request->validated();
        $item = Project::create($data);
        return new ProjectResource($item);
    }

    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $data = $request->validated();
        $project->update($data);
        return new ProjectResource($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
