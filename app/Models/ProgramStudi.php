<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProgramStudi extends Model
{
    use HasFactory;

    public static function getAllProgramStudi(){
        try{
            $Data = DB::table('program_studi')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->join('level_program','program_studi.IDLevel','=','level_program.IDLevel')
            ->select('program_studi.IDProgram','program_studi.Cicilan','program_studi.KodeProgram','program_studi.UUID as UUIDProgram',
            'program_studi.NamaProdi','program_studi.KodeProgram',
            'program_studi.TotalPertemuan','program_studi.Harga','level_program.NamaLevel','kategori_program.KategoriProgram')
            ->where('program_studi.IDProgram','!=',1)
            ->where('program_studi.Status','OPN')->get();
            return array('Status'=>'success','ProgramStudi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getProgramStudi(){
        try{
            $Data = DB::table('program_studi')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->join('level_program','program_studi.IDLevel','=','level_program.IDLevel')
            ->select('program_studi.IDProgram','program_studi.Cicilan','program_studi.KodeProgram','program_studi.UUID',
            'program_studi.NamaProdi','program_studi.KodeProgram',
            'program_studi.TotalPertemuan','program_studi.Harga','level_program.NamaLevel','kategori_program.KategoriProgram')
            ->where('program_studi.Status','OPN')
            ->where('program_studi.IDProgram','!=',1)->get();
            return array('Status'=>'success','ProgramStudi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getProgramStudiByKategori($Kode,$kodee){
    
        try{
            $Data = DB::table('program_studi')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->join('level_program','program_studi.IDLevel','=','level_program.IDLevel')
            ->join('kategori_global_program','program_studi.IDKategoriGlobalProgram','=','kategori_global_program.IDKategoriGlobalProgram')
            ->select('program_studi.IDProgram','program_studi.Cicilan','program_studi.KodeProgram','program_studi.UUID',
            'program_studi.NamaProdi','program_studi.KodeProgram',
            'program_studi.TotalPertemuan','program_studi.Harga','level_program.NamaLevel','kategori_program.KategoriProgram')
            ->where('program_studi.Status','OPN')
            ->where('kategori_global_program.UUID',$kodee)
            ->where('kategori_program.UUID',$Kode)->get();
            return array('Status'=>'success','ProgramStudi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }

    public static function getDetailProgramStudi($Kode){

        try{
            $Data = DB::table('program_studi')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->join('level_program','program_studi.IDLevel','=','level_program.IDLevel')
            ->select('program_studi.IDProgram','program_studi.KodeProgram','program_studi.UUID',
            'program_studi.NamaProdi','program_studi.Cicilan',
            'program_studi.TotalPertemuan','program_studi.Harga','level_program.NamaLevel',
            'level_program.IDLevel','kategori_program.KategoriProgram','kategori_program.IDKategoriProgram')
            ->where('program_studi.Status','OPN')
            ->where('IDProgram',$Kode)->get();
            return array('Status'=>'success','ProgramStudi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function showProgramByKode($Kode){

        try{
            $Data = DB::table('program_studi')
            ->join('kategori_program','program_studi.IDKategoriProgram','=','kategori_program.IDKategoriProgram')
            ->join('level_program','program_studi.IDLevel','=','level_program.IDLevel')
            ->select('program_studi.IDProgram','program_studi.KodeProgram','program_studi.UUID',
            'program_studi.NamaProdi','program_studi.Cicilan',
            'program_studi.TotalPertemuan','program_studi.Harga','level_program.NamaLevel',
            'level_program.IDLevel','kategori_program.KategoriProgram','kategori_program.IDKategoriProgram')
            ->where('program_studi.Status','OPN')
            ->where('KodeProgram',$Kode)->get();
            return array('Status'=>'success','ProgramStudi'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storeProgramStudi($Data){
        try{
            DB::table('program_studi')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updateProgramStudi($Data,$Kode){
        try{
            DB::table('program_studi')->where('IDProgram',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteProgramStudi($Kode){
        try{
            DB::table('program_studi')->where('IDProgram',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
