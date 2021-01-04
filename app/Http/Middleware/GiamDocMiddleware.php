<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class GiamDocMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('getLogin');
        } else {
            $role = DB::table('users')->where('id', auth()->user()->id)->value('role');
            if ($role == 'president') {
                return $next($request);
            } else
                return abort(400);
        }
    }
}
