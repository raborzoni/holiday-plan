<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken($user->name)->accessToken;
        $response = [
            'message' => 'Usuário criado com SUCESSO! Aproveite seu plano de férias ' . $user->name . '!',
            'token' => $token
        ];
        return response($response, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $tokenResult = $user->createToken($user->name);
                $accessToken = $tokenResult->accessToken;

                $response = [
                    'message' => 'Bem Vindo a BUZZVEL e ao seu PLANEJAMENTO DE FÉRIAS ' . $user->name . '!',
                    'token' => $tokenResult->accessToken,
                ];

                return response($response, 200);
            } else {
                $response = ["message" => "Erro no Password"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'Usuário não encontrado!'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        if ($request->user()) {
            $token = $request->user()->token();
            $token->revoke();
            $response = ['message' => 'Até a próxima!'];
            return response($response, 200);
        }
        return response(['message' => 'Unauthenticated.'], 401);
    }
}
