<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\AssignmentPeople\FindAllPeople;
use App\Core\Application\UseCases\AssignmentPeople\FindAllPeopleWithPagination;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class AssignmentPeopleController extends BaseController
{
    private FindAllPeople $findAllPeople;
    private FindAllPeopleWithPagination $findAllPeopleWithPagination;

    public function __construct(FindAllPeople $findAllPeople, FindAllPeopleWithPagination $findAllPeopleWithPagination)
    {
        $this->findAllPeople = $findAllPeople;
        $this->findAllPeopleWithPagination = $findAllPeopleWithPagination;
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

    public function allPeoples(Request $request)
    {
        try {
            $queryParams = $request->all();
            $assignment_peoples = $this->findAllPeopleWithPagination->execute($queryParams);
            return $this->sendResponse(["assignment_peoples" => $assignment_peoples], "Lista de Personas.");
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }
}
