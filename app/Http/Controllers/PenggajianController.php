<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
class PenggajianController extends Controller
{
    public function index(){
        $Data = DB::table('karyawan as k')
        ->join('role_karyawan_list as rkl','k.IDKaryawan','=','rkl.IDKaryawan')
        ->join('role_karyawan as rk','rkl.IDRoleKaryawan','=','rk.IDRoleKaryawan')
        ->select('k.NamaKaryawan','k.KodeKaryawan','k.UUID as UIDKaryawan','rk.RoleKaryawan')
        ->where('k.Status','CLS')
        ->where('rk.IDRoleKaryawan','!=',1)
        ->get();
        return view('karyawan/penggajian/index',['Karyawan'=>$Data]);
    }
    public function show($uid){
        return view('karyawan/penggajian/show');

    }
    public function getData($id){
        $TMP_Penggajian = DB::table('penggajian as p')
        ->join('karyawan as k','p.IDKaryawan','=','k.IDKaryawan')
        ->select('p.*')
        ->where(DB::raw('YEAR(p.Tanggal)'),date('Y'))
        ->where('k.UUID',$id)->get();
        $Penggajian =[];
        $JadwalTutor = DB::table('jadwal as j')
        ->join('karyawan as k','j.IDTutor','=','k.IDKaryawan')
        ->join('kursus_materi as km','j.IDMateri','=','km.IDKursusMateri')
        ->join('program_studi as ps','km.IDProgram','=','ps.IDProgram')
        ->join('kursus_siswa as ks','ks.IDKursusSiswa','=','j.IDKursusSiswa')
        ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
        ->where(DB::raw('YEAR(j.Tanggal)'),date('Y'))
        ->where('k.UUID',$id)
        ->select('j.IDJadwal','km.NamaMateri','km.NoRecord','ps.NamaProdi','s.NamaSiswa','j.IDKursusSiswa',
        'ps.IDLevel','ps.IDKategoriProgram','j.Jenis','j.Tanggal')->get();
        $KelasTutor = [];
        foreach($JadwalTutor as $jt){
            $absen_tutor = DB::table('absen_tutor')->where('IDJadwal',$jt->IDJadwal)->get();
            array_push($KelasTutor,array(
                'IDJadwal'=>$jt->IDJadwal,
                'IDKursusSiswa'=>$jt->IDKursusSiswa,
                'NamaMateri'=>$jt->NamaMateri,
                'NoRecord'=>$jt->NoRecord,
                'NamaProdi'=>$jt->NamaProdi,
                'Kelas'=>count($absen_tutor)>0,
                'Tanggal'=>$jt->Tanggal,
                'IDLevel'=>$jt->IDLevel,
                'IDKategoriProgram'=>$jt->IDKategoriProgram,
                'JenisProgram'=>$jt->Jenis,
                'NamaSiswa'=>$jt->NamaSiswa
            ));
        }

        $MasterPenggajian = DB::table('master_penggajian')->where('Status','!=','DEL')->get();
        $MasterPenggajianTransport = DB::table('master_penggajian_transport')->where('Status','!=','DEL')->get();

        $Karyawan = DB::table('karyawan as k')
        ->join('role_karyawan_list as rkl','k.IDKaryawan','=','rkl.IDKaryawan')
        ->join('role_karyawan as rk','rkl.IDRoleKaryawan','=','rk.IDRoleKaryawan')
        ->select('k.*','k.IDKaryawan','rk.RoleKaryawan')
        ->where('k.UUID',$id)
        ->get();
        foreach($TMP_Penggajian as $pg){
            $DPenggajian = DB::table('penggajian_detail')->where('IDPenggajian',$pg->IDPenggajian)->where('Status','OPN')->get();
            array_push($Penggajian,array(
                'IDPenggajian'=>$pg->IDPenggajian,
                'Tanggal'=>$pg->Tanggal,
                'Jenis'=>$pg->Jenis,
                'IDKaryawan'=>$pg->IDKaryawan,
                'NamaKaryawan'=>$pg->NamaKaryawan,
                'SubTotal'=>$pg->SubTotal,
                'PPN'=>$pg->PPN,
                'NilaiPPN'=>$pg->NilaiPPN,
                'Total'=>$pg->Total,
                'Detail'=>$DPenggajian
            ));
        }

        return response()->json([
            $KelasTutor,
            $Penggajian,
            $MasterPenggajian,
            $MasterPenggajianTransport,
            $Karyawan
        ]);
    }
    public function getDetailData($id){
        $Data = DB::table('penggajian as p')
        ->join('karyawan as k','p.IDKaryawan','=','k.IDKaryawan')
        ->where('p.Status','!=','DEL')
        ->where('k.UUID',$id)
        ->select('k.*')
        ->get();
        return response()->json($Data);
    }

    public function store(Request $request){
        $TimeData = Carbon::now();
        $DataPenggajian = array(
            'Jenis'=>'tutor',
            'IDKaryawan'=>$request->IDKaryawan,
            'NamaKaryawan'=>$request->NamaKaryawan,
            'SubTotal'=>$request->SubTotal,
            'PPN'=>0,
            'NilaiPPN'=>0,
            'Total'=>$request->Total,
            'Tanggal'=>$TimeData,
            'created_at'=>$TimeData,
            'updated_at'=>$TimeData,
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        
      //  dd($DataPenggajian);
        DB::table('penggajian')->insert($DataPenggajian);
        $Penggajian = DB::table('penggajian')->where('IDKaryawan',$request->IDKaryawan)
        ->where('SubTotal',$request->SubTotal)
        ->where('Total',$request->Total)
        ->where('created_at',$TimeData)
        ->get();
        $KodeKasBank = "KBK-" . date("myHis");
        $KasBank = array(
            'KodeKasBank'=>$KodeKasBank,
            'IDPembayaran'=>$Penggajian[0]->IDPenggajian,
            'Total'=>intval($request->Total)*-1,
            'Keterangan'=>'Penggajian karyawan ',
            'Status'=>'OPN',
            'UserUpd'=>session()->get('Username'),
            'UserAdd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'Tanggal'=>Carbon::now(),

        );
        DB::table('kas_bank')->insert($KasBank);
        $DataPenggajianDetail = [];
        $ite = 0;
        foreach($request->dt_title as $random){
            $InfoData = $request->dt_jenispendapatan[$ite].'[,]'.$request->dt_title[$ite].'[,]'.$request->dt_subtitle[$ite].'[,]'.$request->dt_data1[$ite].'[,]'.$request->dt_data2[$ite].'[,]'.$request->dt_data3[$ite];
            array_push($DataPenggajianDetail,array(
                'IDPenggajian'=>$Penggajian[0]->IDPenggajian,
                'InfoData'=>$InfoData,
                'Nominal'=>$request->dt_nominal[$ite],
                'created_at'=>$TimeData,
                'updated_at'=>$TimeData,
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
                'Status'=>'OPN'
            ));
            $ite++;
        }
        DB::table('penggajian_detail')->insert($DataPenggajianDetail);
        return response()->json('Penggajian di tambahkan');
    }
}
