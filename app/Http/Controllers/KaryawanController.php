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
