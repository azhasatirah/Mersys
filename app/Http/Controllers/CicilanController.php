<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\Cicilan;

class CicilanController extends Controller
{
    public function index(){
        return view('karyawan.master.cicilan');
    }

    public function store(Request $request){
        $Data = array(
            'Cicilan'=>$request->cicilan,
            'Bunga'=>$request->bunga,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = Cicilan::storeCicilan($Data);
        return response()->json($status);
    }
    public function edit($id){
        $Cicilan = Cicilan::getDetailCicilan($id);
        return response()->json($Cicilan['Cicilan']);
    }
    public function update(Request $request){
        $Data = array(
            'Cicilan'=>$request->cicilan,
            'Bunga'=>$request->bunga,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = Cicilan::updateCicilan($Data,$request->id);
        return response()->json($Status);
    }

    //json
    public function delete($Kode){
        $Pesan = Cicilan::deleteCicilan($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $Cicilan = Cicilan::getAllCicilan();
        return response()->json($Cicilan);
    }
}
