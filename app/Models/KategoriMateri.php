<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class KategoriMateri extends Model
{
    use HasFactory;
    public static function getAllKategoriMateri(){
        try{
            $Data = DB::table('kategori_materi')->where('status','OPN')->get();
            return array('Status'=>'success','KategoriMateri'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','Message'=>$e);
        }
    }
    public static function getDetailKategoriMateri($Kode){
        try{
            $Data = DB::table('kategori_materi')->where('status','OPN')
            ->where('IDKategoriMateri',$Kode)->get();
            return array('Status'=>'success','KategoriMateri'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','Message'=>$e);
        }
    }
    public static function updateKategoriMateri($Data,$Kode){
        try{
            DB::table('kategori_materi')->where('IDKategoriMateri',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','Message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteKategoriMateri($Kode){
        try{
            DB::table('kategori_materi')->where('IDKategoriMateri',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','Message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function storeKategoriMateri($Data){
        try{
            DB::table('kategori_materi')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','Message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }
}
