<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use DB;
class SiswaController extends Controller
{
    public function infoPendaftaran(){
       $Transaksi = Transaksi::getLinkBiayaPendaftaran();
       $Link = '/siswa/pembayaran/info/'.$Transaksi[0]->UUID;
        return view('siswa.infopendaftaran',[
            'Link'=>$Link,
            'Transaksi'=>$Transaksi
        ]);
    }
    public function indexSiswa(){
        $Siswa = DB::table('siswa')->get();
        $DataSiswa=[];
        foreach($Siswa as $siswa){
            $Psikologi = DB::table('test_psikologi')
            ->where('IDSiswa',$siswa->IDSiswa)->get();
            array_push($DataSiswa , array(
                'NamaSiswa'=>$siswa->NamaSiswa,
                'Username'=>$siswa->Username,
                'Email'=>$siswa->Email,
                'Alamat'=>$siswa->Alamat,
                'JenisKelamin'=>$siswa->JenisKelamin,
                'created_at'=>$siswa->created_at,
                'IDSiswa'=>$siswa->IDSiswa,
                'Psikologi'=>count($Psikologi)>0?$Psikologi[0]->HasilTestPsikologi:false,
                'KodeSiswa'=>$siswa->KodeSiswa,
                'PhotoProfile'=>$siswa->PhotoProfile,
                'Status'=>$siswa->Status
            ));
        }
      //  dd($DataSiswa);
        return view('karyawan.show_siswa_owner',['Siswa'=>$DataSiswa]);
    }
    public function indexAdminSiswa(){
        $Siswa = DB::table('siswa')->get();
        $DataSiswa=[];
        foreach($Siswa as $siswa){
            $Psikologi = DB::table('test_psikologi')
            ->where('IDSiswa',$siswa->IDSiswa)->get();
            array_push($DataSiswa , array(
                'NamaSiswa'=>$siswa->NamaSiswa,
                'Username'=>$siswa->Username,
                'Email'=>$siswa->Email,
                'Alamat'=>$siswa->Alamat,
                'JenisKelamin'=>$siswa->JenisKelamin,
                'created_at'=>$siswa->created_at,
                'IDSiswa'=>$siswa->IDSiswa,
                'Psikologi'=>count($Psikologi)>0?$Psikologi[0]->HasilTestPsikologi:false,
                'KodeSiswa'=>$siswa->KodeSiswa,
                'PhotoProfile'=>$siswa->PhotoProfile,
                'Status'=>$siswa->Status
            ));
        }
      //  dd($DataSiswa);
        return view('karyawan.show_siswa_admin',['Siswa'=>$DataSiswa]);
    }

    public function showSiswa($id){
        $Siswa = DB::table('siswa')->where('IDSiswa',$id)->get();
        return response()->json($Siswa);
    }

}
