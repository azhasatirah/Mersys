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
        ->select('d.*','s.NamaSiswa')
        ->where('d.Status','OPN')
        ->get();
        $Siswa = DB::table('siswa')->where('Status','CLS')->get();
        return response()->json([$Data,$Siswa]);
    }
    public function store(Request $request){
        $KodeDiskon = "DSK-" . date("ymHis");
        $Data = array(
            'KodeDiskon'=>$KodeDiskon,
            'IDSiswa'=>$request->idsiswa,
            'Nilai'=>$request->nilai,
            'Type'=>$request->type,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('diskon')->insert($Data);
        $DataSiswa = DB::table('siswa')->where('IDSiswa',$request->idsiswa)->get();
        DB::table('notif')->insert([
            'Notif'=> " Selamat anda mendapatkan diskon untuk mengambil " .$request->type.", sebesar ".$request->nilai."%. ambil program sekarang!",
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
        $DataSiswa = DB::table('siswa')
        ->join('diskon','siswa.IDSiswa','=','diskon.IDSiswa')
        ->where('diskon.IDDiskon',$id)
        ->select('siswa.UUID','diskon.Nilai')
        ->get();
        DB::table('notif')->insert([
            'Notif'=> " Promo sebesar".$DataSiswa[0]->Nilai."% sudah berakhir!",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=> $DataSiswa[0]->UUID,
            'IsRead'=>false,
            'Link'=>'',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        return response()->json('Promo di delete');
    }
    public function siswaData($id){
        $Data = DB::table('diskon')->where('Status','OPN')->where('IDSiswa',$id)->get();
        return response()->json($Data);
    }
}
