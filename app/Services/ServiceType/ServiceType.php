<?php

namespace App\Services\ServiceType;

use App\Models\ServiceType as Type;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\ServiceType\ServiceTypeInterface;

class ServiceType implements ServiceTypeInterface
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
}
