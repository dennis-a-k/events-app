<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'login'     => 'required|string',
            'password'  => 'required|string',
        ]);

        $user = User::where('login', $fields['login'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'errors' => ['name' => ['Wrong login or password']],
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $responce = [
            'error'     => null,
            'result'    => new UserResource($user),
            'token'     => $token,
        ];

        return response($responce, 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }
}
