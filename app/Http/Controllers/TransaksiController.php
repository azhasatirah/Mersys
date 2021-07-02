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
        ->select('transaksi.KodeTransaksi','transaksi.Total','transaksi.SubTotal','transaksi.IDTransaksi',
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
                    'Cicilan'=>count($CicilanCLS)
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
