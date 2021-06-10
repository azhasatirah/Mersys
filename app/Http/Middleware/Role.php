<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$role)
    {
        if(session()->has('RoleUser')){
            if($role!==session()->get('RoleUser')){
                switch (session()->get('Level')){
                    case 1:
                        return redirect('karyawan/dasbor');
                        break;
                    case 2:
                        return redirect('karyawan/dasbor');
                        break;
                    case 3:
                        return redirect('karyawan/dasbor');
                        break;
                    case 4:
                        return redirect('siswa/program/global');
                        break;
                }
            }
            return $next($request);
        }
        return redirect('/');
    }
}
