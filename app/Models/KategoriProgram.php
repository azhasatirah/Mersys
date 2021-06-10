<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class KategoriProgram extends Model
{
    use HasFactory;

    public static function getAllKategoriProgram(){
        try{
            $Data = DB::table('kategori_program')->where('status','OPN')->get();
            return array('Status'=>'success','KategoriProgram'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }

    // kategori program tanpa kategori kustom
    public static function getAllKategoriProgramSiswa(){
        // ac3d7e6c3f1d48b49d38e6ab3f6039b3 uuid kategori program pendaftaran
        try{
            $Data = DB::table('kategori_program')->where('status','OPN')
            ->where('UUID','!=','ac3d7e6c3f1d48b49d38e6ab3f6039b3')->get();
            return array('Status'=>'success','KategoriProgram'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailKategoriProgram($Kode){
        try{
            $Data = DB::table('kategori_program')->where('status','OPN')
            ->where('IDKategoriProgram',$Kode)->get();
            return array('Status'=>'success','KategoriProgram'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function updateKategoriProgram($Data,$Kode){
        try{
            DB::table('kategori_program')->where('IDKategoriProgram',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteKategoriProgram($Kode){
        try{
            DB::table('kategori_program')->where('IDKategoriProgram',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function storeKategoriProgram($Data){
        try{
            DB::table('kategori_program')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil disimpan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }
}
