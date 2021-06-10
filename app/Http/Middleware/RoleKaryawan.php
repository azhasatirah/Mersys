<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleKaryawan
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
        if(session()->has('Level')){

            if(intval($role)!==session()->get('Level')){
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
        return redirect('/karyawan');
    }
}
