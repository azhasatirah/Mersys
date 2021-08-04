<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class BatasGantiJadwal extends Controller
{
    public function index(){
        return view('karyawan/notmaster/batasgantijadwal');
    } 
    public function getData(){
        $Data = DB::table('master_waktu_maksimal_sebelum_ganti_jadwal')->get();
        return response()->json($Data);
    }

    public function update(Request $request){
        $Data = array(
            'jam'=>$request->data,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_waktu_maksimal_sebelum_ganti_jadwal')
        ->where('id',$request->idmaster)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
}
