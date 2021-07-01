<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class DiskonController extends Controller
{
    public function adminIndex(){
        return view('karyawan/diskon/index_admin');
    }
    public function getData(){
        $Data = DB::table('diskon as d')
        ->join('siswa as s','d.IDSiswa','=','s.IDSiswa')
        ->join('program_studi as ps','d.IDProgram','=','ps.IDProgram')
        ->select('d.*','s.NamaSiswa','ps.NamaProdi')
        ->where('d.Status','OPN')
        ->get();
        $Siswa = DB::table('siswa')->where('Status','CLS')->get();
        $ProgramStudi = DB::table('program_studi')->where('Status','OPN')->where('IDProgram','!=',1)->get();
        return response()->json([$Data,$Siswa,$ProgramStudi]);
    }
    public function store(Request $request){
        $KodeDiskon = "DSK-" . date("ymHis");
        $Data = array(
            'KodeDiskon'=>$KodeDiskon,
            'IDSiswa'=>$request->idsiswa,
            'Nilai'=>$request->nilai,
            'IDProgram'=>$request->idprogram,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('diskon')->insert($Data);
        $DataSiswa = DB::table('siswa')->where('IDSiswa',$request->idsiswa)->get();
        $Prodi = DB::table('program_studi')->where('IDProgram',$request->idprogram)->get();
        DB::table('notif')->insert([
            'Notif'=> " Anda mendapatkan diskon sebesar Rp " .number_format($request->nilai).", untuk belajar ".$Prodi[0]->NamaProdi."!",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=> $DataSiswa[0]->UUID,
            'IsRead'=>false,
            'Link'=>'/siswa/program/global',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        return response()->json('Promo Terkirim');

    }
    public function delete($id){
        DB::table('diskon')->where('IDDiskon',$id)->update([
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        ]);
        return response()->json('Promo di delete');
    }
    public function siswaData($id){
        $Data = DB::table('diskon')->where('Status','OPN')->where('IDSiswa',$id)->get();
        return response()->json($Data);
    }
}
