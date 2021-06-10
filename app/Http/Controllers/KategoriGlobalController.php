<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriGlobal;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;

class KategoriGlobalController extends Controller
{
    public function index(){
        $KategoriGlobal = KategoriGlobal::getAllKategoriGlobal();
        //dd($KategoriProgram);
        return view('karyawan.master.kategoriglobal');
    }
    public function create(){
        return view('karyawan.master.kategori program.create');
    }
    public function store(Request $request){
       
        $Data = array(
            'UUID'=>str_replace('-','',str::uuid()),
            'KategoriGlobalProgram'=>$request->kategoriglobal,
            'Keterangan'=>$request->keterangan,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = KategoriGlobal::storeKategoriGlobal($Data);
        return response()->json($status);
    }
    public function edit($id){
        $KategoriGlobal = KategoriGlobal::getDetailKategoriGlobal($id);
        return response()->json($KategoriGlobal['KategoriGlobal']);
    }
    public function update(Request $request){
        $Data = array(
            'KategoriGlobal'=>$request->KategoriGlobal,
            'Keterangan'=>$request->keterangan,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = KategoriGlobal::updateKategoriGlobal($Data,$request->id);
        return response()->json($Status);
    }
    
    //json
    public function delete($Kode){
        $Pesan = KategoriGlobal::deleteKategoriGlobal($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $KategoriGlobal = KategoriGlobal::getAllKategoriGlobal();
        return response()->json($KategoriGlobal);
    }
}
