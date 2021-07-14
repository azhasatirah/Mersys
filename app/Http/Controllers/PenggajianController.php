<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class PenggajianController extends Controller
{
    public function index(){
        $Data = DB::table('karyawan as k')
        ->join('role_karyawan_list as rkl','k.IDKaryawan','=','rkl.IDKaryawan')
        ->join('role_karyawan as rk','rkl.IDRoleKaryawan','=','rk.IDRoleKaryawan')
        ->select('k.NamaKaryawan','k.KodeKaryawan','k.UUID as UIDKaryawan','rk.RoleKaryawan')
        ->where('k.Status','CLS')
        ->where('rk.IDRoleKaryawan','!=',1)
        ->get();
        return view('karyawan/penggajian/index',['Karyawan'=>$Data]);
    }
    public function show($uid){
        return view('karyawan/penggajian/show');

    }
    public function getDetailData($id){
        $Data = DB::table('penggajian as p')
        ->join('karyawan as k','p.IDKaryawan','=','k.IDKaryawan')
        ->where('p.Status','!=','DEL')
        ->where('k.UUID',$id)
        ->select('k.*')
        ->get();
        return response()->json($Data);
    }
}
