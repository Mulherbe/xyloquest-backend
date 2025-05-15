<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'activity_id'     => $this->activity_id,
            'recurrence_rule' => $this->recurrence_rule,
            'next_occurrence' => $this->next_occurrence->toDateTimeString(),
        ];
    }
}
