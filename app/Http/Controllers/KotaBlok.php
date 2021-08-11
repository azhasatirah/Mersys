<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class KotaBlok extends Controller
{
    public function index(){
        return view('karyawan/master/blok');
    } 
    public function getdata(){
        $Data = DB::table('master_kota_blok')
        ->where('Status','!=','DEL')->get();
        $Kota = DB::table('master_kota')
        ->where('Status','!=','DEL')->get();
        return response()->json([$Data,$Kota]);
    }
    public function store(Request $request){ 
        $Data = array(
            'IDKota'=>$request->kota,
            'NamaBlok'=>$request->blok,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_kota_blok')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'IDKota'=>$request->kota,
            'NamaBlok'=>$request->blok,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_kota_blok')
        ->where('IDBlok',$request->idblok)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_kota_blok')
        ->where('IDBlok',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
}
