<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'data' => [
                'status' => 'ok'
            ]
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'exists:users'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();

        if(!Hash::check($request->password, $user->password)) {
            return \response()->json([
                'data' => [
                    'error' => 'Email or Password is invalid.'
                ]
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        $api_token = Str::random(150);

        User::where('email', $request->email)->update(
            ['api_token' => $api_token]
        );

        return \response()->json([
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $api_token
            ]
        ], Response::HTTP_ACCEPTED);
    }
}
