<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use Illuminate\support\Carbon;
class SertifikatController extends Controller
{
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
        return [$Grade,$Desc];
    }
    public function sumNilai($Nilai){
        $TotalNilai = 0;
        foreach($Nilai as $nilai){
            $TotalNilai += $nilai->Nilai;
        }
        return intVal(explode('.',round($TotalNilai/count($Nilai)))[0]);
    }
    public function depan($id){

        $Nilai = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select(
            'nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','program_studi.IDKategoriGlobalProgram','kursus_siswa.UUID',
            'siswa.NamaSiswa'
        )
        ->get();
        if(count($Nilai)>0){
            //dd($Nilai);
            $DataNilai = array(
                'NamaSiswa'=>$Nilai[0]->NamaSiswa,
                'NamaProdi'=>$Nilai[0]->IDKategoriGlobalProgram == 2 ? explode('(B',$Nilai[0]->NamaProdi)[0]:$Nilai[0]->NamaProdi,
                'UUIDKursus'=>$Nilai[0]->UUID,
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>$this->sumNilai($Nilai),
                'Grade'=>$this->grade($this->sumNilai($Nilai))[0],
                'Desc'=>$this->grade($this->sumNilai($Nilai))[1]
            );
            //dd($DataNilai);
            return view('karyawan/sertifikat/depan',['Nilai'=>$DataNilai]);
        }else{
            return redirect()->back()->withErrors(['msg'=>'Belum ada nilai'])->withInput();
        }
    }
    public function printDepan($id){
        $Nilai = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select(
            'nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','program_studi.IDKategoriGlobalProgram','kursus_siswa.UUID',
            'siswa.NamaSiswa'
        )
        ->get();

        //dd($Nilai);
        $DataNilai = array(
            'NamaSiswa'=>$Nilai[0]->NamaSiswa,
            'NamaProdi'=>$Nilai[0]->IDKategoriGlobalProgram == 2 ? explode('(B',$Nilai[0]->NamaProdi)[0]:$Nilai[0]->NamaProdi,
            'UUIDKursus'=>$Nilai[0]->UUID,
            'Jenis'=>$Nilai[0]->Jenis,
            'Nilai'=>$this->sumNilai($Nilai),
            'Grade'=>$this->grade($this->sumNilai($Nilai))[0],
            'Desc'=>$this->grade($this->sumNilai($Nilai))[1]
        );
        //dd($DataNilai);
        $Depan = PDF::loadview('karyawan/sertifikat/print_depan',['Nilai'=>$DataNilai])->setPaper('a4', 'landscape')->setWarnings(false);
        return $Depan->download('sertifikat depan '.$Nilai[0]->NamaSiswa.'.pdf');
    }
    public function belakang($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','program_studi.IDKategoriGlobalProgram','kursus_siswa.UUID')
        ->get()->groupBy('Jenis');
        if(count($DataNilaiTMP)>0){
            $DataNilai = [];
            foreach($DataNilaiTMP as $Nilai){
                if(floor($Nilai->sum('Nilai')/count($Nilai))>=95 && floor($Nilai->sum('Nilai')/count($Nilai))<=100){
                    $Grade = 'A';
                    $Desc = 'Excelent';
                }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=90 && floor($Nilai->sum('Nilai')/count($Nilai))<=94){
                    $Grade = 'B+';
                    $Desc = 'Exceeds Standard';
                }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=80 && floor($Nilai->sum('Nilai')/count($Nilai))<=89){
                    $Grade = 'B';
                    $Desc = 'Good';
                }else{
                    $Grade = 'C';
                    $Desc = 'Standard';
                }
      
                array_push($DataNilai, array(
                    'NamaProdi'=>$Nilai[0]->IDKategoriGlobalProgram == 2? explode('(B',$Nilai[0]->NamaProdi)[0]:$Nilai[0]->NamaProdi,
                    'UUIDKursus'=>$Nilai[0]->UUID,
                    'Jenis'=>$Nilai[0]->Jenis,
                    'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                    'Grade'=>$Grade,
                    'Desc'=>$Desc
                ));
            };
            return view('karyawan/sertifikat/belakang',['Nilai'=>$DataNilai]);
        }else{
            return redirect()->back()->withErrors(['msg'=>'Belum ada nilai'])->withInput();
        }
    }
    public function print($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','program_studi.IDKategoriGlobalProgram','kursus_siswa.UUID')
        ->get()->groupBy('Jenis');
        
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            if(floor($Nilai->sum('Nilai')/count($Nilai))>=95 && floor($Nilai->sum('Nilai')/count($Nilai))<=100){
                $Grade = 'A';
                $Desc = 'Excelent';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=90 && floor($Nilai->sum('Nilai')/count($Nilai))<=94){
                $Grade = 'B+';
                $Desc = 'Exceeds Standard';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=80 && floor($Nilai->sum('Nilai')/count($Nilai))<=89){
                $Grade = 'B';
                $Desc = 'Good';
            }else{
                $Grade = 'C';
                $Desc = 'Standard';
            }
            array_push($DataNilai, array(
                'NamaProdi'=>$Nilai[0]->IDKategoriGlobalProgram == 2? explode('(B',$Nilai[0]->NamaProdi)[0]:$Nilai[0]->NamaProdi,
                'UUIDKursus'=>$Nilai[0]->UUID,
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Grade'=>$Grade,
                'Desc'=>$Desc
            ));
        };
        $Belakang = PDF::loadview('karyawan/sertifikat/print_belakang',['Nilai'=>$DataNilai])->setPaper('a4', 'landscape')->setWarnings(false);
        return $Belakang->download('sertifikat.pdf');
    }

    public function depanSiswa($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','kursus_siswa.UUID')
        ->get()->groupBy('Jenis');
        
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            if(floor($Nilai->sum('Nilai')/count($Nilai))>=95 && floor($Nilai->sum('Nilai')/count($Nilai))<=100){
                $Grade = 'A';
                $Desc = 'Excelent';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=90 && floor($Nilai->sum('Nilai')/count($Nilai))<=94){
                $Grade = 'B+';
                $Desc = 'Exceeds Standard';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=80 && floor($Nilai->sum('Nilai')/count($Nilai))<=89){
                $Grade = 'B';
                $Desc = 'Good';
            }else{
                $Grade = 'C';
                $Desc = 'Standard';
            }
            array_push($DataNilai, array(
                'NamaProdi'=>$Nilai[0]->NamaProdi,
                'UUIDKursus'=>$Nilai[0]->UUID,
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Grade'=>$Grade,
                'Desc'=>$Desc
            ));
        };
        return view('/sertifikat/depan',['Nilai'=>$DataNilai]);
    }
    public function printDepanSiswa($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','kursus_siswa.UUID')
        ->get()->groupBy('Jenis');
        
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            if(floor($Nilai->sum('Nilai')/count($Nilai))>=95 && floor($Nilai->sum('Nilai')/count($Nilai))<=100){
                $Grade = 'A';
                $Desc = 'Excelent';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=90 && floor($Nilai->sum('Nilai')/count($Nilai))<=94){
                $Grade = 'B+';
                $Desc = 'Exceeds Standard';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=80 && floor($Nilai->sum('Nilai')/count($Nilai))<=89){
                $Grade = 'B';
                $Desc = 'Good';
            }else{
                $Grade = 'C';
                $Desc = 'Standard';
            }
            array_push($DataNilai, array(
                'NamaProdi'=>$Nilai[0]->NamaProdi,
                'UUIDKursus'=>$Nilai[0]->UUID,
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Grade'=>$Grade,
                'Desc'=>$Desc
            ));
        };
        $Belakang = PDF::loadview('/sertifikat/print_belakang',['Nilai'=>$DataNilai])->setPaper('a4', 'landscape')->setWarnings(false);
        return $Belakang->download('sertifikat.pdf');
    }
    public function belakangSiswa($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','kursus_siswa.UUID')
        ->get()->groupBy('Jenis');
        
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            if(floor($Nilai->sum('Nilai')/count($Nilai))>=95 && floor($Nilai->sum('Nilai')/count($Nilai))<=100){
                $Grade = 'A';
                $Desc = 'Excelent';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=90 && floor($Nilai->sum('Nilai')/count($Nilai))<=94){
                $Grade = 'B+';
                $Desc = 'Exceeds Standard';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=80 && floor($Nilai->sum('Nilai')/count($Nilai))<=89){
                $Grade = 'B';
                $Desc = 'Good';
            }else{
                $Grade = 'C';
                $Desc = 'Standard';
            }
            array_push($DataNilai, array(
                'NamaProdi'=>$Nilai[0]->NamaProdi,
                'UUIDKursus'=>$Nilai[0]->UUID,
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Grade'=>$Grade,
                'Desc'=>$Desc
            ));
        };
        return view('/sertifikat/belakang',['Nilai'=>$DataNilai]);
    }
    public function printSiswa($id){
        $DataNilaiTMP = DB::table('nilai')
        ->join('kursus_siswa','nilai.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('jenis_nilai','nilai.IDJenis','=','jenis_nilai.IDJenisNilai')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->where('nilai.Status','OPN')->where('kursus_siswa.UUID',$id)
        ->select('nilai.*','jenis_nilai.Jenis','program_studi.NamaProdi','kursus_siswa.UUID')
        ->get()->groupBy('Jenis');
        
        $DataNilai = [];
        foreach($DataNilaiTMP as $Nilai){
            if(floor($Nilai->sum('Nilai')/count($Nilai))>=95 && floor($Nilai->sum('Nilai')/count($Nilai))<=100){
                $Grade = 'A';
                $Desc = 'Excelent';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=90 && floor($Nilai->sum('Nilai')/count($Nilai))<=94){
                $Grade = 'B+';
                $Desc = 'Exceeds Standard';
            }else if(floor($Nilai->sum('Nilai')/count($Nilai))>=80 && floor($Nilai->sum('Nilai')/count($Nilai))<=89){
                $Grade = 'B';
                $Desc = 'Good';
            }else{
                $Grade = 'C';
                $Desc = 'Standard';
            }
            array_push($DataNilai, array(
                'NamaProdi'=>$Nilai[0]->NamaProdi,
                'UUIDKursus'=>$Nilai[0]->UUID,
                'Jenis'=>$Nilai[0]->Jenis,
                'Nilai'=>floor($Nilai->sum('Nilai')/count($Nilai)),
                'Grade'=>$Grade,
                'Desc'=>$Desc
            ));
        };
        $Belakang = PDF::loadview('/sertifikat/print_belakang',['Nilai'=>$DataNilai])->setPaper('a4', 'landscape')->setWarnings(false);
        return $Belakang->download('sertifikat.pdf');
    }
}
