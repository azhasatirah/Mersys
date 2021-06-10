<?php

namespace App\Http\Controllers;

use App\Models\KategoriMateri;
use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;

class KategoriMateriController extends Controller
{
    public function index(){
        return view('karyawan.master.kategorimateri');
    }
    public function create(){
        return view('karyawan.master.kategori program.create');
    }
    public function store(Request $request){
        //dd($request);
        $KodeDisplay = "KMT-" . date("ymHis");
        $Data = array(
            'KodeKategoriMateri'=>$KodeDisplay,
            'NamaKategoriMateri'=>$request->kategorimateri,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = KategoriMateri::storeKategoriMateri($Data);
        return response()->json($status);
    }
    public function update(Request $request){
        $Data = array(
            'NamaKategoriMateri'=>$request->kategorimateri,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = KategoriMateri::updateKategoriMateri($Data,$request->id);
        return response()->json($Status);
    }
    
    //json
    public function edit($id){
        $KategoriMateri = KategoriMateri::getDetailKategoriMateri($id);
        return response()->json($KategoriMateri['KategoriMateri']);
    }
    public function delete($id){
        $Pesan = KategoriMateri::deleteKategoriMateri($id);
        return response()->json($Pesan);
    }  
    public function getData(){
        $KategoriMateri = KategoriMateri::getAllKategoriMateri();
        return response()->json($KategoriMateri);
    }
}
