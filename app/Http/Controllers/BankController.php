<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\Bank;

class BankController extends Controller
{
    public function index(){
        return view('karyawan.master.bank');
    }

    public function store(Request $request){
        $Data = array(
            'NamaBank'=>$request->bank,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = Bank::storeBank($Data);
        return response()->json($status);
    }
    public function edit($id){
        $Bank = Bank::getDetailBank($id);
        return response()->json($Bank['Bank']);
    }
    public function update(Request $request){
        $Data = array(
            'NamaBank'=>$request->bank,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = Bank::updateBank($Data,$request->id);
        return response()->json($Status);
    }

    //json
    public function delete($Kode){
        $Pesan = Bank::deleteBank($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $Bank = Bank::getAllBank();
        return response()->json($Bank);
    }
}
