<?php

namespace App\Http\Controllers;

use App\Http\Resources\Mechanic\MechanicResourceCollection;
use App\Interfaces\Mechanic\MechanicServiceInterface;
use Illuminate\Http\Request;

class SelectAvailableMechanicController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, MechanicServiceInterface $mechanicService)
    {
        //
        $date = $request->query('date');

        $availableMechanics = $mechanicService->getAvailableMechanics($date);

        return response()->success(__('app.operation_successful'), new MechanicResourceCollection($availableMechanics));
    }
}
