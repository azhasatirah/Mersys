<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MetodePembayaran extends Model
{
    use HasFactory;
    public static function getAllMetodePembayaran(){
        try{
            $Data = DB::table('metode_pembayaran')
            ->join('rekening','metode_pembayaran.IDDompet','=','rekening.IDRekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->select('metode_pembayaran.MetodePembayaran','metode_pembayaran.IDMetodePembayaran',
            'metode_pembayaran.Jenis',
            'bank.LogoBank','bank.NamaBank','rekening.NoRekening')
            ->where('metode_pembayaran.Status','OPN')->get();
            return array('Status'=>'success','MetodePembayaran'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function showMetodePembayaran($Kode){
        try{
            $Data = DB::table('metode_pembayaran')
            ->join('rekening','metode_pembayaran.IDDompet','=','rekening.IDRekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->select('metode_pembayaran.MetodePembayaran','metode_pembayaran.IDMetodePembayaran',
            'bank.LogoBank','bank.NamaBank','rekening.NamaRekening','rekening.NoRekening')
            ->where('metode_pembayaran.Status','OPN')
            ->where('metode_pembayaran.IDMetodePembayaran',$Kode)->get();
            return array('Status'=>'success','metode_pembayaran'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storeMetodePembayaran($Data){
        try{
            DB::table('metode_pembayaran')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updateMetodePembayaran($Data,$Kode){
        try{
            DB::table('metode_pembayaran')->where('IDMetodePembayaran',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteMetodePembayaran($Kode){
        try{
            DB::table('metode_pembayaran')->where('IDMetodePembayaran',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
