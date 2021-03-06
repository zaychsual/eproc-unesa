<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Auth;

class Role
{
    /**
        * Handle an incoming request.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \Closure  $next
        *
        * @return mixed
        */
    public function __construct(Request $request)
    {
        $this->req = $request;
    }

    public function handle($request, Closure $next, $role)
    {
        $roles = $this->getAllRoleName($request->route());
        // dd(auth()->user()->is_active);
        if (auth()->user()) {
            if (auth()->user()->is_active == 1) {
                if (auth()->user()->role) {
                    $level = auth()->user()->role;
                } else {
                    // Session::put('ss_status_user', 'naktif');
                    $level = 'no-access';

                    Auth::logout();
                    return redirect('non-active');
                }
            } else {
                // Session::put('ss_status_user', 'naktif');
                $level = 'no-access';

                Auth::logout();
                return redirect('non-active');
            }
        } else {
            $level = 'no-access';

            return redirect('/');
        }
        $roles = explode('_', $role);
        $x = 0;
        foreach ($roles as $r) {
            if ($level == $r) {
                $x = 1;
            }
        }

        
        if ($x == 1) {
            return $next($request);
        }
        Session::put('ss_x', 'noaccess');

        return redirect('home');
    }

    private function getAllRoleName($route)
    {
        $actions = $route->getAction();
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
    
}
