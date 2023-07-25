<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVerfied
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data=User::where('phone',$request->phone)->first();
        if($data['verify']=='verified'){
            return $next($request);
    } else {
        return response()->json(['status' => 'fail', 'message' => 'your account is not verified'], 403);
    }
    }
}
