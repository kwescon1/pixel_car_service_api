<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreMechanicRequest;
use App\Http\Requests\UpdateMechanicRequest;
use App\Http\Resources\Mechanic\MechanicResource;
use App\Interfaces\Mechanic\MechanicServiceInterface;
use App\Http\Resources\Mechanic\MechanicResourceCollection;
use Illuminate\Http\Request;

class MechanicController extends Controller
{

    protected $mechanicService;
    /**
     * Create a new class instance.
     */

    public function __construct(MechanicServiceInterface $mechanicService)
    {
        $this->mechanicService = $mechanicService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mechanics = $this->mechanicService->getMechanics();

        return response()->success(__('app.operation_successful'), new MechanicResourceCollection($mechanics));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMechanicRequest $request)
    {

        $data = $request->validated();
        $file = $request->getImage();


        $mechanic = $this->mechanicService->storeMechanicDetails($data, $file);

        return response()->created(__('app.resource_created'), new MechanicResource($mechanic));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->success(__('app.operation_successful'), new MechanicResource($this->mechanicService->getMechanic($id)));
    }

    public function update(UpdateMechanicRequest $request, string $id)
    {

        // Get the validated and sanitized data
        $data = $request->validated();
        $file = $request->getImage();

        // Update the the mechanic data
        $updatedMechanic = $this->mechanicService->updateMechanic($data, $id, $file);

        // Return a success response with the updated car service data
        return response()->success(__('app.operation_successful'), new MechanicResource($updatedMechanic));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(string $id)
    {
        $this->mechanicService->deleteMechanic($id);

        return response()->noContent();
    }
}
