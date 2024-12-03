<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\AssignmentPeople\FindAllPeople;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class AssignmentPeopleController extends BaseController
{
    private FindAllPeople $findAllPeople;

    public function __construct(FindAllPeople $findAllPeople)
    {
        $this->findAllPeople = $findAllPeople;
    }

    public function index(Request $request)
    {
        try {
            $queryParams = [];
            $assignment_peoples = $this->findAllPeople->execute($queryParams);
            return $this->sendResponse(["assignment_peoples" => $assignment_peoples], "Lista de Personas.");
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }
}
