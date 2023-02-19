<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;

class CreateRandomUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //Checked if user is not logged in create a random user otherwise just return the request
         if(!auth()->check()){
            $user =  User::factory()->create();
            auth()->login($user);
         }
        return $next($request);
    }
}
