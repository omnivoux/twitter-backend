<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Interfaces\AuthenticationInterface;
use Carbon\Carbon;
use App\User;

class UserRepository implements AuthenticationInterface{

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = $this->model->create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'mobile' => request()->mobile
        ]);

        return response()->json([
            'message' => 'Hi '. $user->name . ', you have now successfully registered your email '. $user->email
        ]);
        
    }
    
    public function userUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users'           
        ]);

        Auth()->user()->update($request->all());

        return response()->json([
            'message' => 'profile successfully changed.',
            'data' => Auth()->User()
        ]);
    }

    public function userLogin(Request $request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addYears(1);
        }

        $token->save();

        $response = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ];

        return response()->json(array_merge($response, $user->toArray()));
    }

}