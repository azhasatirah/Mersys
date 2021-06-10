<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pembayaran extends Model
{
    use HasFactory;
    public static function getAllPembayaran(){
        try{
            $Data = DB::table('pembayaran')
            ->join('metode_pembayaran','pembayaran.IDMetodePembayaran','=','metode_pembayaran.IDMetodePembayaran')
            ->join('rekening','metode_pembayaran.IDRekening','=','rekening.IDRekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->select('pembayaran.Total','pembayaran.IDPembayaran','pembayaran.KodePembayaran','pembayaran.UUID',
            'pembayaran.TanggalBayar','metode_pembayaran.MetodePembayaran','rekening.NoRekening','rekening.NamaRekening',
            'bank.NamaBank')
            ->where('pembayaran.Status','OPN')
            ->get();
            return array('Status'=>'success','Pembayaran'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function showPembayaranByKodeTransaksi($Kode){
        try{
            $Data = DB::table('pembayaran')
            ->join('transaksi','pembayaran.IDTransaksi','=','transaksi.IDTransaksi')
            ->where('transaksi.UUID',$Kode)

            ->select('pembayaran.UUID as UUIDPembayaran')
            ->get();
            return $Data;
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function showPembayaranByKodePembayaran($Kode){
        try{
            $Data = DB::table('pembayaran')
            ->join('transaksi','pembayaran.IDTransaksi','=','transaksi.IDTransaksi')
            ->where('pembayaran.KodePembayaran',$Kode)
            ->select('pembayaran.UUID as UUIDPembayaran','pembayaran.IDPembayaran',
            'transaksi.IDTransaksi')
            ->get();
            return $Data;
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailPembayaran($Kode){
        try{
            $Data = DB::table('pembayaran')
            ->join('transaksi','pembayaran.IDTransaksi','=','transaksi.IDTransaksi')
            ->join('metode_pembayaran','pembayaran.IDMetodePembayaran','=','metode_pembayaran.IDMetodePembayaran')
            ->join('rekening','metode_pembayaran.IDDompet','=','rekening.IDRekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->select('pembayaran.Total','pembayaran.IDPembayaran','pembayaran.KodePembayaran','pembayaran.UUID',
            'pembayaran.created_at','metode_pembayaran.MetodePembayaran','rekening.NoRekening','rekening.NamaRekening',
            'bank.NamaBank')
            ->where('pembayaran.UUID',$Kode)->get();
            return array('Status'=>'success','Pembayaran'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailBuktiPembayaran($Kode){
        try{
            $Data = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->join('bank as banksend','bukti_pembayaran.Bank','=','banksend.IDBank')
            ->join('transaksi','pembayaran.IDTransaksi','=','transaksi.IDTransaksi')
            ->join('metode_pembayaran','pembayaran.IDMetodePembayaran','=','metode_pembayaran.IDMetodePembayaran')
            ->join('rekening','metode_pembayaran.IDDompet','=','rekening.IDRekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->join('kursus_siswa','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
            ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->select(
                'bukti_pembayaran.JumlahDitransfer','bukti_pembayaran.NoRekening as NoRekeningPengirim',
                'bukti_pembayaran.NamaRekening as NamaRekeningPengirim','bukti_pembayaran.BuktiFoto',
                'pembayaran.Total','pembayaran.IDPembayaran','pembayaran.KodePembayaran',
            'pembayaran.created_at','metode_pembayaran.MetodePembayaran','rekening.NoRekening','rekening.NamaRekening',
            'bank.NamaBank','transaksi.KodeTransaksi','banksend.NamaBank as BankPengirim',
            'siswa.NamaSiswa','program_studi.NamaProdi')
            ->where('transaksi.UUID',$Kode)->get();
            return array('Status'=>'success','Pembayaran'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailPembayaranBySiswa($Kode){
        try{
            $Data = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->join('bank as banksend','bukti_pembayaran.Bank','=','banksend.IDBank')
            ->join('transaksi','pembayaran.IDTransaksi','=','transaksi.IDTransaksi')
            ->join('metode_pembayaran','pembayaran.IDMetodePembayaran','=','metode_pembayaran.IDMetodePembayaran')
            ->join('rekening','metode_pembayaran.IDDompet','=','rekening.IDRekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->join('kursus_siswa','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
            ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->select(
                'bukti_pembayaran.JumlahDitransfer','bukti_pembayaran.NoRekening as NoRekeningPengirim',
                'bukti_pembayaran.NamaRekening as NamaRekeningPengirim','bukti_pembayaran.BuktiFoto',
                'pembayaran.Total','pembayaran.IDPembayaran','pembayaran.KodePembayaran',
            'pembayaran.created_at','metode_pembayaran.MetodePembayaran','rekening.NoRekening','rekening.NamaRekening',
            'bank.NamaBank','transaksi.KodeTransaksi','banksend.NamaBank as BankPengirim',
            'siswa.NamaSiswa','program_studi.NamaProdi')
            ->where('siswa.UUID',$Kode)->get();
            return array('Status'=>'success','Pembayaran'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storePembayaran($Data){
        try{
            DB::table('pembayaran')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function storeBuktiPembayaran($Data){
        try{
            DB::table('bukti_pembayaran')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updatePembayaran($Data,$Kode){
        try{
            DB::table('pembayaran')->where('IDPembayaran',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deletePembayaran($Kode){
        try{
            DB::table('pembayaran')->where('IDPembayaran',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function changeStatusByKodePembayaran($Kode,$Data){
        try{
            DB::table('pembayaran')
            ->where('KodePembayaran',$Kode)
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
