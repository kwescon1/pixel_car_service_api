<?php

namespace App\Http\Resources\CarService;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ServiceType\ServiceTypeResource;

class CarServiceResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,

            "service_type" => $this->whenLoaded('serviceType', function () {
                return new ServiceTypeResource($this->serviceType);
            }),
            "price" => $this->price,
        ];
    }
}
