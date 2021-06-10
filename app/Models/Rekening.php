<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Rekening extends Model
{
    use HasFactory;
    public static function getAllRekening(){
        try{
            $Data = DB::table('rekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->select('rekening.*','bank.NamaBank','bank.LogoBank')
            ->where('rekening.Status','OPN')->get();
            return array('Status'=>'success','Rekening'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailRekening($Kode){
        try{
            $Data = DB::table('rekening')
            ->join('bank','rekening.IDBank','=','bank.IDBank')
            ->select('rekening.*','bank.NamaBank')
            ->where('rekening.Status','OPN')
            ->where('rekening.IDRekening',$Kode)->get();
            return array('Status'=>'success','Rekening'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storeRekening($Data){
        try{
            DB::table('rekening')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updateRekening($Data,$Kode){
        try{
            DB::table('rekening')->where('IDRekening',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteRekening($Kode){
        try{
            DB::table('rekening')->where('IDRekening',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
