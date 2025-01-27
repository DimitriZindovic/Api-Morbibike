<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bike' => new BikeResource($this->whenLoaded('bike')),
            'name' => $this->name,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
        ];
    }
}
