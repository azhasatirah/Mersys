<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\KursusSiswa;
use App\Models\ProgramStudi;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;

class TransaksiController extends Controller
{
    //owner
    public function ownerIndex(){
        return view('karyawan.transaksi.owner.transaksi');
    }
    public function ownerGetTransaksi(){
        $Transaksi = DB::table('transaksi')
        ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
        ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
            'transaksi.Status','transaksi.UUID as UUIDTransaksi',
            'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('transaksi.Status','OPN')
        ->where('program_studi.IDProgram','!=',1)->get();
        
        $DataTransaksi=[];
        //dd($Transaksi);
        for($i=0;$i<count($Transaksi);$i++){
            $Pembayaran = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $PembayaranCFM = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CFM')
            ->get();
            $Cicilan = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
            $CicilanOPN = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $KodeStatus = count($Pembayaran)>0?'waitForAdmin':'waitForPayment';
            $Status = count($Pembayaran)>0?'Sedang dicek admin':'Menunggu pembayaran';
            $FinalCicilan = (count($Cicilan) - count($CicilanOPN))==0?1:count($Cicilan) - count($CicilanOPN);
            $FinalStatus = count($PembayaranCFM)>0?'Menunggu dicek owner':$Status;
            $FinalKodeStatus = count($PembayaranCFM)>0?'waitForOwner':$KodeStatus;
            array_push($DataTransaksi,
                array(
                    'KodeTransaksi'=> $Transaksi[$i]->KodeTransaksi,
                    'Total'=> $Transaksi[$i]->Total,
                    'SubTotal'=> $Transaksi[$i]->SubTotal,
                    'IDTransaksi'=> $Transaksi[$i]->IDTransaksi,
                    'UUIDTransaksi'=> $Transaksi[$i]->UUIDTransaksi,
                    'Hutang'=> $Transaksi[$i]->Hutang,
                    'created_at'=> $Transaksi[$i]->created_at,
                    'NamaSiswa'=> $Transaksi[$i]->NamaSiswa,
                    'NamaProdi'=>$Transaksi[$i]->NamaProdi,
                    'KodeStatus'=>$FinalKodeStatus,
                    'Status'=> $Transaksi[$i]->Hutang=='y'? $FinalStatus . '(Cicilan ke '. $FinalCicilan.')':$FinalStatus,
                )
            );
        }
        return response()->json($DataTransaksi);

    }
    public function ownerGetTransaksiSelesai(){
        $KasBank = DB::table('kas_bank')->get()->sum('Total');
        $TransaksiSelesai = DB::table('transaksi')->where('Status','CLS')->get();
        return view('karyawan.transaksi.transaksi',['KasBank'=>$KasBank,'TransaksiSelesai'=>count($TransaksiSelesai)]);
    }
    //transaksi halaman admin
    public function adminTransaksi(){
        return view('karyawan.transaksi.admin.transaksi');
    }
    public function adminTransaksiSelesai(){
        $KasBank = DB::table('kas_bank')->get()->sum('Total');
        $TransaksiSelesai = DB::table('transaksi')->where('Status','CLS')->get();
        return view('karyawan.transaksi.transaksi',
        ['KasBank'=>$KasBank,'TransaksiSelesai'=>count($TransaksiSelesai)]);
    }

    public function adminGetTransaksi(){
        $Transaksi = DB::table('transaksi')
        ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
        ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
            'transaksi.Status','transaksi.UUID as UUIDTransaksi',
            'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('transaksi.Status','OPN')
        ->where('program_studi.IDProgram','!=',1)->get();
        
        $DataTransaksi=[];
        //dd($Transaksi);
        for($i=0;$i<count($Transaksi);$i++){
            $Pembayaran = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $PembayaranCFM = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CFM')
            ->get();
            $Cicilan = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
            $CicilanOPN = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $KodeStatus = count($Pembayaran)>0?'waitForAdmin':'waitForPayment';
            $Status = count($Pembayaran)>0?'Menunggu dikonfirmasi admin':'Menunggu pembayaran';
            $FinalCicilan = (count($Cicilan) - count($CicilanOPN))==0?1:count($Cicilan) - count($CicilanOPN);
            $FinalStatus = count($PembayaranCFM)>0?'Sedang dicek Owner':$Status;
            $FinalKodeStatus = count($PembayaranCFM)>0?'waitForOwner':$KodeStatus;
            array_push($DataTransaksi,
                array(
                    'KodeTransaksi'=> $Transaksi[$i]->KodeTransaksi,
                    'Total'=> $Transaksi[$i]->Total,
                    'SubTotal'=> $Transaksi[$i]->SubTotal,
                    'IDTransaksi'=> $Transaksi[$i]->IDTransaksi,
                    'UUIDTransaksi'=> $Transaksi[$i]->UUIDTransaksi,
                    'Hutang'=> $Transaksi[$i]->Hutang,
                    'created_at'=> $Transaksi[$i]->created_at,
                    'NamaSiswa'=> $Transaksi[$i]->NamaSiswa,
                    'NamaProdi'=>$Transaksi[$i]->NamaProdi,
                    'KodeStatus'=>$FinalKodeStatus,
                    'Status'=> $Transaksi[$i]->Hutang=='y'? $FinalStatus . '(Cicilan ke '. $FinalCicilan.')':$FinalStatus,
                )
            );
        }
        return response()->json($DataTransaksi);

    }

    public function adminGetTransaksiSelesai(){
        $TransaksiSelesai = DB::table('transaksi')->where('Status','CLS')->get();
        return response()->json($TransaksiSelesai);
    }
    
    public function indexAdmin(){
        return view('karyawan.transaksi.admin.transaksi');
    }
    public function storeTransaksiPendaftaran(){
        $KodeKursus =str_replace('-','',str::uuid());
        $DataKursusSiswa = array(
            'UUID'=>$KodeKursus,
            'KodeKursus'=>'KSW-'.date('ymHis'),
            'IDProgram'=>1,
            'IDSiswa'=>session()->get('IDUser'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        KursusSiswa::storeKursusSiswa($DataKursusSiswa);
        $KursusSiswa = KursusSiswa::showKursusSiswa($KodeKursus);
        //dd($KursusSiswa,$KodeKursus);
        $IDKursusSiswa = $KursusSiswa['KursusSiswa'][0]->IDKursusSiswa;
        $Pendaftaran = ProgramStudi::getDetailProgramStudi(1);
        $Total = $Pendaftaran['ProgramStudi'][0]->Harga;
        $CountTransaksi = Transaksi::getAllTransaksi();
        if(strlen((string)count($CountTransaksi['Transaksi']))==1){
            $Urut = '00'.(count($CountTransaksi['Transaksi'])+1);
        }elseif(strlen((string)count($CountTransaksi['Transaksi']))==2){
            $Urut = '0'.(count($CountTransaksi['Transaksi'])+1);
        }else{
            $Urut = count($CountTransaksi['Transaksi'])+1;
        }
        $KodeTransaksi = "TRX-" . date("my").$Urut;
        $DataTransaksi = array(
            'UUID'=>str_replace('-','',str::uuid()),
            'KodeTransaksi'=>$KodeTransaksi,
            'IDKursusSiswa'=>$IDKursusSiswa,
            'IDSiswa'=>session()->get('IDUser'),
            'Tanggal'=>Carbon::now(),
            'Status'=>'OPN',
            'Diskon'=>0,
            'SubTotal'=>$Total,
            'Total'=>$Total,
            'Keterangan'=>'',
            'DiskonPersen'=>0,
            'PPN'=>'n',
            'NilaiPPN'=>0,
            'Hutang'=>'n',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $StatusTransaksi = Transaksi::storeTransaksi($DataTransaksi);
        if($StatusTransaksi['Status']=='success'){
            return response()->json('Transaksi pendaftaran telah dibuat');
        }

    }
    public function storeTransaksi(Request $request){
       // dd($request);
        $KodeKursus =str_replace('-','',str::uuid());
        $DataKursusSiswa = array(
            'UUID'=>$KodeKursus,
            'KodeKursus'=>'KSW-'.date('ymHis'),
            'IDProgram'=>$request->program,
            'IDSiswa'=>session()->get('IDUser'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        //dd($DataKursusSiswa);
        KursusSiswa::storeKursusSiswa($DataKursusSiswa);
        $KursusSiswa = KursusSiswa::showKursusSiswa($KodeKursus);
        //dd($KursusSiswa,$KodeKursus);
        $IDKursusSiswa = $KursusSiswa['KursusSiswa'][0]->IDKursusSiswa;
        $CountTransaksi = Transaksi::getAllTransaksi();
        $Prefix = $request->cicilan=='y'?"TRH-":"TRX-";
        if(strlen((string)count($CountTransaksi['Transaksi']))==1){
            $Urut = '00'.(count($CountTransaksi['Transaksi'])+1);
        }elseif(strlen((string)count($CountTransaksi['Transaksi']))==2){
            $Urut = '0'.(count($CountTransaksi['Transaksi'])+1);
        }else{
            $Urut = (count($CountTransaksi['Transaksi'])+1);
        }
        $KodeTransaksi = $Prefix . date("my").$Urut;
        $UUIDTransaksi =str_replace('-','',str::uuid());
        $DataTransaksi = array(
            'UUID'=>$UUIDTransaksi,
            'KodeTransaksi'=>$KodeTransaksi,
            'IDKursusSiswa'=>$IDKursusSiswa,
            'IDSiswa'=>session()->get('IDUser'),
            'IDCicilan'=>$request->idcicilan,
            'Tanggal'=>Carbon::now(),
            'Status'=>'OPN',
            'Diskon'=>0,
            'SubTotal'=>$request->harga,
            'Total'=>$request->harga,
            'Keterangan'=>'',
            'DiskonPersen'=>0,
            'PPN'=>'n',
            'NilaiPPN'=>0,
            'Hutang'=>$request->cicilan,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );
        $StatusTransaksi = Transaksi::storeTransaksi($DataTransaksi);
        if($StatusTransaksi['Status']=='success'){
            return redirect('/siswa/pembayaran/info/'.$UUIDTransaksi);
        }

    }

    //riwayat transaksi siswa
    public function pembelianSiswa(){
        // $Pembelian = Transaksi::getTransaksiByIDSiswa(session()->get('IDUser'));
        $Transaksi = DB::table('transaksi')
        ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
        ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
            'transaksi.Status','transaksi.UUID as UUIDTransaksi',
            'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('transaksi.IDSiswa',session()->get('IDUser'))->get();
        
        $DataTransaksi=[];
        //dd($Transaksi);
        for($i=0;$i<count($Transaksi);$i++){
            $Pembayaran = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $PembayaranCFM = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CFM')
            ->get();
            $PembayaranCLS = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $Cicilan = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
            $CicilanOPN = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $KodeStatus = count($Pembayaran)>0?'waitForAdmin':'waitForPayment';
            $Status = count($Pembayaran)>0?'Sedang dicek admin':'Menunggu pembayaran';
            $FinalCicilan = (count($Cicilan) - count($CicilanOPN))==0?1:count($Cicilan) - count($CicilanOPN);
            $FinalStatus = count($PembayaranCFM)>0?'Menunggu dicek owner':$Status;
            $EndStatus = count($PembayaranCLS)>0?'Selesai':$FinalStatus;
            $FinalKodeStatus = count($PembayaranCFM)>0?'waitForOwner':$KodeStatus;
            array_push($DataTransaksi,
                array(
                    'KodeTransaksi'=> $Transaksi[$i]->KodeTransaksi,
                    'Total'=> $Transaksi[$i]->Total,
                    'SubTotal'=> $Transaksi[$i]->SubTotal,
                    'IDTransaksi'=> $Transaksi[$i]->IDTransaksi,
                    'UUIDTransaksi'=> $Transaksi[$i]->UUIDTransaksi,
                    'Hutang'=> $Transaksi[$i]->Hutang,
                    'created_at'=> $Transaksi[$i]->created_at,
                    'NamaSiswa'=> $Transaksi[$i]->NamaSiswa,
                    'NamaProdi'=>$Transaksi[$i]->NamaProdi,
                    'KodeStatus'=>$FinalKodeStatus,
                    'Status'=> $Transaksi[$i]->Hutang=='y'? $EndStatus . '(Cicilan ke '. $FinalCicilan.')':$EndStatus,
                )
            );
        }
        //dd($DataTransaksi);
        return view('siswa.transaksi',['Transaksi'=>$DataTransaksi]);
    }
    public function getData(){
        $Transaksi = DB::table('transaksi')
        ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
        ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
            'transaksi.Status','transaksi.UUID as UUIDTransaksi',
            'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('transaksi.Status','CLS')->get();
        return response()->json($Transaksi);
    }
    public function show($id){
        $Transaksi = Transaksi::showTransaksi($id);
        //dd($Transaksi);
        return view('karyawan.transaksi.detail',['Transaksi'=>$Transaksi]);
    }
}
