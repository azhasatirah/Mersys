<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class DendaController extends Controller
{
    public function indexOwner(){
        return view('karyawan.penggajian.master_denda_owner');
    }

    public function getData(){
        $Data = DB::table('master_penggajian_denda_terlambat')
        ->where('Status','!=','DEL')->get();
        return response()->json($Data);
    }
    public function store(Request $request){
        $Data = array(
            'MinuteMin'=>$request->minutemin,
            'MinuteMax'=>$request->minutemax,
            'Denda'=>$this->idrToInt($request->denda),
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_denda_terlambat')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'MinuteMin'=>$request->minutemin,
            'MinuteMax'=>$request->minutemax,
            'Denda'=>$this->idrToInt($request->denda),
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_denda_terlambat')
        ->where('IDDendaTerlambat',$request->iddendaterlambat)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_denda_terlambat')
        ->where('IDDendaTerlambat',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
    public function idrToInt($idr){
        $n = str_replace('.','',str_replace('Rp. ','',$idr));
        return intval($n);
    }
}
