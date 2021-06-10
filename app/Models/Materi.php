<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Materi extends Model
{
    use HasFactory;
    public static function getAllMateri(){
        try{
            $Data = DB::table('materi_program')
            ->join('kategori_materi','materi_program.IDKategoriMateri','=','kategori_materi.IDKategoriMateri')
            ->join('program_studi','materi_program.IDProgram','=','program_studi.IDProgram')
            ->select('materi_program.IDProgram','materi_program.IDKategoriMateri','materi_program.IDMateriProgram',
            'materi_program.NamaMateri','kategori_materi.NamaKategoriMateri','program_studi.NamaProdi')
            ->where('materi_program.Status','OPN')->get();
            return array('Status'=>'success','Materi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailMateri($Kode){
        try{
            $Data = DB::table('materi_program')
            ->join('kategori_materi','materi_program.IDKategoriMateri','=','kategori_materi.IDKategoriMateri')
            ->join('program_studi','materi_program.IDProgram','=','program_studi.IDProgram')
            ->select('materi_program.IDProgram','materi_program.IDKategoriMateri','materi_program.IDMateriProgram',
            'materi_program.NamaMateri','kategori_materi.NamaKategoriMateri','program_studi.NamaProdi')
            ->where('materi_program.Status','OPN')
            ->where('materi_program.IDMateriProgram',$Kode)->get();
            return array('Status'=>'success','Materi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storeMateri($Data){
        try{
            DB::table('materi_program')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updateMateri($Data,$Kode){
        try{
            DB::table('materi_program')->where('IDMateriProgram',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteMateri($Kode){
        try{
            DB::table('materi_program')->where('IDMateriProgram',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
