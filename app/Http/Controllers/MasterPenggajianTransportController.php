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
        return view('karyawan/kasbank');
    } 
    public function getData(){
        $Data = DB::table('kas_bank')
        ->where('Status','!=','DEL')->get();
        return response()->json($Data);
    }
    public function store(Request $request){ 
        $Data = array(
            'Blok'=>$request->blok,
            'Biaya'=>$request->biaya,
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
            'Blok'=>$request->blok,
            'Biaya'=>$request->biaya,
            'Status'=>'OPN',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('kas_bank')
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
        DB::table('kas_bank')
        ->where('IDMasterPenggajianTransport',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
}
