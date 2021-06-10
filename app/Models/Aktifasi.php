<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Aktifasi extends Model
{
    use HasFactory;

    public static function getAllAktifasi(){
        try{
            $Data = DB::table('karyawan')
            ->select('karyawan.IDKaryawan','karyawan.NamaKaryawan','karyawan.TanggalLahir','karyawan.TempatLahir',
            'karyawan.JenisKelamin','karyawan.Alamat','karyawan.NoHP')
            ->where('karyawan.Status','OPN')->get();
            return array('Status'=>'success','AkunKaryawan'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    // public static function getDetailAktifasi($Kode){

    //     try{
    //         $Data = DB::table('karyawan')
    //         ->select('karyawan.IDKaryawan','karyawan.NamaKaryawan','karyawan.TanggalLahir',
    //         'karyawan.TempatLahir','karyawan.Cicilan',
    //         'karyawan.JenisKelamin','karyawan.Alamat','karyawan.NoHP')
    //         ->where('karyawan.Status','OPN')
    //         ->where('KodeProgram',$Kode)->get();
    //         return array('Status'=>'success','AkunKaryawan'=>$Data);
    //     }catch(QueryException $e){
    //         return array('Status'=>'error','message'=>$e);
    //     }
    // }

   public static function updateAkun($id){
        try{
            DB::table('karyawan') 
               ->where('IDKaryawan',$id)
               ->update(['karyawan.Status' => "CFM"]);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
