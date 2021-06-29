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

</style>

<div class="row bg-white">



    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel" style="border:0px;">
            <div class="row">
                <div class="col-md-8">
                    <h2 style="color: black"> Kelas {{$Prodi[0]->NamaProdi}} </h2>
                    <input type="hidden" id="UUIDKelas" value="{{$Prodi[0]->UUIDKelas}}">
                    {{-- <small>({{$Prodi[0]->KodeKursus}})</small>**/ --}}
                </div>
                <div class="col-md-4">
                    <ul class="nav navbar-right panel_toolbox">
                        <a class="btn btn-sm btn-primary" href="{{url('siswa/nilai')}}/{{$Prodi[0]->UUIDKelas}}" role="button">Nilai</a>
                    </ul>
                    <ul class="nav navbar-right panel_toolbox">
                        <a class="btn btn-sm btn-primary" href="{{url('siswa/nilaieval')}}/{{$Prodi[0]->UUIDKelas}}" role="button">Nilai Evaluasi</a>
                    </ul>
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
                {{-- konten Modul --}}

                <div style="display: none" id="content-modul" class="row mt-3">
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
  
                {{-- konten Video --}}

                <div style="display: none" id="content-video" class="row mt-3">
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
                {{-- konten pertemuan dan materi selesai --}}
                <div style="display: none" id="content-selesai" class="row mt-3">
                    <div class="col-md-12 ">

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
                            <div class="col-md-7"></div>
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
                            
                            <a id="button-ubah-jadwal" onclick="traceJadwalChange()" class="btn btn-primary" href="javascript:void(0)" role="button">Ubah</a>
                        </div>
                        <div style="display: none" id="input-ubah-semua-jadwal">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Libur berapa lama</label>
                                        <select class="custom-select" id="input-freeze-jadwal">
                                            <option value="7">1 minggu</option>
                                            <option value="14">2 minggu</option>
                                            <option value="21">3 minggu</option>
                                            <option value="30">1 bulan</option>
                                        </select>
                                    </div>        
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                            <a id="button-ubah-jadwal" onclick="freezeJadwal()" class="btn btn-primary" href="javascript:void(0)" role="button">Ubah</a>
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
                    <div class="col-md-6">
                        <h4>Sesudah</h4>
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
    let jadwal_selesai=[];
    let jadwal = [];
    let ReqJadwalChanges = [];
    let JadwalChanges = [];

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

        $('#tabel-jadwal').DataTable();
        showContent();
        showJadwal();
        getChanges();
    });

    // window.Echo.channel('Event'+$('#UUIDKelas').val()).listen('.Kelas', function (e) {
    //     console.log(e);
    //     showJadwal();

    // });
    function freezeJadwal(){
        let freeze = $('#input-freeze-jadwal').val();
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
        jadwal.forEach((data)=>{
            let tmpDate = moment(data.Tanggal+' '+data.Jam).format('yyyy-MM-DD HH:mm:ss')
            console.log('firs',tmpDate)
            let dateTo = moment(tmpDate).add(freeze,'days').format('yyyy-MM-DD HH:mm:ss')
            console.log(dateTo)
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
                'TanggalTo': dateTo
            })

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
        console.log(DataChanges)
        ReqJadwalChanges = DataChanges
        console.log(ReqJadwalChanges)
        setAndShowDataModalChanges(newJadwal)
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
    
    function showJadwal(){
        // console.log('get req jadwal siswa/jadwal/getdata'+$('#UUIDKelas').val());
        $.get('/siswa/jadwal/getdata/'+$('#UUIDKelas').val(),(data)=>{
            console.log(data)
            $('#data-table-jadwal').empty();
            $('#data-table-jadwal-selesai').empty();
            TabelJadwal.clear().draw();
            data.forEach((element) => {
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
    function traceJadwalChange(){
        let JadwalChanged =[]
        let InputNoRecord = $('#input-ubah-jadwal-select').val()
        let reqTanggal = $('#input-ubah-jadwal-tanggal').val()
        let reqJam = $('#input-ubah-jadwal-jam').val()
        let jadwalChangedIndex = jadwal.findIndex(ele => ele.NoRecord == InputNoRecord)
        let jadwalPrevChanged = jadwal[jadwalChangedIndex].Tanggal+' '+jadwal[jadwalChangedIndex].Jam
 
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
            setAndShowDataModalChanges(JadwalChanged)
        }
        if(jadwal[jadwalChangedIndex].Tanggal != reqTanggal){
            let reqJadwal = jadwal[jadwalChangedIndex].Tanggal != reqTanggal
            && jadwal[jadwalChangedIndex].Jam != reqJam ?reqTanggal+' '+reqJam:
            jadwal[jadwalChangedIndex].Tanggal != reqTanggal
            && jadwal[jadwalChangedIndex].Jam == reqJam? reqTanggal+' '+jadwal[jadwalChangedIndex].Jam:''
            if(filterSameDate(jadwal,reqJadwal).length != 0){
                swal('Jadwal penuh')
            }else{
                // jadwalPrevChanged = jadwal yang akan di ubah
                // jadwal = semua jadwal yang belum di ubah
                // reqJadwal = perubahan jadwal
                let tmp_new_jadwal = filterCheckPrevRecord(jadwal,reqJadwal,jadwalPrevChanged)
                let ite = 0
                console.log(tmp_new_jadwal)
                console.log(tmp_new_jadwal.length,'berapa cm')
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
                        'TanggalTo':tmp_new_jadwal[ite+1].Tanggal+' '+tmp_new_jadwal[ite+1].Jam
                    }
                    ite ++;
                    return data
                })
                console.log('new jadwal',newJadwal)

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
                console.log(DataChanges)
                ReqJadwalChanges = DataChanges
                console.log(ReqJadwalChanges)
                setAndShowDataModalChanges(newJadwal)
             
            }
        }
        //kunai
       
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
        $.post("/siswa/jadwalchanges/store", ReqJadwalChanges, ele => swal('Permintaan terkirim'))
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
                            "<td>"+ele.IDMateriFrom+"</td>"+
                        "</tr>"
                })
                ele.JadwalChanges.sort((a,b)=> a.NoRecordTo - b.NoRecordTo).forEach((ele)=>{
                    ChangesSesudah +=
                        "<tr>"+
                            "<td>"+ele.NoRecordTo+"</td>"+
                            "<td>"+ele.TanggalTo.split(' ')[0]+"</td>"+
                            "<td>"+ele.TanggalTo.split(' ')[1]+"</td>"+
                            "<td>"+ele.IDMateriTo+"</td>"+
                        "</tr>"
                    
                })
              // console.log(ChangesSebelum)
                $('#list-history-changes').append(
                    "<a style=\"cursor: pointer\" onclick=\"showHistoryChanges("+ele.IDJadwalChange+")\" class=\"list-group-item list-group-item-action\">"+
                        "<h2>"+ele.JadwalChanges[0].TanggalFrom+"<span class=\"text-success\">( "+StatusChange+" )</span></h2>"+
                        "<div id=\"history-changes-"+ele.IDJadwalChange+"\" class=\"row\" style=\"display: none\">"+
                            "<div class=\"col-md-6\">"+
                                "<h4>Sebelum</h4>"+
                                "<table class=\"table\">"+
                                    "<thead><tr><th>Pertemuan</th> <th>Tanggal</th><th>Jam</th><th>Nama Materi</th></tr></thead>"+
                                    "<tbody class=\"bg-warning text-white\" >"+ChangesSebelum+"</tbody>"+
                                "</table>"+
                            "</div>"+
                            "<div class=\"col-md-6\">"+
                                "<h4>Sesudah</h4>"+
                                "<table class=\"table\">"+
                                    "<thead><tr><th>Pertemuan</th> <th>Tanggal</th><th>Jam</th><th>Nama Materi</th></tr></thead>"+
                                    "<tbody class=\"bg-success text-white\" >"+ChangesSesudah+"</tbody>"+
                                "</table>"+
                            "</div>"+
                       " </div>"+
                    "</a>"
                );
            })
        });
    }
    //jika aada request jadwal pending tidak boleh membuat request jadwal
    function statusUbahJadwal(){
        console.log('trace paket',jadwal.length,jadwal,JadwalChanges)
        if(jadwal.length ==0){
            $('#select-ubah-jadwal').hide()
        }
        if(JadwalChanges.some(ele=>ele.Status == 'OPN')){
            $('#select-ubah-jadwal').hide()
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