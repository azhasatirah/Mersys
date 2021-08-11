<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class Kota extends Controller
{
    public function index(){
        return view('karyawan/master/kota');
    } 
    public function getdata(){
        $Data = DB::table('master_kota')
        ->where('Status','!=','DEL')->get();
        return response()->json($Data);
    }
    public function store(Request $request){ 
        $Data = array(
            'NamaKota'=>$request->kota,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_kota')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'NamaKota'=>$request->kota,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_kota')
        ->where('IDKota',$request->idkota)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_kota')
        ->where('IDKota',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
}
