<?php

namespace App\Http\Resources\BookingDate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->uuid,
            "available_date" => $this->date,
            "is_active" => $this->is_active,
        ];
    }
}
