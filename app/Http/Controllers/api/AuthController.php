<?php

namespace App\Http\Controllers\API;

use App\Core\Application\UseCases\Auth\LoginUser;
use App\Core\Application\UseCases\Auth\LogoutUser;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    private LoginUser $loginUser;
    private LogoutUser $logoutUser;

    public function __construct(
        LoginUser $loginUser,
        LogoutUser $logoutUser
    ) {
        $this->loginUser = $loginUser;
        $this->logoutUser = $logoutUser;
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
    public function logout(Request $request)
    {
        try {
            $result = $this->logoutUser->execute();
            return $this->sendResponse(["logout" => true], $result->message);
        } catch (\Exception $e) {
            return $this->sendError("Error al cerrar sision", errorMessages: $e->getMessage(), code: $e->getCode());
        }
    }
}
