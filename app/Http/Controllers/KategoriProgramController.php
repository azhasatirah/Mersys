<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProgram;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;

class KategoriProgramController extends Controller
{
        public function index(){
            $KategoriProgram = KategoriProgram::getAllKategoriProgram();
            //dd($KategoriProgram);
            return view('karyawan.master.kategoriprogram');
        }
        public function create(){
            return view('karyawan.master.kategori program.create');
        }
        public function store(Request $request){
            $Data = array(
                'UUID'=>str_replace('-','',str::uuid()),
                'KategoriProgram'=>$request->kategoriprogram,
                'Keterangan'=>$request->keterangan,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
                'Status'=>'OPN'
            );
            $status = KategoriProgram::storeKategoriProgram($Data);
            return response()->json($status);
        }
        public function edit($id){
            $KategoriProgram = KategoriProgram::getDetailKategoriProgram($id);
            return response()->json($KategoriProgram['KategoriProgram']);
        }
        public function update(Request $request){
            $Data = array(
                'KategoriProgram'=>$request->kategoriprogram,
                'Keterangan'=>$request->keterangan,
                'updated_at'=>Carbon::now(),
                'UserUpd'=>session()->get('Username'),
            );
            $Status = KategoriProgram::updateKategoriProgram($Data,$request->id);
            return response()->json($Status);
        }
        
        //json
        public function delete($Kode){
            $Pesan = KategoriProgram::deleteKategoriProgram($Kode);
            return response()->json($Pesan);
        }  
        public function getData(){
            $KategoriProgram = KategoriProgram::getAllKategoriProgram();
            return response()->json($KategoriProgram);
        }
}
