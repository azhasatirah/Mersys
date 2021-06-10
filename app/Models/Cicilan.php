<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Cicilan extends Model
{
    use HasFactory;
    public static function getAllCicilan(){
        try{
            $Data = DB::table('cicilan')
            ->where('cicilan.Status','OPN')->get();
            return array('Status'=>'success','Cicilan'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getHargaByIDProgram($ID){
        try{
            $Data = DB::table('cicilan')
            ->join('program_studi','cicilan.IDProgram','=','program_studi.IDProgram')
            ->select('cicilan.IDCicilan','cicilan.Harga','cicilan.Cicilan')
            ->where('program_studi.UUID',$ID)->get();
            return array('Status'=>'success','Harga'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getCicilanByIDTransaksi($ID){
        try{
            $Data = DB::table('cicilan')
            ->join('program_studi','cicilan.IDProgram','=','program_studi.IDProgram')
            ->join('kursus_siswa','program_studi.IDProgram','=','kursus_siswa.IDProgram')
            ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
            ->select('cicilan.Cicilan','cicilan.Harga')
            ->where('transaksi.IDTransaksi',$ID)
            ->get();
            return array('Status'=>'success','Cicilan'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function showCicilanByIDProgram($ID){
        try{
            $Data = DB::table('cicilan')
            ->join('program_studi','cicilan.IDProgram','=','program_studi.IDProgram')
            ->select('cicilan.Cicilan','cicilan.Harga')
            ->get();
            return array('Status'=>'success','Cicilan'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function getDetailCicilan($Kode){
        try{
            $Data = DB::table('cicilan')
            ->where('cicilan.IDCicilan',$Kode)->get();
            return array('Status'=>'success','Cicilan'=>$Data);
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e);
        }
    }
    public static function storeCicilan($Data){
        try{
            DB::table('cicilan')->insert($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil ditambahkan :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }
    }

    public static function updateCicilan($Data,$Kode){
        try{
            DB::table('cicilan')->where('IDCicilan',$Kode)->update($Data);
            return array('Status'=>'success','Pesan'=>'Data berhasil diubah :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
    public static function deleteCicilan($Kode){
        try{
            DB::table('cicilan')->where('IDCicilan',$Kode)->update(['Status'=>'DEL']);
            return array('Status'=>'success','Pesan'=>'Data berhasil dihapus :)');
        }catch(QueryException $e){
            return array('Status'=>'error','message'=>$e,'Pesan'=>'Terjadi kesalahan :(');
        }  
    }
}
