<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Log\StoreLogRequest;
use App\Http\Requests\Log\UpdateLogRequest;
use App\Http\Resources\LogResource;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        return LogResource::collection(Log::with(['user', 'activity'])->get());
    }

    public function store(StoreLogRequest $request)
    {
        $log = Log::create($request->validated());
        return new LogResource($log->load(['user', 'activity']));
    }

    public function show(Log $log)
    {
        return new LogResource($log->load(['user', 'activity']));
    }

    public function update(UpdateLogRequest $request, Log $log)
    {
        $log->update($request->validated());
        return new LogResource($log->load(['user', 'activity']));
    }

    public function destroy(Log $log)
    {
        $log->delete();
        return response()->noContent();
    }
}
