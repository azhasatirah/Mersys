<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Carbon;
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
                'Status'=>$siswa->Status,
                'TempatLahir'=>$siswa->TempatLahir,
                'TanggalLahir'=>$siswa->TanggalLahir,
                'NoHP'=>$siswa->NoHP
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
    public function resetPassword(Request $request){
        //dd($request);
        DB::table('siswa')->where('IDSiswa',$request->resetidsiswa)->update([
            'Password'=> Hash::make($request->resetpassword),
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        return response()->json('Berhasil diganti');
    }
    public function showSiswa($id){
        $Siswa = DB::table('siswa')->where('IDSiswa',$id)->get();
        return response()->json($Siswa);
    }
    public function deleteSiswa(Request $request){
        DB::table('siswa')->where('IDSiswa',$request->idsiswa)->update([
            'Status'=>'DEL'
        ]);
        $msg ='Berhasil menonaktifkan siswa';

        return redirect()->back()->with('msg',$msg);
    }
    public function unDeleteSiswa(Request $request){
        DB::table('siswa')->where('IDSiswa',$request->idsiswa)->update([
            'Status'=>'CLS'
        ]);
        $msg ='Berhasil mengaktifkan siswa';
        
        return redirect()->back()->with('msg',$msg);
    }

}
