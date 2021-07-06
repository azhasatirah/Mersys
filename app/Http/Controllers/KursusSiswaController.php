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
            ->select('kursus_siswa.*','kursus_siswa.UUID as UUIDKelas','program_studi.NamaProdi','program_studi.IDKategoriGlobalProgram')
            ->where('kursus_siswa.UUID',$id)->get();
            $Modul = [];
            $Video = [];
            $BahanTutor = [];
            if($Prodi[0]->IDKategoriGlobalProgram == 2){
                $BulananKey = explode('(Bulanan',$Prodi[0]->NamaProdi)[0];
                $MainProdi = DB::table('program_studi')->where('NamaProdi','like',$BulananKey.'(Bulanan-1)')
                // ->where('IDProgram',$Prodi[0]->IDProgram)
                ->where('Status','OPN')->get();
                 //kunai
                $Modul = DB::table('program_studi_modul')
                ->where('IDProgram',$MainProdi[0]->IDProgram)->where('program_studi_modul.Status','OPN')->get();
                $Video = DB::table('program_studi_video')
                ->where('IDProgram',$MainProdi[0]->IDProgram)->where('program_studi_video.Status','OPN')->get();
                $BahanTutor = DB::table('program_studi_bahan_tutor')
                ->where('IDProgram',$MainProdi[0]->IDProgram)->where('program_studi_bahan_tutor.Status','OPN')->get();
                //dd($MainProdi,$Video);
            }else{

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
            }
            return view('siswa.show_program',[
                'Prodi'=>$Prodi,
                'Modul'=>$Modul,
                'Video'=>$Video,
                'BahanTutor'=>$BahanTutor,
            ]);
        }

        public function adminIndexKursus(){

            return view('karyawan.kursus_admin_index');
        }
        public function adminAbsenKursus(Request $request){
            $Data = [];
            $NamaTabel = $request->person == 1?'absen_siswa':'absen_tutor';
            $DataJadwal = DB::table('jadwal')->where('IDJadwal',$request->IDJadwal)->get();
            $Start = explode(' ',$DataJadwal[0]->Tanggal)[1];
            $End =  date('H:i:s',strtotime('+2 hours',strtotime($DataJadwal[0]->Tanggal)));
           // dd($Start, $End);
            if($request->person == 2){
                $Data = [
                    'IDTutor'=>$request->IDPerson,
                    'IDJadwal'=>$request->IDJadwal,
                    'Start'=>$Start,
                    'End'=>$End,
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ];
            }
            if($request->person == 1){
                $Data = [
                    'IDSiswa'=>$request->IDPerson,
                    'IDJadwal'=>$request->IDJadwal,
                    'Start'=>$Start,
                    'End'=>$End,
                    'IsVirtual'=>0,
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ];
            }
            DB::table($NamaTabel)->insert($Data);
            return response()->json('Absen berhasil ditambahkan');
        }
        public function adminGetDataKursus(){
            $Kursus = DB::table('kursus_siswa as ks')
            ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
            ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
            ->select('ks.IDKursusSiswa','ks.UUID as UIDKursus','ks.KodeKursus','ks.created_at as TanggalOrder'
            ,'s.NamaSiswa','s.KodeSiswa','ps.NamaProdi','ks.Status')
            ->where('ks.IDProgram','!=',1)
            ->where('ks.Status','!=','DEL')
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
            return response()->json($Data);
        }
        public function adminShowKursus($id){
            return view('karyawan.kursus_admin_show');
        }
        public function adminDeleteKursus($uid){
            DB::table('kursus_siswa')->where('UUID',$uid)->update([
                'Status'=>'DEL',
                'UserUpd'=>session()->get('Username'),
                'updated_at'=>Carbon::now()
            ]);
            return response()->json('Berhasil dihapus');
        }
        public function adminShowKursusGetData($id){
            $Data = [];
            $NilaiEvaluasi = [];

            $Jadwal = DB::table('jadwal as j')
            ->join('kursus_siswa as ks','j.IDKursusSiswa','=','ks.IDKursusSiswa')
            ->join('kursus_materi as mp','j.IDMateri','=','mp.IDKursusMateri')
            ->where('ks.UUID',$id)
            ->select('j.*','ks.IDSiswa','ks.UUID as UUIDProgram','mp.NoRecord','ks.IDSiswa','j.IDTutor','j.IDJadwal',
            'mp.NamaMateri','mp.Status as StatusMateri')
            ->orderBy('mp.NoRecord')->get();
            $DataKelas = DB::table('jadwal as j')
            ->join('kursus_siswa as ks','j.IDKursusSiswa','=','ks.IDKursusSiswa')
            ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
            ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
            ->join('karyawan as k','j.IDTutor','=','k.IDKaryawan')
            ->where('ks.UUID',$id)
            ->select('k.KodeKaryawan','ks.KodeKursus','k.NamaKaryawan','s.NamaSiswa','s.KodeSiswa','ps.NamaProdi')->get();
            foreach($Jadwal as $item){
                $AbsenSiswa = false ;
                $AbsenTutor = false ;
                $a_siswa = DB::table('absen_siswa')->where('IDJadwal',$item->IDJadwal)->get();
                $a_tutor = DB::table('absen_tutor')->where('IDJadwal',$item->IDJadwal)->get();
                $KehadiranSiswa ='';
                $KehadiranTutor = '';
               // dd(date('ymd',strtotime($item->Tanggal)));
                if(date('ymd',strtotime($item->Tanggal))==date('ymd',strtotime(Carbon::now()))){
                    $KehadiranSiswa='Hari ini';
                    $KehadiranTutor='Hari ini';
                }
                if(strtotime($item->Tanggal)<strtotime(Carbon::now())){
                    $KehadiranSiswa=count($a_siswa)>0?$a_siswa[0]->Start.' sampai '.$a_siswa[0]->End:'Alpha';
                    $KehadiranTutor=count($a_tutor)>0?$a_tutor[0]->Start.' sampai '.$a_tutor[0]->End:'Alpha';
                    $AbsenSiswa =count($a_siswa)>0?false: true;
                    $AbsenTutor =count($a_tutor)>0?false: true;
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
                    'AbsenTutor'=>$AbsenTutor,
                    'AbsenSiswa'=>$AbsenSiswa,
                    'IDSiswa'=>$item->IDSiswa,
                    'IDTutor'=>$item->IDTutor,
                    'IDJadwal'=>$item->IDJadwal
                ));
            }
            $TmpChanges = DB::table('jadwal_change as jc')
            ->join('kursus_siswa as ks','jc.IDKursusSiswa','=','ks.IDKursusSiswa')
            ->select('jc.Status','jc.IDJadwalChange')
            ->where('ks.UUID',$id)
            ->get();
            $Changes = [];
            foreach($TmpChanges as $item){
                $ChangesDetail = DB::table('jadwal_change_detail')->where('IDJadwalChange',$item->IDJadwalChange)->get();
                if(count($ChangesDetail)>0){

                    array_push($Changes,array(
                        'Status'=>$item->Status,
                        'IDJadwalChange'=>$item->IDJadwalChange,
                        'JadwalChanges'=>$ChangesDetail
                    ));
                }
            }
            //dd($Jadwal,$Data);
            $ActiveJadwal = array_filter($Jadwal->toArray(),function($var){
                return $var->StatusMateri != 'CLS';
            });
            $KursusMateri = DB::table('kursus_materi as km')
            ->join('kursus_siswa as ks','km.IDKursus','=','ks.IDKursusSiswa')
            ->select('km.*')
            ->where('ks.UUID',$id)->get();
            foreach($KursusMateri as $km){
                $TMPEvaluasi = DB::table('nilai_evaluasi as ne')
                ->where('ne.IDKursusMateri',$km->IDKursusMateri)
                ->get();
                array_push($NilaiEvaluasi,array(
                    'Pertemuan'=>$km->NoRecord,
                    'Materi'=>$km->NamaMateri,
                    'Plus'=>count($TMPEvaluasi)>0?$TMPEvaluasi[0]->Plus:'Belum ada nilai',
                    'Minus'=>count($TMPEvaluasi)>0?$TMPEvaluasi[0]->Minus:'Belum ada nilai',
                    'Saran'=>count($TMPEvaluasi)>0?$TMPEvaluasi[0]->Saran:'Belum ada nilai'
                ));
            }
            $Nilai = DB::table('nilai as n')
            ->join('kursus_siswa as ks','n.IDKursus','=','ks.IDKursusSiswa')
            ->join('jenis_nilai as js','n.IDJenis','=','js.IDJenisNilai')
            ->select('n.*','js.Jenis')
            ->where('ks.UUID',$id)->get();

            //kelas datakelas activejadwal
            return response()->json([
                'DataKelas'=>$DataKelas,
                'Absen'=>$Data,
                'Changes'=>$Changes,
                'ActiveJadwal'=>$ActiveJadwal,
                'Evaluasi'=>$NilaiEvaluasi,
                'Nilai'=>$Nilai
            ]);
        }
        public function ownerIndexKursus(){
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
            return view('karyawan.kursus_owner_index',['Kursus'=>$Data]);
        }
        public function ownerShowKursus($id){
            $Data = [];
            $Jadwal = DB::table('jadwal as j')
            ->join('kursus_siswa as ks','j.IDKursusSiswa','=','ks.IDKursusSiswa')
            ->join('kursus_materi as mp','j.IDMateri','=','mp.IDKursusMateri')
            ->where('ks.UUID',$id)->select('j.*','mp.NoRecord','mp.NamaMateri')->orderBy('mp.NoRecord')->get();
            $DataKelas = DB::table('jadwal as j')
            ->join('kursus_siswa as ks','j.IDKursusSiswa','=','ks.IDKursusSiswa')
            ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
            ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
            ->join('karyawan as k','j.IDTutor','=','k.IDKaryawan')
            ->where('ks.UUID',$id)
            ->select('k.KodeKaryawan','ks.KodeKursus','k.NamaKaryawan','s.NamaSiswa','s.KodeSiswa','ps.NamaProdi')->get();
            foreach($Jadwal as $item){
                $a_siswa = DB::table('absen_siswa')->where('IDJadwal',$item->IDJadwal)->get();
                $a_tutor = DB::table('absen_tutor')->where('IDJadwal',$item->IDJadwal)->get();
                $KehadiranSiswa ='';
                $KehadiranTutor = '';
               // dd(date('ymd',strtotime($item->Tanggal)));
                if(date('ymd',strtotime($item->Tanggal))==date('ymd',strtotime(Carbon::now()))){
                    $KehadiranSiswa='Hari ini';
                    $KehadiranTutor='Hari ini';
                }
                if(strtotime($item->Tanggal)<strtotime(Carbon::now())){
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
            //dd($DataKelas);
            return view('karyawan.kursus_owner_show',['Absen'=>$Data,'Kelas'=>$DataKelas[0]]);

        }
        public function storeAbsen($id){
            
        }
}
