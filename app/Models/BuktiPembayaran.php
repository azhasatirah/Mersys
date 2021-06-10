<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class BuktiPembayaran extends Model
{
    use HasFactory;
    public static function showBuktiPembayaranByKodeTransaksi($Kode){
        try{
            $BuktiPembayaran = DB::table('bukti_pembayaran')
            ->join('pembayaran','bukti_pembayaran.IDPembayaran','=','pembayaran.IDPembayaran')
            ->join('transaksi','pembayaran.IDTransaksi','=','transaksi.IDTransaksi')
            ->join('bank','bukti_pembayaran.Bank','=','bank.IDBank')
            ->select('bank.NamaBank','bukti_pembayaran.NamaRekening',
            'bukti_pembayaran.NoRekening','bukti_pembayaran.JumlahDitransfer',
            'bukti_pembayaran.BuktiFoto','bukti_pembayaran.IDBuktiPembayaran',
            'pembayaran.Status','bukti_pembayaran.created_at',
            'pembayaran.NoUrut'
            )
            ->where('transaksi.UUID',$Kode)

            ->get();
            return $BuktiPembayaran;
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
    
}

