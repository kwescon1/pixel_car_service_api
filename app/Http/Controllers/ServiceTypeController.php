<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Interfaces\ServiceType\ServiceTypeInterface;
use App\Http\Resources\ServiceType\ServiceTypeResource;
use App\Http\Resources\ServiceType\ServiceTypeResourceCollection;

class ServiceTypeController extends Controller
{

    protected $serviceType;

    public function __construct(ServiceTypeInterface $serviceType)
    {
        $this->serviceType = $serviceType;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceTypes = $this->serviceType->getServiceTypes();

        return response()->success(__('app.service_types_retrieved'), new ServiceTypeResourceCollection($serviceTypes));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceTypeRequest $request)
    {
        $data = $request->validated();

        $serviceType = $this->serviceType->storeServiceType($data);

        return response()->created(__('app.service_type_created'), new ServiceTypeResource($serviceType));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
