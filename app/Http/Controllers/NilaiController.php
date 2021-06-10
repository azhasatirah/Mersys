<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\support\Carbon;

class NilaiController extends Controller
{
    public function index($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis')
        ->get()->groupBy('Jenis');
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            array_push($DataNilai, array(
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Content'=>$Nilai
            ));

        };
        $DataKursus = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('jadwal','kursus_siswa.IDKursusSiswa','=','jadwal.IDKursusSiswa')
        ->select('kursus_siswa.*','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('kursus_siswa.UUID',$id)
        ->where('jadwal.IDTutor',session()->get('IDUser'))
        ->get();
        $JenisNilai = DB::table('jenis_nilai')->where('Status','OPN')->get();
        //dd($DataNilai);
        return view('karyawan/nilai_tutor_detail',['Nilai'=>$DataNilai,'Kursus'=>$DataKursus,'JenisNilai'=>$JenisNilai]);
    }
    public function indexSiswa($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis')
        ->get()->groupBy('Jenis');
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            array_push($DataNilai, array(
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Content'=>$Nilai
            ));

        };
        $DataKursus = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('jadwal','kursus_siswa.IDKursusSiswa','=','jadwal.IDKursusSiswa')
        ->select('kursus_siswa.*','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('kursus_siswa.UUID',$id)
        ->get();
        $JenisNilai = DB::table('jenis_nilai')->where('Status','OPN')->get();
        //dd($DataNilai);
        return view('siswa/nilai/nilai_detail',['Nilai'=>$DataNilai,'Kursus'=>$DataKursus,'JenisNilai'=>$JenisNilai]);
    }
    public function kursus(){
        $Kursus = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('kursus_siswa.Status','CLS')
        ->select('kursus_siswa.*','siswa.NamaSiswa','program_studi.NamaProdi')->get();
       // dd($Kursus);
        return view('karyawan/nilai_tutor',['Kursus'=>$Kursus]);
    }
    public function getData(){
        $Data = DB::table('nilai')->where('Status','OPN')->get();
        return response()->json($Data);
    }
    public function getDataDetail($id){
        $DataNilai = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis')
        ->get()->groupBy('Jenis');
        $DataKursus = DB::table('kursus_siswa')->where('kursus_siswa.UUID',$id)->get();
        $Data = array(
            'Nilai'=>$DataNilai,
            'Kursus'=>$DataKursus
        );
        return response()->json($Data);
    }

    public function store(Request $request){
        $Data = array(
            'IDJenis'=>$request->jenis,
            'IDKursus'=>$request->kursus,
            'Nilai'=>$request->nilai,
            'NamaNilai'=>$request->namanilai,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('nilai')->insert($Data);
        return redirect()->back();
    }
    public function storeNilaiEvaluasi(Request $request){
        //dd($request);
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
            'IDJenis'=>$request->jenis,
            'NamaNilai'=>$request->namanilai,
            'Nilai'=>$request->nilai,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('nilai')->where('IDNilai',$request->IDNilai)->update($Data);
        return redirect('karyawan/tutor/nilai');
    }
    public function destroy( $id){
        DB::table('nilai')->where('IDNilai',$id)
        ->update(['Status'=>'DEL']);
       return redirect()->back()->withInput();;
    }

    public function showRapor($id){
        $Rapor = DB::table('kursus_siswa as ks')
        ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
        ->join('nilai as n','ks.IDKursusSiswa','=','n.IDKursus')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->where('ks.UUID',$id)
        ->select('s.NamaSiswa','ps.NamaProdi','n.NamaNilai','n.Nilai','n.IDJenis as JenisNilai')
        ->get();

        $Tutor = DB::table('kursus_siswa as ks')
        ->join('jadwal as j','ks.IDKursusSiswa','=','j.IDKursusSiswa')
        ->join('Karyawan as k','j.IDTutor','=','k.IDKaryawan')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->where('ks.UUID',$id)
        ->select('k.NamaKaryawan')
        ->get();
        //dd($Rapor);
        if(count($Rapor)>0){

            $DataRapor = [];
            $NilaiRapor=0;
            $NilaiRaporHuruf=0;
            $NilaiRaporTotalLook=0;
            $NilaiRaporHurufTotalLook=0;
            foreach($Rapor as $item){
               // dd($item);
               if($item->JenisNilai == 11){
                $NilaiRaporTotalLook += intval($item->Nilai);
               }else{
                $NilaiRapor += intval($item->Nilai);
               }
            }
            foreach($Rapor as $rapor){
             //   dd($rapor->NamaSiswa);
                if($NilaiRapor >= 95 && $NilaiRapor <= 100){
                    $NilaiRaporHuruf = "A";
                }else if($NilaiRapor >= 90 && $NilaiRapor <= 94){
                    $NilaiRaporHuruf = "B+";
                }else if($NilaiRapor >= 80 && $NilaiRapor <= 89){
                    $NilaiRaporHuruf = "B";
                }else if($NilaiRapor >= 75 && $NilaiRapor <= 79){
                    $NilaiRaporHuruf = "C+";
                }else{
                    $NilaiRaporHuruf ="C";
                }
                // nilai rata huruf total look
                if($NilaiRaporTotalLook >= 95 && $NilaiRaporTotalLook <= 100){
                    $NilaiRaporHurufTotalLook = "A";
                }else if($NilaiRaporTotalLook >= 90 && $NilaiRaporTotalLook <= 94){
                    $NilaiRaporHurufTotalLook = "B+";
                }else if($NilaiRaporTotalLook >= 80 && $NilaiRaporTotalLook <= 89){
                    $NilaiRaporHurufTotalLook = "B";
                }else if($NilaiRaporTotalLook >= 75 && $NilaiRaporTotalLook <= 79){
                    $NilaiRaporHurufTotalLook = "C+";
                }else{
                    $NilaiRaporHurufTotalLook ="C";
                }
                array_push($DataRapor,array(
                    'NamaSiswa'=>$rapor->NamaSiswa,
                    'NamaTutor'=>$Tutor[0]->NamaKaryawan,
                    'NamaProdi'=>$rapor->NamaProdi,
                    'NamaNilai'=>$rapor->NamaNilai,
                    'Nilai'=>$rapor->Nilai,
                    'NilaiRapor'=>$NilaiRapor,
                    'NilaiRaporHuruf'=>$NilaiRaporHuruf,
                    'NilaiRaporTotalLook'=>$NilaiRaporTotalLook,
                    'NilaiRaporHurufTotalLook'=>$NilaiRaporHurufTotalLook,
                    'JenisNilai'=>$rapor->JenisNilai
                ));
            }
           // dd($DataRapor);
            return view('siswa/nilai/nilai_rapor',['Rapor'=>$DataRapor]);
        }else{
            return redirect()->back()->withErrors(['msg'=>'Belum ada nilai'])->withInput();
        }
    }
}
