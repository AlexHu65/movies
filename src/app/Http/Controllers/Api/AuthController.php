<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

// Resource
use App\Http\Resources\UserResource;
//Models
use App\Models\User;
//Requests
use App\Http\Requests\LoginRequest;

class AuthController extends BaseController
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware(
            'auth:api', ['except' => ['login']]
        );
    }

    public function login(LoginRequest $request){
        
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Credenciales incorrectas, por favor verifica tus datos',
            ], 401);
        }
        
        return $this->respondWithToken($token);

    }

     /**
     * Get the authenticated User.
     * @return JsonResponse
     */
    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse{
        try {
            
            $user = auth('api')->user();

            $response = [
                'user' => new UserResource($user)
            ];

            return $this->success('User retrivied successfully', $response);

        } catch (\Exception $e) {
            return $this->error('Excepción', ["error" => $e->getMessage()], $e->getMessage(), 500);
        }

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
     * @return JsonResponse
     */
    protected function respondWithToken(string $token){

        try {

            $user = Auth::guard('api')->user();
    
            return [
                'status' => true,
                'authorization' => [
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
