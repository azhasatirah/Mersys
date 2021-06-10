<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\support\str;
use Illuminate\support\Carbon;

class UserController extends Controller
{
    //
    public function profileKaryawan($id){
        $Data = DB::table('karyawan')
        ->join('role_karyawan_list','karyawan.IDKaryawan','=','role_karyawan_list.IDKaryawan')
        ->where('karyawan.UUID',$id)
        ->select('karyawan.*','role_karyawan_list.IDRoleKaryawan')
        ->get();
        return view('profile',['Data'=>$Data]);
    }
    public function profileSiswa($id){
        $Data = DB::table('siswa')
        ->where('UUID',$id)
        ->get();
        return view('profileSiswa',['Data'=>$Data]);
    }

    public function profileSiswaUpdate(Request $request){
        DB::table('siswa')
        ->where('IDSiswa',$request->iduser)
        ->update([
            'NamaSiswa'=>$request->nama,
            'Username'=>$request->username,
            'Email'=>$request->email,
            'PhotoProfile'=>$request->photoprofile,
            'Alamat'=>$request->alamat,
            'NoHP'=>$request->nohp,
            'NoHPKeluarga'=>$request->nohpkeluarga,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        session()->put('Username',$request->username);
        session()->put('NamaUser',$request->nama);
        return redirect('siswa/profile/'. $request->uid)->with('msg', true);
    }

    public function profileKaryawanUpdate(Request $request){
        DB::table('karyawan')
        ->where('IDKaryawan',$request->iduser)
        ->update([
            'NamaKaryawan'=>$request->nama,
            'Username'=>$request->username,
            'Email'=>$request->email,
            'PhotoProfile'=>$request->photoprofile,
            'Alamat'=>$request->alamat,
            'NoHP'=>$request->nohp,
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        session()->put('Username',$request->username);
        session()->put('NamaUser',$request->nama);
        return redirect('karyawan/profile/'. $request->uid)->with('msg', 'Profile berhasil di update');
    }
}
