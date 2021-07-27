<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes haha
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/send', function () {
    broadcast(new App\Events\EveryoneEvent());
    return response('Sent');
});//test

Route::get('/receiver', function () {
    return view('receiver');
});

Route::get('/notif/user/{id}','NotifController@notifUser');
Route::get('/notif/update/{id}','NotifController@update');



//karyawan
Route::group(['middleware'=>['Role:karyawan'],'prefix'=>'karyawan'],function(){

    Route::get('kursus','KursusSiswaController@adminIndexKursus');
    Route::get('kursus/show/{id}','KursusSiswaController@adminShowKursus');
    Route::post('kursus/absen','KursusSiswaController@adminAbsenKursus');
    Route::get('kursus/delete/{id}','KursusSiswaController@adminDeleteKursus');
    Route::get('kursus/get','KursusSiswaController@adminGetDataKursus');
    Route::get('kursus/getdata/{id}','KursusSiswaController@adminShowKursusGetData');
    Route::post('kursus/jadwalchanges/store','JadwalChangesController@adminStoreChanges');
    Route::post('kursus/changetutor','JadwalController@adminChangeTutor');

    //multi karyawanwww
    Route::post('jadwalchanges/store','JadwalChangesController@storeChanges');
    Route::get('jadwalchanges/get/{id}','JadwalChangesController@getChanges');

    Route::post('/deleteakunkaryawan','KaryawanController@deleteKaryawan');
    Route::post('/undeleteakunkaryawan','KaryawanController@unDeleteKaryawan');
    Route::post('/deleteakunsiswa','SiswaController@deleteSiswa');
    Route::post('/undeleteakunsiswa','SiswaController@unDeleteSiswa');
    Route::post('password/update','AuthController@changePasswordKaryawan');
    Route::get('/transaksi/getdata','TransaksiController@getData');
 
    //route owner
    Route::group(['middleware'=>['RoleKaryawan:1'],'prefix'=>'owner'],function(){

        Route::get('masterpenggajian/gajipokok/','GajiPokokController@indexOwner');
        Route::get('masterpenggajian/gajipokok/getdata','GajiPokokController@getData');
        Route::post('masterpenggajian/gajipokok/store','GajiPokokController@store');
        Route::post('masterpenggajian/gajipokok/update','GajiPokokController@update');
        Route::get('masterpenggajian/gajipokok/delete/{id}','GajiPokokController@delete');

        Route::get('masterpenggajian/denda/','DendaController@indexOwner');
        Route::get('masterpenggajian/denda/getdata','DendaController@getData');
        Route::post('masterpenggajian/denda/store','DendaController@store');
        Route::post('masterpenggajian/denda/update','DendaController@update');
        Route::get('masterpenggajian/denda/delete/{id}','DendaController@delete');

        Route::get('penggajian/','PenggajianController@index');
        Route::get('penggajian/karyawan/{id}','PenggajianController@show');
        Route::get('penggajian/karyawan/getdata/{id}','PenggajianController@getData');
        Route::post('penggajian/store','PenggajianController@store');

        Route::get('masterpenggajian/transport/','MasterPenggajianTransportController@index');
        Route::get('masterpenggajian/transport/getdata','MasterPenggajianTransportController@getData');
        Route::post('masterpenggajian/transport/store','MasterPenggajianTransportController@store');
        Route::post('masterpenggajian/transport/update','MasterPenggajianTransportController@update');
        Route::get('masterpenggajian/transport/delete/{id}','MasterPenggajianTransportController@delete');

        Route::get('masterpenggajian/','MasterPenggajianController@index');
        Route::get('masterpenggajian/getdata','MasterPenggajianController@getData');
        Route::post('masterpenggajian/store','MasterPenggajianController@store');
        Route::post('masterpenggajian/update','MasterPenggajianController@update');
        Route::get('masterpenggajian/delete/{id}','MasterPenggajianController@delete');

        Route::get('kursus','KursusSiswaController@adminIndexKursus');
        Route::get('kursus/show/{id}','KursusSiswaController@adminShowKursus');

        Route::get('/syarat', 'SyaratController@index');
        Route::post('/syarat/store', 'SyaratController@store');
        Route::get('/syarat/edit/{id}', 'SyaratController@edit');
        Route::post('/syarat/update', 'SyaratController@update');
        Route::get('/syarat/delete/{id}', 'SyaratController@delete');
        Route::get('/syarat/getdata', 'SyaratController@getData');
        Route::get('/syarat/show/{id}','SyaratController@show');

        Route::get('/notif','NotifController@notifOwner');
        Route::get('/notif/user/{id}','NotifController@notifUser');

        Route::get('/dasbor',function(){return view('karyawan.index');});

        Route::get('/transaksi','TransaksiController@ownerIndex');
        Route::get('/transaksi/detail/{id}','PembayaranController@ownerDetailPembayaran');
        Route::post('transaksi/konfirmasi','PembayaranController@ownerKonfirmasi');
        Route::get('/transaksi/getdata','TransaksiController@ownerGetTransaksi');
        Route::get('/transaksi/selesai','TransaksiController@ownerGetTransaksiSelesai');
        Route::get('/transaksi/exchange','TransaksiController@ownerTransaksiExchange');
        Route::get('/transaksi/exchange/getdata','TransaksiController@ownerGetTransaksiExchange');
        Route::get('/transaksi/exchange/confirm/{id}','TransaksiController@ownerConfirmTransaksiExchange');

        //pendaftaran siswa
        Route::get('pendaftaran/siswa','PendaftaranController@ownerPendaftaranSiswa');
        Route::get('pendaftaran/siswa/getdata','PendaftaranController@ownerGetDataPendaftaranSiswa');
        Route::get('pendaftaran/siswa/pembayaran/{id}','PembayaranController@ownerDetailPembayaranPendaftaran');
        Route::post('pendaftaran/siswa/konfirmasi','PembayaranController@ownerKonfirmasiPendaftaran');


        Route::get('/pendaftaran/karyawan','AktifasiController@indexOwner');
        Route::get('/pendaftaran/karyawan/update/{id}','AktifasiController@updateOwner');
        Route::get('/pendaftaran/karyawan/getdata','AktifasiController@getDataOwner');

        Route::get('siswa/show/{id}','SiswaController@showSiswa');
        Route::get('siswa','SiswaController@indexSiswa');
        Route::get('karyawan/show/{id}','KaryawanController@showKaryawan');
        Route::get('karyawan','KaryawanController@indexKaryawan');



    });

    //route admin
    Route::group(['middleware'=>['RoleKaryawan:2'],'prefix'=>'admin'],function(){

        Route::get('jadwal/semiprivate','JadwalSemiPrivateController@index');
        Route::get('jadwal/semiprivate/getdata','JadwalSemiPrivateController@getData');
        Route::post('jadwal/semiprivate/store','JadwalSemiPrivateController@store');
        Route::post('jadwal/semiprivate/update','JadwalSemiPrivateController@update');
        Route::get('jadwal/semiprivate/delete/{id}','JadwalSemiPrivateController@delete');

        Route::get('diskon','DiskonController@adminIndex');
        Route::get('diskon/getdata','DiskonController@getData');
        Route::get('diskon/delete/{id}','DiskonController@delete');
        Route::post('diskon/store','DiskonController@store');
        Route::post('diskon/update','DiskonController@update');


        //admin akses melihat semua kursus
        Route::get('kursus','KursusSiswaController@adminIndexKursus');
        Route::get('kursus/show/{id}','KursusSiswaController@adminShowKursus');
        // Route::post('kursus/absen','KursusSiswaController@adminAbsenKursus');
        // Route::get('kursus/delete/{id}','KursusSiswaController@adminDeleteKursus');
        // Route::get('kursus/get','KursusSiswaController@adminGetDataKursus');
        // Route::get('kursus/getdata/{id}','KursusSiswaController@adminShowKursusGetData');
        // Route::post('kursus/jadwalchanges/store','JadwalChangesController@adminStoreChanges');
        // Route::post('kursus/changetutor','JadwalController@adminChangeTutor');

        //kunai
        Route::get('prodidetail/getprodi/{id}','ProgramStudiController@pdGetProdi');
        Route::post('prodidetail/storecicilan','ProgramStudiController@pdStoreCicilan');
        Route::post('prodidetail/updatecicilan','ProgramStudiController@pdUpdateCicilan');
        
        Route::get('prodidetail/getpertemuan/{id}','ProgramStudiController@pdGetPertemuan');
        Route::get('prodidetail/deletepertemuan/{id}','ProgramStudiController@pdDeletePertemuan');
        Route::post('prodidetail/storepertemuan','ProgramStudiController@pdStorePertemuan');
        Route::post('prodidetail/updatepertemuan','ProgramStudiController@pdUpdatePertemuan');

        Route::get('prodidetail/getmodul/{id}','ProgramStudiController@pdGetModul');
        Route::get('prodidetail/deletemodul/{id}','ProgramStudiController@pdDeleteModul');
        Route::post('prodidetail/storemodul','ProgramStudiController@pdStoreModul');
        Route::post('prodidetail/updatemodul','ProgramStudiController@pdUpdateModul');

        Route::get('prodidetail/gettool/{id}','ProgramStudiController@pdGetTool');
        Route::get('prodidetail/deletetool/{id}','ProgramStudiController@pdDeleteTool');
        Route::post('prodidetail/storetool','ProgramStudiController@pdStoreTool');
        Route::post('prodidetail/updatetool','ProgramStudiController@pdUpdateTool');

        Route::get('prodidetail/getvideo/{id}','ProgramStudiController@pdGetVideo');
        Route::get('prodidetail/deletevideo/{id}','ProgramStudiController@pdDeleteVideo');
        Route::post('prodidetail/storevideo','ProgramStudiController@pdStoreVideo');
        Route::post('prodidetail/updatevideo','ProgramStudiController@pdUpdateVideo');

        Route::get('prodidetail/getbahan/{id}','ProgramStudiController@pdGetBahan');
        Route::get('prodidetail/deletebahan/{id}','ProgramStudiController@pdDeleteBahan');
        Route::post('prodidetail/storebahan','ProgramStudiController@pdStoreBahan');
        Route::post('prodidetail/updatebahan','ProgramStudiController@pdUpdateBahan');


        Route::get('/notif','NotifController@notifAdmin');
        Route::get('/notif/user/{id}','NotifController@notifUser');

        Route::get('/dasbor',function(){return view('karyawan.index');});


        Route::get('/pendaftaran/karyawan','PendaftaranController@karyawan');
    
        Route::get('/transaksi','TransaksiController@adminTransaksi');
        Route::get('/transaksi/detail/{id}','PembayaranController@adminDetailPembayaran');
        Route::get('/transaksi/getdata','TransaksiController@adminGetTransaksi');
        Route::get('/transaksi/delete/{id}','TransaksiController@adminDeleteTransaksi');
        Route::post('/transaksi/update','TransaksiController@adminUpdateTransaksi');
        Route::post('transaksi/konfirmasi','PembayaranController@adminKonfirmasi');
        Route::get('/transaksi/selesai','TransaksiController@adminTransaksiSelesai');
        Route::get('/transaksi/exchange','TransaksiController@adminTransaksiExchange');
        Route::get('/transaksi/exchange/getdata','TransaksiController@adminGetTransaksiExchange');
        Route::post('/transaksi/exchange/store','TransaksiController@adminStoreTransaksiExchange');

        //level program
        Route::get('/master/levelprogram', 'LevelProgramController@index');
        Route::get('/master/levelprogram/create', 'LevelProgramController@create');
        Route::post('/master/levelprogram/store', 'LevelProgramController@store');
        Route::get('/master/levelprogram/edit/{id}', 'LevelProgramController@edit');
        Route::post('/master/levelprogram/update', 'LevelProgramController@update');
        Route::get('/master/levelprogram/delete/{id}', 'LevelProgramController@delete');
        Route::get('/master/levelprogram/getdata', 'LevelProgramController@getData');

        //kategori program
        Route::get('/master/kategoriprogram', 'KategoriProgramController@index');
        Route::get('/master/kategoriprogram/create', 'KategoriProgramController@create');
        Route::post('/master/kategoriprogram/store', 'KategoriProgramController@store');
        Route::get('/master/kategoriprogram/edit/{id}', 'KategoriProgramController@edit');
        Route::post('/master/kategoriprogram/update', 'KategoriProgramController@update');
        Route::get('/master/kategoriprogram/delete/{id}', 'KategoriProgramController@delete');
        Route::get('/master/kategoriprogram/getdata','KategoriProgramController@getData');

        //kategori global program
        Route::get('/master/kategoriglobal', 'KategoriGlobalController@index');
        Route::get('/master/kategoriglobal/create', 'KategoriGlobalController@create');
        Route::post('/master/kategoriglobal/store', 'KategoriGlobalController@store');
        Route::get('/master/kategoriglobal/edit/{id}', 'KategoriGlobalController@edit');
        Route::post('/master/kategoriglobal/update', 'KategoriGlobalController@update');
        Route::get('/master/kategoriglobal/delete/{id}', 'KategoriGlobalController@delete');
        Route::get('/master/kategoriglobal/getdata','KategoriGlobalController@getData');

        //program studi 
        Route::get('/master/program', 'ProgramStudiController@index');
        Route::get('/master/program/show/{id}', 'ProgramStudiController@show');
        Route::get('/master/program/create', 'ProgramStudiController@create');
        Route::post('/master/program/materi', 'ProgramStudiController@storeMateriProgram');
        Route::post('/master/program/store', 'ProgramStudiController@store');
        Route::get('/master/program/edit/{id}', 'ProgramStudiController@edit');
        Route::post('/master/program/update', 'ProgramStudiController@update');
        Route::get('/master/program/delete/{id}', 'ProgramStudiController@delete');
        Route::get('/master/program/getdata', 'ProgramStudiController@getData');
        Route::get('program/stream/modul/{id}','DocumentController@streamModul');

        //program studi detail 
        Route::get('/program/detail/add/cicilan','ProgramStudiController@detailProgramAddCicilan');
        Route::get('/program/detail/add/pertemuan','ProgramStudiControllers@detailProgramAddPertemuan');
        Route::get('/program/detail/add/modul','ProgramStudiController@detailProgramAddModul');
        Route::get('/program/detail/add/tool','ProgramStudiController@detailProgramAddTool');
        Route::get('/program/detail/add/video','ProgramStudiController@detailProgramAddVideo');
        Route::get('/program/detail/add/bahantutor','ProgramStudiController@detailProgramAddBahanTutor');

        Route::get('/program/detail/get/programstudi/{id}','ProgramStudiController@detailProgramGetProgramStudi');
        Route::get('/program/detail/get/pertemuan/{id}','ProgramStudiController@detailProgramGetPertemuan');
        Route::get('/program/detail/get/modul/{id}','ProgramStudiController@detailProgramGetModul');
        Route::get('/program/detail/get/tool/{id}','ProgramStudiController@detailProgramGetTool');
        Route::get('/program/detail/get/video/{id}','ProgramStudiController@detailProgramGetVideo');
        Route::get('/program/detail/get/bahantutor/{id}','ProgramStudiController@detailProgramGetBahanTutor');
        //materi 
        Route::get('/master/materi', 'MateriController@index');
        Route::get('/master/materi/create', 'MateriController@create');
        Route::post('/master/materi/store', 'MateriController@store');
        Route::get('/master/materi/edit/{id}', 'MateriController@edit');
        Route::post('/master/materi/update', 'MateriController@update');
        Route::get('/master/materi/delete/{id}', 'MateriController@delete');
        Route::get('/master/materi/getdata', 'MateriController@getData');

        //kategori materi 
        Route::get('/master/kategorimateri', 'KategoriMateriController@index');
        Route::get('/master/kategorimateri/create', 'KategoriMateriController@create');
        Route::post('/master/kategorimateri/store', 'KategoriMateriController@store');
        Route::get('/master/kategorimateri/edit/{id}', 'KategoriMateriController@edit');
        Route::post('/master/kategorimateri/update', 'KategoriMateriController@update');
        Route::get('/master/kategorimateri/delete/{id}', 'KategoriMateriController@delete');
        Route::get('/master/kategorimateri/getdata', 'KategoriMateriController@getData');
        Route::get('/master/kategorimateri/show/{id}','KatgoriMateriController@show');

        //bank 
        Route::get('/master/bank', 'BankController@index');
        Route::post('/master/bank/store', 'BankController@store');
        Route::get('/master/bank/edit/{id}', 'BankController@edit');
        Route::post('/master/bank/update', 'BankController@update');
        Route::get('/master/bank/delete/{id}', 'BankController@delete');
        Route::get('/master/bank/getdata', 'BankController@getData');
        Route::get('/master/bank/show/{id}','KatgoriMateriController@show');

        //cicilan
        Route::get('/master/cicilan', 'CicilanController@index');
        Route::get('/master/cicilan/create', 'CicilanController@create');
        Route::post('/master/cicilan/store', 'CicilanController@store');
        Route::get('/master/cicilan/edit/{id}', 'CicilanController@edit');
        Route::post('/master/cicilan/update', 'CicilanController@update');
        Route::get('/master/cicilan/delete/{id}', 'CicilanController@delete');
        Route::get('/master/cicilan/getdata', 'CicilanController@getData');
        Route::get('/master/cicilan/show/{id}','CicilanController@show');

        //kategori rekening 
        Route::get('/manage/rekening', 'RekeningController@index');
        Route::get('/manage/rekening/create', 'RekeningController@create');
        Route::post('/manage/rekening/store', 'RekeningController@store');
        Route::get('/manage/rekening/edit/{id}', 'RekeningController@edit');
        Route::post('/manage/rekening/update', 'RekeningController@update');
        Route::get('/manage/rekening/delete/{id}', 'RekeningController@delete');
        Route::get('/manage/rekening/getdata', 'RekeningController@getData');
        Route::get('/manage/rekening/show/{id}','RekeningController@show');

        //kategori metodepembayaran 
        Route::get('/manage/metodepembayaran', 'MetodePembayaranController@index');
        Route::get('/manage/metodepembayaran/create', 'MetodePembayaranController@create');
        Route::post('/manage/metodepembayaran/store', 'MetodePembayaranController@store');
        Route::get('/manage/metodepembayaran/edit/{id}', 'MetodePembayaranController@edit');
        Route::post('/manage/metodepembayaran/update', 'MetodePembayaranController@update');
        Route::get('/manage/metodepembayaran/delete/{id}', 'MetodePembayaranController@delete');
        Route::get('/manage/metodepembayaran/getdata', 'MetodePembayaranController@getData');
        Route::get('/manage/metodepembayaran/show/{id}','MetodePembayaranController@show');

        //pendaftaran siswa
        Route::get('pendaftaran/siswa','PendaftaranController@adminPendaftaranSiswa');
        Route::get('pendaftaran/siswa/getdata','PendaftaranController@adminGetDataPendaftaranSiswa');
        Route::get('pendaftaran/siswa/pembayaran/{id}','PembayaranController@adminDetailPembayaranPendaftaran');
        Route::post('pendaftaran/siswa/konfirmasi','PembayaranController@adminKonfirmasiPendaftaran');
        
        //Aktifasi Akun  
        Route::get('/master/aktifasi', 'AktifasiController@index');
        Route::post('/master/aktifasi/store', 'AktifasiController@store');
        Route::get('/master/aktifasi/getdata', 'AktifasiController@getdata');
        Route::get('/master/aktifasi/update/{id}', 'AktifasiController@update');

        //Jadwal 
        Route::get('jadwal', 'JadwalController@index');
        Route::post('/jadwal/store', 'JadwalController@store');
        Route::get('jadwal/getdata', 'JadwalController@getdata');
        Route::get('/master/jadwal/edit/{id}', 'JadwalController@edit');
        Route::post('/master/jadwal/update', 'JadwalController@update');
        Route::post('/jadwal/updatetutor','JadwalController@updateTutor');
        //api
        Route::get('getdata/tutor','KaryawanController@getDataTutor');

        Route::get('jenisnilai','JenisNilaiController@index');
        Route::get('jenisnilai/getdata','JenisNilaiController@getData');
        Route::get('jenisnilai/getdata/detail/{id}','JenisNilaiController@getDataDetail');
        Route::post('jenisnilai/store','JenisNilaiController@store');
        Route::post('jenisnilai/update','JenisNilaiController@update');
        Route::get('jenisnilai/destroy/{id}','JenisNilaiController@destroy');

        Route::get('getJadwalTutor/{id}','JadwalController@getJadwalGroupByTutor');
        Route::get('getJadwalSiswa/{id}','JadwalController@getJadwalSiswa');
        Route::get('siswa/show/{id}','SiswaController@showSiswa');
        Route::get('siswa','SiswaController@indexSiswa');
        Route::post('siswa/resetpassword','SiswaController@resetPassword');
        Route::get('karyawan/show/{id}','KaryawanController@showKaryawan');
        Route::get('karyawan','KaryawanController@indexKaryawan');

    });

    //route tutor
    Route::group(['middleware'=>['RoleKaryawan:3'],'prefix'=>'tutor'],function(){

        Route::get('/dasbor','KaryawanController@dasborTutor');


        Route::get('/notif','NotifController@notifTutor');
        Route::get('/notif/user/{id}','NotifController@notifUser');

        Route::get('jadwalchanges/get/{id}','JadwalChangesController@getChanges');
        Route::get('jadwalchanges/answer/{id}/{answer}','JadwalChangesController@confirmChanges');

        Route::get('program/stream/modul/{id}','DocumentController@streamModul');
        Route::post('evaluasi/store','NilaiController@storeNilaiEvaluasi');
        // TODO merger with Kelas
        Route::get('/jadwal','JadwalController@jadwalTutor');
        Route::get('jadwal/getdata', 'JadwalController@getdataTutor');
        Route::get('jadwal/getdetaildata/{id}', 'JadwalController@getDetailDataTutor');
        Route::post('kursus/start', 'JadwalController@startKursus');
        Route::post('kursus/end', 'JadwalController@endKursus');
        Route::get('/kursus/event/{id}', function ($id) {
            broadcast(new App\Events\KelasEvent($id));
        });

        Route::get('siswa','ProgramStudiController@kelasTutorGroupBySiswa');
        Route::get('kelas/{id}','ProgramStudiController@kelasTutor');
        Route::get('kelas/show/{id}','ProgramStudiController@showKelasTutor');
        //Route::get('nilai','NilaiController@index');
        Route::get('nilai/getdata','NilaiController@getData');
        Route::get('nilai/{id}','NilaiController@index');
        Route::post('nilai/store','NilaiController@store');
        Route::post('nilai/update','NilaiController@update');
        Route::get('nilai/destroy/{id}','NilaiController@destroy');

        Route::get('nilaieval/getdata','NilaiEvaluasiController@getData');
        Route::get('nilaieval/{id}','NilaiEvaluasiController@index');
        Route::post('nilaieval/store','NilaiEvaluasiController@store');
        Route::post('nilaieval/update','NilaiEvaluasiController@update');
        Route::get('nilaieval/destroy/{id}','NilaiEvaluasiController@destroy');


        Route::get('sertifikat/belakang/{id}','SertifikatController@belakang');
        Route::get('sertifikat/belakang/cetak/{id}','SertifikatController@print');
        Route::get('sertifikat/depan/{id}','SertifikatController@depan');
        Route::get('sertifikat/depan/cetak/{id}','SertifikatController@printDepan');

        Route::get('evaluasi/{id}','NilaiEvaluasiController@showEvaluasi');
        Route::get('rapor/{id}','NilaiController@showRapor');

    });
    Route::get('/dasbor','KaryawanController@dasbor');
    Route::get('profile/{id}','UserController@profileKaryawan');
    Route::post('profile/update','UserController@profileKaryawanUpdate');
});

Route::group(['middleware'=>['Role:siswa'],'prefix'=>'siswa'],function(){

   Route::get('diskon/getdata/{id}','DiskonController@siswaData');  

    Route::post('jadwalchanges/store','JadwalChangesController@storeChanges');
    Route::get('jadwalchanges/get/{id}','JadwalChangesController@getChanges');

    Route::get('/psikologi/get/{id}','TestPsikologiController@getDetailData');
    Route::post('/psikologi/store','TestPsikologiController@store');

    Route::get('/notif','NotifController@notifSiswa');

    Route::get('program/stream/modul/{id}','DocumentController@streamModul');

    Route::get('sertifikat/belakang/{id}','SertifikatController@belakang');
    Route::get('sertifikat/depan/{id}','SertifikatController@depan');
    //pembayaran
    Route::get('pembayaran/','PembayaranController@index');

    Route::get('pembayaran/info/{id}','PembayaranController@info');
    Route::get('pembayaran/detail/{id}','PembayaranController@detail');
    Route::get('pembayaran/metode/{id}','PembayaranController@metode');
    Route::get('pembayaran/metode/bank/{id}','PembayaranController@createMetodeBank');

    Route::post('pembayaran/metode/bank','PembayaranController@storePembayaranBank');
    Route::post('pembayaran/bukti','PembayaranController@storeBuktiPembayaran');
    Route::get('pembayaran/rincian/{id}','PembayaranController@rincian');


    //transaksi
    Route::get('transaksi/pendaftaran','TransaksiController@storeTransaksiPembayaran');
    Route::post('transaksi/program','TransaksiController@storeTransaksi');
    Route::post('transaksi/kursussiswa','TransaksiController@store');

    //siswa
    Route::get('transaksi','TransaksiController@pembelianSiswa');
    Route::get('program/global/','ProgramStudiController@global');
    Route::get('program/kategori/{id}','ProgramStudiController@kategoriProgramSiswa');
    // Route::get('program/kategori/{id}/{id}','ProgramStudiController@');
    Route::get('program/{id}/{id2}','ProgramStudiController@programSiswa');
    Route::get('program/harga/{id}','ProgramStudiController@getHargaByIDProgram');
    Route::get('jprogram/getDetail/{id}','ProgramStudiController@showDetail');


    Route::get('kursus','KursusSiswaController@programSiswaAktif');
    Route::get('kursus/show/{id}','KursusSiswaController@showProgramSiswaAktif');
    Route::get('kursus/masuk{id}','KursusSiswaController@storeAbsen');

    Route::get('jadwal/show/{id}','JadwalController@showJadwal');
    Route::get('jadwal/create/{id}','JadwalController@createJadwal');
    Route::post('jadwal/store/','JadwalController@storeJadwal');
    Route::get('jadwal/getdata/{id}', 'JadwalController@getdataSiswa');
    Route::get('jadwal/getjadwalsemi','JadwalController@getJadwalSemi');

    Route::get('info','SiswaController@infoPendaftaran');

    Route::post('absen','AbsenController@absen');

    Route::get('getJadwalTutor/{id}','KaryawanController@getJadwalGroupByTutor');
    Route::get('getReqChangeJadwalTutor/{id}','JadwalController@getReqChangeJadwalGroupByTutor');
    Route::get('getDataTutor/','KaryawanController@getDataTutor');
    Route::get('getMateriByIDProgram/{id}','MateriController@getMateriByIDProgram');

    Route::get('profile/{id}','UserController@profileSiswa');
    Route::post('profile/update','UserController@profileSiswaUpdate');

    
    Route::get('nilai/{id}','NilaiController@indexSiswa');
    
    Route::get('nilaieval/{id}','NilaiEvaluasiController@indexSiswa');
    
    Route::get('sertifikat/belakang/{id}','SertifikatController@belakang');
    Route::get('sertifikat/belakang/cetak/{id}','SertifikatController@print');
    Route::get('sertifikat/depan/{id}','SertifikatController@depan');
    Route::get('sertifikat/depan/cetak/{id}','SertifikatController@printDepan');
    
    Route::get('evaluasi/{id}','NilaiEvaluasiController@showEvaluasi');
    Route::get('rapor/{id}','NilaiController@showRapor');

    //event broadcast
    Route::get('/kursus/event/{id}', function ($id) {
        broadcast(new App\Events\KelasEvent($id));
    });
    Route::get('/event/transaksi/{kode}/{type}', function ($kode,$type) {
        broadcast(new App\Events\TransaksiEvent($kode,$type));
    });
});

//handle user autentikasi
Route::prefix('auth')->group(function(){
    Route::post('/login','AuthController@login');
    Route::post('/daftar','AuthController@store');
    Route::post('/logout','AuthController@logout');
    Route::get('/cekusername/{id}','AuthController@cekUsername');
    Route::get('/cekemail/{id}','AuthController@cekEmail');
});

//gerbang user
Route::get('/','AuthController@index');
Route::get('/karyawan','AuthController@gerbangKaryawan');

// Route::get('/updatetutor','JadwalController@updateIDTutor');
// Route::get('/updatekursusmateri','JadwalController@updateMateriKursus');
// Route::get('/updatetotalpertemuan','JadwalController@updateTotalPertemuan');
// Route::get('/recover','JadwalController@recoverJadwal');
// Route::get('/recovermateri','JadwalController@recoverMateri');