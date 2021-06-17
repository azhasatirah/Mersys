<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use DB;
use File;
use App\Models\ProgramStudi;
use App\Models\KategoriProgram;
use App\Models\LevelProgram;
use App\Models\Cicilan;
use App\Models\KategoriGlobal;
class ProgramStudiController extends Controller
{

    public function detailProgramGetProgramStudi($id){
        $Prodi= DB::table('program_studi')->where('UUID',$id)->get();
        $Modul = DB::table('program_studi_modul')->join('program_studi','program_studi_modul.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
        $Tool = DB::table('program_studi_tool')->join('program_studi','program_studi_tool.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
        $Cicilan = DB::table('cicilan')->join('program_studi','cicilan.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)
        ->select('Cicilan.*')->get();
        $LevelProgram = DB::table('level_program')->where('Status','OPN')->get();
        $KategoriProgram = DB::table('kategori_program')->where('Status','OPN')->get();
        $KategoriGlobalProgram = DB::table('kategori_global_program')->where('Status','OPN')->get();
        $ProgramStudi = [];
        foreach($Prodi as $prodi){
            array_push($ProgramStudi,array(
                'Harga'=>$prodi->Harga,
                'HargaTool'=>$Tool->sum('Harga'),
                'HargaModul'=>$Modul->sum('Harga'),
                'Cicilan'=>$prodi->Cicilan,
                'NamaProdi'=>$prodi->NamaProdi,
                'Level'=>$prodi->IDLevel,
                'KategoriProgram'=>$prodi->IDKategoriProgram,
                'KategoriGlobalProgram'=>$prodi->IDKategoriGlobalProgram
            ));
        }
        dd($ProgramStudi);

    }
    //
    public function show($id){
        $Prodi= DB::table('program_studi')->where('UUID',$id)->get();
        $Modul = DB::table('program_studi_modul')->join('program_studi','program_studi_modul.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
        $Tool = DB::table('program_studi_tool')->join('program_studi','program_studi_tool.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
        $Video = DB::table('program_studi_video')->join('program_studi','program_studi_video.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
        $BahanTutor = DB::table('program_studi_bahan_tutor')->join('program_studi','program_studi_bahan_tutor.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
        $Cicilan = DB::table('cicilan')->join('program_studi','cicilan.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)
        ->select('cicilan.*')->get();
        $LevelProgram = DB::table('level_program')->where('Status','OPN')->get();
        $KategoriProgram = DB::table('kategori_program')->where('Status','OPN')->get();
        $KategoriGlobalProgram = DB::table('kategori_global_program')->where('Status','OPN')->get();
        $KategoriMateri = DB::table('kategori_materi')->where('Status','OPN')->get();
        $MateriProgram = DB::table('materi_program')->join('program_studi','materi_program.IDProgram','=','program_studi.IDProgram')->where('program_studi.UUID',$id)->get();
       // dd($Prodi);
        return view('karyawan.manage.program.detail',[
            'Prodi'=>$Prodi,
            'Modul'=>$Modul,
            'Tool'=>$Tool,
            'Video'=>$Video,
            'BahanTutor'=>$BahanTutor,
            'Cicilan'=>$Cicilan,
            'KategoriProgram'=>$KategoriProgram,
            'KategoriGlobalProgram'=>$KategoriGlobalProgram,
            'LevelProgram'=>$LevelProgram,
            'KategoriMateri'=>$KategoriMateri,
            'MateriProgram'=>$MateriProgram
        ]);
    }
    public function index(){
        $KategoriProgram = KategoriProgram::getAllKategoriProgram();
        $LevelProgram = LevelProgram::getAllLevelProgram();
        return view('karyawan.manage.programstudi',[
            'KategoriProgram'=>$KategoriProgram,
            'LevelProgram'=>$LevelProgram
        ]);
    }
    public function global(){
        //'ed5f531e8c0b401895be163cdae1fc02' uuid kategori global program pendaftaran
        $KategoriProgram = KategoriProgram::getAllKategoriProgramSiswa();
        $KategoriGlobal = DB::table('kategori_global_program')->where('Status','OPN')
        ->where('UUID','!=','ed5f531e8c0b401895be163cdae1fc02')->get();
        return view('siswa.kategoriprogram',['KategoriProgram'=>$KategoriProgram['KategoriProgram'],'KategoriGlobal'=>$KategoriGlobal]);
    }
    public function kategoriProgramSiswa($KategoriGlobal){
        $KategoriProgram = KategoriProgram::getAllKategoriProgramSiswa();
        return view('siswa.kategoriprogram2',['KategoriProgram'=>$KategoriProgram['KategoriProgram'],'KategoriGlobal'=>$KategoriGlobal]);
    }

    public function programSiswa($ID,$ID2){
    
        $ProgramStudi = ProgramStudi::getProgramStudiByKategori($ID2,$ID);
       // dd($ProgramStudi);
        $Data = [];
        foreach($ProgramStudi['ProgramStudi']as $Prodi){
            $Tools = DB::table('program_studi_tool')
            ->where('IDProgram',$Prodi->IDProgram)
            ->where('Status','OPN')->get();
            $Moduls = DB::table('program_studi_modul')
            ->where('IDProgram',$Prodi->IDProgram)
            ->where('Status','OPN')->get();
            $Cicilan = DB::table('cicilan')
            ->where('IDProgram',$Prodi->IDProgram)
            ->where('Status','OPN')->get();
            array_push($Data,array(
                'IDProgram'=>$Prodi->IDProgram,
                'NamaProdi'=>$Prodi->NamaProdi,
                'TotalPertemuan'=>$Prodi->TotalPertemuan,
                'HargaLunas'=>$Prodi->Harga + $Tools->sum('Harga')+$Moduls->sum('Harga'),
                'Tool'=>count($Tools)>0?$Tools:false,
                'Modul'=>count($Moduls)>0?$Moduls:false,
                'Cicilan'=>count($Cicilan)>0?$Cicilan:false
            ));
        }
     //   dd($Data);

        return view('siswa.program',['Program'=>$Data]);
    }

    public function showDetail($ID){
        $ProgramStudi = DB::table('program_studi')->where('IDProgram',$ID)->get();
        //dd($ProgramStudi);
        $Data = [];
        foreach($ProgramStudi as $Prodi){
            $Tools = DB::table('program_studi_tool')
            ->where('IDProgram',$Prodi->IDProgram)
            ->where('Status','OPN')->get();
            $Moduls = DB::table('program_studi_modul')
            ->where('IDProgram',$Prodi->IDProgram)
            ->where('Status','OPN')->get();
            $Cicilan = DB::table('cicilan')
            ->where('IDProgram',$Prodi->IDProgram)
            ->where('Status','OPN')->get();
            array_push($Data,array(
                'IDProgram'=>$Prodi->IDProgram,
                'NamaProdi'=>$Prodi->NamaProdi,
                'TotalPertemuan'=>$Prodi->TotalPertemuan,
                'HargaLunas'=>$Prodi->Harga + $Tools->sum('Harga')+$Moduls->sum('Harga'),
                'Tool'=>count($Tools)>0?$Tools:false,
                'Modul'=>count($Moduls)>0?$Moduls:false,
                'Cicil'=>$Prodi->Cicilan,
                'Cicilan'=>count($Cicilan)>0?$Cicilan:false
            ));
        }


        return response()->json($Data);
    }
    public function create(){
        $KategoriProgram = KategoriProgram::getAllKategoriProgram();
        $KategoriGlobalProgram = KategoriGlobal::getAllKategoriGlobal();
        $LevelProgram = LevelProgram::getAllLevelProgram();
        return view('karyawan.manage.program.create',[
            'KategoriGlobalProgram'=>$KategoriGlobalProgram,
            'KategoriProgram'=>$KategoriProgram,
            'LevelProgram'=>$LevelProgram
        ]);
    }
    public function store(Request $request){
        //dd($request);
        //return response()->json($request);
        $KodeProgram = "PG-" . date("ymHis");
        $Data = array(
            'UUID'=>str_replace('-','',str::uuid()),
            'KodeProgram'=> $KodeProgram,
            'NamaProdi'=>$request->namaprogram,
            'IDKategoriProgram'=>$request->kategori,
            'IDKategoriGlobalProgram'=>$request->kategoriglobal,
            'IDLevel'=>$request->level,
            'Cicilan'=>$request->cicilan,
            'TotalPertemuan'=>$request->totalpertemuan,
            'Harga'=>$request->harga,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $status = ProgramStudi::storeProgramStudi($Data);
        if($request->cicilan =='y'){
            $Program= ProgramStudi::showProgramByKode($KodeProgram);
            $IDProgram = $Program['ProgramStudi'][0]->IDProgram;
            for($i=0;$i<count($request->hargacicilan);$i++){
                $DataCicilan = array(
                    'IDProgram'=>$IDProgram,

                    'Harga'=>$request->hargacicilan[$i],
                    'Cicilan'=>$request->jumlahcicilan[$i],
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'Status'=>'OPN'
                );
                Cicilan::storeCicilan($DataCicilan);
            }
        }
        $Program = DB::table('program_studi')->where('KodeProgram',$KodeProgram)->get();
        for($i=0;count($request->materi)> $i;$i++){
            $DataMateri = array(
                'IDKategoriMateri'=>$request->kategorimateri[$i],
                'IDProgram'=>$Program[0]->IDProgram,
                'NamaMateri'=>$request->materi[$i],
                'NoRecord'=>$i+1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
                'Status'=>'OPN'
            );
            DB::table('materi_program')->insert($DataMateri);
        }
        if(isset($request->nama_modul)){
            $i=0;
            foreach($request->file('modul') as $modul){
               
                $FormatFile = $modul->getClientOriginalExtension();
                $NamaModul = 'MDL'.date('dmyhis').'.sspdf';
                $Status = $modul->move(public_path('program_studi/modul'),$NamaModul);
                $Data = array(
                    'IDProgram'=>$Program[0]->IDProgram,
                    'UUID'=>str_replace('-','',str::uuid()),
                    'Judul'=>$request->nama_modul[$i],
                    'Modul'=>$NamaModul,
                    'Harga'=>$request->harga_modul[$i],
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'Status'=>'OPN'
                );
                $i++;
                DB::table('program_studi_modul')->insert($Data);
            }
        }
        if(isset($request->nama_bahantutor)){
            $i=0;
            foreach($request->file('file_bahantutor') as $btr){
               
                $FormatFile = $btr->getClientOriginalExtension();
                $NamaBahan = 'BTR'.date('dmyhis').'.'.$FormatFile;
                $Status = $btr->move(public_path('program_studi/bahan_tutor'),$NamaBahan);
                $Data = array(
                    'IDProgram'=>$Program[0]->IDProgram,
                    'UUID'=>str_replace('-','',str::uuid()),
                    'NamaBahan'=>$request->nama_bahantutor[$i],
                    'File'=>$NamaBahan,
                    'Type'=>$request->tipe_bahantutor[$i],
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'Status'=>'OPN'
                );
                $i++;
                DB::table('program_studi_bahan_tutor')->insert($Data);
            }
        }
        if(isset($request->nama_tool)){
            for($i=0;$i<count($request->nama_tool);$i++){
                $Data = array(
                    'IDProgram'=>$Program[0]->IDProgram,
                    'NamaTool'=>$request->nama_tool[$i],
                    'Harga'=>$request->harga_tool[$i],
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'Status'=>'OPN'
                );
                DB::table('program_studi_tool')->insert($Data);
            }
        }
        if(isset($request->judul_video)){
            for($i=0;$i<count($request->judul_video);$i++){
                $Data = array(
                    'IDProgram'=>$Program[0]->IDProgram,
                    'UUID'=>str_replace('-','',str::uuid()),
                    'Judul'=>$request->judul_video[$i],
                    'Link'=>$request->link_video[$i],
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'Status'=>'OPN'
                );
                DB::table('program_studi_video')->insert($Data);
            }
        }
        return redirect('karyawan/admin/master/program');
    }
    public function edit($id){
        $ProgramStudi = ProgramStudi::getDetailProgramStudi($id);
        return response()->json($ProgramStudi['ProgramStudi']);
    }
    public function update(Request $request){
        $Data = array(
            'NamaProdi'=>$request->namaprodi,
            'IDKategoriProgram'=>$request->kategoriprodi,
            'IDKategoriGlobalProgram'=>$request->kategoriglobalprodi,
            'IDLevel'=>$request->levelprodi,
            'Cicilan'=>$request->cicilanprodi,
            'Harga'=>$request->hargaprodi,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username'),
        );
        $Status = ProgramStudi::updateProgramStudi($Data,$request->idprodi);
        return response()->json($Status);
    }

    //json
    public function delete($Kode){
        $Pesan = ProgramStudi::deleteProgramStudi($Kode);
        return response()->json($Pesan);
    }  
    public function getData(){
        $ProgramStudi = ProgramStudi::getAllProgramStudi();
        return response()->json($ProgramStudi);
    }
    public function getHargaByIDProgram($id){
        $Harga = Cicilan::getHargaByIDProgram($id);
        return response()->json($Harga);
    }


    //materi program
    public function createMateriProgram(){
        return view('karyawan.manage.program.create');
    }
    public function storeMateriProgram(Request $request){
        dd($request);
    }
    public function kelasTutorGroupBySiswa(){
        $Data = [];
        $Siswa = DB::table('jadwal as j')
        ->select(
            's.NamaSiswa','s.IDSiswa','s.UUID as UUIDSiswa','s.KodeSiswa','s.IDSiswa'
        )
        ->join('kursus_siswa as ks','j.IDKursusSiswa','=','ks.IDKursusSiswa')
        ->join('siswa as s','ks.IDSiswa','=','s.IDSiswa')
        ->where('j.IDTutor',session()->get('IDUser'))
        ->get()->groupBy('NamaSiswa');
        foreach($Siswa as $item ){
            array_push($Data, array(
                'KodeSiswa'=>$item[0]->KodeSiswa,
                'NamaSiswa'=>$item[0]->NamaSiswa,
                'UUIDSiswa'=>$item[0]->UUIDSiswa,
                'TestPsiko'=>DB::table('test_psikologi')->where('IDSiswa',$item[0]->IDSiswa)->get()
            ));
        }
        //dd($Data);
        return view('karyawan/kelasTutorGroupBySiswa',['Siswa'=>$Data]);
    }
    public function kelasTutor($id){


        $Program = DB::table('kursus_siswa')
        ->join('siswa','kursus_siswa.IDSiswa','=','siswa.IDSiswa')
        ->join('program_studi','program_studi.IDProgram','=','kursus_siswa.IDProgram')
        ->join('kursus_materi','kursus_siswa.IDKursusSiswa','=','kursus_materi.IDKursus')
        ->join('jadwal','kursus_materi.IDKursusMateri','=','jadwal.IDMateri')
        ->select('program_studi.NamaProdi','program_studi.TotalPertemuan','kursus_siswa.KodeKursus',
        'kursus_siswa.UUID as UUIDKursus','program_studi.IDProgram','kursus_siswa.IDKursusSiswa')
        ->where('jadwal.IDTutor',session()->get('IDUser'))
        // ->where('kursus_siswa.IDProgram','!=',1)
        ->where('siswa.UUID',$id)
        ->where('kursus_siswa.Status','=','CLS')
        ->orderBy('NamaProdi')
        ->get()->groupBy('UUIDKursus');
       //dd($Program);
        $Data =[];
        foreach($Program as $program){
           //dd($program[0]);
            //pertemuan yg sudah dilewati
            $KursusMateri = DB::table('kursus_materi')->where('IDKursus',$program[0]->IDKursusSiswa)
            ->where('Status','CLS')->get();
            //pertemuan yg aktif (materi yang sudah dibuat jadwal)
            $KursusMateriAktif = DB::table('kursus_materi')->where('IDKursus',$program[0]->IDKursusSiswa)
            ->where('Status','OPN')->get();
            //Materi
            $whichMateri =count($KursusMateri) == $program[0]->TotalPertemuan? 
            count($KursusMateri):count($KursusMateri)+1;
            //dd($whichMateri,$program[0]->TotalPertemuan);
            $Materi = DB::table('materi_program')->where('IDProgram',$program[0]->IDProgram)
            ->where('NoRecord',$whichMateri)
            ->orderBy('created_at','desc')->get();
            //jadwal
            //dd($KursusMateri);
           // dd($Materi,$program[0]->IDProgram);
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
            $SecondStatus = count($KursusMateri) == $program[0]->TotalPertemuan? 'Kelas selesai':'Jadwal belum dibuat';
            array_push($Data, array(
                'IDKursus'=>$program[0]->IDKursusSiswa,
                'UUIDKursus'=>$program[0]->UUIDKursus,
                'KodeKursus'=>$program[0]->KodeKursus,
                'NamaProgram'=>$program[0]->NamaProdi,
                'IDProgram'=>$program[0]->IDProgram,
                'TotalPertemuan'=>$program[0]->TotalPertemuan,
                'SisaPertemuan'=>$program[0]->TotalPertemuan - count($KursusMateri),
                'Pertemuan'=>count($KursusMateri),
                'NamaMateri'=> count($KursusMateri) == $program[0]->TotalPertemuan? 'Selesai':$Materi[0]->NamaMateri,
                
                'NoRecord'=>$Materi[0]->NoRecord,
                'JadwalExist'=>count($KursusMateriAktif)>0?true:false,
                'StatusJadwal'=>count($KursusMateriAktif)>0?$StatusJadwal:$SecondStatus,
                'JadwalTanggal'=>count($KursusMateriAktif)>0?$Jadwal[0]->Tanggal:0,
                'JadwalJam'=>count($KursusMateriAktif)>0?explode(' ',$Jadwal[0]->Tanggal)[1]:0,
            ));
        }
       // dd($Data);
        // return view('siswa.myprogram',['Kursus'=>$Data]);
        return view('karyawan/kelasTutor',['Kursus'=>$Data]);
    }
    public function showKelasTutor($id){
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
     
       //dd($Prodi);
        return view('karyawan.kelas_tutor',[
            'Prodi'=>$Prodi,
            'Modul'=>$Modul,
            'Video'=>$Video,
            'BahanTutor'=>$BahanTutor,
        ]);
    }

    public function pdGetProdi($id){
        //kunai
        $Prodi = DB::table('program_studi')->where('IDProgram',$id)->get();
        $Cicilan = DB::table('cicilan')->where('IDProgram',$id)->where('Status','!=','DEL')->get();
        return response()->json(['Prodi'=>$Prodi,'Cicilan'=>$Cicilan]);
    }
    public function pdStoreCicilan(Request $request){
        DB::table('cicilan')->insert([
            'IDProgram'=>$request->cicilanidprogram,
            'Cicilan'=>$request->cicilancicilan,
            'Harga'=>$request->cicilanharga,
            'Status'=>'OPN',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Berhasil ditambahkan');
    }
    public function pdUpdateCicilan(Request $request){
        DB::table('cicilan')->where('IDCicilan',$request->cicilanidprogram)->update([
            'Cicilan'=>$request->cicilancicilan,
            'Harga'=>$request->cicilanharga,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Berhasil di edit');
    }

    public function pdGetPertemuan($id){
        //kunai
        $Pertemuan = DB::table('materi_program')->where('IDProgram',$id)->where('Status','!=','DEL')->get();
        $Kategori = DB::table('kategori_materi')->where('Status','!=','DEL')->get();
        return response()->json(['PertemuanMateri'=>$Pertemuan,'KategoriMateri'=>$Kategori]);
    }
    public function pdStorePertemuan(Request $request){
        $Materi = DB::table('materi_program')->where('IDProgram',$request->idprogram)
        ->where('Status','OPN')->orderBy('NoRecord','asc')->get();
        DB::table('materi_program')->insert([
            'IDProgram'=>$request->idprogram,
            'NamaMateri'=>$request->pertemuanmateri,
            'IDKategoriMateri'=>$request->pertemuankategori,
            'NoRecord'=>$Materi[count($Materi) -1]->NoRecord +1,
            'Status'=>'OPN',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Berhasil ditambahkan');
    }
    public function pdUpdatePertemuan(Request $request){
        DB::table('materi_program')->where('IDMateriProgram',$request->idmateriprogram)->update([
            'NamaMateri'=>$request->pertemuanmateri,
            'IDKategoriMateri'=>$request->pertemuankategori,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Berhasil di edit');
    }
    public function pdDeletePertemuan($id){

        DB::table('materi_program')->where('IDMateriProgram',$id)->update(['Status'=>'DEL']);
        return response()->json('Berhasil di hapus');
    }
    public function pdGetTool($id){
        $Tool = DB::table('program_studi_tool')->where('Status','!=','DEL')
        ->where('IDProgram',$id)->get();
        return response()->json($Tool);
    }
    public function pdStoreTool(Request $request){
        DB::table('program_studi_tool')->insert([
            'IDProgram'=>$request->idprogram,
            'NamaTool'=>$request->namatool,
            'Harga'=>$request->hargatool,
            'Status'=>'OPN',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Data berhasil ditambahkan');
    }
    public function pdUpdateTool(Request $request){
       // dd($request);
        DB::table('program_studi_tool')->where('IDTool',$request->idtool)->update([
            'NamaTool'=>$request->namatool,
            'Harga'=>$request->hargatool,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Data berhasil diedit');
    }
    public function pdDeleteTool($id){
        DB::table('program_studi_tool')->where('IDTool',$id)->update(['Status'=>'DEL']);
        return response()->json('Berhasil di hapus');
    }
    public function pdGetVideo($id){
        $Video = DB::table('program_studi_video')->where('Status','OPN')->where('IDProgram',$id)->get();
        return response()->json($Video);
    }
    public function pdStoreVideo(Request $request){
        DB::table('program_studi_video')->insert([
            'UUID'=>str_replace('-','',str::uuid()),
            'IDProgram'=>$request->idprogram,
            'Judul'=>$request->judul,
            'Link'=>$request->video,
            'Status'=>'OPN',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Data berhasil ditambahkan');
    }
    public function pdUpdateVideo(Request $request){
        DB::table('program_studi_video')->where('IDVideo',$request->idvideo)->update([
            'Judul'=>$request->judul,
            'Link'=>$request->video,
            'updated_at'=>Carbon::now(),
            'UserUpd'=>session()->get('Username')
        ]);
        return response()->json('Data berhasil ditambahkan');
    }
    public function pdDeleteVideo($id){
        DB::table('program_studi_video')->where('IDVideo',$id)->update(['Status'=>'DEL']);
        return response()->json('Berhasil di hapus');
    }

    public function pdGetModul($id){
        $Modul = DB::table('program_studi_modul')->where('Status','OPN')
        ->where('IDProgram',$id)->get();
        return response()->json($Modul);
    }
    public function pdStoreModul(Request $request){
        //dd($request);
        $btr = $request->file('modul'); 
        $FormatFile = $btr->getClientOriginalExtension();
        $NamaBahan = 'MDL'.date('dmyhis').'.'.'ss'.$FormatFile;
        $Status = $btr->move(public_path('program_studi/modul'),$NamaBahan);
        $Data = array(
            'IDProgram'=>$request->idprogram,
            'UUID'=>str_replace('-','',str::uuid()),
            'Judul'=>$request->nama,
            'Modul'=>$NamaBahan,
            'Harga'=>$request->harga,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('program_studi_modul')->insert($Data);
        return response()->json('Berhasil ditambahkan');
    }
    public function pdUpdateModul(Request $request){
        if(count($request->file())>0){
            $Modul = DB::table('program_studi_modul')->where('IDModul',$request->idmodul)->get();
            if(!unlink(public_path('program_studi/modul/').$Modul[0]->Modul)){
                return response()->json('gagal');
            }else{
                $btr = $request->file('modul'); 
                $FormatFile = $btr->getClientOriginalExtension();
                $NamaBahan = 'MDL'.date('dmyhis').'.'.'ss'.$FormatFile;
                $Status = $btr->move(public_path('program_studi/modul'),$NamaBahan);
                $Data = array(
                    'Judul'=>$request->nama,
                    'Modul'=>$NamaBahan,
                    'Harga'=>$request->harga,
                    'updated_at'=>Carbon::now(),
                    'UserUpd'=>session()->get('Username')
                );
                DB::table('program_studi_modul')->where('IDModul',$request->idmodul)->update($Data);
                return response()->json('Berhasil diubah');
            }
        }else{
            $Data = array(
                'Judul'=>$request->nama,
                'Harga'=>$request->harga,
                'updated_at'=>Carbon::now(),
                'UserUpd'=>session()->get('Username')
            );
            DB::table('program_studi_modul')->where('IDModul',$request->idmodul)->update($Data);
            return response()->json('Berhasil diubah');
        }
    }
    public function pdDeleteModul($id){
        $Modul = DB::table('program_studi_modul')->where('IDModul',$id)->get();
        if(file_exists(public_path('program_studi/modul/').$Modul[0]->Modul)){
            if(!unlink(public_path('program_studi/modul/').$Modul[0]->Modul)){
                return response()->json('gagal');
            }else{
                DB::table('program_studi_modul')->where('IDModul',$id)->update(['Status'=>'DEL']);
                return response()->json('Berhasil di hapus');
            }
        }else{
            DB::table('program_studi_modul')->where('IDModul',$id)->update(['Status'=>'DEL']);
            return response()->json('Berhasil di hapus');
        }
    }
    public function pdGetBahan($id){
        $Modul = DB::table('program_studi_bahan_tutor')->where('Status','OPN')
        ->where('IDProgram',$id)->get();
        return response()->json($Modul);
    }
    public function pdStoreBahan(Request $request){
        //dd($request);
        $btr = $request->file('modul'); 
        $FormatFile = $btr->getClientOriginalExtension();
        $NamaBahan = 'BTR'.date('dmyhis').'.'.'ss'.$FormatFile;
        $Status = $btr->move(public_path('program_studi/modul'),$NamaBahan);
        $Data = array(
            'IDProgram'=>$request->idprogram,
            'UUID'=>str_replace('-','',str::uuid()),
            'NamaBahan'=>$request->nama,
            'File'=>$NamaBahan,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        DB::table('program_studi_bahan_tutor')->insert($Data);
        return response()->json('Berhasil ditambahkan');
    }
    public function pdUpdateBahan(Request $request){
        if(count($request->file())>0){
            $Modul = DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$request->idbahan)->get();
            if(file_exists(public_path('program_studi/modul/').$Modul[0]->File)){
                if(!unlink(public_path('program_studi/modul/').$Modul[0]->File)){
                    return response()->json('gagal');
                }else{
                    $btr = $request->file('modul'); 
                    $FormatFile = $btr->getClientOriginalExtension();
                    $NamaBahan = 'BTR'.date('dmyhis').'.'.'ss'.$FormatFile;
                    $Status = $btr->move(public_path('program_studi/modul'),$NamaBahan);
                    $Data = array(
                        'NamaBahan'=>$request->nama,
                        'File'=>$NamaBahan,
                        'updated_at'=>Carbon::now(),
                        'UserUpd'=>session()->get('Username')
                    );
                    DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$request->idbahan)->update($Data);
                    return response()->json('Berhasil diubah');
                }
            }else{
                $btr = $request->file('modul'); 
                $FormatFile = $btr->getClientOriginalExtension();
                $NamaBahan = 'BTR'.date('dmyhis').'.'.'ss'.$FormatFile;
                $Status = $btr->move(public_path('program_studi/modul'),$NamaBahan);
                $Data = array(
                    'NamaBahan'=>$request->nama,
                    'File'=>$NamaBahan,
                    'updated_at'=>Carbon::now(),
                    'UserUpd'=>session()->get('Username')
                );
                DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$request->idbahan)->update($Data);
                return response()->json('Berhasil diubah');
            }
        }else{
            $Data = array(
                'NamaBahan'=>$request->nama,
                'updated_at'=>Carbon::now(),
                'UserUpd'=>session()->get('Username')
            );
            DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$request->idbahan)->update($Data);
            return response()->json('Berhasil diubah');
        }
    }
    public function pdDeleteBahan($id){
        $Modul = DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$id)->get();
        if(file_exists(public_path('program_studi/modul/').$Modul[0]->File)){
            if(!unlink(public_path('program_studi/modul/').$Modul[0]->File)){
                return response()->json('gagal');
            }else{
                DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$id)->update(['Status'=>'DEL']);
                return response()->json('Berhasil di hapus');
            }
        }else{
            DB::table('program_studi_bahan_tutor')->where('IDBahanTutor',$id)->update(['Status'=>'DEL']);
            return response()->json('Berhasil di hapus');
        }
    }
}

