<?php

namespace App\Http\Middleware\FileManager;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

// active user cannot get files and folders from other users
class UserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle($req, Closure $next)
    {
        $sysRole = $req->user()->id;
        $reqID = ($req->route()->parameter('base_path'));

        if ($sysRole == $reqID)
          return $next($req);
        return redirect('/home');
    }

}
