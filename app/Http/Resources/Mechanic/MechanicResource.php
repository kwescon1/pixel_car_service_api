<?php

namespace App\Http\Resources\Mechanic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MechanicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'years_of_experience' => $this->years_of_experience,
            'specialty' => $this->specialty,
            'avatar' => $this->avatar,
            'is_active' => $this->is_active,
        ];
    }
}
