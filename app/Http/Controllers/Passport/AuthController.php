<?php

namespace App\Http\Controllers\Passport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Interfaces\AuthenticationInterface;

class AuthController extends Controller
{
    protected $auth;
    
    public function __construct(AuthenticationInterface $service)
    {
        $this->auth = $service;
    }

    public function passportLogin(Request $request)
    {                
        return $this->auth->userLogin($request);
    }

    public function passportRegister(Request $request)
    {
        return $this->auth->registerUser($request);
    }

    public function passportUpdate(Request $request)
    {
        return $this->auth->userUpdate($request);
    }
}
