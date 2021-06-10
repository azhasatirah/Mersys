<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotifController extends Controller
{
    public function notifAdmin(){
        $TMPNotif = DB::table('notif')->where('NotifTo','admin')
        ->where('IsRead',0)->get();
        $Notif=[];
        foreach($TMPNotif as $tnotif){
            $From ='';
            $PhotoProfile='https://mklm.org/wp-content/plugins/divi-eventmanager//assets/images/default.png';
            if($tnotif->NotifTo != 'admin'||
            $tnotif->NotifTo != 'owner'||
            $tnotif->NotifTo != 'tutor'||
            $tnotif->NotifTo != 'siswa'){
                $Karyawan = DB::table('karyawan')->where('UUID',$tnotif->NotifFrom)->get();
                $Siswa = DB::table('siswa')->where('UUID',$tnotif->NotifFrom)->get();
                $PhotoProfile = count($Karyawan)>0?$Karyawan[0]->PhotoProfile:$Siswa[0]->PhotoProfile;
                $From = count($Karyawan)>0?$Karyawan[0]->NamaKaryawan:$Siswa[0]->NamaSiswa;
            }else{
                $From = $tnotif->NotifTo;
            }
            array_push($Notif,array(
                'IDNotif'=>$tnotif->IDNotif ,
                'Notif'=>$tnotif->Notif ,
                'NotifFrom'=>$From,
                'NotifFromProfile'=>$PhotoProfile,
                'Link'=>$tnotif->Link,
                'Tanggal'=>$tnotif->created_at
            ));
        }
        return response()->json($Notif);
    }
    public function notifOwner(){
        $TMPNotif = DB::table('notif')->where('NotifTo','owner')
        ->where('IsRead',0)->get();
                $Notif=[];
        foreach($TMPNotif as $tnotif){
            $From ='';
            $PhotoProfile='https://mklm.org/wp-content/plugins/divi-eventmanager//assets/images/default.png';
            if($tnotif->NotifTo != 'admin'||
            $tnotif->NotifTo != 'owner'||
            $tnotif->NotifTo != 'tutor'||
            $tnotif->NotifTo != 'siswa'){
                $Karyawan = DB::table('karyawan')->where('UUID',$tnotif->NotifFrom)->get();
                $Siswa = DB::table('siswa')->where('UUID',$tnotif->NotifFrom)->get();
                $PhotoProfile = count($Karyawan)>0?$Karyawan[0]->PhotoProfile:$Siswa[0]->PhotoProfile;
                $From = count($Karyawan)>0?$Karyawan[0]->NamaKaryawan:$Siswa[0]->NamaSiswa;
            }else{
                $From = $tnotif->NotifTo;
            }
            array_push($Notif,array(
                'IDNotif'=>$tnotif->IDNotif ,
                'Notif'=>$tnotif->Notif ,
                'NotifFrom'=>$From,
                'NotifFromProfile'=>$PhotoProfile,
                'Link'=>$tnotif->Link,
                'Tanggal'=>$tnotif->created_at
            ));
        }
        return response()->json($Notif);
    }
    public function notifTutor(){
        $TMPNotif = DB::table('notif')->where('NotifTo','tutor')
        ->where('IsRead',0)->get();
                $Notif=[];
        foreach($TMPNotif as $tnotif){
            $From ='';
            $PhotoProfile='https://mklm.org/wp-content/plugins/divi-eventmanager//assets/images/default.png';
            if($tnotif->NotifTo != 'admin'||
            $tnotif->NotifTo != 'owner'||
            $tnotif->NotifTo != 'tutor'||
            $tnotif->NotifTo != 'siswa'){
                $Karyawan = DB::table('karyawan')->where('UUID',$tnotif->NotifFrom)->get();
                $Siswa = DB::table('siswa')->where('UUID',$tnotif->NotifFrom)->get();
                $PhotoProfile = count($Karyawan)>0?$Karyawan[0]->PhotoProfile:$Siswa[0]->PhotoProfile;
                $From = count($Karyawan)>0?$Karyawan[0]->NamaKaryawan:$Siswa[0]->NamaSiswa;
            }else{
                $From = $tnotif->NotifTo;
            }
            array_push($Notif,array(
                'IDNotif'=>$tnotif->IDNotif ,
                'Notif'=>$tnotif->Notif ,
                'NotifFrom'=>$From,
                'NotifFromProfile'=>$PhotoProfile,
                'Link'=>$tnotif->Link,
                'Tanggal'=>$tnotif->created_at
            ));
        }
        return response()->json($Notif);
    }
    public function notifSiswa(){
        $TMPNotif = DB::table('notif')->where('NotifTo','siswa')
        ->where('IsRead',0)->get();
                $Notif=[];
        foreach($TMPNotif as $tnotif){
            $From ='';
            $PhotoProfile='https://mklm.org/wp-content/plugins/divi-eventmanager//assets/images/default.png';
            if($tnotif->NotifTo != 'admin'||
            $tnotif->NotifTo != 'owner'||
            $tnotif->NotifTo != 'tutor'||
            $tnotif->NotifTo != 'siswa'){
                $Karyawan = DB::table('karyawan')->where('UUID',$tnotif->NotifFrom)->get();
                $Siswa = DB::table('siswa')->where('UUID',$tnotif->NotifFrom)->get();
                $PhotoProfile = count($Karyawan)>0?$Karyawan[0]->PhotoProfile:$Siswa[0]->PhotoProfile;
                $From = count($Karyawan)>0?$Karyawan[0]->NamaKaryawan:$Siswa[0]->NamaSiswa;
            }else{
                $From = $tnotif->NotifTo;
            }
            array_push($Notif,array(
                'IDNotif'=>$tnotif->IDNotif ,
                'Notif'=>$tnotif->Notif,
                'NotifFrom'=>$From,
                'NotifFromProfile'=>$PhotoProfile,
                'Link'=>$tnotif->Link,
                'Tanggal'=>$tnotif->created_at
            ));
        }
        return response()->json($Notif);
    }
    public function notifUser($id){
        $TMPNotif = DB::table('notif')->where('NotifTo',$id)
        ->where('IsRead',0)->get();
                $Notif=[];
        foreach($TMPNotif as $tnotif){
            $From ='';
            $PhotoProfile='https://mklm.org/wp-content/plugins/divi-eventmanager//assets/images/default.png';
            if($tnotif->NotifTo != 'admin'||
            $tnotif->NotifTo != 'owner'||
            $tnotif->NotifTo != 'tutor'||
            $tnotif->NotifTo != 'siswa'){
                $Karyawan = DB::table('karyawan')->where('UUID',$tnotif->NotifFrom)->get();
                $Siswa = DB::table('siswa')->where('UUID',$tnotif->NotifFrom)->get();
                $PhotoProfile = count($Karyawan)>0?$Karyawan[0]->PhotoProfile:$Siswa[0]->PhotoProfile;
                $From = count($Karyawan)>0?$Karyawan[0]->NamaKaryawan:$Siswa[0]->NamaSiswa;
            }else{
                $From = $tnotif->NotifTo;
            }
            array_push($Notif,array(
                'IDNotif'=>$tnotif->IDNotif ,
                'Notif'=>$tnotif->Notif ,
                'NotifFrom'=>$From,
                'NotifFromProfile'=>$PhotoProfile,
                'Link'=>$tnotif->Link,
                'Tanggal'=>$tnotif->created_at
            ));
        }
        return response()->json($Notif);
    }
    public function update($id){
        DB::table('notif')->where('IDNotif',$id)->update([
            'IsRead'=> 1,
        ]);
        return response()->json('readed');
    }
}
