<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class JadwalSemiPrivateController extends Controller
{
    public function index(){
        return view('karyawan/jadwalsemi/index');
    }
    public function getData(){
        $Data = DB::table('jadwal_semi_private')->where('Status','OPN')->get();
        return response()->json($Data);
    }
    public function getHari($id){
        $Hari = '';
        switch($id){
            case 0:
                $Hari = 'Minggu';
                break;
            case 1:
                $Hari = 'Senin';
                break;
            case 2:
                $Hari = 'Selasa';
                break;
            case 3:
                $Hari = 'Rabu';
                break;        
            case 4:
                $Hari = 'Kamid';
                break;
            case 5:
                $Hari = 'Jumat';
                break;
            case 6:
                $Hari = 'Sabtu';
                break;
        }
        return $Hari;
    }
    public function update(Request $request){
        $Hari = $this->getHari($request->kodehari);
 
        $Data = array(
            'Hari'=>$Hari,
            'KodeHari'=>$request->kodehari,
            'Start'=>$request->start,
            'End'=>$request->end,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('jadwal_semi_private')->where('IDJadwalSemiPrivate',$request->idjadwalsemiprivate)
        ->update($Data);
        return response()->json('Data berhasil di update');
    }
    public function store(Request $request){
        $Hari = $this->getHari($request->kodehari);
        $Data = array(
            'Hari'=>$Hari,
            'KodeHari'=>$request->kodehari,
            'Start'=>$request->start,
            'End'=>$request->end,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('jadwal_semi_private')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('jadwal_semi_private')->where('IDJadwalSemiPrivate',$id)
        ->update($Data);
        return response()->json('Data berhasil di hapus');
    }
}
