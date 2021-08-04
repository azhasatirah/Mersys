<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class BatasMaksimalCuti extends Controller
{
    public function index(){
        return view('karyawan/notmaster/batasmaksimalcuti');
    } 
    public function getData(){
        $Data = DB::table('master_waktu_maksimal_cuti')->get();
        return response()->json($Data);
    }

    public function update(Request $request){
        $Data = array(
            'hari'=>$request->data,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_waktu_maksimal_cuti')
        ->where('id',$request->idmaster)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
}
