<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class AuthController extends Controller
// {
//     //
// }
namespace App\Http\Controllers;

use App\Models\Admins;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $admin = Admins::create([
             'first_name' => $request->first_name,
             'last_name' => $request->last_name,
             'email'    => $request->email,
             'password' => $request->password,
         ]);

        $token = auth()->login($admin);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['first_name','last_name','email', 'password','phone_number','picture']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        // $user = auth()-> user();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'admin' => auth()-> user()
        ]);
    }
}