<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class KursusSiswa extends Model
{
    use HasFactory;
    public static function getAllKursusSiswa(){
        try{
            $KursusSiswa = DB::table('kursus_siswa')
            ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->join('transaksi','kursus_siswa.IDTransaksi','=','transaksi.IDTransaksi')
            ->get();
            return array(
                'Status'=>'success',
                'KursusSiswa'=>$KursusSiswa);
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>$e);
        }
    }
    public static function showKursusSiswa($Kode){
        try{
            $KursusSiswa = DB::table('kursus_siswa')
            ->select('kursus_siswa.*')
            ->where('kursus_siswa.UUID',$Kode)->get();
            return array(
                'Status'=>'success',
                'KursusSiswa'=>$KursusSiswa);
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>$e);
        }
    }

    public static function storeKursusSiswa($Data){
        try{
            DB::table('kursus_siswa')->insert($Data);
            return array(
                'Status'=>'success',
                'Pesan'=>'Berhasil mengambil kursus!');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi kesalahan!');
        }
    }
    public static function changeStatus($Kode,$Data){
        try{
            DB::table('kursus_siswa')
            ->update($Data)
            ->where('KodeKursus',$Kode)
            ->get();
            return array(
                'Status'=>'success');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi Kesalahan!');
        }
    }
}
