<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\ProgramStudi;
use App\Models\KategoriMateri;
use App\Models\Materi;
use DB;

class MateriController extends Controller
{
    public function index(){
        $ProgramStudi = ProgramStudi::getAllProgramStudi();
        $KategoriMateri = KategoriMateri::getAllKategoriMateri();
        return view('karyawan.master.materi',[
            'ProgramStudi'=>$ProgramStudi,
            'KategoriMateri'=>$KategoriMateri
        ]);
    }
    public function create(){
        $KategoriProgram = KategoriProgram::getAllKategoriProgram();
        $LevelProgram = LevelProgram::getAllLevelProgram();
        return view('karyawan.master.program studi.create',[
            'KategoriProgram'=>$KategoriProgram,
            'LevelProgram'=>$LevelProgram
        ]);
    }
    public function store(Request $request){
        $Data = array(
            'NamaMateri'=>$request->materi,
            'IDKategoriMateri'=>$request->kategorimateri,
            'IDProgram'=>$request->programstudi,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = Materi::storeMateri($Data);
        return response()->json($status);
    }
    public function edit($id){
        $Materi = Materi::getDetailMateri($id);

        return response()->json($Materi['Materi']);
    }
    public function update(Request $request){
        $Data = array(
            'NamaMateri'=>$request->materi,
            'IDKategoriMateri'=>$request->kategorimateri,
            'IDProgram'=>$request->programstudi,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = Materi::updateMateri($Data,$request->id);
        return response()->json($Status);
    }

    //json
    public function delete($Kode){
        $Pesan = Materi::deleteMateri($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $Materi = Materi::getAllMateri();
        return response()->json($Materi);
    }
    public function getMateriByIDKursusSiswa($id){
        $Data = DB::table('materi_program')
        ->join('program_studi','materi_program.IDProgram','=','program_studi.IDProgram')
        ->join('kursus_siswa','program_studi.IDProgram','=','kursus_siswa.IDProgram')
        ->select('materi_program.NamaMateri','materi_program.IDMateriProgram')
        ->where('materi_program.Status','OPN')
        ->get()->orderBy('materi_program.NoRecord','ASC');
        return response()->json($Data);
    }
    public function getMateriByIDProgram($id){
        $Data = DB::table('materi_program')
        ->select('materi_program.NamaMateri','materi_program.IDMateriProgram')
        ->where('materi_program.Status','OPN')
        ->where('materi_program.IDProgram',$id)
        ->get();
        return response()->json($Data);
    }
}
