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
    //redirect pembayaran sesuai status
    public function info($Kode){
        $Transaksi=Transaksi::showTransaksi($Kode);
        $CekPembayaran = Pembayaran::showPembayaranByKodeTransaksi($Kode);
        $Bank = Bank::getAllBank();
        $BuktiPembayaran = BuktiPembayaran::showBuktiPembayaranByKodeTransaksi($Kode);
        $PembayaranCLSWithnoBukti = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->where('p.status','CLS')
        ->where('t.UUID',$Kode)->get();
        $PembayaranOPN = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->select('p.UUID as UIDPembayaran','p.NoUrut')
        ->where('p.status','OPN')
        ->where('t.UUID',$Kode)
        ->orderBy('p.NoUrut','asc')->get();
        //mengalihkan ke halaman rincian pembayaran
        if(count($PembayaranCLSWithnoBukti)>0){
            //dd($Transaksi['Transaksi'],$BuktiPembayaran,$PembayaranCLSWithnoBukti);
            return view('siswa.pembayaran.rincian',[
                'Pembayaran'=>$Transaksi['Transaksi'],
                'Bank'=>$Bank['Bank'],
                'BuktiPembayaran'=>$BuktiPembayaran,
                'PembayaranOPN'=>$PembayaranOPN
            ]);
        }
        if(count($BuktiPembayaran)>0){
           //dd($BuktiPembayaran,$Transaksi);
            return view('siswa.pembayaran.rincian',[
                'Pembayaran'=>$Transaksi['Transaksi'],
                'Bank'=>$Bank['Bank'],
                'BuktiPembayaran'=>$BuktiPembayaran,
                'PembayaranOPN'=>$PembayaranOPN
            ]);
        //mengalihkan ke halaman upload bukti pembayaran
        }elseif(count($CekPembayaran)>0){
            //by id pembayaran
            return redirect('siswa/pembayaran/metode/bank/'.$PembayaranOPN[0]->UIDPembayaran);
        // halaman pembayaran selesai
        }else{
         //dd($Transaksi['Transaksi']);
            return  redirect('siswa/pembayaran/detail/'.$Kode);
        }
    }
    public function detail($Kode){
        $Transaksi=Transaksi::showTransaksi($Kode);
        $CekPembayaran = Pembayaran::showPembayaranByKodeTransaksi($Kode);
        $Bank = Bank::getAllBank();
        return view('siswa.pembayaran.info',[
            'Pembayaran'=>$Transaksi['Transaksi'],
            'Bank'=>$Bank['Bank']
        ]);
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

        $Pembayaran = Pembayaran::getDetailPembayaran($UUID);
        $Bank = Bank::getAllBank();
        //dd($Pembayaran);
        return view('siswa.pembayaran.metode_bank',[
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
            $Cicilan = Cicilan::getCicilanByIDTransaksi($Transaksi['Transaksi'][0]->IDTransaksi);
            $UUIDPembayaranPertama=str_replace('-','',str::uuid());
            //dd($Cicilan,$UUIDPembayaranPertama,$Transaksi['Transaksi'][0]->IDTransaksi);
            for($i =0;$i < $Cicilan['Cicilan'][0]->Cicilan;$i++){
                $Data = array(
                    'UUID'=>$i==0?$UUIDPembayaranPertama:str_replace('-','',str::uuid()),
                    'KodePembayaran'=>"PAY-" . date("mHis").$i,
                    'IDTransaksi'=>$Transaksi['Transaksi'][0]->IDTransaksi,
                    'IDMetodePembayaran'=>$request->metode,
                    'Total'=>$Cicilan['Cicilan'][0]->Harga / $Cicilan['Cicilan'][0]->Cicilan,
                    'NoUrut'=>$i+1,
                    'created_at'=>Carbon::now(),
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
        $IsPendaftaran = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->join('kursus_siswa as ks','t.IDKursusSiswa','ks.IDKursusSiswa')
        ->join('siswa as s','t.IDSiswa','=','s.IDSiswa')
        ->select('ks.IDProgram','s.UUID as UIDSiswa')
        ->where('p.IDPembayaran',$request->idpembayaran)->get();
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
        $Pembayaran = Pembayaran::getDetailBuktiPembayaran($ID);
       //dd($Pembayaran['Pembayaran']);
        return view('karyawan.transaksi.admin.rincian',['Pembayaran'=>$Pembayaran]);
    }

    //konfirmasi pembayaran di admin
    public function adminKonfirmasi(Request $request){
        $Pembayaran = array(
            'Status'=>'CFM',
            'UserUpd'=>session()->get('Username'),
            'updated_at'=>Carbon::now(),
        );
        Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$Pembayaran);
        // pembayaran2 for notif data
        $Pembayaran2 = DB::table('pembayaran as p')
        ->join('transaksi as t','p.IDTransaksi','=','t.IDTransaksi')
        ->where('p.KodePembayaran',$request->pembayaran)
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
        return redirect('karyawan/admin/transaksi');

    }
    
    //halaman detail pembayaran di owner
    public function ownerDetailPembayaran($ID)
    {
        $Pembayaran = Pembayaran::getDetailBuktiPembayaran($ID);
        //dd($Pembayaran['Pembayaran']);
        return view('karyawan.transaksi.owner.rincian',['Pembayaran'=>$Pembayaran]);
    }

    //konfirmasi pembayaran di owner
    public function ownerKonfirmasi(Request $request){
        $Transaksi = DB::table('transaksi')
        ->join('pembayaran','transaksi.IDTransaksi','=','pembayaran.IDTransaksi')
        ->select('transaksi.IDTransaksi')
        ->where('pembayaran.KodePembayaran',$request->pembayaran)->get();
        $Pembayaran = DB::table('pembayaran')
        ->where('IDTransaksi',$Transaksi[0]->IDTransaksi)->get();
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
            Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$DataPembayaran);
            Transaksi::changeStatusByKodePembayaran($request->pembayaran,$Transaksi);
        }else{

            $DataPembayaran = array(
                'Status'=>'CLS',
                'UserUpd'=>session()->get('Username'),
                'updated_at'=>Carbon::now(),
            );
            Pembayaran::changeStatusByKodePembayaran($request->pembayaran,$DataPembayaran);
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
