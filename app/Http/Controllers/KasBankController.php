<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class KasBankController extends Controller
{
    public function index(){
        return view('karyawan.kasbank');
    }
    public function getData(){
        $Data = DB::table('kas_bank')
        ->where('Status','!=','DEL')
        ->orderBy('created_at','desc')->get();
        return response()->json($Data);
    }
    public function store(Request $request){
        $Data = array(
            'KodeKasBank'=>$KodeKasBank,
            'IDPembayaran'=>$request->idpenbayaran,
            'Tanggal'=>$request->tanggal,
            'Total'=>$request->total,
            'Keterangan'=>$request->keterangan,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('kas_bank')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'IDPembayaran'=>$request->idpenbayaran,
            'Tanggal'=>$request->tanggal,
            'Total'=>$request->total,
            'Keterangan'=>$request->keterangan,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        );
        DB::table('kas_bank')->where('IDKasBank',$request->idkasbank)->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('kas_bank')
        ->where('IDKasBnak',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
    public function idrToInt($idr){
        $n = str_replace('.','',str_replace('Rp. ','',$idr));
        return intval($n);
    }
}
