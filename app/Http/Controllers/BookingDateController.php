<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingDateRequest;
use App\Http\Requests\UpdateBookingDateRequest;
use App\Http\Resources\BookingDate\BookingDateResource;
use App\Http\Resources\BookingDate\BookingDateResourceCollection;
use App\Interfaces\BookingDate\BookingDateServiceInterface;
use Illuminate\Http\Request;

class BookingDateController extends Controller
{
    protected $bookingDateService;
    /**
     * constructor class
     */
    public function __construct(BookingDateServiceInterface $bookingDateService)
    {
        $this->bookingDateService = $bookingDateService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dates = $this->bookingDateService->getDates();

        return response()->success(__('app.operation_successful'), new BookingDateResourceCollection($dates));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingDateRequest $request)
    {

        $data = $request->validated();


        $availableDate = $this->bookingDateService->storeDate($data);

        return response()->created(__('app.resource_created'), new BookingDateResource($availableDate));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->success(__('app.operation_successful'), new BookingDateResource($this->bookingDateService->getDate($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingDateRequest $request, string $id)
    {
        //
        $data = $request->validated();

        // Update the the mechanic data
        $updatedDate = $this->bookingDateService->updateDate($data, $id);

        return response()->success(__('app.operation_successful'), new BookingDateResource($updatedDate));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->bookingDateService->deleteDate($id);
        return response()->noContent();
    }
}
