<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\Rekening;
use App\Models\Bank;

class RekeningController extends Controller
{
    public function index(){
        $Bank = Bank::getAllBank();
        return view('karyawan.manage.rekening',[
            'Bank'=>$Bank
        ]);
    }

    public function store(Request $request){
        $Data = array(
            'NamaRekening'=>$request->namarekening,
            'NoRekening'=>$request->nomorrekening,
            'IDBank'=>$request->bank,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = Rekening::storeRekening($Data);
        return response()->json($status);
    }
    public function edit($id){
        $Rekening = Rekening::getDetailRekening($id);
        return response()->json($Rekening['Rekening']);
    }
    public function update(Request $request){
        $Data = array(
            'NamaRekening'=>$request->namarekening,
            'NoRekening'=>$request->nomorrekening,
            'IDBank'=>$request->bank,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = Rekening::updateRekening($Data,$request->id);
        return response()->json($Status);
    }

    //json
    public function delete($Kode){
        $Pesan = Rekening::deleteRekening($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $Rekening = Rekening::getAllRekening();
        return response()->json($Rekening);
    }
}
