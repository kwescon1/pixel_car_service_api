<?php

namespace App\Interfaces\ServiceType;

use App\Models\ServiceType as Type;
use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceTypeInterface
{
    public function storeServiceType(array $data): Type;
    public function getServiceTypes(): LengthAwarePaginator;
}
