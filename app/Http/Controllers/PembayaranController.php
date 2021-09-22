<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\Bank;
use App\Models\Siswa;
use App\Models\Cicilan;
use DB;
use App\Models\KursusSiswa;
use App\Models\BuktiPembayaran;
use Illuminate\support\str;
use Illuminate\support\Carbon;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    //
    public function index(){
        return view('siswa.pembayaran.info');
    }
    //redirect pembayaran sesuai phase transaksi
    public function info($Kode){

        $Data = $this->getDetailTransaksi($Kode);
        $Transaksi = $Data[0];
        $Pembayaran = $Data[1];
        //----------- init phase transaksi --------------
        $phase1 = count($Pembayaran)===0;
        $phase2 = count($Pembayaran)>0?
        array_reduce($Pembayaran,function($con,$item){
            return $con && count($item['BuktiPembayaran'])===0;
        },true):false;
        $phase3 = count($Pembayaran)>0?
        array_reduce($Pembayaran,function($con,$item){
            return $con || count($item['BuktiPembayaran'])>0;
        },false):false;
        //----------------------REDIRECT sesuai phase---------------------------
        //phase 3 telah melakukan pembayaran pertama
        if($phase3){
            return view('siswa.pembayaran.rincian',[
                'Transaksi'=>$Transaksi,
                'Pembayaran'=>$Pembayaran
            ]);
        }
        //phase 2 pembayaran peratama
        if($phase2){
            $FirstPembayaran = array_filter($Pembayaran,function($item){
                return $item['NoUrut']===1;
            });
            if(count($FirstPembayaran)>0){
                return redirect('siswa/pembayaran/metode/bank/'.$FirstPembayaran[0]['UUIDPembayaran']);
            }
            dd("opss! something went wrong x_x");
        }
        //phase 1 belum memilih metode pembayaran
        if($phase1){
            return  redirect('siswa/pembayaran/detail/'.$Transaksi[0]->UUID);
        }
    }
    public function detail($Kode){
        $Transaksi=Transaksi::showTransaksi($Kode);
        $CekPembayaran = Pembayaran::showPembayaranByKodeTransaksi($Kode);
        $Bank = Bank::getAllBank();
        $Data = [
            'Pembayaran'=>$Transaksi['Transaksi'],
            'Bank'=>$Bank['Bank']
        ];
        if($Transaksi['Transaksi'][0]->Hutang=='y'){
            $Cicilan = DB::table('cicilan')->where('IDCicilan',$Transaksi['Transaksi'][0]->IDCicilan)->get();
            $Data = [
                'Pembayaran'=>$Transaksi['Transaksi'],
                'Bank'=>$Bank['Bank'],
                'Cicilan'=>$Cicilan
            ];
        }
        return view('siswa.pembayaran.info',$Data);
    }

    //Halaman metode pembayaran
    public function metode($Kode){
        $Transaksi=Transaksi::showTransaksi($Kode);
        $Metode = MetodePembayaran::getAllMetodePembayaran();
        $CekPembayaran = Pembayaran::showPembayaranByKodeTransaksi($Kode);
        if(count($CekPembayaran)>0){
            $Pembayaran = Pembayaran::getDetailPembayaran($CekPembayaran[0]->UUIDPembayaran);
            $Bank = Bank::getAllBank();
            return view('siswa.pembayaran.metode_bank',[
                'Pembayaran'=>$Pembayaran,
                'Bank'=>$Bank['Bank'],
            ]);
        }else{
            return view('siswa.pembayaran.metode',[
                'Pembayaran'=>$Transaksi['Transaksi'],
                'Metode'=>$Metode['MetodePembayaran'],
                'KodeTransaksi'=>$Kode
            ]);
        }
    }

    //Store pembayaran setelah mamilih metode
    public function store(Request $request){
        //dd($request);
        $KodePembayaran = "PAY-" . date("mmyyHis");
        $Data = array(
            'UUID'=>str_replace('-','',str::uuid()),
            'KodePembayaran'=>$KodePembayaran,
            'IDTransaksi'=>$request->pembayaran,
            'IDMetodePembayaran'=>$request->metode,
            'Total'=>'',
            'NoUrut'=>'',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'Status'=>'OPN'
        );

        $Status = Pembayaran::storePembayaran($Data);
        return response()->json($Status);
    }
    public function createMetodeBank($UUID){
        //kunai
        $IsPendaftaran = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','ks.IDKursusSiswa')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->select('t.IDTransaksi','t.Total as TotalTr','ks.IDProgram','p.Total as TotalPay','p.created_at as TanggalHarus','s.UUID as UIDSiswa','t.Hutang')
        ->where('p.UUID',$UUID)->get();
        //dd($IsPendaftaran);
        $DendanTelatCicilan = DB::table('master_denda_keterlambatan_cicilan')
        ->where('Status','!=','DEL')
        ->orderBy('range_from')->get();
        //dd($DendanTelatCicilan);
        $tglharus = date(
            'Y-M-d H:i:s',
            strtotime('+'.$DendanTelatCicilan[0]->range_from.' days',
            strtotime($IsPendaftaran[0]->TanggalHarus))
        );
        $Denda=[];

        $Timepay = (strtotime(date('Y-m-d H:i:s'))*1000) - (strtotime(date('Y-M-d H:i:s'))*1000) ;
        if($IsPendaftaran[0]->Hutang=='y'&&$Timepay>=(86000000*$DendanTelatCicilan[0]->range_from)){
            //dd('kei');
            $Denda = array_filter($DendanTelatCicilan->toArray(),function($dat) use($Timepay){
                return ($dat->range_from*86000000)<=$Timepay && ($dat->range_to*86000000)>=$Timepay;
            // return true;
            });
            if(count($Denda)>0){
                $old_total = $IsPendaftaran[0]->TotalPay;
                $denda = ($old_total *$Denda[0]->denda/100);
                DB::table('pembayaran')->where('UUID',$UUID)->update([
                    'Total'=>$denda+$old_total,
                    'UserUpd'=>'system denda cicilan'
                ]);
                DB::table('transaksi')->where('IDTransaksi',$IsPendaftaran[0]->IDTransaksi)->update([
                    'Total'=>$IsPendaftaran[0]->TotalTr+$denda,
                    'UserUpd'=>'system denda cicilan'
                ]);
            }
        }
        $Pembayaran = Pembayaran::getDetailPembayaran($UUID);
        $Bank = Bank::getAllBank();
        //dd($Pembayaran);
        return view('siswa.pembayaran.metode_bank',[
            'MasterDenda'=>$DendanTelatCicilan,
            'Pembayaran'=>$Pembayaran,
            'Bank'=>$Bank['Bank'],
        ]);
    }
    public function storePembayaranBank(Request $request){
        $Transaksi = Transaksi::showTransaksi($request->transaksi);
        $Metode = MetodePembayaran::showMetodePembayaran($request->metode);
        $KodePembayaran = "PAY-" . date("myHis");
        $UUIDPembayaran = str_replace('-','',str::uuid());
        if($Transaksi['Transaksi'][0]->Hutang=='y'){
            $Cicilan = DB::table('cicilan')
            ->select('cicilan.Cicilan','cicilan.Harga')
            ->where('cicilan.IDCicilan',$Transaksi['Transaksi'][0]->IDCicilan)
            ->get();
            $TransaksiTambahan = $Transaksi['Transaksi'][0]->Total - $Cicilan[0]->Harga;
            $UUIDPembayaranPertama=str_replace('-','',str::uuid());
            //dd($Cicilan,$UUIDPembayaranPertama,$Transaksi['Transaksi'][0]->IDTransaksi);
            for($i =0;$i < $Cicilan[0]->Cicilan;$i++){
                $Harga = $i === 0 ? $Cicilan[0]->Harga / $Cicilan[0]->Cicilan+$TransaksiTambahan:$Cicilan[0]->Harga / $Cicilan[0]->Cicilan;
                $tang = $i==0? date('Y-m-d H:i') : date('Y-m-d H:i',strtotime('+'.($i*14).' days'));
                $Data = array(
                    'UUID'=>$i==0?$UUIDPembayaranPertama:str_replace('-','',str::uuid()),
                    'KodePembayaran'=>"PAY-" . date("mHis").$i,
                    'IDTransaksi'=>$Transaksi['Transaksi'][0]->IDTransaksi,
                    'IDMetodePembayaran'=>$request->metode,
                    'Total'=>$Harga,
                    'NoUrut'=>$i+1,
                    'created_at'=>$tang,
                    'updated_at'=>Carbon::now(),
                    'UserAdd'=>session()->get('Username'),
                    'UserUpd'=>session()->get('Username'),
                    'Status'=>'OPN'
                );
                $Status = Pembayaran::storePembayaran($Data);
            }
            return redirect('/siswa/pembayaran/metode/bank/'.$UUIDPembayaranPertama);
        }else{

            $Data = array(
                'UUID'=>$UUIDPembayaran,
                'KodePembayaran'=>$KodePembayaran,
                'IDTransaksi'=>$Transaksi['Transaksi'][0]->IDTransaksi,
                'IDMetodePembayaran'=>$request->metode,
                'Total'=>$Transaksi['Transaksi'][0]->Total,
                'NoUrut'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'UserAdd'=>session()->get('Username'),
                'UserUpd'=>session()->get('Username'),
                'Status'=>'OPN'
            );
            $Status = Pembayaran::storePembayaran($Data);
        }
        return redirect('/siswa/pembayaran/metode/bank/'.$UUIDPembayaran);
    }
    public function storeBuktiPembayaran(Request $request){
        //kunai
        date_default_timezone_set('Asia/Jakarta');
        $IsPendaftaran = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','ks.IDKursusSiswa')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->select('t.IDTransaksi','t.Total as TotalTr','ks.IDProgram','p.Total as TotalPay','p.created_at as TanggalHarus','s.UUID as UIDSiswa','t.Hutang')
        ->where('p.IDPembayaran',$request->idpembayaran)->get();
        $DendanTelatCicilan = DB::table('master_denda_keterlambatan_cicilan')
        ->where('Status','!=','DEL')
        ->orderBy('range_from')->get();
       // dd($DendanTelatCicilan[0]->range_from,$IsPendaftaran[0]->TanggalHarus);


       // dd($IsPendaftaran);
        $File = $request->file('file');
        $FormatFile = $File->getClientOriginalExtension();
        $BuktiFoto = 'PIMG'.date('dmyhis').'.'.$FormatFile;
        $Status = $request->file('file')->move(public_path('images/BuktiPembayaran'),$BuktiFoto);
        $Data = array(
            'IDPembayaran'=>$request->idpembayaran,
            'NamaRekening'=>$request->namarekening,
            'NoRekening'=>$request->norekening,
            'Bank'=>$request->bank,
            'JumlahDitransfer'=> $request->jumlah,
            'BuktiFoto'=>$BuktiFoto,
            'Status'=>'OPN',
            'UserAdd'=>session()->get('Username'),
            'UserUpd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        );
        $Status = BuktiPembayaran::storeBuktiPembayaran($Data);

        if($IsPendaftaran[0]->IDProgram != 1){
            $Pembayaran = DB::table('pembayaran as p')
            ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
            ->where('p.IDPembayaran',$request->idpembayaran)
            ->select('p.KodePembayaran','t.UUID')->get();
            DB::table('notif')->insert([
                'Notif'=> session()->get('Username')." mengupload bukti pembayaran untuk pembayaran ".$Pembayaran[0]->KodePembayaran,
                'NotifFrom'=> session()->get('UID'),
                'NotifTo'=>'admin',
                'IsRead'=>false,
                'Link'=>'/karyawan/admin/transaksi/detail/'.$Pembayaran[0]->UUID,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
            //broadcast(new \App\Events\NotifEvent('admin'));
        }else{
            DB::table('notif')->insert([
                'Notif'=> session()->get('Username')." mengupload bukti pembayaran untuk pendaftaran siswa",
                'NotifFrom'=> $IsPendaftaran[0]->UIDSiswa,
                'NotifTo'=>'admin',
                'IsRead'=>false,
                'Link'=>'/karyawan/admin/pendaftaran/siswa/pembayaran/'.$IsPendaftaran[0]->UIDSiswa,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
            //broadcast(new \App\Events\NotifEvent('admin'));
        }

        return redirect('/siswa/transaksi')->withErrors($Status['Pesan']);
    }


    //halaman detail pembayaran pendaftaran di admin
    public function adminDetailPembayaranPendaftaran($ID)
    {
        $Pembayaran = Pembayaran::getDetailPembayaranBySiswa($ID);
        //dd($Pembayaran['Pembayaran']);
        return view('karyawan.pendaftaran.admin.rincian',['Pembayaran'=>$Pembayaran]);
    }

    //konfirmasi pembayaran pendaftaran di admin
    public function adminKonfirmasiPendaftaran(Request $request){
        $Siswa = array(
            'siswa.Status'=>'CFM',
            'siswa.UserUpd'=>session()->get('Username'),
            'siswa.updated_at'=>Carbon::now(),
        );
        $Pembayaran = array(
            'Status'=>'CFM',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        $Transaksi = array(
            'transaksi.Status'=>'CFM',
            'transaksi.UserUpd'=>session()->get('Username'),
            'transaksi.updated_at'=>Carbon::now(),
        );
        Siswa::changeStatusByKodePembayaran($request->pembayaran,$Siswa);
        Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$Pembayaran);
        Transaksi::changeStatusByKodePembayaran($request->pembayaran,$Transaksi);
        $DataNotif = DB::table('siswa')
        ->join('kursus_siswa','siswa.IDSiswa','=','kursus_siswa.IDSiswa')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)
        ->select('siswa.KodeSiswa','siswa.UUID as UIDSiswa')
        ->get();
        DB::table('notif')->insert([
            'Notif'=> session()->get('Username').' Telah mengkonfirmasi pendaftaran siswa ' . $DataNotif[0]->KodeSiswa,
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>'owner',
            'IsRead'=>false,
            'Link'=>'/karyawan/owner/pendaftaran/siswa/pembayaran/'.$DataNotif[0]->UIDSiswa,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent('owner'));
        return redirect('karyawan/admin/pendaftaran/siswa');

    }

    //halaman detail pembayaran pembayaran di owner
    public function ownerDetailPembayaranPendaftaran($ID)
    {
        $Pembayaran = Pembayaran::getDetailPembayaranBySiswa($ID);
        //dd($Pembayaran['Pembayaran']);
        return view('karyawan.pendaftaran.owner.rincian',['Pembayaran'=>$Pembayaran]);
    }

    //konfirmasi pembayaran pendaftaran owner
    public function ownerKonfirmasiPendaftaran(Request $request){
        $Siswa = array(
            'siswa.Status'=>'CLS',
            'siswa.UserUpd'=>session()->get('Username'),
            'siswa.updated_at'=>Carbon::now(),
        );
        $Pembayaran = array(
            'Status'=>'CLS',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        $Transaksi = array(
            'transaksi.Status'=>'CLS',
            'transaksi.UserUpd'=>session()->get('Username'),
            'transaksi.updated_at'=>Carbon::now(),
        );
        $KursusSiswa = array(
            'kursus_siswa.Status'=>'CLS',
            'transaksi.UserUpd'=>session()->get('Username'),
            'transaksi.updated_at'=>Carbon::now(),
        );
        $KodeKasBank = "KBK-" . date("myHis");
        $DataPembayaran = DB::table('pembayaran')
        ->where('KodePembayaran',$request->pembayaran)
        ->get();
        $KasBank = array(
            'KodeKasBank'=>$KodeKasBank,
            'IDPembayaran'=>$DataPembayaran[0]->IDPembayaran,
            'Total'=>$DataPembayaran[0]->Total,
            'Keterangan'=>'Pembyaran '.$DataPembayaran[0]->KodePembayaran,
            'Status'=>'OPN',
            'UserUpd'=>session()->get('Username'),
            'UserAdd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'Tanggal'=>Carbon::now(),

        );
        Siswa::changeStatusByKodePembayaran($request->pembayaran,$Siswa);
        Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$Pembayaran);
        Transaksi::changeStatusByKodePembayaran($request->pembayaran,$Transaksi);
        DB::table('kursus_siswa')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)
        ->update($KursusSiswa);
        DB::table('kas_bank')->insert($KasBank);
        $DataNotif =    DB::table('siswa')
        ->join('kursus_siswa','siswa.IDSiswa','=','kursus_siswa.IDSiswa')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->select('siswa.UUID as UIDSiswa')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)->get();
        DB::table('notif')->insert([
            'Notif'=> 'Pendaftaran anda telah berhasil',
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$DataNotif[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\PendaftaranEvent($DataNotif[0]->UIDSiswa));
        return redirect('karyawan/owner/pendaftaran/siswa');

    }

    //halaman detail pembayaran di admin
    public function adminDetailPembayaran($ID)
    {
        $Data = $this->getDetailTransaksi($ID);
        $Transaksi = $Data[0];
        $Pembayaran = $Data[1];
        return view('karyawan.transaksi.admin.rincian',[
            'Transaksi'=>$Transaksi,
            'Pembayaran'=>$Pembayaran
        ]);
    }

    //konfirmasi pembayaran di admin
    public function adminConfirm($KodePembayaran){
        $Pembayaran = array(
            'Status'=>'CFM',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        Pembayaran::changeStatusByKodePembayaran($KodePembayaran,$Pembayaran);
        // pembayaran2 for notif data
        $Pembayaran2 = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->where('p.KodePembayaran',$KodePembayaran)
        ->select('p.KodePembayaran','t.UUID')->get();
        DB::table('notif')->insert([
            'Notif'=> session()->get('Username')." mengkonfirmasi bukti pembayaran untuk pembayaran ".$Pembayaran2[0]->KodePembayaran,
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>'owner',
            'IsRead'=>false,
            'Link'=>'/karyawan/owner/transaksi/detail/'.$Pembayaran2[0]->UUID,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent('owner'));
        return response()->json('oke');

    }
    public function adminReject($IDBuktiPembayaran){
        $BuktiPembayaran = array(
            'Status'=>'DEL',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        DB::table('bukti_pembayaran')->where('IDBuktiPembayaran',$IDBuktiPembayaran)->update($BuktiPembayaran);
        // pembayaran2 for notif data
        $Pembayaran2 = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->join('bukti_pembayaran as bp','p.IDPembayaran','=','bp.IDPembayaran')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->where('bp.IDBuktiPembayaran',$IDBuktiPembayaran)
        ->select('p.KodePembayaran','t.UUID','s.UUID as UIDSiswa')->get();
        DB::table('notif')->insert([
            'Notif'=> session()->get('Username')." menolak bukti pembayaran untuk pembayaran ".$Pembayaran2[0]->KodePembayaran
            ." cek kembali pembayaran anda",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$Pembayaran2[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/pembayaran/info/'.$Pembayaran2[0]->UUID,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent('owner'));
        return response()->json('oke');

    }
    public function getDetailTransaksi($ID){
        $Transaksi = DB::table('transaksi')
        ->where('UUID',$ID)
        ->where('Status','!=','DEL')->get();
        $Pembayaran = [];
        $TMPPembayarans = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->join('metode_pembayaran as mp','p.IDMetodePembayaran','=','mp.IDMetodePembayaran')
        ->join('rekening as r','mp.IDDompet','=','r.IDRekening')
        ->join('bank as b','r.IDBank','=','b.IDBank')
        ->select('p.*','mp.MetodePembayaran','b.NamaBank','r.NamaRekening','r.NoRekening')
        ->where('t.UUID',$ID)
        ->where('t.Status','!=','DEL')->get();
        foreach($TMPPembayarans as $TMPPembayaran){
            $BuktiPembayaran = DB::table('bukti_pembayaran')
            ->where('IDPembayaran',$TMPPembayaran->IDPembayaran)->get();
            array_push($Pembayaran,[
                'IDPembayaran'=>$TMPPembayaran->IDPembayaran,
                'KodePembayaran'=>$TMPPembayaran->KodePembayaran,
                'UUIDPembayaran'=>$TMPPembayaran->UUID,
                'Total'=>$TMPPembayaran->Total,
                'NoUrut'=>$TMPPembayaran->NoUrut,
                'Status'=>$TMPPembayaran->Status,
                'created_at'=>$TMPPembayaran->created_at,
                'MetodePembayaran'=>$TMPPembayaran->MetodePembayaran,
                'NamaBank'=>$TMPPembayaran->NamaBank,
                'NamaRekening'=>$TMPPembayaran->NamaRekening,
                'NoRekening'=>$TMPPembayaran->NoRekening,
                'BuktiPembayaran'=>$BuktiPembayaran
            ]);
        }
        return [$Transaksi,$Pembayaran];
    }
    //halaman detail pembayaran di owner
    public function ownerDetailPembayaran($ID)
    {
        $Data = $this->getDetailTransaksi($ID);
        $Transaksi = $Data[0];
        $Pembayaran = $Data[1];
        return view('karyawan.transaksi.owner.rincian',[
            'Transaksi'=>$Transaksi,
            'Pembayaran'=>$Pembayaran
        ]);
    }

    //konfirmasi pembayaran di owner
    public function ownerKonfirmasi(Request $request){
        $Transaksi = DB::table('transaksi')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->select('transaksi.IDTransaksi')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)->get();
        $Pembayaran = DB::table('pembayaran')
        ->where('IDTransaksi',$Transaksi[0]->IDTransaksi)->get();
        //dd($Pembayaran);
        if(count($Pembayaran)==1){
            $DataPembayaran = array(
                'Status'=>'CLS',
                'UserUpd'=>session()->get('Username'),
                'updated_at'=>Carbon::now(),
            );
            $Transaksi = array(
                'transaksi.Status'=>'CLS',
                'transaksi.UserUpd'=>session()->get('Username'),
                'transaksi.updated_at'=>Carbon::now(),
            );
            Transaksi::changeStatusByKodePembayaran($request->pembayaran,$Transaksi);
            Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$DataPembayaran);
        }else{
            $PembayaranSelesai =[];
            //dd($Pembayaran);
            $PembayaranSelesai = array_filter($Pembayaran->toArray(),function($data){
                return $data->Status == 'CLS';
            });
            $DataPembayaran = array(
                'Status'=>'CLS',
                'UserUpd'=>session()->get('Username'),
                'updated_at'=>Carbon::now(),
            );
            Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$DataPembayaran);
            if((count($Pembayaran)-count($PembayaranSelesai))==1){
                $Transaksi = array(
                    'transaksi.Status'=>'CLS',
                    'transaksi.UserUpd'=>session()->get('Username'),
                    'transaksi.updated_at'=>Carbon::now(),
                );
                Transaksi::changeStatusByKodePembayaran($request->pembayaran,$Transaksi);
            }
        }
        $KursusSiswa = array(
            'kursus_siswa.Status'=>'CLS',
            'transaksi.UserUpd'=>session()->get('Username'),
            'transaksi.updated_at'=>Carbon::now(),
        );
        $KodeKasBank = "KBK-" . date("myHis");
        $DataPembayaran = DB::table('pembayaran')
        ->where('KodePembayaran',$request->pembayaran)
        ->get();
        $KasBank = array(
            'KodeKasBank'=>$KodeKasBank,
            'IDPembayaran'=>$DataPembayaran[0]->IDPembayaran,
            'Total'=>$DataPembayaran[0]->Total,
            'Keterangan'=>'Pembyaran '.$DataPembayaran[0]->KodePembayaran,
            'Status'=>'OPN',
            'UserUpd'=>session()->get('Username'),
            'UserAdd'=>session()->get('Username'),
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
            'Tanggal'=>Carbon::now(),

        );
        DB::table('kursus_siswa')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)
        ->update($KursusSiswa);
        DB::table('kas_bank')->insert($KasBank);

        $Pembayaran2 = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->where('p.KodePembayaran',$request->pembayaran)
        ->select('p.KodePembayaran','t.UUID','s.UUID as UIDSiswa')->get();
        DB::table('notif')->insert([
            'Notif'=> session()->get('Username')." Telah mengkonfirmasi pembayaran anda (".$Pembayaran2[0]->KodePembayaran.")",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$Pembayaran2[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/pembayaran/info/'.$Pembayaran2[0]->UUID,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        $KursusSiswa = DB::table('kursus_siswa')
        ->join('program_studi','kursus_siswa.IDProgram','=','program_studi.IDProgram')
        ->join('transaksi','kursus_siswa.IDKursusSiswa','=','transaksi.IDKursusSiswa')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)
        ->select('program_studi.NamaProdi')->get();
        DB::table('notif')->insert([
            'Notif'=> "Kursus ".$KursusSiswa[0]->NamaProdi." sudah aktif, segera buat jadwal",
            'NotifFrom'=> session()->get('UID'),
            'NotifTo'=>$Pembayaran2[0]->UIDSiswa,
            'IsRead'=>false,
            'Link'=>'/siswa/kursus',
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        //broadcast(new \App\Events\NotifEvent($Pembayaran2[0]->UIDSiswa));
        return redirect('karyawan/owner/transaksi');

    }


}
