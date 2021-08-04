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
        ->where('transaksi.Status','!=','DEL')
        ->where('transaksi.Status','!=','CLS')
        ->where('program_studi.IDProgram','!=',1)
        ->get();
        
        $DataTransaksi=[];
        //dd($Transaksi);
        for($i=0;$i<count($Transaksi);$i++){
            $AllPembayaran = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
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
            $PembayaranCLSWithnoBukti = DB::table('pembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $Cicilan = DB::table('pembayaran')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
            $CicilanCLS = DB::table('pembayaran')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $CicilanOPN = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $KodeStatus = count($Pembayaran)>0?'waitForAdmin':'waitForPayment';
            $Status = count($Pembayaran)>0?'Sedang dicek admin':'Menunggu pembayaran';
            $FinalCicilan = (count($Cicilan) - count($CicilanOPN))==0?1:count($Cicilan) - count($CicilanOPN);
            $FinalStatus = count($PembayaranCFM)>0?'Menunggu dicek owner':$Status;
            $EndStatus = count($PembayaranCLS)>0||count($PembayaranCLSWithnoBukti)>0?'Selesai':$FinalStatus;
            $FinalKodeStatus = count($PembayaranCFM)>0?'waitForOwner':$KodeStatus;
            $FinalStatusCicilan = 
           ( (count($CicilanOPN) == 0)&&
           ( count($AllPembayaran))>0&&
            (count($Cicilan) == count($CicilanCLS)))?
             'Selesai' :$EndStatus . ' (Cicilan ke '. $FinalCicilan.' dari '.count($Cicilan).')';
             //kunai
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
                    'Status'=> $Transaksi[$i]->Hutang=='y'?$FinalStatusCicilan :$EndStatus,
                )
            );
        }
        //dd($DataTransaksi);
        return response()->json($DataTransaksi);

    }
    public function ownerGetTransaksiSelesai(){
        $KasBank = DB::table('kas_bank')->get()->sum('Total');
        $TransaksiSelesai = DB::table('transaksi')->where('Status','CLS')->get();
        return view('karyawan.transaksi.owner.selesai',['KasBank'=>$KasBank,'TransaksiSelesai'=>count($TransaksiSelesai)]);
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
    public function ownerTransaksiExchange(){
        return view('karyawan.transaksi.owner.exchange');
    }
    public function ownerGetTransaksiExchange(){
        $Exchange = DB::table('transaksi as t')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','=','ks.IDKursusSiswa')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->select('t.*','s.NamaSiswa','ps.NamaProdi')
        ->where('KodeTransaksi','like','TREX-%')
        ->get();
        return response()->json([
            'TransaksiExchange'=>$Exchange
        ]);
    }
    public function ownerConfirmTransaksiExchange($id){
        $Transaksi = DB::table('transaksi')->where('IDTransaksi',$id)
        ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
        ->select('transaksi.*','siswa.UUID as UIDSiswa')
        ->get();
        DB::table('transaksi')->where('IDTransaksi',$id)->update([
            'Status'=>'CLS',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('pembayaran')->where('IDTransaksi',$id)->update([
            'Status'=>'CLS',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('kursus_siswa')->where('IDKursusSiswa',$Transaksi[0]->IDKursusSiswa)->update([
            'Status'=>'CLS',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('notif')->insert([
            'Notif'=> " Request pindah program anda di setujui oleh " .session()->get('Username'),
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=> $Transaksi[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/transaksi/',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        return response()->json('Dikonfirmasi');
    }
    public function adminTransaksiExchange(){
        return view('karyawan.transaksi.admin.exchange');
    }
    public function adminGetTransaksiExchange(){
        $TransaksiSelesai = DB::table('transaksi as t')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','=','ks.IDKursusSiswa')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->select(
            't.IDTransaksi','t.IDSiswa','t.IDCicilan','t.KodeTransaksi','t.created_at',
            't.Hutang','t.Total','s.NamaSiswa','s.KodeSiswa','ks.KodeKursus','ps.NamaProdi','ks.IDKursusSiswa'
        )
        ->where('t.Status','CLS')
        ->where('ps.IDProgram','!=',1)
        ->where('t.KodeTransaksi','like','TRX-%')
        ->get();
        //dd($TransaksiSelesai);
        $DataSelesai = [];
        foreach($TransaksiSelesai as $dat){
            $TotalPertemuan = DB::table('kursus_materi')->where('IDKursus',$dat->IDKursusSiswa)->get();
            $PertemuanTerakhir =DB::table('jadwal as j')
            ->join('kursus_materi as km','j.IDMateri','=','km.IDKursusMateri')
            ->join('absen_tutor as at','j.IDJadwal','=','at.IDJadwal')
            ->select('km.NoRecord','km.NamaMateri','at.updated_at')
            ->where('j.IDKursusSiswa',$dat->IDKursusSiswa)
            ->get();
            $Pembayaran = DB::table('pembayaran')
            ->where('Status','CLS')->where('IDTransaksi',$dat->IDTransaksi)->get();
            if(count($TotalPertemuan) > count($PertemuanTerakhir)){
                array_push($DataSelesai,array(
                    'IDTransaksi'=>$dat->IDTransaksi,
                    'IDSiswa'=>$dat->IDSiswa,
                    'IDCicilan'=>$dat->IDCicilan,
                    'KodeTransaksi'=>$dat->KodeTransaksi,
                    'created_at'=>$dat->created_at,
                    'Hutang'=>$dat->Hutang,
                    'Total'=>$dat->Total,
                    'TotalDibayar'=>$Pembayaran->sum('Total'),
                    'NamaSiswa'=>$dat->NamaSiswa,
                    'KodeSiswa'=>$dat->KodeSiswa,
                    'KodeKursus'=>$dat->KodeKursus,
                    'NamaProdi'=>$dat->NamaProdi,
                    'IDKursusSiswa'=>$dat->IDKursusSiswa,
                    'TotalPertemuan'=>count($TotalPertemuan),
                    'PertemuanTerakhir'=>$PertemuanTerakhir,
                ));
            }
        }
        $ProgramStudi = DB::table('program_studi')->where('Status','OPN')->get();
        $Exchange = DB::table('transaksi as t')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','=','ks.IDKursusSiswa')
        ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->select('t.*','s.NamaSiswa','ps.NamaProdi')
        ->where('KodeTransaksi','like','TREX-%')
        ->get();
        return response()->json([
            'TransaksiSelesai'=>$DataSelesai,
            'TransaksiExchange'=>$Exchange,
            'ProgramStudi'=>$ProgramStudi
        ]);
    }
    public function adminStoreTransaksiExchange(Request $request){
        $UIDKS =str_replace('-','',str::uuid());
        $UIDT =str_replace('-','',str::uuid());
        $UIDP =str_replace('-','',str::uuid());
        $TransaksiOld = DB::table('transaksi as t')
        ->join('pembayaran as p','t.IDTransaksi','=','p.IDTransaksi')
        ->select('p.IDMetodePembayaran')
        ->where('t.IDTransaksi',$request->IDTransaksi)->get();
        //data kursus siswa
        $DataKS = array(
            'UUID'=>$UIDKS,
            'KodeKursus'=>'KSW-'.date('ymHis'),
            'IDProgram'=>$request->IDProgram,
            'IDSiswa'=>$request->IDSiswa,
            'Status'=>'CFM',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('kursus_siswa')->insert($DataKS);
        $KS = DB::table('kursus_siswa')->where('UUID',$UIDKS)->get();
        //data transaksi
        $DataT = array(
            'UUID'=>$UIDT,
            'KodeTransaksi'=>$request->KodeTransaksi,
            'IDKursusSiswa'=>$KS[0]->IDKursusSiswa,
            'IDSiswa'=>$request->IDSiswa,
            'IDCicilan'=>0,
            'Tanggal'=>Carbon::now(),
            'Diskon'=>0,
            'Subtotal'=>$request->Total,
            'Total'=>$request->Total,
            'Keterangan'=>$request->Keterangan,
            'DiskonPersen'=>0,
            'PPN'=>'n',
            'NilaiPPN'=>0,
            'Hutang'=>'n',
            'Status'=>'CFM',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('transaksi')->insert($DataT);
        $T = DB::table('transaksi')->where('UUID',$UIDT)->get();
        //data pembayaran
        $DataP = array(
            'UUID'=>$UIDP,
            'KodePembayaran'=> "PAY-" . date("mmyyHis"),
            'IDMetodePembayaran'=>$TransaksiOld[0]->IDMetodePembayaran,
            'IDTransaksi'=>$T[0]->IDTransaksi,
            'Total'=>$request->Total,
            'NoUrut'=>1,
            'Status'=>'CFM',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        DB::table('pembayaran')->insert($DataP);
        DB::table('transaksi')->where('IDTransaksi',$request->IDTransaksi)->update([
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        DB::table('kursus_siswa')->where('IDKursusSiswa',$request->IDKursusSiswa)->update([
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        return response()->json('berhasil di ganti');
    }
    public function adminDeleteTransaksi($id){
        DB::table('transaksi')->where('IDTransaksi',$id)->update([
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        $Transaksi = DB::table('transaksi')->where('IDTransaksi',$id)->get();
        DB::table('kursus_siswa')->where('IDKursusSiswa',$Transaksi[0]->IDKursusSiswa)->update([
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now()
        ]);
        return response()->json('Transaksi berhasil dihapus');  
    }
    public function adminGetTransaksi(){
        $Transaksi = DB::table('transaksi')
        ->join('siswa','transaksi.IDSiswa','=','siswa.IDSiswa')
        ->join('kursus_siswa','transaksi.IDKursusSiswa','=','kursus_siswa.IDKursusSiswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi','kursus_siswa.KodeKursus',
            'transaksi.Status','transaksi.UUID as UUIDTransaksi','program_studi.IDProgram','transaksi.IDCicilan','transaksi.Diskon','transaksi.PPN',
            'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('transaksi.Status','!=','DEL')
        ->where('transaksi.Status','!=','CLS')
        ->where('program_studi.IDProgram','!=',1)
        ->get();
        
        $DataTransaksi=[];
        //dd($Transaksi);
        for($i=0;$i<count($Transaksi);$i++){
            $AllPembayaran = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
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
            $PembayaranCLSWithnoBukti = DB::table('pembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $Cicilan = DB::table('pembayaran')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
            $CicilanCLS = DB::table('pembayaran')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $CicilanOPN = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $KodeStatus = count($Pembayaran)>0?'waitForAdmin':'waitForPayment';
            $Status = count($Pembayaran)>0?'Sedang dicek admin':'Menunggu pembayaran';
            $FinalCicilan = (count($Cicilan) - count($CicilanOPN))==0?1:count($Cicilan) - count($CicilanOPN);
            $FinalStatus = count($PembayaranCFM)>0?'Menunggu dicek owner':$Status;
            $EndStatus = count($PembayaranCLS)>0||count($PembayaranCLSWithnoBukti)>0?'Selesai':$FinalStatus;
            $FinalKodeStatus = count($PembayaranCFM)>0?'waitForOwner':$KodeStatus;
            $FinalStatusCicilan = 
           ( (count($CicilanOPN) == 0)&&
           ( count($AllPembayaran))>0&&
            (count($Cicilan) == count($CicilanCLS)))?
             'Selesai' :$EndStatus . ' (Cicilan ke '. $FinalCicilan.' dari '.count($Cicilan).')';
             //kunai
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
                    'IDProgram'=>$Transaksi[$i]->IDProgram,
                    'IDCicilan'=>$Transaksi[$i]->IDCicilan,
                    'KodeStatus'=>$FinalKodeStatus,
                    'Diskon'=>$Transaksi[$i]->Diskon,
                    'ppn'=>$Transaksi[$i]->PPN,
                    'Status'=> $Transaksi[$i]->Hutang=='y'?$FinalStatusCicilan :$EndStatus,
                    'Cicilan'=>count($CicilanCLS),
                    'KodeKursus'=>$Transaksi[$i]->KodeKursus
                )
            );
        }
        $ProgramStudi = DB::table('program_studi')->where('IDProgram','!=',1)->where('Status','OPN')->get();
        $Cicilan = DB::table('cicilan')->where('Status','OPN')->get();
        //dd($DataTransaksi);
        return response()->json([$DataTransaksi,$ProgramStudi,$Cicilan]);

    }
    public function adminUpdateTransaksi(Request $request){
        $Transaksi = DB::table('transaksi as t')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','=','ks.IDKursusSiswa')
        ->select('ks.IDProgram','ks.IDKursusSiswa')
        ->where('t.KodeTransaksi',$request->kodetransaksi)->get();
        if($Transaksi[0]->IDProgram == $request->programstudi){
            $DataTransaksi = array(
                'Hutang'=>$request->cicilan,
                'IDCicilan'=>$request->Cicilan == 'y'?$request->idcicilan:0,
                'Diskon'=>$request->diskon,
                'PPN'=>$request->ppn,
                'NilaiPPN'=>$request->ppn == 'y'? $request->subtotal*10/100:0,
                'SubTotal'=>$request->subtotal,
                'Total'=>$request->total
            );
            DB::table('transaksi')->where('KodeTransaksi',$request->kodetransaksi)->update($DataTransaksi);
        }
        else{
            $DataTransaksi = array(
                'Hutang'=>$request->cicilan,
                'IDCicilan'=>$request->Cicilan == 'y'?$request->idcicilan:0,
                'Diskon'=>$request->diskon,
                'PPN'=>$request->ppn,
                'NilaiPPN'=>$request->ppn == 'y'? $request->subtotal*10/100:0,
                'SubTotal'=>$request->subtotal,
                'Total'=>$request->total,
                'UserUpd'=>session()->get('Username'),
                'updated_at'=>Carbon::now()
            );
            $DataKursus = array(
                'IDProgram'=>$request->programstudi,
                'UserUpd'=>session()->get('Username'),
                'updated_at'=>Carbon::now()
            );
            DB::table('kursus_siswa')->where('IDKursusSiswa',$Transaksi[0]->IDKursusSiswa)->update($DataKursus);
            DB::table('transaksi')->where('KodeTransaksi',$request->kodetransaksi)->update($DataTransaksi);
        }
        return response()->json('Transaksi berhasil di ubah');
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
        //dd($Pendaftaran);
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
        $ProgramStudi = DB::table('program_studi')->where('IDProgram',$request->program)->get();
        $KeyProgramStudi = $ProgramStudi[0]->IDKategoriGlobalProgram == 2?explode('(Bulanan-',$ProgramStudi[0]->NamaProdi):false;
        if($ProgramStudi[0]->IDKategoriGlobalProgram==2&&intVal($KeyProgramStudi[1][0])!=1){
            $isValid = false;
            $KursusBulananSiswa = DB::table('kursus_siswa as ks')
            ->join('program_studi as ps','ks.IDProgram','=','ps.IDProgram')
            ->where('ps.NamaProdi','like',$KeyProgramStudi[0].'(bulanan-%')
            ->where('ks.IDSiswa',session()->get('IDUser'))
            ->where('ks.Status','!=','DEL')
            ->select('ks.*','ps.NamaProdi')
            ->get();
           // dd($KursusBulananSiswa->toArray());
            if(count($KursusBulananSiswa)==0){
                $isValid== true;
            }
            if(count($KursusBulananSiswa)>0){
                $LastBulanan = intval($KeyProgramStudi[1][0])-1;
                $isValid = array_reduce($KursusBulananSiswa->toArray(), function($isBigger, $num) use($LastBulanan){
                    return $isBigger || intval(explode('Bulanan-',$num->NamaProdi)[1][0]) == $LastBulanan;
                });
            }
            if($isValid==false){
                return redirect()->back()->with('msg','Tidak bisa mengambil program bulanan ini, karena anda belum belajar bulanan ke '.$LastBulanan);
            }
            
        }
     
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
            'Diskon'=>$request->diskon,
            'SubTotal'=>$request->harga,
            'Total'=>$request->harga - $request->diskon,
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
        DB::table('notif')->insert([
            'Notif'=> session()->get('NamaUser'). " membuat transaksi ".$KodeTransaksi,
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=> 'owner',
            'IsRead'=>false,
            'Link'=>'/karyawan/owner/transaksi',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        DB::table('notif')->insert([
            'Notif'=> session()->get('NamaUser'). " membuat transaksi ".$KodeTransaksi,
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=> 'admin',
            'IsRead'=>false,
            'Link'=>'/karyawan/admin/transaksi',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        if($request->iddiskon!=0){
            $Diskon = DB::table('diskon')->where('IDDiskon',$request->iddiskon)->get();
            DB::table('diskon')->where('IDDiskon',$request->iddiskon)->update([
                'Status'=>'DEL'
            ]);
            DB::table('notif')->insert([
                'Notif'=> "Diskon ".$Diskon[0]->KodeDiskon.", Telah digunakan ".session()->get('NamaUser'),
                'NotifFrom'=> session()->get('UID'),
                'NotifTo'=> 'admin',
                'IsRead'=>false,
                'Link'=>'/karyawan/admin/diskon',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
        }
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
        ->where('transaksi.IDSiswa',session()->get('IDUser'))->where('transaksi.Status','!=','DEL')->get();
        
        $DataTransaksi=[];
        //dd($Transaksi);
        for($i=0;$i<count($Transaksi);$i++){
            $AllPembayaran = DB::table('pembayaran')
            ->join('bukti_pembayaran','pembayaran.IDPembayaran','=','bukti_pembayaran.IDPembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
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
            $PembayaranCLSWithnoBukti = DB::table('pembayaran')
            ->select('pembayaran.*')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $Cicilan = DB::table('pembayaran')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->get();
            $CicilanCLS = DB::table('pembayaran')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','CLS')
            ->get();
            $CicilanOPN = DB::table('pembayaran')->where('pembayaran.Status','OPN')
            ->where('pembayaran.IDTransaksi','=',$Transaksi[$i]->IDTransaksi)
            ->where('pembayaran.Status','OPN')
            ->get();
            $KodeStatus = count($Pembayaran)>0?'waitForAdmin':'waitForPayment';
            $Status = count($Pembayaran)>0?'Sedang dicek admin':'Menunggu pembayaran';
            $FinalCicilan = (count($Cicilan) - count($CicilanOPN))==0?1:count($Cicilan) - count($CicilanOPN);
            $FinalStatus = count($PembayaranCFM)>0?'Menunggu dicek owner':$Status;
            $EndStatus = count($PembayaranCLS)>0||count($PembayaranCLSWithnoBukti)>0?'Selesai':$FinalStatus;
            $FinalKodeStatus = count($PembayaranCFM)>0?'waitForOwner':$KodeStatus;
            $FinalStatusCicilan = 
           ( (count($CicilanOPN) == 0)&&
           ( count($AllPembayaran))>0&&
            (count($Cicilan) == count($CicilanCLS)))?
             'Selesai' :$EndStatus . ' (Cicilan ke '. $FinalCicilan.')';
             //kunai
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
                    'Status'=> $Transaksi[$i]->Hutang=='y'?$FinalStatusCicilan :$EndStatus,
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
            'transaksi.Status','transaksi.UUID as UUIDTransaksi','kursus_siswa.KodeKursus',
            'transaksi.Hutang','transaksi.created_at','siswa.NamaSiswa','program_studi.NamaProdi')
        ->where('transaksi.Status','CLS')->get();
        return response()->json($Transaksi);
    }
    public function show($id){
        $Transaksi = Transaksi::showTransaksi($id);
        //dd($Transaksi);
        return view('karyawan.transaksi.detail',['Transaksi'=>$Transaksi]);
    }
    public function transaksiExpired(){
        //transactions phase
        //phase1 transaction opn without payment (expired able)
        //phase2 transaction opn with payment opn (expired able)
        //phase3 transaction opn with payment opn with proof of payment opn
        //phase4 transaction opn with payment opn with proof of payment cfm
        //phase5 transaction opn with payment opn with proof of payment cls
        //phase0 transaction opn with some cfm payments
        //phase00 transaction opn with opn payments with some proof of payment any
        $TransaksiOPN = DB::table('transaksi')->where('IDSiswa',session()->get('IDUser'))
        ->where('Status','OPN')->get();
        //more than 86 400 000 expired
        $now = strtotime(date('Y-m-d H:m:s'))*1000;
     //   return response()->json($TransaksiOPN);
  
        $expired_tr = array_filter($TransaksiOPN->toArray(),function($var) use($now){
            $tr_expiredable = false;
            $pembayaran = DB::table('pembayaran')
            ->where('Status','!=','DEL')
            ->where('IDTransaksi',$var->IDTransaksi)->get();
            //dd($pembayaran);
            //return response()->json($pembayaran);
            if(count($pembayaran)>0){

                if(count($pembayaran)==1){
                    $bukti_p = DB::table('bukti_pembayaran')->where('IDPembayaran',$pembayaran[0]->IDPembayaran)->get();
                    if(count($bukti_p)>0){
                        if($bukti_p[0]->Status == 'OPN'){
                            $tr_expiredable = false;
                        }
                        if($bukti_p[0]->Status == 'CFM'){
                            $tr_expiredable = false;
                        }
                        if($bukti_p[0]->Status == 'CLS'){
                            $tr_expiredable = false;
                        }
                    }
                    if(count($bukti_p)==0){
                        $tr_expiredable = true;
                    }
                }
                if(count($pembayaran)>1){
                    $isPhase0 = array_reduce($pembayaran->toArray(), function($isBigger, $phase0){
                        return $isBigger || $phase0 == 'CFM';
                    });
                    //dd($isPhase0);
                    if($isPhase0==false){
                        $isPhase00 = array_reduce($pembayaran->toArray(), function($isBigger, $phase00){
                            $bukti_p00 = DB::table('bukti_pembayaran')->where('IDPembayaran',$phase00->IDPembayaran)->get();
                          
                            return $isBigger || count($bukti_p00)>0;
                        });
                        if($isPhase00==true){
                            $tr_expiredable = false;
                        }
                        if($isPhase00==false){
                            $tr_expiredable=true;
                        }

                    }

                    if($isPhase0==true){
                        $tr_expiredable = false;

                    }
                   // var_dump($tr_expiredable);

                }
            }
            if(count($pembayaran)==0){
                $tr_expiredable = true;
            }
            $created=  strtotime($var->created_at)*1000;
            $tr_expired = (($created-$now)*-1)>=86000000;
           // dd($now,$created,$var->created_at,$tr_expired,(($created-$now)*-1));
            return $tr_expired && $tr_expiredable;
        });
        //dd($debug);
        foreach($expired_tr as $f){
            DB::table('transaksi')->where('IDTransaksi',$f->IDTransaksi)->update(array(
                'Keterangan'=>'Transaksi expired',
                'UserUpd'=>'system',
                'updated_at'=>Carbon::now(),
                'Status'=>'DEL'
            ));
        }
        return response($expired_tr);


    }
}
