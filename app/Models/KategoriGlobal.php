<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class KategoriGlobal extends Model
{
    use HasFactory;

    public static function getAllKategoriGlobal(){
        try{
            $Data = DB::table('kategori_global_program')->where('Status','OPN')->get();
            return array('Status'=>'success','KategoriGlobal'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }

    // kategori program tanpa kategori kustom
    public static function getAllKategoriGlobalSiswa(){
        try{
            $Data = DB::table('kategori_global_program')->where('Status','OPN')
            ->where('IDKategoriGlobalProgram','!=',6)->get();
            return array('Status'=>'success','KategoriGlobal'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailKategoriGlobal($Kode){
        try{
            $Data = DB::table('kategori_global_program')->where('Status','OPN')
            ->where('IDKategoriGlobalProgram',$Kode)->get();
            return array('Status'=>'success','KategoriGlobal'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function updateKategoriGlobal($Data,$Kode){
        try{
            DB::table('kategori_global_program')->where('IDKategoriGlobalProgram',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteKategoriGlobal($Kode){
        try{
            DB::table('kategori_global_program')->where('IDKategoriGlobalProgram',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function storeKategoriGlobal($Data){
        try{
            DB::table('kategori_global_program')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil disimpan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }
}
