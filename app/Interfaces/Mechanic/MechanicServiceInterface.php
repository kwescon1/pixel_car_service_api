<?php

namespace App\Interfaces\Mechanic;

use App\Models\Mechanic;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

interface MechanicServiceInterface
{
    //
    public function storeMechanicDetails(array $data, ?UploadedFile $file): Mechanic;
    public function getMechanics(): LengthAwarePaginator;
    public function getMechanic(string $id): Mechanic;
    public function updateMechanic(array $data, string $id, ?UploadedFile $file): Mechanic;
    public function getAvailableMechanics(?string $date): ?LengthAwarePaginator;
    public function deleteMechanic(string $id): bool;
}
