<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class KasBankController extends Controller
{
    public function index(){
        return view('karyawan.kasbank');
    }
    public function getData(){
        $Data = DB::table('kas_bank')
        ->where('Status','!=','DEL')
        ->orderBy('created_at','desc')->get();
        $FinalData = [];
        foreach($Data as $data){
            $DataA = $Data->toArray();
            $PrevTotal =0 ;
            $LatestDate = $data->created_at;
            //dd($LatestDate);
            $PrevData = array_filter($DataA,function($dat) use($LatestDate){
                return $dat->created_at < $LatestDate;
            });
            foreach($PrevData as $pd){
                $PrevTotal += $pd->Total;
            }
            array_push($FinalData,array(
                'IDKasBank'=>$data->IDKasBank,
                'KodeKasBank'=>$data->KodeKasBank,
                'Tanggal'=>$data->Tanggal,
                'Total'=>$data->Total,
                'PrevTotal'=>$PrevTotal,
                'Keterangan'=>$data->Keterangan,
            ));
        }
        return response()->json($FinalData);
    }
    public function store(Request $request){
        $KodeKasBank = "SBK-" . date("myHis");
        $ChangeKas = $this->idrToInt($request->total);
        $Data = array(
            'KodeKasBank'=>$KodeKasBank,
            'IDPembayaran'=>0,
            'Tanggal'=>Carbon::now(),
            'Total'=>$request->typekasbank==1?$ChangeKas*-1:$ChangeKas,
            'Keterangan'=>$request->keterangan,
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
        $ChangeKas = $this->idrToInt($request->total);
        $Data = array(
            'Total'=>$request->typekasbank==1?$ChangeKas*-1:$ChangeKas,
            'Keterangan'=>$request->keterangan,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('kas_bank')->where('IDKasBank',$request->idkasbank)->update($Data);
        return response()->json('Data berhasil diubah');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('kas_bank')
        ->where('IDKasBank',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
    public function idrToInt($idr){
        $n = str_replace('.','',str_replace('Rp. ','',$idr));
        return intval($n);
    }
}
