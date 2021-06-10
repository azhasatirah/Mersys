<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\support\Carbon;
class JenisNilaiController extends Controller
{
    public function index(){
        return view('karyawan/master/jenisnilai');
    }
    public function getData(){
        $Data = DB::table('jenis_nilai')->where('Status','OPN')->get();
        return response()->json($Data);
    }
    public function getDataDetail($id){
        $Data = DB::table('jenis_nilai')->where('Status','OPN')->where('IDJenisNilai',$id)->get();
        return response()->json($Data);
    }
    public function store(Request $request){
        $Data = array(
            'Jenis'=>$request->jenisnilai,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('jenis_nilai')->insert($Data);
        return response()->json(['Pesan'=>'Data berhasil ditambahkan']);
    }
    public function update(Request $request){
        $Data = array(
            'Jenis'=>$request->jenisnilai,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('jenis_nilai')->where('IDJenisNilai',$request->id)->update($Data);
        return response()->json(['Pesan'=>'Berhasil diubah']);
    }
    public function destroy($id){
        DB::table('jenis_nilai')->where('IDJenisNilai',$id)
        ->update(['Status'=>'DEL']);
        return response()->json(['Pesan'=>'success']);
    }
}
