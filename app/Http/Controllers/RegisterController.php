<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterUserRequest;
use App\User;

class RegisterController extends Controller
{
    public function register(RegisterUserRequest $request) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'user';
        $user->deleted = false;
        $user->save();

        return response()->json([
            'data' => [
                'message' => 'Successfully registered.',
                'status' => 200
            ]
        ]);
    }
}
