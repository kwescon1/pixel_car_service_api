<?php

namespace App\Services\CarService;

use App\Models\CarService;
use App\Models\ServiceType;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\CarService\CarServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarServiceService implements CarServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function storeCarService(array $data, ServiceType $serviceType): CarService
    {

        return $serviceType->carServices()->create($data);
    }

    public function getCarServices(): LengthAwarePaginator
    {
        return CarService::with('serviceType')->paginate(10);
    }

    public function getCarService(string $id): CarService
    {
        $carService = CarService::with('serviceType')->where('uuid', $id)->first();

        if (!$carService) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        return $carService;
    }

    public function deleteCarService(string $id): bool
    {
        $carService = $this->getCarService($id);

        if (!$carService) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        return $carService->delete();
    }
    public function updateCarService(array $data, string $id): CarService
    {
        $serviceType = ServiceType::where('uuid', $data['service_type_id'])->firstOrFail();

        $carService = $this->getCarService($id);

        $data['service_type_id'] = $serviceType->id;

        $carService->update($data);

        return $carService;
    }

    public function filterByServiceType(?string $type): LengthAwarePaginator
    {
        return CarService::filterByServiceType($type)->paginate(10);
    }
}
