<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class GajiPokokController extends Controller
{
    public function indexOwner(){
        return view('karyawan.penggajian.master_gajipokok_owner');
    }
    public function getData(){
        $Data = DB::table('master_penggajian_gaji_pokok')
        ->where('Status','!=','DEL')->get();
        return response()->json($Data);
    }
    public function store(Request $request){
        $Data = array(
            'Kelas'=>$request->kelas,
            'Gaji'=>$this->idrToInt($request->gaji),
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_gaji_pokok')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'Kelas'=>$request->kelas,
            'Gaji'=>$this->idrToInt($request->gaji),
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_gaji_pokok')
        ->where('IDGajiPokok',$request->idgajipokok)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_gaji_pokok')
        ->where('IDGajiPokok',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
    public function idrToInt($idr){
        $n = str_replace('.','',str_replace('Rp. ','',$idr));
        return intval($n);
    }
}
