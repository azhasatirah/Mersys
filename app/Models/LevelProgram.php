<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class LevelProgram extends Model
{
    use HasFactory;

    public static function getAllLevelProgram(){
        try{
            $Data = DB::table('level_program')->where('status','OPN')->get();
            return array('Status'=>'success','LevelProgram'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailLevelProgram($Kode){
        try{
            $Data = DB::table('level_program')->where('status','OPN')
            ->where('IDLevel',$Kode)->get();
            return array('Status'=>'success','LevelProgram'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function updateLevelProgram($Data,$Kode){
        try{
            DB::table('level_program')->where('IDLevel',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah:)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }  
    }
    public static function deleteLevelProgram($Kode){
        try{
            DB::table('level_program')->where('IDLevel',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus:)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }  
    }
    public static function storeLevelProgram($Data){
        try{
            DB::table('level_program')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan:)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }

}
