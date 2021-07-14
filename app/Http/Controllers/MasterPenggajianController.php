<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class MasterPenggajianController extends Controller
{
    public function index(){
        return view('karyawan/penggajian/index_master_penggajian');
    }
    public function getData(){
        $MasterPenggajian = DB::table('master_penggajian')
        ->where('Status','!=','DEL')->get();
        $Level = DB::table('level_program')->where('Status','!=','DEL')->get();
        return response()->json([$MasterPenggajian,$Level]);

    }
    public function getLevelName($id){
        $Level = DB::table('level_program')->where('IDLevel',$id)->get();
        $LevelName = $Level[0]->NamaLevel;
        return $LevelName;
    }
    public function store(Request $request){
        $Data = array(
            'IDLevel'=>$request->idlevel,
            'Level'=>$this->getLevelName($request->idlevel),
            'JenisProgram'=>$request->jenisprogram,
            'Pendapatan'=>$request->pendapatan,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian')->insert($Data);
        return response()->json('Data berhasil ditambahkan');
    }
    public function update(Request $request){
        $Data = array(
            'IDLevel'=>$request->idlevel,
            'Level'=>$this->getLevelName($request->idlevel),
            'JenisProgram'=>$request->jenisprogram,
            'Pendapatan'=>$request->pendapatan,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian')
        ->where('IDMasterPenggajian',$request->idmasterpenggajian)
        ->update($Data);
        return response()->json('Data berhasil diupdate');
    }
    public function delete($id){
        $Data = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('master_penggajian')
        ->where('IDMasterPenggajian',$id)
        ->update($Data);
        return response()->json('Data berhasil dihapus');
    }
}
