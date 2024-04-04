<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

//Models
use App\Models\User;

class AuthApiToken
{

    public function handle($request, Closure $next){

        $token = $request->header('Token');

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();

        if (!$user || $user->api_token !== $token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
