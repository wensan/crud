<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware("jwt.auth");
    }

    public function index() {
        $user = _getLoggedUser();
        if ($user->role != "admin") {
            return view('error');
        } else {
            $users = User::where('id', '!=', $user->id)->get();
            return view('admin.manage', ['users' => $users]);
        }
    }

    public function manageUser($id = 0) {
        $user = User::find($id);
        $user->deleted = $user->deleted ? false : true;
        $saved = $user->save();
        $ok = true;
        if (!$saved) {
            $ok = false;
        }
        return response()->json([
            'data' => [
                'message' => $ok ? 'Successfully updated.' : "There was an error.",
                'status' => $ok ? 200 : 500
            ]
        ]);
    }
}
