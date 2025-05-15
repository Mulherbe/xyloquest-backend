<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'description'     => $this->description,
            'start_date'      => $this->start_date?->toDateTimeString(),
            'end_date'        => $this->end_date?->toDateTimeString(),
            'is_recurring'    => $this->is_recurring,
            'recurrence_rule' => $this->recurrence_rule,
            'completed_at'    => $this->completed_at?->toDateTimeString(),
            'activity_type'   => new ActivityTypeResource($this->whenLoaded('activityType')),
            'user'            => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ],
            'created_at'      => $this->created_at->toDateTimeString(),
        ];
    }
}
