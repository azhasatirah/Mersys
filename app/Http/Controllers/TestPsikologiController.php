<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;

class TestPsikologiController extends Controller
{
    public function getData(){
        $Data = DB::table('test_psikologi as tp')
        ->join('siswa as s','tp.IDSiswa','=','s.IDSiswa')
        ->select('s.NamaSiswa','s.Email','tp.IDTestPsikologi','tp.HasilTestPsikologi','tp.created_at')
        ->get();
        return response()->json($Data);
    }
    public function getDetailData($id){
        $Data = DB::table('test_psikologi')
        ->where('IDSiswa',$id)->get();
        return response()->json($Data);
    }
    public function store(Request $request){
        $Siswa = DB::table('siswa')->where('IDSiswa',$request->idsiswa)->get();
        $File = $request->file('file');
        $FormatFile = $File->getClientOriginalExtension();
        $FileName = 'HTP'.date('dmyhis').'.'.$FormatFile;
        $File->move(public_path('images/hasil-psikologi'),$FileName);
        $Data = array(
            'IDSiswa'=>$request->idsiswa,
            'HasilTestPsikologi'=>$FileName,
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        );
        DB::table('test_psikologi')->insert($Data);
        DB::table('notif')->insert([
            'Notif'=> session()->get('NamaUser').' mengupload hasil test psikologi',
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>'admin',
            'IsRead'=>false,
            'Link'=>'/karyawan/admin/siswa#psik#'.$Siswa[0]->KodeSiswa,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('notif')->insert([
            'Notif'=> session()->get('NamaUser').' mengupload hasil test psikologi',
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>'owner',
            'IsRead'=>false,
            'Link'=>'/karyawan/owner/siswa#psik#'.$Siswa[0]->KodeSiswa,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent('owner'));
        return redirect()->back()->withErrors('Terimakasih sudah mengisi test')->withInput();
    }
}
