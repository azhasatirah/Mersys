<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Transaksi extends Model
{
    use HasFactory;

    public static function getAllTransaksi(){
        try{
            $Transaksi = DB::table('transaksi')
            ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
            ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
                'transaksi.Status','transaksi.UUID as UUIDTransaksi',
                'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
            ->get();
            return array(
                'Status'=>'success',
                'Transaksi'=>$Transaksi
            );
        }catch(QueryException $e){
            return array(
                'Status'=>'success',
                'Message'=>$e
            );
        }
    }
    public static function getTransaksiByIDSiswa($ID){
        try{
            $Transaksi = DB::table('transaksi')
            ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
            ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->select('transaksi.Total','transaksi.Keterangan','transaksi.Tanggal','transaksi.UUID',
            'siswa.NamaSiswa','program_studi.NamaProdi','program_studi.TotalPertemuan',
            'kategori_program.KategoriProgram','transaksi.IDTransaksi','transaksi.KodeTransaksi',
            'transaksi.Status as StatusPembayaran'
            )
            ->where('transaksi.IDSiswa',$ID)
            ->orderBy('transaksi.created_at','desc')
            ->get();
            return array(
                'Status'=>'success',
                'Transaksi'=>$Transaksi
            );
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Message'=>$e
            );
        }
    }
    public static function showTransaksi($Kode){
        try{
            $Transaksi = DB::table('transaksi')
            ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
            ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->select('transaksi.Total','transaksi.Keterangan','transaksi.Tanggal','transaksi.UUID','transaksi.Hutang',
            'siswa.NamaSiswa','program_studi.NamaProdi','program_studi.TotalPertemuan','transaksi.Status',
            'kategori_program.KategoriProgram','transaksi.IDTransaksi','transaksi.KodeTransaksi'
            )
            ->where('transaksi.UUID',$Kode)
            ->get();
            return array(
                'Status'=>'success',
                'Transaksi'=>$Transaksi
            );
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Message'=>$e
            );
        }
    }
    public static function storeTransaksi($Data){
        try{
            DB::table('transaksi')->insert($Data);
            return array(
                'Status'=>'success');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'message'=>$e);
        }
    }
    public static function changeStatus($Kode,$Data){
        try{
            DB::table('transaksi')
            ->where('UUID',$Kode)
            ->update($Data);
            return array(
                'Status'=>'success');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi Kesalahan!');
        }
    }
    public static function changeStatusByIDPembayaran($Data,$Kode){
        try{
            DB::table('transaksi')
            ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
            ->where('pembayaran.IDPembayaran',$Kode)
            ->update($Data);
            return array(
                'Status'=>'success');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi Kesalahan!');
        }
    }
    public static function changeStatusByID($Kode,$Data){
        try{
            DB::table('transaksi')
            ->update($Data)
            ->where('IDTransaksi',$Kode)
            ->get();
            return array(
                'Status'=>'success');
        }catch(QueryException $e){
            return array(
                'Status'=>'error',
                'Pesan'=>'Terjadi Kesalahan!');
        }
    }
    public static function getLinkBiayaPendaftaran(){
        $Link = DB::table('transaksi')
        ->join('kursus_siswa','transaksi.IDKursusSiswa','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('transaksi.IDSiswa',session()->get('IDUser'))
        ->where('program_studi.IDProgram',1)
        ->select('transaksi.UUID')->get();
        return $Link;
    }

    public static function showTransaksiAndPembayaran($Kode){
        try{
            $Transaksi = DB::table('transaksi')
            ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
            ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
            ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
                'transaksi.Status','transaksi.UUID as UUIDTransaksi',
                'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
            ->get();
            return array(
                'Status'=>'success',
                'Transaksi'=>$Transaksi
            );
        }catch(QueryException $e){
            return array(
                'Status'=>'success',
                'Message'=>$e
            );
        }
    }
    public static function changeStatusByKodePembayaran($Kode,$Data){
 
        try{
            DB::table('transaksi')
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
