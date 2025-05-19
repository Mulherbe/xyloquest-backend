<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityTypeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'default_points_per_hour' => $this->default_points_per_hour, // ✅ LE CHAMP MANQUANT
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
