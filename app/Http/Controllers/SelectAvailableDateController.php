<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingDate\BookingDateResource;
use App\Http\Resources\BookingDate\BookingDateResourceCollection;
use App\Interfaces\BookingDate\BookingDateServiceInterface;
use Illuminate\Http\Request;

class SelectAvailableDateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, BookingDateServiceInterface $bookingDateService)
    {
        $service_id = $request->query('service');

        $availableDates = $bookingDateService->getAvailableDates();

        return response()->success(__('app.operation_successful'), new BookingDateResourceCollection($availableDates));
    }
}
