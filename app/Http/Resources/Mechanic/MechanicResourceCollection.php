<?php

namespace App\Http\Resources\Mechanic;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MechanicResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mechanics' => MechanicResource::collection($this->collection),
            'pagination' => $this->isPaginated() ? [
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),
            ] : null,
            'meta' => [
                'status' => 'success',
                'total_mechanics' => $this->collection->count(),
                'created_at' => $this->collection->first()?->created_at,
                'updated_at' => $this->collection->first()?->updated_at,
            ],
            'links' => [
                'self' => route('mechanics.index'),
            ],
        ];
    }

    /**
     * Check if the resource collection is paginated.
     *
     * @return bool
     */
    public function isPaginated(): bool
    {
        return $this->resource instanceof LengthAwarePaginator;
    }
}
