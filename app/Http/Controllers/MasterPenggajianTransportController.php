<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class MasterPenggajianTransportController extends Controller
{
    public function index(){
        return view('karyawan/penggajian/index_master_penggajian_transport');
    } 
    public function getData(){
        $Data = DB::table('master_penggajian_transport')
        ->where('Status','!=','DEL')->get();
        $Kota = DB::table('master_kota')->get();
        $Blok = DB::table('master_kota_blok')->get();
        return response()->json([$Data,$Kota,$Blok]);
    }
    public function store(Request $request){ 
        $Data = array(
            'IDBlok'=>$request->blok,
            'IDKota'=>$request->kota,
            'Biaya'=>$this->idrToInt($request->biaya),
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_transport')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'IDBlok'=>$request->blok,
            'IDKota'=>$request->kota,
            'Biaya'=>$this->idrToInt($request->biaya),
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_transport')
        ->where('IDMasterPenggajianTransport',$request->penggajiantransport)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian_transport')
        ->where('IDMasterPenggajianTransport',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
    public function idrToInt($idr){
        $n = str_replace('.','',str_replace('Rp. ','',$idr));
        return intval($n);
    }
}
