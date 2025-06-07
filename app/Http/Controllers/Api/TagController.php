<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TagResource::collection(Tag::all());
    }

    public function store(StoreTagRequest $request): TagResource
    {
        $data = $request->validated();
        $item = Tag::create($data);
        return new TagResource($item);
    }

    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag): TagResource
    {
        $data = $request->validated();
        $tag->update($data);
        return new TagResource($tag);
    }

    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();
        return response()->json(['message' => 'Tag deleted successfully.']);
    }
}
