<?php

namespace App\Http\Resources\ServiceType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceTypeResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'types' => ServiceTypeResource::collection($this->collection),
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
                'total_types' => $this->collection->count(),
                'created_at' => $this->collection->first()?->created_at,
                'updated_at' => $this->collection->first()?->updated_at,
            ],
            'links' => [
                'self' => route('service-types.index'),
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
