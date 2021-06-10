<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $Tutor = DB::table('karyawan')
        ->join('role_karyawan_list','karyawan.IDKaryawan','=','role_karyawan_list.IDKaryawan')
        ->select('karyawan.*')
        ->where('IDRoleKaryawan',3)
        ->get();

        //dd($Data);
        return view ('karyawan.jadwal',['Tutor'=>$Tutor]);
    }

    public function updateTutor(Request $request){
        //dd($request);
        $DataTutor = DB::table('karyawan')->where('IDKaryawan',$request->tutor)->get();
        $DataNotif = DB::table('kursus_siswa')
        ->select('siswa.UUID as UIDSiswa','kursus_siswa.KodeKursus','kursus_siswa.UUID as UIDKursus')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->where('IDKursusSiswa',$request->kursussiswa)->get();
       // dd($DataTutor,$DataNotif,$request->kursussiswa);
        DB::table('jadwal')->where('IDKursusSiswa',$request->kursussiswa)
        ->update(['IDTutor'=>$request->tutor,'Status'=>'CFM']);
        DB::table('notif')->insert([
            'Notif'=> "Tutor untuk kelas  (".$DataNotif[0]->KodeKursus.") sudah di tentukan",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$DataNotif[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/kursus/show/'.$DataNotif[0]->UIDKursus,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('notif')->insert([
            'Notif'=> "Admin memasukan anda ke kelas (".$DataNotif[0]->KodeKursus.")",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$DataTutor[0]->UUID,
            'IsRead'=>false,
            'Link'=>'/karyawan/tutor/kelas/show/'.$DataNotif[0]->UIDKursus,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent($DataTutor[0]->UUID));
        //broadcast(new \App\Events\NotifEvent($DataNotif[0]->UIDSiswa));
        return redirect('karyawan/admin/jadwal');
    }
    
    public function store(Request $request){
        $Data = array(
            'IDSiswa'=>$request->idsiswa,
            'NamaSiswa'=>$request->namasiswa,
            // 'TanggalLahir'=>$request->tanggallahir,
            // 'TempatLahir'=>$request->tempatlahir,
            // 'JenisKelamin'=>$request->jeniskelamin,
            // 'Alamat'=>$request->alamat,
            // 'NoHP'=>$request->nohp,
            'IDTutor'=>$request->tutor,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'CFM'
        );
        $Status = Jadwal::storeJadwal($Data);
        return redirect('/karyawan/master/jadwal')->with(['Status'=>$Status]);
    }

    public function getData(){
        
        $DataTMP = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->select('kursus_materi.Hari','jadwal.Tanggal','jadwal.IDKursusSiswa',
        'kursus_materi.NamaMateri','kursus_siswa.KodeKursus',
        'siswa.NamaSiswa','jadwal.IDJadwal','jadwal.IDTutor')
        ->where('jadwal.Status','OPN')->get()->groupBy('IDKursusSiswa');
        $Data = [];
        foreach($DataTMP as $d){
            array_push($Data,array(
                'KodeKursus'=>$d[0]->KodeKursus,
                'NamaSiswa'=>$d[0]->NamaSiswa,
                'IDKursusSiswa'=>$d[0]->IDKursusSiswa,
                'IDJadwal'=>$d[0]->IDJadwal,
                'IDTutor'=>$d[0]->IDTutor,
            ));
        }
        $Jadwal = Jadwal::getAllJadwal();
        return response()->json(['Status'=>'success','Jadwal'=>$Data]);
    }
    public function getDataTutor(){
        $Jadwal = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->select('kursus_materi.Hari','jadwal.Tanggal','kursus_materi.IDKursusMateri',
        'program_studi.NamaProdi','kursus_siswa.UUID as KodeKelas','kursus_materi.NoRecord',
        'kursus_materi.NamaMateri','kursus_siswa.KodeKursus','kursus_materi.Status',
        'siswa.NamaSiswa','jadwal.IDJadwal','jadwal.IDTutor')
        ->where('jadwal.Status','CFM')
        ->where('IDTutor',session()->get('IDUser'))->get();
        return response()->json($Jadwal);
    }
    public function getDetailDataTutor($id){
        $Jadwal = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->select('kursus_materi.Hari','jadwal.Tanggal','kursus_materi.IDKursusMateri',
        'program_studi.NamaProdi','kursus_siswa.UUID as KodeKelas','kursus_materi.NoRecord',
        'kursus_materi.NamaMateri','kursus_siswa.KodeKursus','kursus_materi.Status',
        'siswa.NamaSiswa','jadwal.IDJadwal','jadwal.IDTutor')
       // ->where('jadwal.Status','CFM')
        ->where('kursus_siswa.UUID',$id)
        ->where('IDTutor',session()->get('IDUser'))->get();
        return response()->json($Jadwal);
    }
    public function getDataSiswa($id){
//Goldays Goldeys Goldys
        $Data = [];
        $Program = DB::table('kursus_siswa')
        ->select('program_studi.NamaProdi','program_studi.TotalPertemuan',
        'kursus_siswa.UUID as UUIDKursus','program_studi.IDProgram','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','program_studi.IDProgram','=','kursus_siswa.IDProgram')
        ->where('kursus_siswa.UUID',$id)
        ->get();
        $Jadwal = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','jadwal.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
        ->where('kursus_siswa.UUID',$id)
        ->select('jadwal.Tanggal','kursus_materi.NamaMateri','kursus_materi.NoRecord','jadwal.Status','jadwal.IDTutor',
        'jadwal.IDJadwal','kursus_materi.Hari as Hari','kursus_materi.Status as StatusMateri','jadwal.IDMateri',
        'kursus_siswa.IDSiswa','jadwal.IDTutor')
        ->orderBy('jadwal.Tanggal')
        ->get();
        for($i=0;count($Jadwal)>$i;$i++){
            $Tutor = DB::table('karyawan')->where('IDKaryawan',$Jadwal[$i]->IDTutor)->get();
            $Absen = DB::table('absen')->where('IDJadwal',$Jadwal[$i]->IDJadwal)->get();
            
            if($Jadwal[$i]->Status == 'OPN'){
                $StatusJadwal = 'Mencari Tutor';
                $NamaTutor = 'Mencari Tutor';
            }else if($Jadwal[$i]->Status == 'CFM'){
                 if(
                    $Jadwal[$i]->StatusMateri == 'OPN'&&
                    strtotime($Jadwal[$i]->Tanggal)<=
                    strtotime(Carbon::now())&&
                    strtotime(Carbon::now())<=
                    strtotime('+1 days',strtotime($Jadwal[$i]->Tanggal))
                ){
                    $StatusJadwal=  'Menunggu tutor';
                } else if($Jadwal[$i]->StatusMateri == 'OPN'&&
                strtotime(explode(' ',$Jadwal[$i]->Tanggal)[0]) > strtotime(Carbon::now())){
                    $StatusJadwal=  'Belum mulai';
                }else if($Jadwal[$i]->StatusMateri == 'OPN'&&
                date('Y-m-d',strtotime($Jadwal[$i]->Tanggal)) ==
                date('Y-m-d',strtotime(Carbon::now()))){
                    $StatusJadwal=  'hari ini';
                }else if(
                    $Jadwal[$i]->StatusMateri == 'OPN'&&
                    strtotime('+1 days',strtotime($Jadwal[0]->Tanggal)) <
                    strtotime(Carbon::now())
                ){
                    $StatusJadwal=  'Terlewat';
                }else if($Jadwal[$i]->StatusMateri == 'CFM'){

                    $StatusJadwal=  'Berlangsung';
                }else if($Jadwal[$i]->StatusMateri == 'CLS'){

                    $StatusJadwal=  'Selesai';
                }else if($Jadwal[$i]->StatusMateri == 'DEL'){

                    $StatusJadwal=  'Dibatalkan';
                }
        
                $NamaTutor = $Tutor[0]->NamaKaryawan;
            }else if($Jadwal[$i]->Status == 'CLS'){
                $StatusJadwal = 'Selesai';
                $NamaTutor = $Tutor[0]->NamaKaryawan;
            }else if($Jadwal[$i]->Status == 'DEL'){
                $StatusJadwal = 'Tidak menemukan tutor';
                $NamaTutor = 'Tidak menemukan tutor';
            }

            //kolom tutor
            array_push($Data,array(
                'Jam'=>explode(' ',$Jadwal[$i]->Tanggal)[1],
                'Tanggal'=>explode(' ',$Jadwal[$i]->Tanggal)[0],
                'Hari'=>$Jadwal[$i]->Hari,
                'NamaMateri'=>$Jadwal[$i]->NamaMateri,
                'IDSiswa'=>$Jadwal[$i]->IDSiswa,
                'IDTutor'=>$Jadwal[$i]->IDTutor,
                'IDMateri'=>$Jadwal[$i]->IDMateri,
                'NoRecord'=>$Jadwal[$i]->NoRecord,
                'NamaTutor'=>$NamaTutor,
                'Status'=>isset($StatusJadwal)?$StatusJadwal:'undef',
                'Absen'=>count($Absen)>0?$Absen[0]->Absen:'Belum Absen',
                'IDJadwal'=>$Jadwal[$i]->IDJadwal,
                'UUIDProgram'=>$id
            ));
        }
        return response()->json($Data);
    }
    public function startKursus(Request $request){
        DB::table('kursus_materi')->where('IDKursusMateri',$request->idkursusmateri)
        ->update([
            'IDKaryawan'=>$request->karyawan,
            'Status'=>'CFM',
            'Start'=>Carbon::now()
        ]);
        $DataNotif = table('kursus_materi as km')
        ->join('kursus_siswa as ks','km.IDKursus','=','ks.IDKursusSiswa')
        ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
        ->join('karyawan as k','km.IDKaryawan','=','k.IDKaryawan')
        ->join('program_studi as ps','km.IDProgram','=','ps.IDProgram')
        ->where('km.IDKursusMateri',$request->idkursusmateri)
        ->select(
            'ks.UUID as UIDKursus',
            'k.UUID as UIDKaryawan','s.UUID as UIDSiswa',
            'k.NamaKaryawan','s.NamaSiswa','ps.NamaProdi'
        )
        ->get();
        DB::table('notif')->insert([
            'Notif'=> $DataNotif[0]->NamaKaryawan . "memualai kelas (".$DataNotif[0]->NamaProdi.")",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$DataTutor[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/kursus/show/'.$DataNotif[0]->UIDKursus,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent($DataTutor[0]->UIDSiswa));
        return response()->json('Kelas dimulai');
    }
    public function endKursus(Request $request){
        DB::table('kursus_materi')->where('IDKursusMateri',$request->idkursusmateri)
        ->update([
            'Status'=>'CLS',
            'End'=>Carbon::now()
        ]);
        $DataNotif = table('kursus_materi as km')
        ->join('kursus_siswa as ks','km.IDKursus','=','ks.IDKursusSiswa')
        ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
        ->join('karyawan as k','km.IDKaryawan','=','k.IDKaryawan')
        ->join('program_studi as ps','km.IDProgram','=','ps.IDProgram')
        ->where('km.IDKursusMateri',$request->idkursusmateri)
        ->select(
            'ks.UUID as UIDKursus',
            'k.UUID as UIDKaryawan','s.UUID as UIDSiswa',
            'k.NamaKaryawan','s.NamaSiswa','ps.NamaProdi'
        )
        ->get();
        DB::table('notif')->insert([
            'Notif'=> $DataNotif[0]->NamaKaryawan . "mengakhiri kelas (".$DataNotif[0]->NamaProdi.")",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$DataTutor[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/kursus/show/'.$DataNotif[0]->UIDKursus,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent($DataTutor[0]->UIDSiswa));
        return response()->json('Kelas dimulai');
        return response()->json('Kelas selesai');
    }

    public function edit($id){
        $Jadwal = Jadwal::getDetailJadwal($id);
        return view('karyawan.master.jadwal.edit',['Jadwal'=>$Jadwal['Jadwal']]);
    }
    public function update(Request $request){
        $Data = array(
            'NamaSiswa'=>$request->namasiswa,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $status = Jadwal::updateJadwal($Data,$request->kode);
        return redirect('/karyawan/master/jadwal')->with($status);
    }

    //jadwal siswa
    public function showJadwal($id){
        $Data = [];
        $Program = DB::table('kursus_siswa')
        ->select('program_studi.NamaProdi','program_studi.TotalPertemuan',
        'kursus_siswa.UUID as UUIDKursus','program_studi.IDProgram','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','program_studi.IDProgram','=','kursus_siswa.IDProgram')
        ->where('kursus_siswa.UUID',$id)
        ->get();
        $Jadwal = DB::table('jadwal')
        ->join('kursus_materi','jadwal.IDMateri','=','kursus_materi.IDKursusMateri')
        ->join('kursus_siswa','kursus_materi.IDKursus','=','kursus_siswa.IDKursusSiswa')
        ->where('kursus_siswa.UUID',$id)
        ->select('jadwal.Tanggal','kursus_materi.NamaMateri','jadwal.Status','jadwal.IDTutor',
        'jadwal.IDJadwal','kursus_materi.Hari as Hari','kursus_materi.Status as StatusMateri')
        ->get();

        for($i=0;count($Jadwal)>$i;$i++){
            $Tutor = DB::table('karyawan')->where('IDKaryawan',$Jadwal[$i]->IDTutor)->get();
            $Absen = DB::table('absen')->where('IDJadwal',$Jadwal[$i]->IDJadwal)->get();
            
            if($Jadwal[$i]->Status == 'OPN'){
                $StatusJadwal = 'Mencari Tutor';
                $NamaTutor = 'Mencari Tutor';
            }else if($Jadwal[$i]->Status == 'CFM'){


                if($Jadwal[$i]->StatusMateri == 'OPN'&&
                strtotime(explode(' ',$Jadwal[$i]->Tanggal)[0]) > strtotime(Carbon::now())){

                    $StatusJadwal=  'Belum mulai';
                }else if($Jadwal[$i]->StatusMateri == 'OPN'&&
                date('Y-m-d his',strtotime($Jadwal[$i]->Tanggal)) ==
                date('Y-m-d his',strtotime(Carbon::now()))){
                    $StatusJadwal=  'hari ini';
                }else if(
                    $Jadwal[$i]->StatusMateri == 'OPN'&&
                    strtotime($Jadwal[$i]->Tanggal)<=
                    strtotime(Carbon::now())&&
                    strtotime(Carbon::now())<=
                    strtotime('+1 days',strtotime($Jadwal[$i]->Tanggal))
                ){
                    $StatusJadwal=  'Menunggu tutor';
                }else if($Jadwal[$i]->StatusMateri == 'OPN'&&
                strtotime('+1 days',strtotime($Jadwal[0]->Tanggal)) <strtotime(Carbon::now())){

                    $StatusJadwal=  'Terlewat';
                }else if($Jadwal[$i]->StatusMateri == 'CFM'){

                    $StatusJadwal=  'Berlangsung';
                }else if($Jadwal[$i]->StatusMateri == 'CLS'){

                    $StatusJadwal=  'Selesai';
                }else if($Jadwal[$i]->StatusMateri == 'DEL'){

                    $StatusJadwal=  'Dibatalkan';
                }
        
                $NamaTutor = $Tutor[0]->NamaKaryawan;
            }else if($Jadwal[$i]->Status == 'CLS'){
                $StatusJadwal = 'Selesai';
                $NamaTutor = $Tutor[0]->NamaKaryawan;
            }else if($Jadwal[$i]->Status == 'DEL'){
                $StatusJadwal = 'Tidak menemukan tutor';
                $NamaTutor = 'Tidak menemukan tutor';
            }

            //kolom tutor
            array_push($Data,array(
                'Jam'=>explode(' ',$Jadwal[$i]->Tanggal)[1],
                'Tanggal'=>explode(' ',$Jadwal[$i]->Tanggal)[0],
                'Hari'=>$Jadwal[$i]->Hari,
                'NamaMateri'=>$Jadwal[$i]->NamaMateri,
                'NamaTutor'=>$NamaTutor,
                'Status'=>$StatusJadwal,
                'Absen'=>count($Absen)>0?$Absen[0]->Absen:'Belum Absen',
                'IDJadwal'=>$Jadwal[$i]->IDJadwal,
                'UUIDProgram'=>$id
            ));
        }
       // dd($Data);
        return view('siswa.jadwal',['Jadwal'=>$Data,'IDKelas'=>$id]);
    }
    public function createJadwal($id){
        $Kursus = DB::table('kursus_siswa')->where('UUID',$id)->get();
    }
    public function storeJadwal(Request $request){ 
        //dd($request);

        for($i=0;$i<count($request->idprogram);$i++){
            $DataMateri = array(
                'IDProgram'=>$request->idprogram[$i],
                'IDKursus'=>$request->idkursus[$i],
                'NoRecord'=>$request->norecord[$i],
                'NamaMateri'=>$request->namamateri[$i],
                'Tanggal'=>$request->tanggal[$i],
                'Hari'=>$request->hari[$i],  
                'Keterangan'=>'-',  
                'Status'=>'OPN',
            );
             DB::table('kursus_materi')->insert($DataMateri);
            $KursusMateri = DB::table('kursus_materi')->where('NamaMateri',$DataMateri['NamaMateri'])
            ->where('Tanggal',$DataMateri['Tanggal'])->where('Hari',$DataMateri['Hari'])
            ->where('IDKursus',$DataMateri['IDKursus'])->get();
            // dd($KursusMateri,$DataMateri['Tanggal'],$DataMateri['Hari'],$DataMateri['IDKursus']);
            $DataJadwal = array(
                'IDKursusSiswa'=>$request->idkursus[$i],
                'IDMateri'=>$KursusMateri[0]->IDKursusMateri,
                'Tanggal'=>$request->tanggal[$i].' '.$request->jam[$i],
                'Status'=>'OPN',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
            );
            DB::table('jadwal')->insert($DataJadwal);
        };
        $DataNotif = DB::table('kursus_siswa')->where('IDKursusSiswa',$request->idkursus[0])->get();
        DB::table('notif')->insert([
            'Notif'=> session()->get('Username')." Membuat jadwal baru untuk kelas (".$DataNotif[0]->KodeKursus.")",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>'admin',
            'IsRead'=>false,
            'Link'=>'/karyawan/admin/jadwal',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent('admin'));
        return redirect('siswa/kursus');
    }
    public function jadwalTutor(){
        return view('karyawan/jadwal_tutor');
    }
    public function getJadwalSiswa($id){
        $JadwalSiswa = DB::table('jadwal')
        ->where('IDKursusSiswa',$id)
        ->orderBy('Tanggal')
        ->get();
        return response()->json($JadwalSiswa);
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
            array_push($Tea, count($Sch)>0?array(
                'teaStatus'=>true,
                'Data'=>$Sch,
                'IDTutor'=>$data->IDKaryawan,
                'Nama'=>$data->NamaKaryawan
            ):array(
                'teaStatus'=>false,
                'IDTutor'=>$data->IDKaryawan,
                'Nama'=>$data->NamaKaryawan
            ));
        }
        foreach($TmpClass as $data){
            array_push($Class,$data);
        }
        //dd($RealData);
        return response()->json([$Tea,$Class]);
    }
    public function getReqChangeJadwalGroupByTutor($req_date){
        $start_date = date('Y-m-d H:i:s', strtotime('-3 hour',strtotime($req_date)));
        $end_date = date('Y-m-d H:i:s', strtotime('+3 hour',strtotime($req_date)));
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
        ->whereBetween('Tanggal',[$start_date,$end_date])
       // ->whereDate('Tanggal','=',$req_date)
        ->where('jadwal.Status','OPN')
        ->select('jadwal.*')->get()->groupBy('IDKursusSiswa');
      //  dd($Data);
        $Tea = [];
        $Class =[];
        foreach($TmpTea as $data){
            $Sch =[];
            $TmpSch = DB::table('jadwal')
            ->where('IDTutor',$data->IDKaryawan)
            ->whereBetween('Tanggal',[$start_date,$end_date])
            ->get()->groupBy('IDKursusSiswa');
            foreach($TmpSch as $param){
                array_push($Sch,$param);
            }
            array_push($Tea, count($Sch)>0?array(
                'teaStatus'=>true,
                'Data'=>$Sch,
                'IDTutor'=>$data->IDKaryawan,
                'Nama'=>$data->NamaKaryawan
            ):array(
                'teaStatus'=>false,
                'IDTutor'=>$data->IDKaryawan,
                'Nama'=>$data->NamaKaryawan
            ));
        }
        foreach($TmpClass as $data){
            array_push($Class,$data);
        }
        //dd($RealData);
        return response()->json([$Tea,$Class]);
    }
    public function recoverJadwal(){ 
      //  dd('the data has been recovered');
        //dd($request);
        $order_program = DB::connection('mysqls')->table('order_program')
        ->join('siswa','order_program.kd_siswa','=','siswa.kd_siswa')
        ->where('siswa.status','=',0)
        ->whereNull('order_program.status')
        ->get();
        //dd($order_program);
        $kursusSiswa = DB::table('kursus_siswa')
        ->where('Status','!=','DEL')->get();
        //dd($kursusSiswa);
        $DataJadwal =[];
        $DataMateri=[];
        $DataAbsen =[];
        $LostData = [];
        $IDLoop = 0;
        foreach($kursusSiswa as $ks){
            $materiProgram = DB::table('materi_program')->where('IDProgram',$ks->IDProgram)->get();
            $DataTutor = DB::connection('mysqls')->table('jadwal as j')
            ->join('kursus as k','j.id','=','k.id_jadwal')
            ->where('j.id_order',$ks->IDKursusSiswa)
            ->select('k.id_tutor')
            ->get();
            $DataSiswa = DB::connection('mysqls')->table('order_program')
            ->where('id',$ks->IDKursusSiswa)->get();
            //Desinta 1005
            //Afifah 1016
            //Purwa 1004
            //Lutfia 1028
            //Musyfirotun 1006
            //Welasmiyati 1025 ysware
            foreach($materiProgram as $mp){
                $IDLoop ++;
                if(count($DataTutor)==0){
                    if($DataSiswa[0]->nm_siswa=='Catherine faith tandibrata'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1005,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Renny Fazrin Nisa'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1005,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Gabrielle Karina Boediman'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1005,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='ariana'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1016,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Insiya'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1005,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Fatichatus sa\'diyah'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1025,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Lutfiatul jannah'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1025,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Cindy Margaretha'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1006,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Celine Natalie Setiawan'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1005,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Devi Vitriana Purwanto'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1016,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Nadien Alkatiry'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1025,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    if($DataSiswa[0]->nm_siswa=='Andi Lisna'){
                        array_push($DataMateri , array(
                            'IDKursusMateri'=>$IDLoop,
                            'IDKaryawan'=>1004,
                            'IDProgram'=>$ks->IDProgram,
                            'IDKursus'=>$ks->IDKursusSiswa,
                            'NoRecord'=>$mp->NoRecord,
                            'NamaMateri'=>$mp->NamaMateri,
                            'Tanggal'=>Carbon::now(),
                            'Hari'=>'Rabu',  
                            'Start'=>'07:00:00',
                            'End'=>'16:00:00',
                            'Keterangan'=>'migrate',  
                            'Status'=>'CLS',
                        ));
                    }
                    array_push($LostData,array(
                        'NamaSiswa'=>$DataSiswa[0]->nm_siswa,
                        'NamaProgram'=>$DataSiswa[0]->nm_program
                    ));
                }else{
                    array_push($DataMateri , array(
                        'IDKursusMateri'=>$IDLoop,
                        'IDKaryawan'=>$DataTutor[0]->id_tutor,
                        'IDProgram'=>$ks->IDProgram,
                        'IDKursus'=>$ks->IDKursusSiswa,
                        'NoRecord'=>$mp->NoRecord,
                        'NamaMateri'=>$mp->NamaMateri,
                        'Tanggal'=>Carbon::now(),
                        'Hari'=>'Rabu',  
                        'Start'=>'07:00:00',
                        'End'=>'16:00:00',
                        'Keterangan'=>'migrate',  
                        'Status'=>'CLS',
                    ));
                }

                array_push($DataJadwal , array(
                    'IDJadwal'=>$IDLoop,
                    'IDKursusSiswa'=>$ks->IDKursusSiswa,
                    'IDMateri'=>$IDLoop,
                    'IDTutor'=>count($DataTutor)>0?$DataTutor[0]->id_tutor:'1017',
                    'Tanggal'=>Carbon::now(),
                    'Status'=>'CLS',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>'migrate',
                    'UserUpd'=>'migrate',
                ));
           
                array_push($DataAbsen , array(
                    'IDAbsen'=>$IDLoop,
                    'IDJadwal'=>$IDLoop,
                    'Absen'=>'Masuk',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>'migrate',
                    'UserUpd'=>'migrate',
                ));
            };
        }
        // dd($DataMateri);
        // $LostDataFinal =[];
        // foreach($LostData as $val) {
        //     if(array_key_exists('NamaSiswa', $val)){
        //         $LostDataFinal[$val['NamaSiswa']][] = $val;
        //     }else{
        //         $LostData[""][] = $val;
        //     }
        // }
        // dd($LostDataFinal);
        // return view('recoverLostData',['siswa'=>$LostData]);
        //dd($LostData);
        // DB::table('absen')->insert($DataAbsen);
        // DB::table('jadwal')->insert($DataJadwal);
        // DB::table('kursus_materi')->insert($DataMateri);
        dd('the data has been recovered');
        //return redirect('siswa/kursus');
    }
    public function recoverMateri(){
        $materi = DB::connection('mysqls')->table('program_kursus as pk')
        ->select(
            'md.id','m2.id_kat_materi','md.jml_pertemuan',
            'm2.materi','pk.id as id_program','pk.program'
        )
        ->join('program_kursus_modul as pkm','pk.id','=','pkm.id_program')
        ->join('modul as m','pkm.id_modul','=','m.id')
        ->join('modul_detail as md','m.id','=','md.id_modul')
        ->join('materi as m2','md.id_materi','=','m2.id')
        ->where('pk.status',1)
        ->whereNull('m2.status')
        ->orderBy('pk.id')
        ->get()->groupBy('id_program');
   //   dd($materi);
        $materi_program = [];
        foreach($materi as $mate){
            $no_record = 0;
            foreach($mate as $m){
                for($i=0;$i< $m->jml_pertemuan;$i++){
                    $no_record ++;
                    array_push($materi_program,array(
                        "IDKategoriMateri"=>$m->id_kat_materi,
                        "IDProgram"=>$m->id_program,
                        'NamaMateri'=>$m->jml_pertemuan == 1? $m->materi:$m->materi . " ( pertemuan ke ".($i+1)." )",
                        "created_at"=>Carbon::now(),
                        "updated_at"=>Carbon::now(),
                        "UserUpd"=>"migrate",
                        "UserAdd"=>"migrate",
                        "Status"=>"OPN",
                        "Norecord"=>$no_record
                    ));
                }
            }
        }
        
        // DB::table('materi_program')->insert($materi_program);
        dd('the data has been recovered');
    }


    
}
