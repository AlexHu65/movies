<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

//Models
use App\Models\User;
//Resources
use App\Http\Resources\UserResource;
//Requests
use App\Http\Requests\LoginRequest;

class AuthController extends BaseController
{

    public function login(LoginRequest $request){
        
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        
        return $this->respondWithToken($token);

    }

    /**
     * Invalidate the token
     * @return JsonResponse
     */
    public function logout(): JsonResponse {

        try {
       
            $logout = auth('api')->logout();

            return $this->success('Successfully logged out', ['message' => 'Successfully logged out']);

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
       
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token){

        try {

            $user = Auth::guard('api')->user();
    
            return ['authorization' => [
                'token' => $token,
                'user' => new UserResource($user),
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 180,
            ]];

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }
       
    }
}
