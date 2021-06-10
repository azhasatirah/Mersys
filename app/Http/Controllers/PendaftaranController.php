<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use DB;

class PendaftaranController extends Controller
{
    //
    public function adminPendaftaranSiswa(){
        return view('karyawan.pendaftaran.admin.siswa');
    }

    public function change($Id){

    }

    public function adminGetDataPendaftaranSiswa(){
        $Siswa = Siswa::adminGetPendaftaranSiswa();
        $Data = [];
        foreach($Siswa['Siswa'] as $data){
            $Pembayaran = DB::table('bukti_pembayaran')
            ->join('pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->where('pembayaran.IDTransaksi',$data->IDTransaksi)->get();
            array_push($Data,array(
                'Alamat'=>$data->Alamat,
                'Email'=>$data->Email,
                'KodeSiswa'=>$data->KodeSiswa,
                'NamaSiswa'=>$data->NamaSiswa,
                'Status'=>$data->Status,
                'UUIDSiswa'=>$data->UUIDSiswa,
                'created_at'=>$data->created_at,
                'Pembayaran'=>$Pembayaran
            ));
        }
        return response()->json($Data);
    }

    public function ownerGetDataPendaftaranSiswa(){
        $Siswa = Siswa::ownerGetPendaftaranSiswa();
        $Data = [];
        foreach($Siswa['Siswa'] as $data){
            $Pembayaran = DB::table('bukti_pembayaran')
            ->join('pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->where('pembayaran.IDTransaksi',$data->IDTransaksi)->get();
            array_push($Data,array(
                'Alamat'=>$data->Alamat,
                'Email'=>$data->Email,
                'KodeSiswa'=>$data->KodeSiswa,
                'NamaSiswa'=>$data->NamaSiswa,
                'Status'=>$data->Status,
                'UUIDSiswa'=>$data->UUIDSiswa,
                'created_at'=>$data->created_at,
                'Pembayaran'=>$Pembayaran
            ));
        }
        return response()->json($Siswa);
    }
    public function ownerPendaftaranSiswa(){
        return view('karyawan.pendaftaran.owner.siswa');
    }
    
}
