<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CarService\CarServiceInterface;
use App\Http\Resources\CarService\CarServiceResourceCollection;

class FilterServiceByTypeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, CarServiceInterface $carService)
    {

        $type = $request->query('type');

        $carServices = $carService->filterByServiceType($type);

        return response()->success(__('app.operation_successful'), new CarServiceResourceCollection($carServices));
    }
}
