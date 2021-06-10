<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MasterDataModel extends Model
{
    use HasFactory;
    public static function getAllData($Table){
        try{
            $Data = DB::table($Table)->where('status','OPN')->get();
            return array('Status'=>'success','Data'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailData($Kode,$Table,$Kolom){
        try{
            $Data = DB::table($Table)->where('status','OPN')
            ->where($Kolom,$Kode)->get();
            return array('Status'=>'success','Data'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function updateData($Data,$Kode,$Table,$Kolom){
        try{
            DB::table($Table)->where($Kolom,$Kode)->update($Data);
            return array('Status'=>'success');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }  
    }
    public static function deleteData($Kode,$Table,$Kolom){
        try{
            DB::table($Table)->where($Kolom,$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }  
    }
    public static function storeData($Data,$Table){
        try{
            DB::table($Table)->insert($Data);
            return array('Status'=>'success');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
}
