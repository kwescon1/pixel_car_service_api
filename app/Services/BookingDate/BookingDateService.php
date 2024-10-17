<?php

namespace App\Services\BookingDate;

use App\Models\BookingDate;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\BookingDate\BookingDateServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookingDateService implements BookingDateServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function storeDate(array $data): BookingDate
    {
        return BookingDate::create($data);
    }

    public function getDates(): LengthAwarePaginator
    {
        return BookingDate::paginate(10);
    }

    public function updateDate(array $data, string $id): BookingDate
    {
        $date = $this->getDate($id);

        $date->update($data);

        return $date;
    }

    public function getDate(string $id): BookingDate
    {
        $date = BookingDate::whereUuid($id)->first();

        if (!$date) {
            throw new NotFoundHttpException(__('app.resource_not_found'));
        }

        return $date;
    }

    public function deleteDate(string $id): bool
    {
        $date = $this->getDate($id);


        return $date->delete();
    }
}
