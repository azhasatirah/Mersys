<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\Hash;
class Auth extends Model
{
    use HasFactory;
    //pendaftaran siswa
    public static function daftarSiswa($Data){
        try{
            DB::table('siswa')->insert($Data);
            return array(
                'Status'=>'success',
                'Pesan'=>'Berhasil melakukan pendaftaran!');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi kesalahan, mohon coba lagi!');
        }
    }
    //pendaftaran karyawan
    public static function daftarKaryawan($Data){
        try{
            //dd($Data,$Data['Username']);
            DB::table('karyawan')->insert($Data);
            $Karyawan = DB::table('karyawan')->where('UUID',$Data['UUID'])->get();
            
            $DataRole = array(
                'IDKaryawan'=>$Karyawan[0]->IDKaryawan,
                'IDRoleKaryawan'=>3,
                'Status'=>'OPN',
                'UserAdd'=>$Data['Username'],
                'UserUpd'=>$Data['Username'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            );
            DB::table('role_karyawan_list')->insert($DataRole);
            return array(
                'Status'=>'success',
                'Pesan'=>'Berhasil melakukan pendaftaran!');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi kesalahan, mohon coba lagi!');
        }
    }
    //login siswa 
    public static function loginSiswa($Data){
        $Username = DB::table('siswa')->where('Username',$Data['Username'])->get();
        if(count($Username)>0){
            if(Hash::check($Data['Password'], $Username[0]->Password)||
            count(DB::table('siswa')->where('Password',md5($Data['Password']))->get())>0
            ){
                if($Username[0]->Status=='CLS'){
                    session()->put('NamaUser',$Username[0]->NamaSiswa);
                    session()->put('Username',$Username[0]->Username);
                    session()->put('IDUser',$Username[0]->IDSiswa);
                    session()->put('StatusUser',$Username[0]->Status);
                    session()->put('Level',4);
                    session()->put('UID',$Username[0]->UUID);
                    session()->put('RoleUser','siswa');
                    return array(
                        'Status'=>'success',
                        'Pesan'=>'Berhasil login!'
                    );
                }else{
                    session()->put('NamaUser',$Username[0]->NamaSiswa);
                    session()->put('Username',$Username[0]->Username);
                    session()->put('Level',4);
                    session()->put('UID',$Username[0]->UUID);
                    session()->put('IDUser',$Username[0]->IDSiswa);
                    session()->put('StatusUser',$Username[0]->Status);
                    session()->put('RoleUser','siswa');
                    return array(
                        'Status'=>'nonactive',
                        'Pesan'=>'Akun anda belum aktif!'
                    );
                }
            }else{
                return array(
                    'Status'=>'error',
                    'Pesan'=>'Password salah!'
                );
            }
        }else{
            return array(
                'Status'=>'error',
                'Pesan'=>'Username salah!'
            );
        }
    }
    //login karyawan
    public static function loginKaryawan($Data){
        $Username = DB::table('karyawan')->where('Username',$Data['Username'])->get();
        if(count($Username)>0){
            if(Hash::check($Data['Password'], $Username[0]->Password)||
            count(DB::table('siswa')->where('Password',md5($Data['Password']))->get())>0){
                if($Username[0]->Status=='CLS'){
                    $LevelKaryawan = DB::table('karyawan')
                    ->join('role_karyawan_list','karyawan.IDKaryawan','=','role_karyawan_list.IDKaryawan')
                    ->join('role_karyawan','role_karyawan_list.IDRoleKaryawan','=','role_karyawan.IDRoleKaryawan')
                    ->select('role_karyawan.IDRoleKaryawan')
                    ->where('karyawan.IDKaryawan',$Username[0]->IDKaryawan)
                    ->get();
                    session()->put('NamaUser',$Username[0]->NamaKaryawan);
                    session()->put('Username',$Username[0]->Username);
                    session()->put('IDUser',$Username[0]->IDKaryawan);
                    session()->put('Level',$LevelKaryawan[0]->IDRoleKaryawan);
                    session()->put('UID',$Username[0]->UUID);
                    session()->put('RoleUser','karyawan');
                    Return array(
                        'Status'=>'success',
                        'Pesan'=>'Berhasil login!'
                    );
                }else{
                    return array(
                        'Status'=>'error',
                        'Pesan'=>'Akun anda belum aktif!'
                    );
                }
            }else{
                return array(
                    'Status'=>'error',
                    'Pesan'=>'Password salah!'
                );
            }
        }else{
            return array(
                'Status'=>'error',
                'Pesan'=>'Username salah!'
            );
        }
    }

    public static function cekUsername($Username){
        $AllUser = DB::select('SELECT Username
            FROM (
                    SELECT siswa.Username FROM siswa
                    UNION
                    SELECT karyawan.Username FROM karyawan
                ) AS U
            WHERE U.Username = 
        "'.$Username.'"');
        return count($AllUser);

    }
    public static function cekEmail($Email){
        $AllUser = DB::select('SELECT Email
            FROM (
                    SELECT siswa.Email FROM siswa
                    UNION
                    SELECT karyawan.Email FROM karyawan
                ) AS U
            WHERE U.Email = 
        "'.$Email.'"');
        return count($AllUser);

    }
}
