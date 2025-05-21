<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Activity
 */
class ActivityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_recurring' => $this->is_recurring,
            'recurrence_rule' => $this->recurrence_rule,
            'completed_at' => $this->completed_at,
            'activity_type_id' => $this->activity_type_id,
            'status' => $this->status,
            'earned_points' => $this->earned_points, // ✅ AJOUT ICI
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'activity_type' => new ActivityTypeResource($this->whenLoaded('activityType')),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ];
    }
}
