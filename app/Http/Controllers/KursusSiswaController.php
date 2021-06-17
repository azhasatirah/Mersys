<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use DB;
use App\Models\ProgramStudi;
use App\Models\KategoriProgram;
use App\Models\LevelProgram;
use App\Models\Cicilan;



//absen dan kursus siswa
class KursusSiswaController extends Controller
{

        //halaman siswa program saya
        public function programSiswaAktif(){
            $Program = DB::table('kursus_siswa')
            ->select('program_studi.NamaProdi','program_studi.TotalPertemuan',
            'kursus_siswa.UUID as UUIDKursus','program_studi.IDProgram','kursus_siswa.IDKursusSiswa')
            ->join('program_studi','program_studi.IDProgram','=','kursus_siswa.IDProgram')
            ->where('kursus_siswa.IDSiswa',session()->get('IDUser'))
            ->where('kursus_siswa.IDProgram','!=',1)
            ->where('kursus_siswa.Status','=','CLS')
            ->get();
          //  dd($Program);
            $Data =[];
            for($i =0; count($Program)>$i;$i++){
    
                //pertemuan yg sudah dilewati
                $KursusMateri = DB::table('kursus_materi')->where('IDKursus',$Program[$i]->IDKursusSiswa)
                ->where('Status','CLS')->get();
                //pertemuan yg aktif (materi yang sudah dibuat jadwal)
                $KursusMateriAktif = DB::table('kursus_materi')->where('IDKursus',$Program[$i]->IDKursusSiswa)
                ->where('Status','OPN')->get();
                //Materi
                $Materi = DB::table('materi_program')->where('IDProgram',$Program[$i]->IDProgram)
                ->where('NoRecord',count($KursusMateri)+1)
                ->orderBy('NoRecord','desc')->get();
                //jadwal
                $Jadwal =count($KursusMateriAktif)>0? 
                DB::table('jadwal')->where('IDMateri',$KursusMateriAktif[0]->IDKursusMateri)->get():false;
                if($Jadwal != false ){
                    if(count($Jadwal)>0){
                        if($Jadwal[0]->Status == 'OPN'){
                            $StatusJadwal = 'Mencari Tutor';
                        }else if($Jadwal[0]->Status == 'CFM'){
                            $StatusJadwal = 'Jadwal telah ditentukan';
                        }else if($Jadwal[0]->Status == 'CLS'){
                            $StatusJadwal = 'Selesai';
                        }else if($Jadwal[0]->Status == 'DEL'){
                            $StatusJadwal = 'Jadwal dibatalkan';
                        }
                    }
                }

                array_push($Data, array(
                    'IDKursus'=>$Program[$i]->IDKursusSiswa,
                    'UUIDKursus'=>$Program[$i]->UUIDKursus,
                    'NamaProgram'=>$Program[$i]->NamaProdi,
                    'IDProgram'=>$Program[$i]->IDProgram,
                    'TotalPertemuan'=>$Program[$i]->TotalPertemuan,
                    'SisaPertemuan'=>$Program[$i]->TotalPertemuan - count($KursusMateri),
                    'Pertemuan'=>count($KursusMateri)+1,
                    'NamaMateri'=>count($Materi)>0?$Materi[0]->NamaMateri:'Kelas selesai',
                    'NoRecord'=>count($Materi)>0?$Materi[0]->NoRecord:'Kelas Selesai',
                    'JadwalExist'=>count($KursusMateriAktif)>0?true:false,
                    'StatusJadwal'=>count($KursusMateriAktif)>0?$StatusJadwal:'Jadwal belum dibuat',
                    'JadwalTanggal'=>count($KursusMateriAktif)>0?$Jadwal[0]->Tanggal:0,
                    'JadwalJam'=>count($KursusMateriAktif)>0?explode(' ',$Jadwal[0]->Tanggal)[1]:0,
                ));
            }
            //dd($Data);
            return view('siswa.myprogram',['Kursus'=>$Data]);
        }
        public function showProgramSiswaAktif($id){
            $Prodi= DB::table('kursus_siswa')
            ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->select('kursus_siswa.*','kursus_siswa.UUID as UUIDKelas','program_studi.NamaProdi')
            ->where('kursus_siswa.UUID',$id)->get();
            $Modul = DB::table('program_studi_modul')
            ->join('program_studi','program_studi_modul.IDProgram','=','program_studi.IDProgram')
            ->join('kursus_siswa','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->where('kursus_siswa.UUID',$id)->where('program_studi_modul.Status','OPN')->get();
        
            $Video = DB::table('program_studi_video')
            ->join('program_studi','program_studi_video.IDProgram','=','program_studi.IDProgram')
            ->join('kursus_siswa','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->where('kursus_siswa.UUID',$id)->where('program_studi_video.Status','OPN')->get();
            $BahanTutor = DB::table('program_studi_bahan_tutor')
            ->join('program_studi','program_studi_bahan_tutor.IDProgram','=','program_studi.IDProgram')
            ->join('kursus_siswa','kursus_siswa.IDProgram','=','program_studi.IDProgram')
            ->where('kursus_siswa.UUID',$id)->where('program_studi_bahan_tutor.Status','OPN')->get();
            return view('siswa.show_program',[
                'Prodi'=>$Prodi,
                'Modul'=>$Modul,
                'Video'=>$Video,
                'BahanTutor'=>$BahanTutor,
            ]);
        }

        public function adminIndexKursus(){
            $Kursus = DB::table('kursus_siswa as ks')
            ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
            ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
            ->select('ks.IDKursusSiswa','ks.UUID as UIDKursus','ks.KodeKursus','ks.created_at as TanggalOrder'
            ,'s.NamaSiswa','s.KodeSiswa','ps.NamaProdi','ks.Status')
            ->where('ks.IDProgram','!=',1)
            ->orderBy('ks.created_at','desc')
            ->get();
            $Data = [];
            foreach($Kursus as $ks){
                $Status = '';
                $RStatus = '';
                if($ks->Status == 'OPN'){
                    $Status = false ;
                    $RStatus = 'Transaksi belum selesai';
                }
                if($ks->Status == 'CLS'){
                    $Jadwal = DB::table('jadwal')->where('IDKursusSiswa',$ks->IDKursusSiswa)->get();
                    if(count($Jadwal)==0){
                        $Status = false;
                        $RStatus = 'Belum buat jadwal';
                    }
                    if(count($Jadwal)>0){
                        if($Jadwal[0]->Status == 'OPN'){
                            $Status = false;
                            $RStatus = 'Jadwal belum ada tutor';
                        }else if($Jadwal[0]->Status == 'CFM'){
                            $Status = true;
                            $RStatus = 'Jadwal ada';
                        }else{
                            $Status = true;
                            $RStatus = 'Jadwal ada';
                        }
                    }
                }
                array_push($Data,array(
                    'UIDKursus'=>$ks->UIDKursus,
                    'KodeKursus'=>$ks->KodeKursus,
                    'TanggalOrder'=>$ks->TanggalOrder,
                    'KodeSiswa'=>$ks->KodeSiswa,
                    'NamaSiswa'=>$ks->NamaSiswa,
                    'NamaProdi'=>$ks->NamaProdi,
                    'Status'=>$Status,
                    'ReadStatus'=>$RStatus,
                ));
            }
            return view('karyawan.kursus_admin_index',['Kursus'=>$Data]);
        }
        public function adminShowKursus($id){
            $Data = [];
            $Jadwal = DB::table('jadwal as j')
            ->join('kursus_siswa as ks','j.IDKursusSiswa','=','ks.IDKursusSiswa')
            ->join('kursus_materi as mp','j.IDMateri','=','mp.IDKursusMateri')
            ->where('ks.UUID',$id)->select('j.*','mp.NoRecord','mp.NamaMateri')->orderBy('mp.NoRecord')->get();
            foreach($Jadwal as $item){
                $a_siswa = DB::table('absen_siswa')->where('IDJadwal',$item->IDJadwal)->get();
                $a_tutor = DB::table('absen_tutor')->where('IDJadwal',$item->IDJadwal)->get();
                $KehadiranSiswa ='';
                $KehadiranTutor = '';
               // dd(date('ymd',strtotime($item->Tanggal)));
                if(date('ymd',strtotime($item->Tanggal))==date('ymd',strtotime(Carbon::now()))){
                    $KehadiranSiswa='Hari ini';
                    $KehadiranTutor='Hari ini';
                }else if(strtotime($item->Tanggal)<strtotime(Carbon::now())){
                    $KehadiranSiswa=count($a_siswa)>0?$a_siswa[0]->Start.' sampai '.$a_siswa[0]->End:'Alpha';
                    $KehadiranTutor=count($a_tutor)>0?$a_tutor[0]->Start.' sampai '.$a_tutor[0]->End:'Alpha';
                }else{
                    $KehadiranSiswa='Belum mulai';
                    $KehadiranTutor='Belum mulai';
                }
                array_push($Data,array(
                    'Pertemuan'=>$item->NoRecord,
                    'Tanggal'=>$item->Tanggal,
                    'Materi'=>$item->NamaMateri,
                    'KehadiranSiswa'=>$KehadiranSiswa,
                    'KehadiranTutor'=>$KehadiranTutor,
                ));
            }
            //dd($Data);
            return view('karyawan.kursus_admin_show',['Absen'=>$Data]);

        }
        public function storeAbsen($id){
            
        }
}
