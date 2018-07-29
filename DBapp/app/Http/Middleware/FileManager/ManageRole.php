<?php

namespace App\Http\Middleware\FileManager;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

// active user cannot get files and folders from other users
class ManageRole
{
    /**
     * Handle an incoming request.
     */
    public function handle($req, Closure $next)
    {
      $systemRole = (Auth::user()->sys_role);

      // if role is only user
      if ($systemRole == 0)
        return false;
      return $next($req);
    }

}
