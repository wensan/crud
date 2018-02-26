<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\User;

class TokenController extends Controller {
    public function auth(Request $request) {
        $credentials = $request->only("email", "password");

        $validator = Validator::make($credentials, ["email" => "required|email", "password" => "required"]);
        if ($validator->fails()) {
            return response()->json([
                "data" => [
                    "message" => "Authentication failed, validation error.",
                    "errors" => $validator->errors(),
                    "status" => 404
                ]
            ]);
        }

        $user = User::where('email', $request['email'])->get();

        if (!empty($user) && $user[0]->deleted) {
            return response()->json([
                "data" => [
                    "message" => "Authentication failed, current user is disabled",
                    "status" => 404
                ]
            ]);
        }

        $token = JWTAuth::attempt($credentials);

        if ($token) {
            return response()->json([
                "data" => [
                    "token" => $token,
                    "status" => 200
                ]
            ]);
        } else {
          return response()->json([
              "data" => [
                  "message" => "Authentication failed, incorrect credentials",
                  "errors" => $validator->errors(),
                  "status" => 404
              ]
          ]);
        }
    }

    public function refresh() {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            $user = $this->checkUser();
            return response()->json([
                "data" => [
                    "token" => $token,
                    "status" => 200,
                    "role" => $user->role
                ]
            ]);
        } catch(TokenExpiredException $e) {
            throw new HttpResponseException (
                Response::json([
                  "data" => [
                      "message" => "Need to login again.",
                      "status" => 404
                  ]
                ])
            );
        }
    }

    public function invalidate() {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::invalidate($token);
            return response()->json(["token" => $token]);
        } catch(Exception $e) {
            throw new HttpResponseException (
                Response::json(["message" => "Error, try again."])
            );
        }
    }

    public function isvalid() {
        $token = JWTAuth::getToken();
        try {
              JWTAuth::parseToken()->authenticate();
              $user = $this->checkUser();
              return response()->json([
                  "data" => [
                      "token" => $token,
                      "status" => 200,
                      "role" => $user->role
                  ]
              ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                "data" => [
                    "status" => 404,
                    "message" => $e->getMessage()
                ]
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                "data" => [
                    "status" => 404,
                    "message" => $e->getMessage()
                ]
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                "data" => [
                    "status" => 404,
                    "message" => $e->getMessage()
                ]
            ]);
        }
    }

    private function checkUser() {
        $user = JWTAuth::toUser();
        return $user;
    }
}
