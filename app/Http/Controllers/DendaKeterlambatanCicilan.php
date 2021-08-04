<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class DendaKeterlambatanCicilan extends Controller
{
    public function index(){
        return view('karyawan/notmaster/dendaketerlambatancicilan');
    } 
    public function getData(){
        $Data = DB::table('master_denda_keterlambatan_cicilan')
        ->where('Status','!=','DEL')->get();
        return response()->json($Data);
    }
    public function store(Request $request){ 
        $Data = array(
            'range_from'=>$request->range_from,
            'range_to'=>$request->range_to,
            'denda'=>$request->denda,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_denda_keterlambatan_cicilan')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'range_from'=>$request->range_from,
            'range_to'=>$request->range_to,
            'denda'=>$request->denda,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_denda_keterlambatan_cicilan')
        ->where('id',$request->idmaster)
        ->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_denda_keterlambatan_cicilan')
        ->where('id',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
}
