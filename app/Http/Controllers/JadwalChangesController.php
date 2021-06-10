<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\support\str;
use Illuminate\support\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class JadwalChangesController extends Controller
{
    //
    public function storeChanges(Request $request){
       // dd($request);
       
        $Program = DB::table('kursus_siswa')->where('UUID',$request->UIDProgram[0])->get();
        $TanggalJadwalChange = Carbon::now();
        $DataJadwalChange = array(
            'IDKursusSiswa'=>$Program[0]->IDKursusSiswa,
            'From'=>$request->IDSiswa[0],
            'To'=>$request->IDTutor[0],
            'Status'=>'OPN',
            'created_at'=>$TanggalJadwalChange,
            'updated_at'=>$TanggalJadwalChange,
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
        );
        DB::table('jadwal_change')->insert($DataJadwalChange);
        $JadwalChanges = DB::table('jadwal_change')
        ->where('created_at',$TanggalJadwalChange)
        ->where('IDKursusSiswa',$Program[0]->IDKursusSiswa)
        ->get();
        $DataNotif = DB::table('jadwal_change')
        ->join('karyawan','jadwal_change.To','=','karyawan.IDKaryawan')
        ->join('siswa','siswa.IDSiswa','=','jadwal_change.From')
        ->join('kursus_siswa as ks','ks.IDKursusSiswa','=','jadwal_change.IDKursusSiswa')
        ->select('jadwal_change.*','karyawan.UUID as UIDTutor','ks.UUID as UIDKelas','siswa.NamaSiswa')
        ->where('IDJadwalChange',$JadwalChanges[0]->IDJadwalChange)->get();
        $DataJadwalChangesDetail=[];
        for($i=0;$i<count($request->IDSiswa);$i++){
            array_push($DataJadwalChangesDetail,array(
                'IDJadwalChange'=>$JadwalChanges[0]->IDJadwalChange,
                'IDJadwal'=>$request->IDJadwal[$i],
                'NoRecordFrom'=>$request->NoRecordFrom[$i],
                'NoRecordTo'=>$request->NoRecordTo[$i],
                'IDMateriFrom'=>$request->IDMateriFrom[$i],
                'IDMateriTo'=>$request->IDMateriTo[$i],
                'TanggalFrom'=>$request->TanggalFrom[$i],
                'TanggalTo'=>$request->TanggalTo[$i],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
            ));
        }
        DB::table('jadwal_change_detail')->insert($DataJadwalChangesDetail);
        DB::table('notif')->insert([
            'Notif'=>$DataNotif[0]->NamaSiswa. " mengajukan permintaan perubahan jadwal",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$DataNotif[0]->UIDTutor,
            'IsRead'=>false,
            'Link'=>'/karyawan/tutor/kelas/show/'.$DataNotif[0]->UIDKelas,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        broadcast(new \App\Events\NotifEvent($DataNotif[0]->UIDTutor));
        return response()->json(true);
    }
    public function confirmChanges($id,$answer){
        $DataNotif = DB::table('jadwal_change')
        ->join('karyawan','jadwal_change.To','=','karyawan.IDKaryawan')
        ->join('siswa','siswa.IDSiswa','=','jadwal_change.From')
        ->join('kursus_siswa as ks','ks.IDKursusSiswa','=','jadwal_change.IDKursusSiswa')
        ->select('jadwal_change.*','karyawan.NamaKaryawan','ks.UUID as UIDKelas','siswa.UUID as UIDSiswa')
        ->where('IDJadwalChange',$id)->get();
        if($answer=="true"){
            DB::table('jadwal_change')->where('IDJadwalChange',$id)->update(['Status'=>'CLS']);
            $TmpJadwalChanges = DB::table('jadwal_change_detail')->where('IDJadwalChange',$id)->get();
            $JadwalChanges =[];
            foreach($TmpJadwalChanges as $Item){
                DB::table('jadwal')->where('IDJadwal',$Item->IDJadwal)->update([
                    'IDMateri'=>$Item->IDMateriTo,
                    'Tanggal'=>$Item->TanggalTo
                ]);
            }
            DB::table('notif')->insert([
                'Notif'=>$DataNotif[0]->NamaKaryawan. " menyetujui permintaan perubahan jadwal anda",
                'NotifFrom'=> session()->get('UID'),
                'NotifTo'=>$DataNotif[0]->UIDSiswa,
                'IsRead'=>false,
                'Link'=>'/siswa/kursus/show/'.$DataNotif[0]->UIDKelas,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
            broadcast(new \App\Events\NotifEvent($DataNotif[0]->UIDSiswa));
            return response()->json('perubahan jadwal disetujui');
        }
        if($answer =="false"){
            
            DB::table('jadwal_change')->where('IDJadwalChange',$id)->update(['Status'=>'DEL']);
            DB::table('notif')->insert([
                'Notif'=>$DataNotif[0]->NamaKaryawan. " menolak permintaan perubahan jadwal anda",
                'NotifFrom'=> session()->get('UID'),
                'NotifTo'=>$DataNotif[0]->UIDSiswa,
                'IsRead'=>false,
                'Link'=>'/siswa/kursus/show/'.$DataNotif[0]->UIDKelas,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
            broadcast(new \App\Events\NotifEvent($DataNotif[0]->UIDSiswa));
            return response()->json('perubahan jadwal ditolak');
        }
        return response()->json('Terjadi kesalahan');
    }
    public function getChanges($id){
        //->join('jadwal_changes_detail as jcd','jc.IDJadwalChanges','=','jcd.IDJadwalChanges')
        $TmpChanges = DB::table('jadwal_change as jc')
        ->join('kursus_siswa as ks','jc.IDKursusSiswa','=','ks.IDKursusSiswa')
        ->select('jc.Status','jc.IDJadwalChange')
        ->where('ks.UUID',$id)
        ->get();
        $Changes = [];
        foreach($TmpChanges as $item){
            array_push($Changes,array(
                'Status'=>$item->Status,
                'IDJadwalChange'=>$item->IDJadwalChange,
                'JadwalChanges'=>DB::table('jadwal_change_detail')->where('IDJadwalChange',$item->IDJadwalChange)->get()
            ));
        }
        return response()->json($Changes);
    }
}

