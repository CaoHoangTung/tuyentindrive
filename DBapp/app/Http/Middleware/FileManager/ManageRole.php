<?php

namespace App\Http\Middleware\FileManager;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use UniSharp\LaravelFilemanager\Traits\LfmHelpers;

// active user cannot get files and folders from other users
class ManageRole
{
    use LfmHelpers;
    /**
     * Handle an incoming request.
     */
    public function handle($req, Closure $next)
    {
     

      $systemRole = (Auth::user()->sys_role);
      
      $folder_name = $req->name;
      $path = $this->getCurrentPath($folder_name);

      $type = $this->getFormatedWorkingDir($folder_name);
  
      // if role is only user && is in shares directory
      if ($type==='shares' && $systemRole == 0)
        return redirect('/403');
      return $next($req);
    }

}
