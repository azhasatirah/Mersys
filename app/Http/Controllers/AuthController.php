<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth;
use App\Models\Transaksi;
use App\Models\KursusSiswa;
use App\Models\Siswa;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TransaksiController;
use DB;

class AuthController extends Controller
{
    //
    public function index(){
        return view('Auth/welcome');
    }
    public function gerbangKaryawan(){
        return view('Auth/welcomekaryawan');
    }
    public function login(Request $request){
        $Data = array(
            'Username'=>$request->username,
            'Password'=>$request->password,
        );
        if($request->peran=='siswa'){
            $Status = Auth::loginSiswa($Data);
            if($Status['Status']=='success'){
                return redirect('/siswa/program/global')->withErrors( $Status['Pesan']);
            }elseif($Status['Status']=='nonactive'){
                return redirect('/siswa/info')->withErrors( $Status['Pesan']);
            }else{
                return redirect()->back()->withErrors($Status['Pesan'])->withInput();
            }
        }else{
            $Status = Auth::loginKaryawan($Data);
            if($Status['Status']=='success'){
                return redirect('karyawan/dasbor')->withErrors($Status['Pesan']);
            }else{
                return redirect()->back()->withErrors($Status['Pesan'])->withInput();
            }
        }
    }
    public function store(Request $request){
        //dd($request);
        $UIDUser = str_replace('-','',str::uuid());
        $Data = $request->peran=='siswa'?array(
            'KodeSiswa'=>"SW-".date("ymHis"),
            'UUID'=>$UIDUser,
            'PhotoProfile'=>'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png',
            'Username'=>$request->username,
            'Email'=>$request->email,
            'Password'=>Hash::make($request->password),
            'NamaSiswa'=>$request->namalengkap,
            'JenisKelamin'=>$request->jeniskelamin,
            'TanggalLahir'=>$request->tanggallahir,
            'TempatLahir'=>$request->tempatlahir,
            'Alamat'=>$request->alamat,
            'NoHP'=>$request->nohp,
            'Status'=>'OPN',
            'UserAdd'=>$request->username,
            'UserUpd'=>$request->username,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ):array(
            'KodeKaryawan'=> "KRY-".date("ymHis"),
            'UUID'=>$UIDUser,
            'PhotoProfile'=>'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png',
            'Username'=>$request->username,
            'Email'=>$request->email,
            'Password'=>Hash::make($request->password),
            'NamaKaryawan'=>$request->namalengkap,
            'JenisKelamin'=>$request->jeniskelamin,
            'TanggalLahir'=>$request->tanggallahir,
            'TempatLahir'=>$request->tempatlahir,
            'Alamat'=>$request->alamat,
            'NoHP'=>$request->nohp,
            'Status'=>'OPN',
            'UserAdd'=>$request->username,
            'UserUpd'=>$request->username,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),

        );
        if($request->peran=='siswa'){
            $Status = $this->storeSiswa($Data);
            if($Status['Status'] =='success'){
                $Siswa = Siswa::showSiswaByKode($Data['KodeSiswa']);
                $IDSiswa = $Siswa[0]->IDSiswa;
                session()->put('NamaUser',$Data['NamaSiswa']);
                session()->put('Username',$Data['Username']);
                session()->put('IDUser',$IDSiswa);
                session()->put('UID',$Siswa[0]->UUID);
                session()->put('RoleUser','siswa');
                app('App\Http\Controllers\TransaksiController')->storeTransaksiPendaftaran();
                DB::table('notif')->insert([
                    'Notif'=> session()->get('NamaUser').' Mendaftar sebagai siswa',
                    'NotifFrom'=> $Siswa[0]->UUID,
                    'NotifTo'=>'admin',
                    'IsRead'=>false,
                    'Link'=>'/karyawan/admin/pendaftaran/siswa/',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ]);
                DB::table('notif')->insert([
                    'Notif'=> session()->get('NamaUser').' Mendaftar sebagai siswa',
                    'NotifFrom'=> $Siswa[0]->UUID,
                    'NotifTo'=>'owner',
                    'IsRead'=>false,
                    'Link'=>'/karyawan/owner/pendaftaran/siswa/',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ]);
                broadcast(new \App\Events\NotifEvent('admin'));
                broadcast(new \App\Events\NotifEvent('owner'));
                return redirect('siswa/info')->withErrors( $Status['Pesan']);
            }else{
                return redirect()->back()->withErrors($Status['Pesan'])->withInput();
            }
        }else{
            $Status = $this->storeKaryawan($Data);
            if($Status['Status'] =='success'){
                DB::table('notif')->insert([
                    'Notif'=> $request->namalengkap.' Mendaftar sebagai karyawan',
                    'NotifFrom'=> $UIDUser,
                    'NotifTo'=>'owner',
                    'IsRead'=>false,
                    'Link'=>'/karyawan/owner/pendaftaran/karyawan/',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ]);
                broadcast(new \App\Events\NotifEvent('owner'));
                return redirect('karyawan')->withErrors( $Status['Pesan']);
            }else{
                return redirect()->back()->withErrors($Status['Pesan'])->withInput();
            }
        }
    }
    public function storeKaryawan($Data){
        $Status = Auth::daftarKaryawan($Data);
        return $Status;
    }
    public function storeSiswa($Data){

        $Status = Auth::daftarSiswa($Data);
        return $Status;
    }
    public function cekUsername(Request $request){
        return response()->json(Auth::cekUsername($request->username));
    }
    public function cekEmail(Request $request){
        return response()->json(Auth::cekEmail($request->email));
    }
    public function logout(){
        session()->flush();
        return redirect('/');
    }
    public function changePasswordKaryawan(Request $request){
        $DataKaryawan = DB::table('karyawan')
        ->where('IDKaryawan',session()->get('IDUser'))->get();
      //  dd($DataKaryawan,$request);
        if(Hash::check($request->oldpassword, $DataKaryawan[0]->Password)||
        count(DB::table('karyawan')->where('Password',md5($request->oldpassword))->get())>0
        ){
            DB::table('karyawan')
            ->where('IDKaryawan',session()->get('IDUser'))
            ->update([
                'Password'=>hash::make($request->newpassword)
            ]);
            return redirect()->back()->with('msg','Password berhasil diganti');
        }
        return redirect()->back()->with('msg','Password lama salah');
    }
}
