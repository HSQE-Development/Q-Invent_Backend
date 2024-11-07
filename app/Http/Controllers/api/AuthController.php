<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\Auth\LoginUser;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    private LoginUser $loginUser;

    public function __construct(
        LoginUser $loginUser,
    ) {
        $this->loginUser = $loginUser;
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {
            $token = $this->loginUser->execute($validated['email'], $validated['password']);
            return $this->sendResponse($token, "Inicio de Sesion correcto.");
        } catch (\Exception $e) {
            return $this->sendError("Error al validar la información", errorMessages: $e->getMessage(), code: $e->getCode());
        }
    }
}
