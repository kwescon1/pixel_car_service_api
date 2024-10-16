<?php

namespace App\Interfaces\ServiceType;

use App\Models\ServiceType as Type;
use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceTypeInterface
{
    public function storeServiceType(array $data): Type;
    public function getServiceTypes(): LengthAwarePaginator;
    public function getServiceType(string $id): Type;
    public function deleteServiceType(string $id): bool;
    public function updateServiceType(array $data, string $id): Type;
}
