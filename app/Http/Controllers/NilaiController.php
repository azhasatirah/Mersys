<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\support\Carbon;

class NilaiController extends Controller
{
    public function getIndexData($id){
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
        $DataEvalFinal = DB::table('nilai_evaluasi_final')
        ->where('IDKursus',$DataKursus[0]->IDKursusSiswa)->get();
        $JenisNilai = DB::table('jenis_nilai')->where('Status','OPN')->get();
        return [$DataNilai,$DataEvalFinal,$DataKursus,$JenisNilai];
    }
    public function index($id){
        $Data =$this->getIndexData($id);
        //dd($DataNilai);
        return view('karyawan/nilai_tutor_detail',['EvaluasiFinal'=>$Data[1],'Nilai'=>$Data[0],'Kursus'=>$Data[2],'JenisNilai'=>$Data[3]]);
    }
    public function storeEvaluasiFinal(Request $request){
        $DataStore = array(
            'IDKursus'=>$request->idkursus,
            'EvaluasiFinal'=>$request->evaluasifinal,
            'Tanggal'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        );
        DB::table('nilai_evaluasi_final')->insert($DataStore);
        $Data =$this->getIndexData($request->uidkursus);
        //dd($DataNilai);
        return redirect()->back()->with('msg', 'Berhasil ditambahkan');
    }
    public function updateEvaluasiFinal(Request $request){
        $DataStore = array(
            'EvaluasiFinal'=>$request->evaluasifinal,
            'Tanggal'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        );
        DB::table('nilai_evaluasi_final')->where('IDEvaluasiFinal',$request->idevaluasifinal)->update($DataStore);
        $Data = $this->getIndexData($request->uidkursus);
        //dd($DataNilai);
        return redirect()->back()->with('msg', 'Berhasil diganti');
        //return view('karyawan/nilai_tutor_detail',['EvaluasiFinal'=>$Data[1],'Nilai'=>$Data[0],'Kursus'=>$Data[2],'JenisNilai'=>$Data[3]])
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
    public function grade($Nilai){
        if($Nilai>=95 && $Nilai<=100){
            $Grade = 'A';
            $Desc = 'Excelent';
        }else if($Nilai>=90 && $Nilai<=94){
            $Grade = 'B+';
            $Desc = 'Exceeds Standard';
        }else if($Nilai>=80 && $Nilai<=89){
            $Grade = 'B';
            $Desc = 'Good';
        }else{
            $Grade = 'C';
            $Desc = 'Standard';
        }
        return $Grade;
    }
    public function sumNilai($Nilai){
        $TotalNilai = 0;
        foreach($Nilai as $nilai){
            $TotalNilai += $nilai->Nilai;
        }
        return intVal(explode('.',round($TotalNilai/count($Nilai)))[0]);
    }
    public function showRapor($id){
        $Rapor = DB::table('kursus_siswa as ks')
        ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
        ->join('nilai as n','ks.IDKursusSiswa','=','n.IDKursus')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->where('ks.UUID',$id)
        ->select('s.NamaSiswa','ks.IDKursusSiswa','ps.IDKategoriGlobalProgram','ps.NamaProdi','n.NamaNilai','n.Nilai','n.IDJenis as JenisNilai')
        ->get();
        $FinalEvaluasi = DB::table('nilai_evaluasi_final')
        ->where('IDKursus',$Rapor[0]->IDKursusSiswa)
        ->get();
        
        $Tutor = DB::table('kursus_siswa as ks')
        ->join('jadwal as j','ks.IDKursusSiswa','=','j.IDKursusSiswa')
        ->join('karyawan as k','j.IDTutor','=','k.IDKaryawan')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->where('ks.UUID',$id)
        ->select('k.NamaKaryawan')
        ->get();
        //dd($Rapor);
        if(count($Rapor)>0){
            $RaporNormal = [];
            $RaporLook = [];
            $rapor_normal = array_filter($Rapor->toArray(), function($var){
                return $var->JenisNilai != 11;
            });
            $rapor_totallook =array_filter($Rapor->toArray(), function($var){
                return $var->JenisNilai == 11;
            });
            foreach($rapor_normal as $rapor){
                array_push($RaporNormal,array(
                    'NamaSiswa'=>$rapor->NamaSiswa,
                    'NamaTutor'=>$Tutor[0]->NamaKaryawan,
                    'NamaProdi'=>$rapor->IDKategoriGlobalProgram == 2?explode('(Bulanan',$rapor->NamaProdi)[0]:$rapor->NamaProdi,
                    'NamaNilai'=>$rapor->NamaNilai,
                    'Nilai'=>$rapor->Nilai,
                    'NilaiRapor'=>$this->sumNilai($rapor_normal),
                    'NilaiRaporHuruf'=>$this->grade($this->sumNilai($rapor_normal)),
                ));
            }
            foreach($rapor_totallook as $rapor){
                //   dd($rapor->NamaSiswa);

                array_push($RaporLook,array(
                    'NamaSiswa'=>$rapor->NamaSiswa,
                    'NamaTutor'=>$Tutor[0]->NamaKaryawan,
                    'NamaProdi'=>$rapor->IDKategoriGlobalProgram == 2?explode('(Bulanan',$rapor->NamaProdi)[0]:$rapor->NamaProdi,
                    'NamaNilai'=>$rapor->NamaNilai,
                    'Nilai'=>$rapor->Nilai,
                    'NilaiRapor'=>$this->sumNilai($rapor_totallook),
                    'NilaiRaporHuruf'=>$this->grade($this->sumNilai($rapor_totallook)),
                ));
               }
           //dd($DataRapor);
            return view('siswa/nilai/nilai_rapor',['FinalEvaluasi'=>$FinalEvaluasi,'Normal'=>$RaporNormal,'Look'=>$RaporLook]);
        }else{
            return redirect()->back()->with('msg','Belum ada nilai');
        }
    }
}
