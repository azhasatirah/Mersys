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
    public function index()
    {
    $Aktifasi = Aktifasi::getAllAktifasi();
    return view ('karyawan.master.aktifasi',['Aktifasi'=>$Aktifasi]);
    }
    public function indexOwner(){
        return view('karyawan.master.aktifasiowner');
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

    public function getData(){
        $Aktifasi = Aktifasi::getAllAktifasi();
        return response()->json($Aktifasi);
    }

    public function getDataOwner(){
        $Data = DB::table('karyawan')
        ->select('karyawan.IDKaryawan','karyawan.NamaKaryawan','karyawan.TanggalLahir','karyawan.TempatLahir',
        'karyawan.JenisKelamin','karyawan.Alamat','karyawan.NoHP')
        ->where('karyawan.Status','OPN')->get();
        $Aktifasi = array('Status'=>'success','AkunKaryawan'=>$Data);
        return response()->json($Aktifasi);
    }

    public function update($id)
    {
      DB::table('karyawan')
         ->where('IDKaryawan', $id)
         ->update([
           'Status' => "CFM"
         ]); 

         return redirect('karyawan/admin/master/aktifasi')->with('success', 'Akun Karyawan Telah Aktif');
    }

    public function updateOwner($id)
    {
      DB::table('karyawan')
         ->where('IDKaryawan', $id)
         ->update([
           'Status' => "CLS"
         ]); 

         return redirect('karyawan/owner/pendaftaran/karyawan')->with('success', 'Akun Karyawan Telah Aktif');
    }
 
}
