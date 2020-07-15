<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use App\User;

interface AuthenticationInterface {    

    public function registerUser(Request $request);

    public function userLogin(Request $request);

    public function userUpdate(Request $request);

}