<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\support\Carbon;
class NilaiEvaluasiController extends Controller
{
    public function index($id){
        $DataKursus = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('jadwal','kursus_siswa.IDKursusSiswa','=','jadwal.IDKursusSiswa')
        ->select('kursus_siswa.*','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('kursus_siswa.UUID',$id)
        ->where('jadwal.IDTutor',session()->get('IDUser'))
        ->get();
        $DataKursusMateri = DB::table('kursus_materi')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->where('kursus_siswa.UUID',$id)->orderBy('NoRecord')->get();
        $NilaiEvaluasi = [];
        foreach($DataKursusMateri as $KursusMateri){
            //dump($KursusMateri);
            $DataNilaiEvaluasi = DB::table('nilai_evaluasi')
            ->where('IDKursusMateri',$KursusMateri->IDKursusMateri)
            ->where('Status','OPN')->get();
            array_push($NilaiEvaluasi,array(
                'IDNilaiEvaluasi'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->IDNilaiEvaluasi:false,
                'NoRecord'=>$KursusMateri->NoRecord,
                'IDKursusMateri'=>$KursusMateri->IDKursusMateri,
                'IDKursusSiswa'=>$KursusMateri->IDKursus,
                'NamaMateri'=>$KursusMateri->NamaMateri,
                'Plus'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Plus:'Belum dinilai',
                'Minus'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Minus:'Belum dinilai',
                'Saran'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Saran:'Belum ada saran',
            ));
        }
       // dd($NilaiEvaluasi);
        return view('karyawan/nilai_evaluasi_tutor_detail',[
            'NilaiEvaluasi'=>$NilaiEvaluasi,
            'Kursus'=>$DataKursus,
        ]);
    }
    public function indexSiswa($id){
        $DataKursus = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('jadwal','kursus_siswa.IDKursusSiswa','=','jadwal.IDKursusSiswa')
        ->select('kursus_siswa.*','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('kursus_siswa.UUID',$id)
        ->get();
        $DataKursusMateri = DB::table('kursus_materi')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->where('kursus_siswa.UUID',$id)->orderBy('NoRecord')->get();
        $NilaiEvaluasi = [];
        foreach($DataKursusMateri as $KursusMateri){
            $DataNilaiEvaluasi = DB::table('nilai_evaluasi')
            ->where('IDKursusMateri',$KursusMateri->IDKursusMateri)
            ->where('Status','OPN')->get();
            array_push($NilaiEvaluasi,array(
                'IDNilaiEvaluasi'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->IDNilaiEvaluasi:false,
                'NoRecord'=>$KursusMateri->NoRecord,
                'IDKursusMateri'=>$KursusMateri->IDKursusMateri,
                'IDKursusSiswa'=>$KursusMateri->IDKursus,
                'NamaMateri'=>$KursusMateri->NamaMateri,
                'Plus'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Plus:'Belum dinilai',
                'Minus'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Minus:'Belum dinilai',
                'Saran'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Saran:'Belum ada saran',
            ));
        }
        //dd($DataKursusMateri);
        return view('siswa/nilai/nilai_evaluasi_detail',[
            'NilaiEvaluasi'=>$NilaiEvaluasi,
            'Kursus'=>$DataKursus,
        ]);
    }

    public function store(Request $request){
        $Data = array(
            'IDKursus'=>$request->idkursussiswa,
            'IDKursusMateri'=>$request->idkursusmateri,
            'NamaMateri'=>$request->materieva,
            'Plus'=>$request->pluseva,
            'Minus'=>$request->minuseva,
            'Saran'=>$request->saraneva,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('nilai_evaluasi')->insert($Data);
        return redirect()->back();
    }

    public function update(Request $request){
        $Data = array(
            'Plus'=>$request->pluseva,
            'Minus'=>$request->minuseva,
            'Saran'=>$request->saraneva,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('nilai_evaluasi')
        ->where('IDNilaiEvaluasi',intval($request->idnilaievaluasi))
        ->update($Data);
        return redirect()->back();
    }
    public function destroy( $id){
        DB::table('nilai_evaluasi')->where('IDNilaiEvaluasi',$id)
        ->update(['Status'=>'DEL']);
       return redirect()->back()->withInput();;
    }
    public function showEvaluasi($id){
        $DataKursus = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('kursus_materi','kursus_siswa.IDKursusSiswa','=','kursus_materi.IDKursus')
        ->join('karyawan','kursus_materi.IDKaryawan','=','karyawan.IDKaryawan')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->select('karyawan.NamaKaryawan','siswa.NamaSiswa','siswa.IDSiswa',
        'program_studi.NamaProdi','program_studi.IDKategoriGlobalProgram as KategoriGlobal')
        ->where('kursus_siswa.UUID',$id)->get();
        if($DataKursus[0]->KategoriGlobal==2){
            $BulananKey = explode(' (Bulanan',$DataKursus[0]->NamaProdi)[0];
            $DataKursusMateri = DB::table('kursus_materi')
            ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->where('NamaProdi','like',$BulananKey.' (Bulanan%')
            ->where('kursus_siswa.IDSiswa',$DataKursus[0]->IDSiswa)
            ->where('kursus_siswa.Status','!=','DEL')
            ->orderBy('kursus_materi.IDProgram')
            ->orderBy('NoRecord')->get();
        }else{
            $DataKursusMateri = DB::table('kursus_materi')
            ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
            ->where('kursus_siswa.UUID',$id)->orderBy('NoRecord')->get();
        }
        $NilaiEvaluasi = [];
        $Ite =0;
        foreach($DataKursusMateri as $KursusMateri){
            $Ite ++;
            $DataNilaiEvaluasi = DB::table('nilai_evaluasi')
            ->where('IDKursusMateri',$KursusMateri->IDKursusMateri)
            ->where('Status','OPN')->get();
            array_push($NilaiEvaluasi,array(
                'IDNilaiEvaluasi'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->IDNilaiEvaluasi:false,
                'NoRecord'=>$Ite,
                'IDKursusMateri'=>$KursusMateri->IDKursusMateri,
                'IDKursusSiswa'=>$KursusMateri->IDKursus,
                'NamaMateri'=>$KursusMateri->NamaMateri,
                'Plus'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Plus:'Belum dinilai',
                'Minus'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Minus:'Belum dinilai',
                'Saran'=>count($DataNilaiEvaluasi)>0?$DataNilaiEvaluasi[0]->Saran:'Belum ada saran',
            ));
        }
        
        return view('siswa/nilai/nilai_evaluasi',[
            'NilaiEvaluasi'=>$NilaiEvaluasi,
            'KursusSiswa'=>$DataKursus,
        ]);

    }
}
