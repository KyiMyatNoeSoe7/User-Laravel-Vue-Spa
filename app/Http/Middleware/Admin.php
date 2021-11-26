<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', trim($request->email))->first();
        Log::info($user);

        if (isset($user->role_id) == 1) {
            Log::info("admin");
            return $next($request);
        }
        return redirect()->route('login');
    }

}
