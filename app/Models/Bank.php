<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Bank extends Model
{
    use HasFactory;
    public static function getAllBank(){
        try{
            $Data = DB::table('bank')
            ->where('bank.Status','OPN')->get();
            return array('Status'=>'success','Bank'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailBank($Kode){
        try{
            $Data = DB::table('bank')
            ->where('bank.IDBank',$Kode)->get();
            return array('Status'=>'success','Bank'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storeBank($Data){
        try{
            DB::table('bank')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updateBank($Data,$Kode){
        try{
            DB::table('bank')->where('IDBank',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteBank($Kode){
        try{
            DB::table('bank')->where('IDBank',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
