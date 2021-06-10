<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Jadwal extends Model
{
    use HasFactory;

    public static function getAllJadwal(){
        try{
            $Data = DB::table('jadwal')
            ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
            ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
            ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
            ->select('kursus_materi.Hari','jadwal.Tanggal',
            'kursus_materi.NamaMateri','kursus_siswa.KodeKursus',
            'siswa.NamaSiswa','jadwal.IDJadwal','jadwal.IDTutor')
            ->where('jadwal.Status','OPN')->get();
            return array('Status'=>'success','Jadwal'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }

    public static function getDetailJadwal($Kode){
        try{
            $Data = DB::table('Siswa')->where('status','CFM')
            ->where('KodeSiswa',$Kode)->get();
            return array('Status'=>'success','Jadwal'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }

    // public static function updateJadwal($Data,$Kode){
    //     try{
    //         DB::table('siswa')->where('KodeLevel',$Kode)->update($Data);
    //         return array('Status'=>'success');
    //     }catch(QueryException $e){
    //         return array('Status'=>'error','message'=>$e);
    //     }  
    // }

}
