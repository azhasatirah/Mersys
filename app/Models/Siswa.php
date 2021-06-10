<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Siswa extends Model
{
    use HasFactory;
    public static function showSiswaByKode($Kode){
        $Siswa = DB::table('siswa')->where('KodeSiswa',$Kode)->get();
        return $Siswa;
    }
    public static function adminGetPendaftaranSiswa(){
        $Siswa = DB::table('siswa')
        ->join('kursus_siswa','siswa.IDSiswa','=','kursus_siswa.IDSiswa')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->where('siswa.Status','OPN')
        ->where('IDProgram',1)
        ->select('siswa.NamaSiswa','siswa.created_at','siswa.KodeSiswa','siswa.UUID as UUIDSiswa',
        'siswa.Alamat','siswa.Email','transaksi.Status','transaksi.IDTransaksi')->get();
        return array('Status'=>'success','Siswa'=>$Siswa);
    }
    public static function ownerGetPendaftaranSiswa(){
        $Siswa = DB::table('siswa')
        ->join('kursus_siswa','siswa.IDSiswa','=','kursus_siswa.IDSiswa')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->where('siswa.Status','CFM')
        ->where('IDProgram',1)
        ->select('siswa.NamaSiswa','siswa.created_at','siswa.KodeSiswa','siswa.UUID as UUIDSiswa',
        'siswa.Alamat','siswa.Email','transaksi.Status','transaksi.IDTransaksi')->get();
        return array('Status'=>'success','Siswa'=>$Siswa);
    }
    public static function changeStatusByKodePembayaran($Kode,$Data){
        try{
            DB::table('siswa')
            ->join('kursus_siswa','siswa.IDSiswa','=','kursus_siswa.IDSiswa')
            ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
            ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
            ->where('pembayaran.KodePembayaran',$Kode)
            ->update($Data)
           ;
            return array(
                'Status'=>'success');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi Kesalahan!');
        }
    }
}
