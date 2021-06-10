<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Carbon;
use App\Models\MetodePembayaran;
class MetodePembayaranController extends Controller
{
    public function index(){
        return view('karyawan.manage.metodepembayaran');
    }
    public function store(Request $request){
        $Data = array(
            'MetodePembayaran'=>$request->metode,
            'Jenis'=>$request->jenis,
            'IDDompet'=>$request->bank,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = MetodePembayaran::storeMetodePembayaran($Data);
        return response()->json($status);
    }
    public function edit($id){
        $MetodePembayaran = MetodePembayaran::showMetodePembayaran($id);
        return response()->json($MetodePembayaran['MetodePembayaran']);
    }
    public function update(Request $request){
        $Data = array(
            'MetodePembayaran'=>$request->metode,
            'Jenis'=>$request->jenis,
            'IDDompet'=>$request->dompet,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = MetodePembayaran::updateMetodePembayaran($Data,$request->id);
        return response()->json($Status);
    }

    //json
    public function delete($Kode){
        $Pesan = MetodePembayaran::deleteMetodePembayaran($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $MetodePembayaran = MetodePembayaran::getAllMetodePembayaran();
        return response()->json($MetodePembayaran);
    }
}
