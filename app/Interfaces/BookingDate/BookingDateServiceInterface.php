<?php

namespace App\Interfaces\BookingDate;

use App\Models\BookingDate;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingDateServiceInterface
{
    //
    public function storeDate(array $data): BookingDate;
    public function getDates(): LengthAwarePaginator;
    public function getDate(string $id): BookingDate;
    public function updateDate(array $data, string $id): BookingDate;
    public function deleteDate(string $id): bool;
    public function getAvailableDates(): LengthAwarePaginator;
}
