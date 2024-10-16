<?php

namespace App\Interfaces\CarService;

use App\Models\CarService;
use App\Models\ServiceType;
use Illuminate\Pagination\LengthAwarePaginator;

interface CarServiceInterface
{
    public function storeCarService(array $data, ServiceType $serviceType): CarService;
    public function getCarServices(): LengthAwarePaginator;
    public function getCarService(string $id): CarService;
    public function deleteCarService(string $id): bool;
    public function updateCarService(array $data, string $id): CarService;
}
