<?php

namespace App\Http\Controllers;

use App\Models\CarService;
use App\Http\Requests\StoreCarServiceRequest;
use App\Http\Requests\UpdateCarServiceRequest;
use App\Interfaces\CarService\CarServiceInterface;
use App\Http\Resources\CarService\CarServiceResource;
use App\Http\Resources\CarService\CarServiceResourceCollection;

class CarServiceController extends Controller
{

    protected $carService;

    public function __construct(CarServiceInterface $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $carServices = $this->carService->getCarServices();

        return response()->success(__('app.operation_successful'), new CarServiceResourceCollection($carServices));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarServiceRequest $request)
    {
        // Use the request to get the service type
        $serviceType = $request->getServiceType();

        // Get the sanitized data
        $data = $request->getSanitizedData();


        $carService = $this->carService->storeCarService($data, $serviceType);

        // Return the response with the created car service
        return response()->created(__('app.operation_successful'), new CarServiceResource($carService));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->success(__('app.operation_successful'), new CarServiceResource($this->carService->getCarService($id)));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(UpdateCarServiceRequest $request, string $id)
    {
        // Get the validated and sanitized data
        $data = $request->validated();

        // Update the car service
        $updatedCarService = $this->carService->updateCarService($data, $id);

        // Return a success response with the updated car service data
        return response()->success(__('app.operation_successful'), new CarServiceResource($updatedCarService));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(string $id)
    {
        return response()->success(__('app.resource_deleted'), $this->carService->deleteCarService($id));
    }
}
