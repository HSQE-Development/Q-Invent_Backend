<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\Ubication\FindAllUbications;
use Illuminate\Http\Request;

class UbicationController extends BaseController
{
    //
    private FindAllUbications $findAllUbications;

    public function __construct(FindAllUbications $findAllUbications)
    {
        $this->findAllUbications = $findAllUbications;
    }

    public function index(Request $request)
    {
        try {
            $queryParams = [];
            $ubications = $this->findAllUbications->execute($queryParams);
            return $this->sendResponse(["ubications" => $ubications], "Lista de Ubicaciones.");
        } catch (\Exception $e) {
            return $this->sendError('Error inesperado', [$e->getMessage()], 500);
        }
    }
}
