<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\support\str;
use Illuminate\support\Carbon;
class KaryawanController extends Controller
{
    public function dasbor(){
        $Dasbor = [];
        $Siswa = DB::table('siswa')->where('Status','!=','DEL')->get();
        $Karyawan = DB::table('karyawan')->where('Status','!=','DEL')->get();
        $Transaksi = DB::table('transaksi')->where('Status','!=','DEL')->get();
        $KasBank = DB::table('kas_bank')->get();
        $Dasbor = array(
            'JumlahSiswa'=>count($Siswa),
            'JumlahKaryawan'=>count($Karyawan),
            'Transaksi'=>count($Transaksi),
            'Omset'=>$KasBank->sum('Total')
        );
        return view('karyawan/index',['Dasbor'=>$Dasbor]);

    }
    public function dasborTutor(){
        return view('karyawan/tutor');
    }
    public function dasborTutorGetData(){
        $jadwal_private = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->select('kursus_materi.Hari','jadwal.Tanggal','kursus_materi.IDKursusMateri',
        'program_studi.NamaProdi','kursus_siswa.UUID as KodeKelas','kursus_materi.NoRecord',
        'kursus_materi.NamaMateri','kursus_siswa.KodeKursus','kursus_materi.Status',
        'kursus_materi.Homework','kursus_siswa.Tempat',
        'siswa.NamaSiswa','jadwal.IDJadwal','jadwal.IDTutor')
       // ->where('jadwal.Status','CFM')
        ->where('jadwal.Jenis','!=','semi')
        ->where('jadwal.IDTutor',session()->get('IDUser'))
        ->whereDate('jadwal.Tanggal','=',date('Y-m-d'))
        ->get();
        $jadwal_semi = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->select('kursus_materi.Hari','jadwal.Tanggal','kursus_materi.IDKursusMateri',
        'program_studi.NamaProdi','kursus_siswa.UUID as KodeKelas','kursus_materi.NoRecord',
        'kursus_materi.NamaMateri','kursus_siswa.KodeKursus','kursus_materi.Status',
        'kursus_materi.Homework','kursus_siswa.Tempat',
        'siswa.NamaSiswa','jadwal.IDJadwal','jadwal.IDTutor')
       // ->where('jadwal.Status','CFM')
        ->where('jadwal.Jenis','semi')
        ->where('jadwal.IDTutor',session()->get('IDUser'))
        ->whereDate('jadwal.Tanggal','=',date('Y-m-d'))
        ->get()->groupBy('Tanggal');
        return response()->json([
            $jadwal_private,
            $jadwal_semi
        ]);
    }
    public function getDataTutor(){
        $Tutor = DB::table('karyawan')
        ->join('role_karyawan_list','karyawan.IDKaryawan','=','role_karyawan_list.IDKaryawan')
        ->select('karyawan.*')
        ->where('IDRoleKaryawan',3)
        ->get();
        return response()->json($Tutor);
    }

    public function indexKaryawan(){
        $Karyawan = DB::table('karyawan')->join('role_karyawan_list','karyawan.IDKaryawan','=','role_karyawan_list.IDKaryawan')
        ->where('role_karyawan_list.IDRoleKaryawan','!=',1)
        ->select('karyawan.*')
        ->get();
        //dd($Karyawan);
        
        return view('karyawan.show_karyawan_owner',['Karyawan'=>$Karyawan]);
    }
    public function deleteKaryawan(Request $request){
        DB::table('karyawan')->where('IDKaryawan',$request->idkaryawan)->update([
            'Status'=>'DEL'
        ]);
        $msg ='Berhasil menonaktifkan karyawan';

        return redirect()->back()->with('msg',$msg);
    }
    public function unDeleteKaryawan(Request $request){
        DB::table('karyawan')->where('IDKaryawan',$request->idkaryawan)->update([
            'Status'=>'CLS'
        ]);
        $msg ='Berhasil mengaktifkan karyawan';
        
        return redirect()->back()->with('msg',$msg);
    }
    public function getJadwalGroupByTutor($start_date){
        /*
        * backend
            ns  : recent sch teacher
            nschque : recent sch student in que
            tmp_tea : teacher(db)
            tmp_class : class(db)
            * false tea mean the tea can take the schedule
            tea{
                tmp_tea.class.sch >= sos? tmp_tea.class.sch :false,
            }
            class{
                tmp_class.sch[stat=OPN] >= sos
            }
            return frontend(tea,class)
        * frontend
            tea = get(tea)
            schque = get(class)
            fschque = schque.filter()
            ftea = tea.length - tea.filter(tea.filter(ns=false)).length
            ! free schque : (ftea - fschque) > 0 
        */
        $TmpTea = DB::table('karyawan')
        ->join('role_karyawan_list','karyawan.IDKaryawan','=','role_karyawan_list.IDKaryawan')
        ->where('role_karyawan_list.IDRoleKaryawan',3)
        ->where('karyawan.Status','CLS')
        ->select('karyawan.*')
        ->get();


        $TmpClass = DB::table('kursus_siswa')
        ->join('jadwal','kursus_siswa.IDKursusSiswa','=','jadwal.IDKursusSiswa')
        ->whereDate('Tanggal','>=',$start_date)
        ->where('jadwal.Status','OPN')
        ->select('jadwal.*')->get()->groupBy('IDKursusSiswa');

      //  dd($Data);
        $Tea = [];
        $Class =[];
        foreach($TmpTea as $data){
            $Sch =[];
            $TmpSch = DB::table('jadwal')
            ->where('IDTutor',$data->IDKaryawan)
            ->whereDate('Tanggal','>=',$start_date)
            ->get()->groupBy('IDKursusSiswa');
            foreach($TmpSch as $param){
                array_push($Sch,$param);
            }
            array_push($Tea, count($Sch)>0?$Sch:false);
        }
        foreach($TmpClass as $data){
            array_push($Class,$data);
        }
        //dd($RealData);
        return response()->json([$Tea,$Class]);
    }

}
