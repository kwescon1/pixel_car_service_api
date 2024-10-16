<?php

namespace App\Services\ServiceType;

use App\Models\ServiceType as Type;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\ServiceType\ServiceTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceTypeService implements ServiceTypeInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function storeServiceType(array $data): Type
    {
        return Type::create($data);
    }

    public function getServiceTypes(): LengthAwarePaginator
    {
        return Type::paginate(10);
    }

    public function getServiceType(string $id): Type
    {
        $type = Type::whereUuid($id)->first();

        if (!$type) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        return $type;
    }

    public function deleteServiceType(string $id): bool
    {
        $type = $this->getServiceType($id);

        if (!$type) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        return $type->delete();
    }
    public function updateServiceType(array $data, string $id): Type
    {

        $type = $this->getServiceType($id);

        if (!$type) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        $type->update($data);

        // Return the updated resource
        return $type;
    }
}
