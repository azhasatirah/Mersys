<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\Aktifasi;
use Illuminate\Support\Facades\DB;

class AktifasiController extends Controller
{
    public function index(){
        return view('karyawan.master.aktifasi_karyawan');
    }

    public function store(Request $request){
        $Data = array(
            'IDKaryawan'=>$request->idkaryawan,
            'NamaKaryawan'=>$request->namakaryawan,
            'TanggalLahir'=>$request->tanggallahir,
            'TempatLahir'=>$request->tempatlahir,
            'JenisKelamin'=>$request->jeniskelamin,
            'Alamat'=>$request->alamat,
            'NoHP'=>$request->nohp,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $Status = Aktifasi::storeAktifasi($Data);
        return redirect('/karyawan/master/aktifasi')->with(['Status'=>$Status]);
    }


    public function getDataKaryawan(){
        $Data = DB::table('karyawan')
        ->select('karyawan.*')
        ->where('karyawan.Status','!=','CLS')
        ->where('karyawan.Status','!=','DEL')
        ->get();
        $Aktifasi = array('Status'=>'success','AkunKaryawan'=>$Data);
        return response()->json($Aktifasi);
    }

    public function adminUpdate($id)
    {
      DB::table('karyawan')
      ->where('IDKaryawan', $id)
      ->update([
        'Status' => "CFM"
      ]);
      $DataNotif = DB::table('karyawan')->where('IDKaryawan',$id)->get();
      DB::table('notif')->insert([
        'Notif'=> "Admin mengkonfirmasi pendaftaran ".$DataNotif[0]->NamaKaryawan." sebagai karyawan.",
        'NotifFrom'=> session()->get('UID'),
        'NotifTo'=>'admin',
        'IsRead'=>false,
        'Link'=>'/karyawan/pendaftaran/karyawan',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now(),
      ]);
      return response()->json('Akun karyawan telah di konfiramsi, menunggu owner');
    }

    public function ownerUpdate($id)
    {
      DB::table('karyawan')
         ->where('IDKaryawan', $id)
         ->update([
           'Status' => "CLS"
      ]); 
      DB::table('role_karyawan_list')->insert([
        'IDRoleKaryawan'=>3,
        'IDKaryawan'=>$id,
        'Status'=>'OPN',
        'UserAdd'=>session()->get('Username'),
        'UserUpd'=>session()->get('Usernamse'),
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
      ]);

      return response()->json('Akun karyawan telah di konfirmasi');
    }
 
}
