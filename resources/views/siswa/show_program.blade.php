@extends('siswa.layouts.layout')
@section('title','Program Studi')
@section('content')
<style>
    .btn-nav {
        margin-top: 10px;
        font-size: 13px;
        color: #6c757d;

    }

    .btn-nav:focus {
        outline: none;
        box-shadow: none;
    }

    .btn-nav.active {
        color: #007bff;
        border-bottom: 3px solid #007bff;
        border-radius: 0px;
    }
    #toast-container > .toast-success {
        background-color: black;
        max-width: 40rem;
        background-image: none !important;
    }
    #modal-jadwal-changes{
        overflow-y:auto
    }

</style>
<div class="modal fade" id="modal-buat-ulang-jadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Ulang Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formdata" class="mx-5">
                @csrf
                <input type="hidden" id="total_pertemuan">
                <input type="hidden" id="id_kursus_siswa">
                <input type="hidden" id="id_program">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date" class="col-form-label">Tanggal mulai:</label>
                        <input type="date" onchange="setFirstDay()" id="start_date" name="bank" class="form-control">
                    </div>
                    {{-- <div class="form-group">
                        <label for="time" class="col-form-label">Jam:</label>
                        <input type="time" id="start_time" name="bank" class="form-control">
                    </div> --}}
                    <hr>
                    <p>Mau masuk hari apa aja?</p>
                    <div class="row ">
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline" id="btn-add-jam-senin">
                                <input type="checkbox" onchange="visibleAddJam(1)" value="1" id="senin" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="senin">Senin</label>
                                <a id="btn-add-jam-1" style="display:none" onclick="addJam(1)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-senin">
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" onchange="visibleAddJam(2)" value="2" id="selasa" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="selasa">Selasa</label>
                                <a id="btn-add-jam-2" style="display:none" onclick="addJam(2)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-selasa">
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline">
                                <input value="3" onchange="visibleAddJam(3)" type="checkbox" id="rabu" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="rabu">Rabu</label>
                                <a id="btn-add-jam-3" style="display:none" onclick="addJam(3)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-rabu">
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline">
                                <input value="4" onchange="visibleAddJam(4)" type="checkbox" id="kamis" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="kamis">Kamis</label>
                                <a id="btn-add-jam-4" style="display:none" onclick="addJam(4)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-kamis">
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline">
                                <input value="5" onchange="visibleAddJam(5)" type="checkbox" id="jumat" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="jumat">Jumat</label>
                                <a id="btn-add-jam-5" style="display:none" onclick="addJam(5)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-jumat">
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline">
                                <input value="6" onchange="visibleAddJam(6)" type="checkbox" id="sabtu" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="sabtu">Sabtu</label>
                                <a id="btn-add-jam-6" style="display:none" onclick="addJam(6)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-sabtu">
                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-check form-check-inline">
                                <input value="0" onchange="visibleAddJam(0)" type="checkbox" id="minggu" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="minggu">Minggu</label>
                                <a id="btn-add-jam-0" style="display:none" onclick="addJam(0)"  class="ml-2 btn btn-primary btn-sm" href="javascript:void(0)" role="button">
                                    tambah jam
                                </a>
                            </div>
                            <div class="row ml-1" id="jadwal-jam-minggu">
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <a id="tombolcreate" onclick="reMakeJadwal()" class="btn text-white btn-sm btn-primary">Buat</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row bg-white">



    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel" style="border:0px;">
            <div class="row">
                <div class="col-md-6">
                    <h2 style="color: black"> Kelas {{$Prodi[0]->NamaProdi}} </h2>
                    <input type="hidden" id="UUIDKelas" value="{{$Prodi[0]->UUIDKelas}}">
                    {{-- <small>({{$Prodi[0]->KodeKursus}})</small>**/ --}}
                    <p id="data-kelas"></p>
                </div>
                <div class="col-md-6" id="btn-nilai">

                </div>
                {{-- nav menu --}}

                <div class="col-md-12" style=" border-bottom: 0.01em solid #0D6c757d;">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" onclick="changeActiveContent('pertemuan')" id="btn-pertemuan"
                            class="btn btn-nav ">Jadwal</button>
                        <button type="button" id="btn-selesai" onclick="changeActiveContent('selesai')"
                            class="btn btn-nav">Materi selesai</button>
                        @if (count($Modul)>0) 
                        <button type="button" onclick="changeActiveContent('modul')" id="btn-modul"
                            class="btn btn-nav ">Modul</button>
                        @endif
                        @if (count($Video)>0)            
                        <button type="button" id="btn-video" onclick="changeActiveContent('video')"
                            class="btn btn-nav">Video</button>
                        @endif
                        <button type="button" id="btn-ubahjadwal" onclick="changeActiveContent('ubahjadwal')"
                            class="btn btn-nav">Ubah jadwal</button>
                    </div>
                </div>

                <hr>
            </div>
            <div class="x_content">
                {{-- konten pertemuan dan materi --}}
                <div style="display: none" id="content-pertemuan" class="row mt-3">
                    <div class="col-md-12 ">
                        <section id="btn-remake-jadwal"></section>
                        {{-- mark 1 --}}
                        
                        <a id="btn-buat-ulang-jadwal" href="javascript:void(0)" class="btn btn-sm btn-primary" role="button">Buat ulang jadwal</a>
                        <div class="table-responsive mt-3">

                            <table id="tabel-jadwal" class="table table-borderless">
                                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />
                                <thead class="thead-dark">
                                    <tr>
                                        <th  style="width:1%">Pertemuan</th>
                                        <th  style="width:5%">Hari</th>
                                        <th  style="width:5%">Jam</th>
                                        <th  style="width:10%">Tanggal</th>
                                        <th  style="width:50%">Nama Materi</th>
                                        <th  style="width:10%">Tutor</th>
                                        <th  style="width:10%">Status</th>      
                                        <th  style="width:10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table-jadwal"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
                {{-- konten Modul --}}

                <div style="display: none" id="content-modul" class="row mt-3">
                    <div class="table-responsive">

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Nama</th>
                                    <th>Modul</th>
                                 
                               
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($Modul)>0)
                                @foreach ($Modul as $modul)
    
                                <tr>
                                    <td scope="row">
                                        <h5>{{$modul->Judul}}</h5>
                                    </td>
                                    <td>
                                        <a name="" id="" class="btn btn-primary"
                                            href="{{url('siswa/program/stream/modul')}}/{{explode('.',$modul->Modul)[0]}}"
                                            target="_blank" role="button">{{$modul->Modul}}</a>
                                        {{-- <input type="file" class="form-control-file" name="" id="" placeholder="" aria-describedby="fileHelpId">   --}}
                                    </td>
                   
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
  
                {{-- konten Video --}}

                <div style="display: none" id="content-video" class="row mt-3">
                    <div class="table-responsive">
                        
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Judul</th>
                                    <th>Video</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Video as $video)
                                <tr>
                                    <td scope="row">
                                        <h5>{{$video->Judul}}</h5>
                                    </td>
                                    <td>
                                       {!!$video->Link!!} 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                {{-- konten pertemuan dan materi selesai --}}
                <div style="display: none" id="content-selesai" class="row mt-3">
                    <div class="col-md-12 ">
                        <div class="table-responsive">
                        
                            <table id="tabel-jadwal-selesai" class="table table-borderless">
                                <thead class="thead-dark">
                                    <tr>
                                        <th  style="width:5%">Pertemuan</th>
                                        <th  style="width:5%">Hari</th>
                                        <th  style="width:5%">Jam</th>
                                        <th  style="width:10%">Tanggal</th>
                                        <th  style="width:50%">Nama Materi</th>
                                        <th  style="width:10%">Tutor</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table-jadwal-selesai"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
                {{-- konten ubah jadwal  --}}
                <div style="display: none" id="content-ubahjadwal" class="row mt-3">
                    <div class="ml-2 col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row" id="select-ubah-jadwal">
                                    <div class="col-md-3">

                                        <label >Ubah jadwal</label>
                                    </div>
                                    <div class="col-md-9">

                                        <select onchange="setDataChangeJadwal()"  class="custom-select" id="input-ubah-jadwal-select">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 ">
                 
                            </div>
         
                        </div>
                        
                        <div style="display:none" id="input-ubah-jadwal">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <label for="">Tanggal</label>
                                      <input type="date"  class="form-control"
                                        id="input-ubah-jadwal-tanggal" aria-describedby="helpId" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                      <label for="">Jam</label>
                                      <input type="time"  class="form-control" 
                                       id="input-ubah-jadwal-jam" aria-describedby="helpId" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="">Nama Materi</label>
                                      <input type="text" readonly class="form-control" 
                                       id="input-ubah-jadwal-materi" aria-describedby="helpId" placeholder="">
                                    </div>
                                </div>
                                <input type="hidden" id="he">
                            </div>
                            
                            <a id="button-ubah-jadwal" onclick="limitChangeTime()" class="btn btn-primary" href="javascript:void(0)" role="button">Ubah</a>
                        </div>
                        <div style="display: none" id="input-ubah-semua-jadwal">
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                      <label for="">Libur mulai tanggal</label>
                                      <input type="date" class="form-control" id="input-libur-mulai" aria-describedby="helpId" placeholder="">     
                                    </div>  
                                    <div class="form-group">
                                        <label for="">sampai tanggal</label>
                                        <input type="date" class="form-control"  id="input-libur-sampai" aria-describedby="helpId" placeholder="">
                                      </div>       
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                            <a id="button-ubah-jadwal" onclick="limitFreezeJadwal()" class="btn btn-primary" href="javascript:void(0)" role="button">Ubah</a>
                        </div>

                    </div>
                    <div class=" ml-2 mt-4 col-md-12">
                        <h5>Riwayat perubahan</h5>
                        {{-- kunai --}}
                        <div id="list-history-changes" class="list-group mt-2">
           
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Modal jadwal changes kunai -->
<div class="modal fade" id="modal-jadwal-changes" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perubahan Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Sebelum</h4>
                        <div class="table-responsive">
                        
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pertemuan</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Nama Materi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-warning text-white" id="tbody-jadwal-changes-from"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Sesudah</h4>
                        <div class="table-responsive">
                        
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pertemuan</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Nama Materi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-success text-white" id="tbody-jadwal-changes-to"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="storeChanges()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>

</div>
    
<!-- Modal change jadwal   -->
<div class="modal fade" id="modal-change-jadwal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Kirim permintaan ubah jadwal </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                {{-- <form action=""></form> --}}
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="">Nama Materi</label>
                        <input type="text" readonly class="form-control" id="change-jadwal-materi" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="change-jadwal-tanggal" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Jam</label>
                        <input type="time" class="form-control" name="jam" id="change-jadwal-jam" aria-describedby="helpId" placeholder="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script src="{{asset('assets/js/moment.js')}}"></script>
{{-- <script type="application/javascript" src="{{ asset('js/app.js') }}"></script> --}}
<script>
    const token = $('#token').val();
    let active_content = "pertemuan";
    const btn_prodi = $('#btn-prodi');
    const btn_pertemuan = $('#btn-pertemuan');
    const btn_modul = $('#btn-modul');
    const btn_tool = $('#btn-tool');
    const btn_video = $('#btn-video');
    const btn_bahantutor = $('#btn-bahantutor');
    const btn_selesai = $('#btn-selesai');
    const btn_ubahjadwal = $('#btn-ubahjadwal');
    const content_prodi = $('#content-prodi');
    const content_pertemuan = $('#content-pertemuan');
    const content_modul = $('#content-modul');
    const content_tool = $('#content-tool');
    const content_video = $('#content-video');
    const content_selesai = $('#content-selesai');
    const content_ubahjadwal = $('#content-ubahjadwal');
    const content_bahantutor = $('#content-bahantutor');
    const TabelJadwal = $('#tabel-jadwal').DataTable();
    const TabelJadwalSelesai = $('#tabel-jadwal-selesai').DataTable();
    const URLData = window.location.hash
    let jadwal_selesai=[];
    let jadwal = [];
    let jam_maker = []
    let ReqJadwalChanges = [];
    let JadwalChanges = [],LimitChangeJadwal=0,MaxCuti=0
    let KursusMateri = [],GformsResponse = [],Prodi = [],SertifikasiKursus = []

    const Hari = [
        {'Hari':'Senin','No':1},
        {'Hari':'Selasa','No':2},
        {'Hari':'Rabu','No':3},
        {'Hari':'Kamis','No':4},
        {'Hari':'Jumat','No':5},
        {'Hari':'Sabtu','No':6},
        {'Hari':'Minggu','No':0},
    ]

    toastr.options = {
        'timeOut' : 0,
        "positionClass": "toast-bottom-full-width",
        'extendedTimeOut' : 0,
        'preventDuplicates' :true
    }
    $(document).ready(function () {
        let url = window.location
        let LinkData = URLData.split('#')
        if(LinkData.length>1){
            active_content = LinkData[1]
        }
        $('#tabel-jadwal').DataTable();
        showContent();
        showJadwal();
        getChanges();
    });

    //kunai ws
    // window.Echo.channel('Event'+$('#UUIDKelas').val()).listen('.Kelas', function (e) {
    //     console.log(e);
    //     showJadwal();

    // });
    Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(),0,1);
        var today = new Date(this.getFullYear(),this.getMonth(),this.getDate());
        var dayOfYear = ((today - onejan + 86400000)/86400000);
        return Math.ceil(dayOfYear/7)
    }

    //start buat ulang jadwal
    $('#btn-buat-ulang-jadwal').on('click',()=>{
        $('#modal-buat-ulang-jadwal').modal('show')
    })
    function setFirstDay() {
        jam_maker = []
        let start_date = $('#start_date').val();
        let firs_day = new Date(start_date).getDay();

        switch (firs_day) {
            case 0:
                $('#minggu').prop('checked', true);
                $('#senin').prop('checked', false);
                $('#selasa').prop('checked', false);
                $('#rabu').prop('checked', false);
                $('#kamis').prop('checked', false);
                $('#jumat').prop('checked', false);
                $('#sabtu').prop('checked', false);
                break;
            case 1:
                $('#senin').prop('checked', true);
                $('#minggu').prop('checked', false);
                $('#selasa').prop('checked', false);
                $('#rabu').prop('checked', false);
                $('#kamis').prop('checked', false);
                $('#jumat').prop('checked', false);
                $('#sabtu').prop('checked', false);
                break;
            case 2:
                $('#selasa').prop('checked', true);
                $('#minggu').prop('checked', false);
                $('#senin').prop('checked', false);
                $('#rabu').prop('checked', false);
                $('#kamis').prop('checked', false);
                $('#jumat').prop('checked', false);
                $('#sabtu').prop('checked', false);
                break;
            case 3:
                $('#rabu').prop('checked', true);
                $('#minggu').prop('checked', false);
                $('#senin').prop('checked', false);
                $('#selasa').prop('checked', false);
                $('#kamis').prop('checked', false);
                $('#jumat').prop('checked', false);
                $('#sabtu').prop('checked', false);
                break;
            case 4:
                $('#kamis').prop('checked', true);
                $('#minggu').prop('checked', false);
                $('#senin').prop('checked', false);
                $('#selasa').prop('checked', false);
                $('#rabu').prop('checked', false);
                $('#jumat').prop('checked', false);
                $('#sabtu').prop('checked', false);
                break;
            case 5:
                $('#jumat').prop('checked', true);
                $('#minggu').prop('checked', false);
                $('#senin').prop('checked', false);
                $('#selasa').prop('checked', false);
                $('#rabu').prop('checked', false);
                $('#kamis').prop('checked', false);;
                $('#sabtu').prop('checked', false);
                break;
            case 6:
                $('#sabtu').prop('checked', true);
                $('#minggu').prop('checked', false);
                $('#senin').prop('checked', false);
                $('#selasa').prop('checked', false);
                $('#rabu').prop('checked', false);
                $('#kamis').prop('checked', false);
                $('#jumat').prop('checked', false);
                break;

        }
        for(let i=0;i<7;i++){
            visibleAddJam(i)
        }

    }
    function visibleAddJam(id){
        let hari = id == 1?'senin':
        id == 2?'selasa':
        id == 3?'rabu':
        id == 4?'kamis':
        id == 5?'jumat':
        id == 6?'sabtu':
        id == 0?'minggu':false

        if($('#'+hari).is(':checked')){
            let now_id = new Date().getTime()
            jam_maker.push({'day_id':id,'now_id':now_id,'val':''})
            $('#btn-add-jam-'+id).show();
            showElementJam()
        }else{
            $('#btn-add-jam-'+id).hide();
            jam_maker = jam_maker.filter(ele=>ele.day_id!=id)
            showElementJam()
        }
    }
    function deleteJam(id){
        jam_maker = jam_maker.filter(ele=>ele.now_id!=id)
        showElementJam()
    }
    function showElementJam(){
     
        const jadwal_jam = id => id == 1?$('#jadwal-jam-senin'):
        id == 2?$('#jadwal-jam-selasa'):
        id == 3?$('#jadwal-jam-rabu'):
        id == 4?$('#jadwal-jam-kamis'):
        id == 5?$('#jadwal-jam-jumat'):
        id == 6?$('#jadwal-jam-sabtu'):
        id == 0?$('#jadwal-jam-minggu'):false

        const name_jam = id => id == 1?'jam_senin[]':
        id == 2?'jam_selasa[]':
        id == 3?'jam_rabu[]':
        id == 4?'jam_kamis[]':
        id == 5?'jam_jumat[]':
        id == 6?'jam_sabtu[]':
        id == 0?'jam_minggu[]':false
        for(let i = 0;i<7;i++){
            let JadwalJam = jadwal_jam(i)
            JadwalJam.empty()
        }
        let jamke=[1,1,1,1,1,1,1]
        jam_maker.forEach((ele)=>{
            let NameJam = name_jam(ele.day_id)
            let JadwalJam = jadwal_jam(ele.day_id)
            JadwalJam.append(
                "<div id=\"jamke"+ele.now_id+"\" class=\"col-md-12 my-1\">"+
                    "<div class=\"row\">"+
                        "<div class=\"col-md-3\">"+
                            "<label for=\"time\" class=\"col-form-label\">Jam ke "+jamke[ele.day_id] +"</label>"+
                        "</div>"+
                        "<div class=\"col-md-7\">"+
                            "<input type=\"time\" value=\""+ele.val+"\" onchange=\"setDataJam("+ele.now_id+")\"  id=\"jamkedata"+ele.now_id+"\" class=\"form-control\">"+
                        "</div>"+
                        "<div class=\"col-md-2\">"+
                            "<a  onclick=\"deleteJam("+ele.now_id+")\" class=\"btn mt-1 text-white btn-danger btn-sm\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>"+
                        "</div>"+
                    "</div>"+
                "</div>"
            )
            jamke[ele.day_id]++
        })
    }
    function setDataJam(id){
        let data = $('#jamkedata'+id).val()
        let indexData = jam_maker.findIndex(ele=> ele.now_id == id)
        jam_maker[indexData].val = data
  
    }
    function addJam(id){


        let now_id = new Date().getTime()
        jam_maker.push({'day_id':id,'now_id':now_id,'val':''})
        showElementJam()
        // if(true){

        // }
      

    }

    function reMakeJadwal() {
        $('#modal-buat-ulang-jadwal').modal('hide')
        //kunai main
        // total pertemuan = jadwal yang belum ada absen dan tanggl nya lebih besar sama dengan sekarang
        let start_date = $('#start_date')
        // console.log(moment(new Date()).format('Y-MM-DD'))
        let total_pertemuan = jadwal.length
        let senin = $('#senin');
        let selasa = $('#selasa');
        let rabu = $('#rabu');
        let kamis = $('#kamis');
        let jumat = $('#jumat');
        let sabtu = $('#sabtu');
        let minggu = $('#minggu');
        let tmp_meet_in_week = [{
                'aktif': senin.is(':checked'),
                'hari': senin.val()
            },
            {
                'aktif': selasa.is(':checked'),
                'hari': selasa.val()
            },
            {
                'aktif': rabu.is(':checked'),
                'hari': rabu.val()
            },
            {
                'aktif': kamis.is(':checked'),
                'hari': kamis.val()
            },
            {
                'aktif': jumat.is(':checked'),
                'hari': jumat.val()
            },
            {
                'aktif': sabtu.is(':checked'),
                'hari': sabtu.val()
            },
            {
                'aktif': minggu.is(':checked'),
                'hari': minggu.val()
            },
        ];
        // hari setiap minggu
        let meet_in_week = tmp_meet_in_week.filter(ele => ele.aktif == true);
        // mengatur tanggal awal dari setiap minggu (waktu awal set tanggal (tanggal + (hari-tanggal)+(hari-tanggal))  )
        let flat_date = meet_in_week.map(ele =>
            new Date(start_date.val()).setDate(
                new Date(start_date.val()).getDate() +
                (ele.hari - new Date(start_date.val()).getDay()) +
                (
                    ele.hari - new Date(start_date.val()).getDay() < 0 ? 7 : 0
                )

            )
        );
          // console.log('trace one',meet_in_week,flat_date)
            //base tanggal 
        let date = flat_date.sort((a, b) => a - b).map(ele =>
            new Date(ele).getFullYear() + '-' + String(new Date(ele).getMonth() + 1).padStart(2, '0') + '-' +
            String(new Date(ele).getDate()).padStart(2, '0')
        )
        //sisa bagi total pertemuan dibagi pertemuan dalam seminggu
        let a = total_pertemuan % jam_maker.length;
        //hasil pembagian total pertemuan tanpa sisa bagi ( max perulangan)
        let c = total_pertemuan % jam_maker.length == 0 ? total_pertemuan / jam_maker.length : (
            total_pertemuan - (total_pertemuan % jam_maker.length)) / jam_maker.length;
        let jadwal_siswa = [];
        let date_increament = 0;
        console.log(a,total_pertemuan,c,jam_maker.length,'trace total')

        //keep it up sware -3-
        // jadwal maker
        // total pertemuan di bagi pertemuan dalam seminggu
        // jika tidak ada sisa bagi 
        // jika hasil bagi ada sisa jadwal di tambah jadwal dibuat dengan sisa pertemuan
        for (let i = 0; i < c; i++) {
            for (let j = 0; j < date.length; j++) {
                let hari = jam_maker.filter(ele=>ele.day_id==new Date(date[j]).getDay())
                for(let jam =0;jam<hari.length;jam++){
                    let tmp_date = new Date(new Date(date[j]).setDate(new Date(date[j]).getDate() + date_increament))
                    let tmp_jadwal = tmp_date.getFullYear() + '-' + String(tmp_date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(tmp_date.getDate()).padStart(2, '0');
                    jadwal_siswa.push({
                        'tanggal': tmp_jadwal,
                        'jam': hari[jam].val
                    });
                }
            }
            date_increament += 7;
        }
        let j = 0
        if (a != 0) {
            do{
                for (let i = 0; i < date.length; i++) {
                    if(j==a){
                        break
                    }
                    let hari = jam_maker.filter(ele=>ele.day_id==new Date(date[i]).getDay())
                    for(let jam =0;jam<hari.length;jam++){
                        if(j==a){
                            break
                        }
                        console.log('ite sisa',j)
                        let tmp_date = new Date(new Date(date[i]).setDate(new Date(date[i]).getDate() + date_increament));
                        let tmp_jadwal = tmp_date.getFullYear() + '-' + String(tmp_date.getMonth() + 1).padStart(2, '0') + '-' +
                            String(tmp_date.getDate()).padStart(2, '0');
                        jadwal_siswa.push({
                            'tanggal': tmp_jadwal,
                            'jam': hari[jam].val
                        });
                        j++
      
                    }
                }
            }while(j!=a)
        }
        jadwalBuiler(jadwal_siswa,jadwal);
        //kunai
    
        //getAndSetNewestJadwalTutor(start_date.val());
        // checkJadwalTutor(jadwal_siswa);

    }
    function jadwalBuiler(changes,data_jadwal){
        //let filtered_jadwal = jadwal
        let newJadwal = []
        let DataChanges={
                '_token':token,
                'UIDProgram[]':[],
                'IDSiswa[]':[],
                'IDTutor[]':[],
                'IDJadwal[]':[],
                'IDMateriFrom[]':[],
                'IDMateriTo[]':[],
                'NoRecordFrom[]': [],
                'NoRecordTo[]':[],
                'TanggalFrom[]': [],
                'TanggalTo[]':[]
        };
        let i=0
        data_jadwal.forEach((data)=>{
            //console.log(tmpDate.getDate(),new Date(tmpDate.setDate(tmpDate.getDate() + freeze)).toString())
            // let date = new Date( tmpDate.setDate(tmpDate.getDate() + freeze))
            newJadwal.push({
                'UIDProgram':data.UUIDProgram,
                'IDSiswa':data.IDSiswa,
                'IDTutor':data.IDTutor,
                'IDJadwal':data.IDJadwal,
                'IDMateriFrom':data.IDMateri,
                'IDMateriTo':data.IDMateri,
                'MateriFrom':data.NamaMateri,
                'MateriTo':data.NamaMateri,
                'NoRecordFrom': parseInt(data.NoRecord),
                'NoRecordTo':parseInt(data.NoRecord),
                'TanggalFrom': data.Tanggal+' '+data.Jam,
                'TanggalTo': changes[i].tanggal+' '+changes[i].jam
            })
            i++
        })
        newJadwal.forEach((ele)=>{
            DataChanges['UIDProgram[]'].push(ele.UIDProgram)
            DataChanges['IDSiswa[]'].push(ele.IDSiswa)
            DataChanges['IDTutor[]'].push(ele.IDTutor)
            DataChanges['IDJadwal[]'].push(ele.IDJadwal)
            DataChanges['IDMateriFrom[]'].push(ele.IDMateriFrom)
            DataChanges['IDMateriTo[]'].push(ele.IDMateriTo)
            DataChanges['NoRecordFrom[]'].push(ele.NoRecordFrom)
            DataChanges['NoRecordTo[]'].push(ele.NoRecordTo)
            DataChanges['TanggalFrom[]'].push(ele.TanggalFrom)
            DataChanges['TanggalTo[]'].push(ele.TanggalTo)
        })
        ReqJadwalChanges = DataChanges
        setAndShowDataModalChanges(newJadwal)
    }
    //end buat ulang jadwal

    function limitFreezeJadwal(){
        let from = new Date($('#input-libur-mulai').val()).getTime()
        let to = new Date($('#input-libur-sampai').val()).getTime()
        if((to - from)<=(MaxCuti*86400000)){
            freezeJadwal()
        }else{
            swal('Batas maksimal cuti adalah '+MaxCuti+' hari')
        }
    }
    function freezeJadwal(){
        //kunai main
        //!! pola adalah pertemuan setiap minggu
        //freeze jadwal / cuti
        // ambil jadwal yang diatas tanggal awal cuti yang materinya belum selesai 
        // jadwal diganti dari tanggal masuk dengan pola sebelumnya
        // cari pertemuan pertama yang dekat dengan tanggal masuk berdasarkan pola
        // buat flat date / tanggal awal berdasarkan pola
        // buat jadwal berdasarkan flat date sampai pertemuan terakhir
        let input_freeze_from = $('#input-libur-mulai').val()
        let input_freeze_to = $('#input-libur-sampai').val()
        //copyjadwal = jadwal di atas tanggal awal cuti yang materi belum selesai
        let copyJadwal = jadwal.filter((ele)=>{
            let time_sch = new Date(ele.Tanggal).getTime()
            let time_to = new Date(input_freeze_to).getTime() 
            let time_from = new Date(input_freeze_from).getTime()
            //sch that can be edit
            let incSch = (time_sch >=  time_from)  
            return incSch
        })
        // newJadwal = jadwal baru yang akan dibuat
        let new_jadwal = []
        // data changes = data post
        let DataChanges={
                '_token':token,
                'UIDProgram[]':[],
                'IDSiswa[]':[],
                'IDTutor[]':[],
                'IDJadwal[]':[],
                'IDMateriFrom[]':[],
                'IDMateriTo[]':[],
                'NoRecordFrom[]': [],
                'NoRecordTo[]':[],
                'TanggalFrom[]': [],
                'TanggalTo[]':[]
        }
        //jadwal remaker
        //keep it up sware -3-
        //ambil tanggal terdekat dari tanggal masuk yang ada di pola 
        const twoDigit = (data) =>{
            return String(data).length==2?data:'0'+data
        }
        const patternSch = (sch)=>{
            let pattern = []
            // get all pattern from all jadwal
            sch.forEach(j=>
                pattern.push(new Date(j.Tanggal).getDay()+' '+j.Jam) 
            )
            // group the pattern or final pattern
            let final_pattern = pattern.reduce((final_p,item)=>{
                let isExist = final_p.some(p=>p==item)
                if(isExist==false){
                    final_p.push(item)
                }
                return final_p
            },[])
            return final_pattern
        }
        //get the pattern(pola) of curent sch
        let pattern = patternSch(copyJadwal)
        //ambil tanggal terdekat dari tanggal masuk yang ada di pola 
        // sort the pattern
        let pattern_from = new Date(input_freeze_to).getDay()
        pattern = pattern.map(p=> [ pattern_from<p.split(' ')[0]?0:1,parseInt(p.split(' ')[0]),p.split(' ')[1] ])
        .sort((a,b)=>a[0] - b[0]).sort((a,b)=>a[1] - b[2])
        // get tanggal masuk pertama yang terdekat dengan tanggal libur terakhr
        let first_day = new Date(input_freeze_to).setDate(
            new Date(input_freeze_to).getDate()+
            ((pattern[0][0]*7 + pattern[0][1]) -
            new Date(input_freeze_to).getDay())
        )
        // final pattern format
        let flat_date = pattern.map(ele =>
            [new Date(first_day).setDate(
                new Date(first_day).getDate() +
                (ele[1] - new Date(first_day).getDay()) +
                (
                    ele[1] - new Date(first_day).getDay() < 0 ? 7 : 0
                )

            ),
            ele[2]]
        )
        //sisa bagi pertemuan dibagi pattern
        let a = copyJadwal.length % flat_date.length;
        //hasil pembagian total pertemuan tanpa sisa bagi ( max perulangan)
        let c = copyJadwal.length % flat_date.length == 0 ? copyJadwal.length / flat_date.length : (
            copyJadwal.length - (copyJadwal.length % flat_date.length)) / flat_date.length;
        let date_increament = 0;

        //keep it up sware -3-
        // jadwal maker
        // total pertemuan di bagi pertemuan dalam seminggu
        // jika tidak ada sisa bagi 
        // jika hasil bagi ada sisa jadwal di tambah jadwal dibuat dengan sisa pertemuan
        for (let i = 0; i < c; i++) {
            flat_date.forEach(date=>{
                let tmp_date = new Date(new Date(date[0]).setDate(new Date(date[0]).getDate() + date_increament))
                let tmp_jadwal = tmp_date.getFullYear() + '-' + String(tmp_date.getMonth() + 1).padStart(2, '0') + '-' +
                    String(tmp_date.getDate()).padStart(2, '0');
                new_jadwal.push({
                    'tanggal': tmp_jadwal,
                    'jam': date[1]
                });
            })
            date_increament += 7;
        }
        if (a != 0) {
            for(let i=0;i<a;i++){
                let tmp_date = new Date(new Date(flat_date[i][0]).setDate(new Date(flat_date[i][0]).getDate() + date_increament))
                let tmp_jadwal = tmp_date.getFullYear() + '-' + String(tmp_date.getMonth() + 1).padStart(2, '0') + '-' +
                    String(tmp_date.getDate()).padStart(2, '0');
                new_jadwal.push({
                    'tanggal': tmp_jadwal,
                    'jam': flat_date[i][1]
                });
            }
        }
        new_jadwal = new_jadwal.reduce((new_sch,ele,index)=>{
            new_sch.push({
                'UIDProgram':copyJadwal[index].UUIDProgram,
                'IDSiswa':copyJadwal[index].IDSiswa,
                'IDTutor':copyJadwal[index].IDTutor,
                'IDJadwal':copyJadwal[index].IDJadwal,
                'IDMateriFrom':copyJadwal[index].IDMateri,
                'IDMateriTo':copyJadwal[index].IDMateri,
                'NoRecordFrom':copyJadwal[index].NoRecord,
                'NoRecordTo':copyJadwal[index].NoRecord,
                'TanggalFrom':copyJadwal[index].Tanggal+' '+copyJadwal[index].Jam,
                'TanggalTo':ele.tanggal+' '+ele.jam,
                'MateriFrom':copyJadwal[index].NamaMateri,
                'MateriTo':copyJadwal[index].NamaMateri,
            })
            return new_sch
        },[])
        new_jadwal.forEach((ele)=>{
            DataChanges['UIDProgram[]'].push(ele.UIDProgram)
            DataChanges['IDSiswa[]'].push(ele.IDSiswa)
            DataChanges['IDTutor[]'].push(ele.IDTutor)
            DataChanges['IDJadwal[]'].push(ele.IDJadwal)
            DataChanges['IDMateriFrom[]'].push(ele.IDMateriFrom)
            DataChanges['IDMateriTo[]'].push(ele.IDMateriTo)
            DataChanges['NoRecordFrom[]'].push(ele.NoRecordFrom)
            DataChanges['NoRecordTo[]'].push(ele.NoRecordTo)
            DataChanges['TanggalFrom[]'].push(ele.TanggalFrom)
            DataChanges['TanggalTo[]'].push(ele.TanggalTo)
        })
        ReqJadwalChanges = DataChanges
        setAndShowDataModalChanges(new_jadwal)
    }
    function sumDate(amount,date){
        var tmpDate = new Date(date);
        tmpDate.setDate(tmpDate.getDate() + amount)
        return tmpDate;
    }
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            hours = d.getHours(),
            min = d.getMinutes();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;
        if (hours.length < 2) 
            hours = '0' + hours; 
        if (min.length < 2) 
            min = '0' + min; 
        return [year, month, day].join('-')+" "+hours+":"+min;
    }
    function setDataChangeJadwal(){
        if($('#input-ubah-jadwal-select').val()=='all'){
            $('#input-ubah-semua-jadwal').show();
            $('#input-ubah-jadwal').hide();
        }else{
            $('#input-ubah-jadwal').show();
            $('#input-ubah-semua-jadwal').hide();
            let pertemuan;
            jadwal.forEach((ele) => {
                if(ele.NoRecord == $('#input-ubah-jadwal-select').val()){
                    pertemuan = ele
                }
            })
            $('#input-ubah-jadwal-materi').val(pertemuan.NamaMateri);
            $('#input-ubah-jadwal-tanggal').val(pertemuan.Tanggal);
            $('#input-ubah-jadwal-jam').val(pertemuan.Jam);
        }
    }
    // Kursus belum selesai
    // Kursus seleasai sertifikat di proses
    // kursus selesai sertifikat selesai -> beri masukan kursus yang telah selesai
    //
    function phaseKursus(){
        let phaseContent = ''
        let phaseElement = $('#btn-nilai')
        let phase = [
            KursusMateri.every(km=>km.Status==='CLS'),
            SertifikasiKursus.length > 0,
            GformsResponse.length>0
        ]
        phaseElement.empty()
        if(phase[0]===true&&phase[1]===false){
            phaseContent = '<h2>Kursus selesai, sertifikat di proses</h2>'
        }
        if(phase[0]===true&&phase[1]===true&&phase[2]===false){
            phaseContent = '<h2>Kursus selesai, sertifikat siap</h2>'+
            '<a href=\'https://s.id/merachelEval\' class=\'btn btn-sm btn-primary\' target=\'blank\'>Isi form evaluasi kursus</a>'
        }
        if(phase[0]===true&&phase[1]===true&&phase[2]===true){
            phaseContent = '<a class=\"btn btn-hasil-nilai btn-primary btn-sm\" href=\"/siswa/sertifikat/depan/'+Prodi[0].UUIDKelas+'\" target=\"blank\">Sertifikat depan</a>'+
                    '<a class=\"btn btn-hasil-nilai btn-primary btn-sm\" href=\"/siswa/sertifikat/belakang/'+Prodi[0].UUIDKelas+'\" target=\"blank\">Sertifikat Belakang</a>'+
                    '<a class=\"btn btn-hasil-nilai btn-primary btn-sm\" href=\"/siswa/rapor/'+Prodi[0].UUIDKelas+'\" target=\"blank\">Rapor</a>'+
                    '<a class=\"btn btn-hasil-nilai btn-primary btn-sm\" href=\"/siswa/evaluasi/'+Prodi[0].UUIDKelas+'\" target=\"blank\">Evaluasi</a>'
        }
        phaseElement.append(phaseContent)

    }
    function showJadwal(){
        // console.log('get req jadwal siswa/jadwal/getdata'+$('#UUIDKelas').val());
        $.get('/siswa/jadwal/getdata/'+$('#UUIDKelas').val(),(data)=>{
      
            $('#data-table-jadwal').empty();
            $('#data-table-jadwal-selesai').empty();
            TabelJadwal.clear().draw();
            LimitChangeJadwal = data[2][0].jam
            MaxCuti = data[1][0].hari
            KursusMateri = data[4]
            GformsResponse = data[3]
            Prodi = data[5]
            SertifikasiKursus = data[6]
            showDataKelas()
            data[0].forEach((element) => {
                let tmp_btn = element['Status']=='Berlangsung'&&element['Absen']=='Belum Absen'?
                    "<button id=\"btnabsen"+element['IDJadwal']+"\" onclick=\"masukKelas("+element['IDJadwal']+")\" class=\"btn btn-sm btn-primary\">Absen</button>"
                    :element['Status']=='Berlangsung'&&element['Absen']=='masuk'?
                    "<a class=\"btn btn-sm btn-success\">Berlangsung</a>"
                    :element['Status']=='Terlewat'?
                    "<a class=\"btn btn-sm btn-success\">Kelas tidak dibuka</a>":
                    "<a class=\"btn btn-sm btn-info\">"+element['Status']+"</a>";
                let btn =
                    "<form class=\'text-white\' id=\"formdata"+element['IDJadwal']+"\">"+
                        "<input type=\"hidden\" name=\"idjadwal\" value=\""+element['IDJadwal']+"\">"+
                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#token').val()+"\">"+
                        "<input type=\"hidden\" name=\"uuidjadwal\" value=\""+element['UUIDProgram']+"\">"+
                        tmp_btn+
                    "</form>";
                let btn_ubah_jadwal = 
                    "<a "+
                        "onclick=\"setDataChangeJadwal("+
                        "\'"+element["NamaMateri"]+
                        "\',\'"+element["Tanggal"]+
                        "\',\'"+element["Jam"]+
                        "\',\'"+element["IDJadwal"]+
                        "\')\""+
                        "data-toggle=\"modal\" data-target=\"#modal-change-jadwal\""+
                        "class=\"btn btn-sm btn-primary\" href=\"javascirpt:void(0)\" role=\"button\">"+
                        "Ubah Jadwal"+
                    "</a>";
                if(element['Status']=='Selesai'){     
                    jadwal_selesai.push(element)
                    TabelJadwalSelesai.row.add([
                        element['NoRecord'],
                        Hari.filter((ele)=> ele.No == new Date(element['Tanggal']).getDay())[0].Hari,
                        element['Jam'],
                        element['Tanggal'],
                        element['NamaMateri'],
                        element['NamaTutor'] 
                    ]).draw();
                }else{
                    jadwal.push(element)
                    console.log(new Date(element['Tanggal']).getDay())
                    TabelJadwal.row.add([
                        element['NoRecord'],
                        Hari.filter((ele)=> ele.No == new Date(element['Tanggal']).getDay())[0].Hari,
                        element['Jam'],
                        element['Tanggal'],
                        element['NamaMateri'],
                        element['NamaTutor'],
                        element['Status'],
                        btn 
                    ]).draw();
                }
                

            });
            phaseKursus()
            $('#input-ubah-jadwal-select').empty();
            $('#input-ubah-jadwal-select').append('<option>pilih</option>');
            $('#input-ubah-jadwal-select').append('<option value="all">Izin Cuti</option>');
            jadwal.forEach((ele)=>{
                $('#input-ubah-jadwal-select').append(
                    "<option value=\""+ele.NoRecord+"\">Ubah pertemuan ke "+ele.NoRecord+"</option>"
                )
            })
            statusUbahJadwal()
        });
    }
    function showDataKelas(){
        $('#data-kelas').html(
            "Kursus : "+Prodi[0].NamaProdi+"<br>"+
            "Kode Kursus : "+Prodi[0].KodeKursus+"<br>"
        );
    }
    function masukKelas(id){
        $('#btnabsen'+id).attr('disabled',true)
        $.post('/siswa/absen',$('#formdata'+id).serialize()).done((data)=>{
            showJadwal();
        }).fail(function(){
            console.log('gagal');
            swal('gagal');
        });
    }

    $('#content-prodi').on('change', function () {
        toastr.success(
            '<div class="d-flex justify-content-between">'+
                '<p >Perhatian - Kamu belum menyimpan perubahan!</p>'+
                '<a onclick="updateProdi()" id="" class="ml-4 btn btn-primary btn-sm" href="javascript:void(0)" role="button">Simpan perubahan</a>'+
            '</div>'
        );
        //updateProdi();
    });

    function showContent() {
        switch (active_content) {
            case 'prodi':
                btn_prodi.addClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_selesai.hide();
                content_ubahjadwal.hide();
                content_prodi.show();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.hide();
                break;
            case 'pertemuan':
                btn_pertemuan.addClass('active');
                btn_prodi.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_selesai.hide();
                content_ubahjadwal.hide();
                content_prodi.hide();
                content_pertemuan.show();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.hide();
                break;
            case 'modul':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.addClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_selesai.hide();
                content_ubahjadwal.hide();
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.show();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.hide();
                break;
            case 'tool':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.addClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_selesai.hide();
                content_ubahjadwal.hide();
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.show();
                content_video.hide();
                content_bahantutor.hide();
                break;
            case 'video':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.addClass('active');
                btn_bahantutor.removeClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_selesai.hide();
                content_ubahjadwal.hide();
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.show();
                content_bahantutor.hide();
                break;
            case 'bahantutor':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.addClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_selesai.hide();
                content_ubahjadwal.hide();
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.show();
                break;
            case 'selesai':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_selesai.addClass('active');
                btn_bahantutor.removeClass('active');
                btn_ubahjadwal.removeClass('active');
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.hide();
                content_selesai.show();
                content_ubahjadwal.hide();
                break;
            case 'ubahjadwal':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
                btn_selesai.removeClass('active');
                btn_ubahjadwal.addClass('active');
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.hide();
                content_selesai.hide();
                content_ubahjadwal.show();
                break;
        }
    }


    function changeActiveContent(data) {
        active_content = data;
        showContent();
    }

    function updateProdi() {
        $.post('/karyawan/admin/master/program/update', $('#form-prodi').serialize())
            .done(function (pesan) {
                swal(pesan.Pesan);
            }).fail(function (pesan) {
           
                swal('gagal' + pesan.Pesan);
            });
    }
    function limitChangeTime(){
        //kunaiss
        let now = new Date().getTime()
        let InputNoRecord = $('#input-ubah-jadwal-select').val()
        let jadwal_will = jadwal.filter(ele => ele.NoRecord == InputNoRecord)[0]

        let now_will = new Date(jadwal_will.Tanggal+' '+jadwal_will.Jam).getTime()
        console.log(now,now_will)
        // time left lower than limit change, cant change jadwal
        let time_left = now_will - now
        if(time_left>=(LimitChangeJadwal*3600000)){
            traceJadwalChange()
        }else{
            swal('Anda tidak dapat mengganti jadwal, karena waktu terlalu mepet')
        }
    }
    function traceJadwalChange(){
        let JadwalChanged =[]
        let InputNoRecord = $('#input-ubah-jadwal-select').val()
        let reqTanggal = $('#input-ubah-jadwal-tanggal').val()
        let reqJam = $('#input-ubah-jadwal-jam').val()
        let jadwalChangedIndex = jadwal.findIndex(ele => ele.NoRecord == InputNoRecord)
        let jadwalPrevChanged = jadwal[jadwalChangedIndex].Tanggal
        console.log('hae',jadwal[jadwalChangedIndex],reqJam,reqTanggal)
 
        if(reqJam == jadwal[jadwalChangedIndex].Jam && 
        jadwal[jadwalChangedIndex].Tanggal == reqTanggal){
            swal('Anda belum mengubah jadwal')
        }
        if(reqJam != jadwal[jadwalChangedIndex].Jam && 
        jadwal[jadwalChangedIndex].Tanggal == reqTanggal){
         
            JadwalChanged.push({
                'UIDProgram':jadwal[jadwalChangedIndex].UUIDProgram,
                'IDSiswa':jadwal[jadwalChangedIndex].IDSiswa,
                'IDTutor':jadwal[jadwalChangedIndex].IDTutor,
                'IDJadwal':jadwal[jadwalChangedIndex].IDJadwal,
                'IDMateriFrom':jadwal[jadwalChangedIndex].IDMateri,
                'IDMateriTo':jadwal[jadwalChangedIndex].IDMateri,
                'MateriFrom':jadwal[jadwalChangedIndex].NamaMateri,
                'MateriTo':jadwal[jadwalChangedIndex].NamaMateri,
                'NoRecordFrom': parseInt(InputNoRecord),
                'NoRecordTo':parseInt(InputNoRecord),
                'TanggalFrom': jadwal[jadwalChangedIndex].Tanggal+' '+jadwal[jadwalChangedIndex].Jam,
                'TanggalTo':jadwal[jadwalChangedIndex].Tanggal+' '+reqJam+':00'
            })
            let DataChanges={
                '_token':token,
                'UIDProgram[]':[],
                'IDSiswa[]':[],
                'IDTutor[]':[],
                'IDJadwal[]':[],
                'IDMateriFrom[]':[],
                'IDMateriTo[]':[],
                'NoRecordFrom[]': [],
                'NoRecordTo[]':[],
                'TanggalFrom[]': [],
                'TanggalTo[]':[]
            };
            JadwalChanged.forEach((ele)=>{
                DataChanges['UIDProgram[]'].push(ele.UIDProgram)
                DataChanges['IDSiswa[]'].push(ele.IDSiswa)
                DataChanges['IDTutor[]'].push(ele.IDTutor)
                DataChanges['IDJadwal[]'].push(ele.IDJadwal)
                DataChanges['IDMateriFrom[]'].push(ele.IDMateriFrom)
                DataChanges['IDMateriTo[]'].push(ele.IDMateriTo)
                DataChanges['NoRecordFrom[]'].push(ele.NoRecordFrom)
                DataChanges['NoRecordTo[]'].push(ele.NoRecordTo)
                DataChanges['TanggalFrom[]'].push(ele.TanggalFrom)
                DataChanges['TanggalTo[]'].push(ele.TanggalTo)
            })
            ReqJadwalChanges = DataChanges
          //  console.log('changed',JadwalChanged)
            setAndShowDataModalChanges(JadwalChanged)
        }
        let jadwal_not_changed = jadwal.filter(jwd=>jwd.NoRecord != InputNoRecord).filter(jwd=> jwd.StatusMateri != 'CLS')
       // console.log(jadwal_not_changed)
        let is_over_date = jadwal_not_changed.some(jnc=>{
            let will_change = jadwal.filter(ele=>ele.NoRecord===parseInt(InputNoRecord))
            return (new Date(jnc.Tanggal).getTime() <= new Date(reqTanggal+' '+reqJam).getTime()&&
            jnc.NoRecord > will_change[0].NoRecord)||
            (new Date(jnc.Tanggal).getTime() >= new Date(reqTanggal+' '+reqJam).getTime()&&
            jnc.NoRecord < will_change[0].NoRecord)
        })
        if(is_over_date){
            swal('Tidak bisa mengganti ke tanggal ini, coba ganti ke tanggal lebih kecil')
        }
        if(!is_over_date && jadwal[jadwalChangedIndex].Tanggal != reqTanggal){
            let reqJadwal = reqTanggal+' '+reqJam
            if(filterSameDate(jadwal,reqJadwal).length != 0){
                swal('Jadwal penuh')
            }else{
                // jadwalPrevChanged = jadwal yang akan di ubah
                // jadwal = semua jadwal yang belum di ubah
                // reqJadwal = perubahan jadwal
                let tmp_new_jadwal = filterCheckPrevRecord(jadwal,reqJadwal,jadwalPrevChanged)
                let ite = 0
     
                let newJadwal = tmp_new_jadwal.filter(ele=>ele.NoRecord != InputNoRecord).map((ele)=>{
                    let data = {
                        'UIDProgram':jadwal[jadwalChangedIndex].UUIDProgram,
                        'IDSiswa':ele.IDSiswa,
                        'IDTutor':ele.IDTutor,
                        'IDJadwal':ele.IDJadwal,
                        'IDMateriFrom':ele.IDMateri,
                        'IDMateriTo':tmp_new_jadwal[ite].IDMateri,
                        'MateriFrom':ele.NamaMateri,
                        'MateriTo':tmp_new_jadwal[ite].NamaMateri,
                        'NoRecordFrom': ele.NoRecord,
                        'NoRecordTo':tmp_new_jadwal[ite].NoRecord,
                        'TanggalFrom': ele.Tanggal+' '+ele.Jam,
                        'TanggalTo':tmp_new_jadwal[ite+1].Tanggal
                    }
                    ite ++;
                    return data
                })
    

                newJadwal.push({
                    'UIDProgram':jadwal[jadwalChangedIndex].UUIDProgram,
                    'IDSiswa':jadwal[jadwalChangedIndex].IDSiswa,
                    'IDTutor':jadwal[jadwalChangedIndex].IDTutor,
                    'IDJadwal':jadwal[jadwalChangedIndex].IDJadwal,
                    'IDMateriFrom':jadwal[jadwalChangedIndex].IDMateri,
                    'IDMateriTo':tmp_new_jadwal.length == 0?jadwal[jadwalChangedIndex].IDMateri:tmp_new_jadwal[tmp_new_jadwal.length-1].IDMateri,
                    'MateriFrom':jadwal[jadwalChangedIndex].NamaMateri,
                    'MateriTo':tmp_new_jadwal.length == 0?jadwal[jadwalChangedIndex].NamaMateri:tmp_new_jadwal[tmp_new_jadwal.length-1].NamaMateri,
                    'NoRecordFrom': parseInt(InputNoRecord),
                    'NoRecordTo':tmp_new_jadwal.length == 0?parseInt(InputNoRecord):tmp_new_jadwal[tmp_new_jadwal.length-1].NoRecord,
                    'TanggalFrom': jadwal[jadwalChangedIndex].Tanggal+' '+jadwal[jadwalChangedIndex].Jam,
                    'TanggalTo':reqJadwal
                })
           
                let DataChanges={
                    '_token':token,
                    'UIDProgram[]':[],
                    'IDSiswa[]':[],
                    'IDTutor[]':[],
                    'IDJadwal[]':[],
                    'IDMateriFrom[]':[],
                    'IDMateriTo[]':[],
                    'NoRecordFrom[]': [],
                    'NoRecordTo[]':[],
                    'TanggalFrom[]': [],
                    'TanggalTo[]':[]
                };
                newJadwal.forEach((ele)=>{
                    DataChanges['UIDProgram[]'].push(ele.UIDProgram)
                    DataChanges['IDSiswa[]'].push(ele.IDSiswa)
                    DataChanges['IDTutor[]'].push(ele.IDTutor)
                    DataChanges['IDJadwal[]'].push(ele.IDJadwal)
                    DataChanges['IDMateriFrom[]'].push(ele.IDMateriFrom)
                    DataChanges['IDMateriTo[]'].push(ele.IDMateriTo)
                    DataChanges['NoRecordFrom[]'].push(ele.NoRecordFrom)
                    DataChanges['NoRecordTo[]'].push(ele.NoRecordTo)
                    DataChanges['TanggalFrom[]'].push(ele.TanggalFrom)
                    DataChanges['TanggalTo[]'].push(ele.TanggalTo)
                })
            
                ReqJadwalChanges = DataChanges
              
                setAndShowDataModalChanges(newJadwal)
             
            }
        }

       
    }

    function setAndShowDataModalChanges(data){
        let TableJadwalChangesFrom = $('#tbody-jadwal-changes-from')
        let TableJadwalChangesTo = $('#tbody-jadwal-changes-to')
        TableJadwalChangesFrom.empty()
        TableJadwalChangesTo.empty()
        data.sort((a,b)=> a.NoRecordFrom - b.NoRecordFrom).forEach((ele)=>{
            TableJadwalChangesFrom.append(
                "<tr>"+
                    "<td>"+ele.NoRecordFrom+"</td>"+
                    "<td>"+ele.TanggalFrom.split(' ')[0]+"</td>"+
                    "<td>"+ele.TanggalFrom.split(' ')[1]+"</td>"+
                    "<td>"+ele.MateriFrom+"</td>"+
                "</tr>"
            )
        })
        data.sort((a,b)=> a.NoRecordTo - b.NoRecordTo).forEach((ele)=>{
            TableJadwalChangesTo.append(
                "<tr>"+
                    "<td>"+ele.NoRecordTo+"</td>"+
                    "<td>"+ele.TanggalTo.split(' ')[0]+"</td>"+
                    "<td>"+ele.TanggalTo.split(' ')[1]+"</td>"+
                    "<td>"+ele.MateriTo+"</td>"+
                "</tr>"
            )
        })
        $('#modal-jadwal-changes').modal('show')
    }
    function storeChanges(){
        $('#modal-jadwal-changes').modal('hide')
        $.post("/siswa/jadwalchanges/store", ReqJadwalChanges, (ele) =>{
             swal('Permintaan terkirim')
             $('#select-ubah-jadwal').hide();
             $('#input-ubah-jadwal').hide();
             $('#input-ubah-semua-jadwal').hide();
             getChanges()
        })
    }
    function filterCheckPrevRecord(jadwal, reqJadwal,jadwalPrevChanged){
        const dataFilter = (ele)=>{
            let oldTanggal = ele.Tanggal+' '+ele.Jam
            return (new Date(oldTanggal).getTime()) < (new Date(reqJadwal).getTime())
                && (new Date(oldTanggal).getTime()) >= (new Date(jadwalPrevChanged).getTime())
        }
        let check = jadwal.filter(ele => dataFilter(ele))
        return check
    }
    function filterSameDate(jadwal,reqJadwal){
        const dataFilter = (ele) => {
            let new_sch =  reqJadwal.split(' ')[0] ;
            let new_sch_hours =  reqJadwal.split(' ')[1].split(':')[0] + ':' +
            reqJadwal.split(' ')[1].split(':')[1];
            check_jadwal = ele.Tanggal == new_sch
            check_jam = 
                    new Date('2002-10-13' + ' ' + new_sch_hours).getTime() <=
                    new Date(new Date('2002-10-13' + ' ' + ele.Jam).setHours(
                        new Date('2002-10-13' + ' ' + ele.Jam).getHours() + 3
                    )).getTime() &&
                    new Date('2002-10-13' + ' ' + new_sch_hours).getTime() >=
                    new Date(new Date('2002-10-13' + ' ' + ele.Jam).setHours(
                        new Date('2002-10-13' + ' ' + ele.Jam).getHours() - 3
                    )).getTime()

            return check_jadwal && check_jam;
        };
        let check = jadwal.filter(ele => dataFilter(ele));
        return check;
    }
    function getChanges(){
        $('#list-history-changes').empty()
        $.get("/siswa/jadwalchanges/get/"+$('#UUIDKelas').val(), (ele)=>{
    
            JadwalChanges = ele

            JadwalChanges.sort((a,b)=> b.IDJadwalChange - a.IDJadwalChange).forEach((ele)=>{
                //console.log(ele)
              //  console.log(ele.JadwalChanges[0].TanggalFrom)
                let ChangesSebelum =""
                let ChangesSesudah =""
                let StatusChange = ele.Status == 'OPN'?'Permintaan Terkirim':ele.Status=='CLS'?'Permintaan Disetujui':'Permintaan Ditolak'
                ele.JadwalChanges.sort((a,b)=> a.NoRecordFrom - b.NoRecordFrom).forEach((ele)=>{
                    ChangesSebelum +=
                        "<tr>"+
                            "<td>"+ele.NoRecordFrom+"</td>"+
                            "<td>"+ele.TanggalFrom.split(' ')[0]+"</td>"+
                            "<td>"+ele.TanggalFrom.split(' ')[1]+"</td>"+
                            "<td>"+ele.NamaMateriFrom+"</td>"+
                        "</tr>"
                })
                ele.JadwalChanges.sort((a,b)=> a.NoRecordTo - b.NoRecordTo).forEach((ele)=>{
                    ChangesSesudah +=
                        "<tr>"+
                            "<td>"+ele.NoRecordTo+"</td>"+
                            "<td>"+ele.TanggalTo.split(' ')[0]+"</td>"+
                            "<td>"+ele.TanggalTo.split(' ')[1]+"</td>"+
                            "<td>"+ele.NamaMateriTo+"</td>"+
                        "</tr>"
                    
                })
                let LinkData =URLData.split('#')
                let disChanges = LinkData[1]=='ubahjadwal'&&parseInt(LinkData[2])==ele.IDJadwalChange?'':'none'
              // console.log(ChangesSebelum)
                $('#list-history-changes').append(
                    "<a style=\"cursor: pointer\" onclick=\"showHistoryChanges("+ele.IDJadwalChange+")\" class=\"list-group-item list-group-item-action\">"+
                        "<h2>"+ele.JadwalChanges[0].TanggalFrom+"<span class=\"text-success\">( "+StatusChange+" )</span></h2>"+
                        "<div id=\"history-changes-"+ele.IDJadwalChange+"\" class=\"row\" style=\"display: "+disChanges+"\">"+
                            "<div class=\"col-md-6\">"+
                                "<h4>Sebelum</h4>"+
                                "<div class=\"table-responsive\">"+
                                    "<table class=\"table\">"+
                                        "<thead><tr><th>Pertemuan</th> <th>Tanggal</th><th>Jam</th><th>Nama Materi</th></tr></thead>"+
                                        "<tbody class=\"bg-warning text-white\" >"+ChangesSebelum+"</tbody>"+
                                    "</table>"+
                                "</div>"+
                            "</div>"+
                            "<div class=\"col-md-6\">"+
                                "<h4>Sesudah</h4>"+
                                "<div class=\"table-responsive\">"+
                                "<table class=\"table\">"+
                                    "<thead><tr><th>Pertemuan</th> <th>Tanggal</th><th>Jam</th><th>Nama Materi</th></tr></thead>"+
                                    "<tbody class=\"bg-success text-white\" >"+ChangesSesudah+"</tbody>"+
                                "</table>"+
                                "</div>"+
                            "</div>"+
                       " </div>"+
                    "</a>"
                );
                statusUbahJadwal()
            })
        });
    }
    //jika aada request jadwal pending tidak boleh membuat request jadwal
    function statusUbahJadwal(){
        if(jadwal.length === 0){
            $('#select-ubah-jadwal').hide()
            $('#btn-buat-ulang-jadwal').hide()
        }
        if(jadwal.length >0){
            $('#select-ubah-jadwal').show()
            $('#btn-buat-ulang-jadwal').show()
        }
        if(JadwalChanges.some(ele=>ele.Status == 'OPN')){
            $('#select-ubah-jadwal').hide()
            $('#btn-buat-ulang-jadwal').hide()
        }
    }
    function showHistoryChanges(id){

        if($('#history-changes-'+id+':hidden').length == 1){

        $('#history-changes-'+id).show();
        }else{

        $('#history-changes-'+id).hide();
        }
    }
</script>
@endpush
@endsection