@extends('karyawan.layouts.layout')
@section('title','Program Studi')
@section('kelas','current-page')
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
                        <a class="btn btn-sm btn-primary" 
                        href="{{url('karyawan/tutor/nilai')}}/{{$Prodi[0]->UUIDKelas}}" 
                        role="button">
                            Nilai
                        </a>
                        <a class="btn btn-sm btn-primary" 
                        href="{{url('karyawan/tutor/nilaieval')}}/{{$Prodi[0]->UUIDKelas}}" 
                        role="button">
                            Nilai Evaluasi
                        </a>
                        
                    </ul>
                </div>
                {{-- nav menu --}}

                <div class="col-md-12" style=" border-bottom: 0.01em solid #0D6c757d;">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" onclick="changeActiveContent('pertemuan')" id="btn-pertemuan"
                            class="btn btn-nav ">Jadwal</button>
                        @if (count($Modul)>0)               
                            <button type="button" onclick="changeActiveContent('modul')" id="btn-modul"
                                class="btn btn-nav ">Modul</button>
                        @endif
                        @if (count($Video)>0)               
                            <button type="button" id="btn-video" onclick="changeActiveContent('video')"
                                class="btn btn-nav">Video</button>
                        @endif
                        @if (count($BahanTutor)>0)               
                        <button type="button" id="btn-bahantutor" onclick="changeActiveContent('bahantutor')"
                            class="btn btn-nav">Bahan Tutor</button>
                        @endif
                        <button type="button" id="btn-ubahjadwal" onclick="changeActiveContent('ubahjadwal')"
                            class="btn btn-nav">Perubahan Jadwal</button>
                    </div>
                </div>

                <hr>
            </div>

        
            <div class="x_content">
                {{-- konten pertemuan dan materi --}}

                <div style="display: none" id="content-pertemuan" class="row mt-3">
                    <div class="col-md-12">

                        <table id="table-jadwal" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Kelas</th>
                                    <th>Nama Materi</th>
                                    <th>Kode Kursus</th>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
                            @foreach ($Modul as $modul)

                            <tr>
                                <td scope="row">
                                    <h5>{{$modul->Judul}}</h5>
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-primary"
                                        href="{{url('karyawan/tutor/program/stream/modul')}}/{{explode('.',$modul->Modul)[0]}}"
                                        target="_blank" role="button">{{$modul->Modul}}</a>
                                    {{-- <input type="file" class="form-control-file" name="" id="" placeholder="" aria-describedby="fileHelpId">   --}}
                                </td>
               
                            </tr>
                            @endforeach
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
                {{-- konten Bahan Tutor --}}

                <div style="display: none" id="content-bahantutor" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 35%">Nama</th>
                                <th>File</th>
               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($BahanTutor as $bahantutor)
                            <tr>
                                <td scope="row">
                                    <h5>{{$bahantutor->NamaBahan}}</h5>
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-primary"
                                        href="{{url('karyawan/tutor/program/stream/modul')}}/{{explode('.',$bahantutor->File)[0]}}"
                                        target="_blank" role="button">{{$bahantutor->File}}</a>
                                    {{-- <input type="file" class="form-control-file" name="" id="" placeholder="" aria-describedby="fileHelpId">   --}}
                                </td>
               
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div style="display: none" id="content-ubahjadwal" class="row mt-3">
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
</div>


<!-- Button trigger modal -->


<!-- Modal nilai evaluasi-->
<div class="modal fade" id="modal-eva" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Evaluasi materi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{url('karyawan/tutor/evaluasi/store')}}" method="POST">
                <input type="hidden" id="csrf" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="idkursussiswa" value="{{$Prodi[0]->IDKursusSiswa}}">
                <input type="hidden" name="idkursusmateri" id="idkursusmateri-eva">
            <div class="modal-body">
                <div class="form-group">
                    <label for="pertemuan-eva">Pertemuan ke</label>
                    <input type="text" readonly name="pertemuan" id="pertemuan-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="materi-eva">Materi</label>
                    <input type="text" readonly name="materieva" id="materi-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="plus-eva">Nilai (+)</label>
                    <input type="text" name="pluseva" id="plus-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="minus-eva">Nilai (-)</label>
                    <input type="text" name="minuseva" id="minus-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                </div>
                <div class="form-group">
                    <label for="saran-eva">Saran</label>
                    <input type="text" name="saraneva" id="saran-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')

<script>
    let active_content = "pertemuan";
    const btn_prodi = $('#btn-prodi');
    const btn_pertemuan = $('#btn-pertemuan');
    const btn_modul = $('#btn-modul');
    const btn_tool = $('#btn-tool');
    const btn_video = $('#btn-video');
    const btn_bahantutor = $('#btn-bahantutor');
    const btn_ubahjadwal = $('#btn-ubahjadwal');
    const content_ubahjadwal = $('#content-ubahjadwal');
    const content_prodi = $('#content-prodi');
    const content_pertemuan = $('#content-pertemuan');
    const content_modul = $('#content-modul');
    const content_tool = $('#content-tool');
    const content_video = $('#content-video');
    const content_bahantutor = $('#content-bahantutor');
    const TabelDataJadwal = $('#table-jadwal').DataTable();
    let JadwalChanges = [];
    const Hari = [
        {'Hari':'Senin','No':1},
        {'Hari':'Selasa','No':2},
        {'Hari':'Rabu','No':3},
        {'Hari':'Kamis','No':4},
        {'Hari':'Jumat','No':5},
        {'Hari':'Sabtu','No':6},
        {'Hari':'Minggu','No':7},
    ]
    toastr.options = {
        'timeOut' : 0,
        "positionClass": "toast-bottom-full-width",
        'extendedTimeOut' : 0,
        'preventDuplicates' :true
    }
    $(document).ready(function () {
        console.log(active_content);
        $('#table-jadwal').DataTable();
        showContent();
        showCicilan();
        showDataJadwal();
        getChanges();
    });

    function dialogEndKelas(NamaKelas,IDKursusMateri,NamaMateri,KodeKelas,NoRecord){
        swal({
              title: "Akhiri Kelas "+NamaKelas+"?",
              text: "Materi " +NamaMateri+" akan selesai!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                $('#pertemuan-eva').val(NoRecord);
                $('#idkursusmateri-eva').val(IDKursusMateri);
                $('#materi-eva').val(NamaMateri);
                $('#modal-eva').modal({backdrop: 'static', keyboard: false}) ;
                endKelas(IDKursusMateri,KodeKelas,NoRecord,NamaMateri);
              } else {
                  swal("Dibatalkan!");
              }
          });
    }

    function showDataJadwal(){
        $.get('/karyawan/tutor/jadwal/getdetaildata/'+$('#UUIDKelas').val(),function(Data){
  
                console.log(Data);
                $('#datatabel').empty();
                var a=0;
                var datenow = new Date().toLocaleString('en-US',{timeZone:'Asia/Bangkok'});
                var today = Date.parse(datenow);
        
                var now = today.getFullYear()+'-'+String(today.getMonth()+1).padStart(2,'0')+'-'+String(today.getDate()).padStart(2,'0');
                var jam = String(today.getHours()).padStart(2,'0')+':'+String(today.getMinutes()).padStart(2,'0')+':'+today.getMilliseconds();
    
                TabelDataJadwal.clear().draw();
                Data.forEach((data) =>{
                    a++;
                    console.log(data);
                    var b_mulai = "<form id=\"formstart"+data.IDKursusMateri+"\" method=\"POST\">"+
                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\">"+
                    "<input type=\"hidden\" name=\"idkursusmateri\" value=\""+data.IDKursusMateri+"\">"+
                    "<input type=\"hidden\" name=\"karyawan\" value=\""+data.IDTutor+"\">"+
                    "<input type=\"hidden\" name=\"idjadwal\" value=\""+data.IDJadwal+"\">"+
                    "<a onclick=\"startKelas(\'"+data.IDKursusMateri+"\',\'"+data.KodeKelas+"\')\" class=\"btn text-white btn-small btn-primary\">Mulai</a>"+
                    "</form>";
                    var b_akhir ="<a  onclick=\"dialogEndKelas(\'"+data.NamaProdi+"\',\'"+data.IDKursusMateri+"\',\'"+data.NamaMateri+"\',\'"+data.KodeKelas+"\',\'"+data.NoRecord+"\')\"  class=\"btn text-white btn-small btn-primary\">Akhiri kelas</a>"+
                    "<form id=\"formend"+data.IDKursusMateri+"\" method=\"POST\">"+
                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\">"+
                    "<input type=\"hidden\" name=\"idkursusmateri\" value=\""+data.IDKursusMateri+"\">"+
                    "<input type=\"hidden\" name=\"karyawan\" value=\""+data.IDTutor+"\">"+
                    "<input type=\"hidden\" name=\"idjadwal\" value=\""+data.IDJadwal+"\">"+
                  
                    "</form>";
                    var b_batalkan = "<a class=\"text-white btn btn-small btn-primary\">Batalkan</a>";
                    TabelDataJadwal.row.add([
                        
                        data.Tanggal.split(' ')[0],
                        data.Tanggal.split(' ')[1],
                        data.NamaProdi , 
                        data.NamaMateri,
                        data.KodeKursus,
                        data.NamaSiswa,
                        data.Status == 'CLS'?'Kelas Selesai':
                        data.Status == 'CFM'?'Sedang berlangsung':
                        now==data.Tanggal.split(' ')[0]?'Hari ini':
                        Date.parse(now)>Date.parse(data.Tanggal.split(' ')[0])?'Terlewat':
                        'Belum Mulai',
                        data.Status == 'CLS'?'<a class=\"btn text-white btn-success\">Selesai</a>':
                        data.Status == 'CFM'?b_akhir:
                        now==data.Tanggal.split(' ')[0]&&
                        Date.parse(jam)>= Date.parse(data.Tanggal.split(' ')[1])?b_mulai:
                        Date.parse(now)>Date.parse(data.Tanggal.split(' ')[0])?b_batalkan:
                        '',

                    ]).draw();
                });

        
        })
    }
    function startKelas(id,KodeKelas,NoRecord,NamaMateri){

        $.post('/karyawan/tutor/kursus/start',$('#formstart'+id).serialize())
        .done(function(param){
            showDataJadwal();
            //$.get('/karyawan/tutor/kursus/event/'+ KodeKelas);
            console.log(param);
        }).fail(function(param){
            console.log('error');
        })
    }
    function endKelas(id,KodeKelas){
        $.post('/karyawan/tutor/kursus/end',$('#formend'+id).serialize())
        .done(function(param){
            showDataJadwal();
            //$.get('/karyawan/tutor/kursus/event/'+ KodeKelas);
            console.log(param);
        }).fail(function(param){
            console.log('error');
        })
    }

    $('#content-prodi').on('change', function () {
        console.log('hello');
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
                btn_ubahjadwal.removeClass('active');
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
                btn_ubahjadwal.removeClass('active');
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
                btn_ubahjadwal.removeClass('active');
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
                btn_ubahjadwal.removeClass('active');
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
                btn_ubahjadwal.removeClass('active');
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
                btn_ubahjadwal.removeClass('active');
                content_ubahjadwal.hide();
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.show();


                break;
            case 'ubahjadwal':
                btn_prodi.removeClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
                btn_ubahjadwal.addClass('active');
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.hide();
                content_ubahjadwal.show();
                break;
        }
    }

    function showCicilan() {
        console.log($('#input-prodi-cicilan').val());
        if ($('#input-prodi-cicilan').val() == 'y') {
            $('#table-cicilan').show();
        } else {
            $('#table-cicilan').hide();
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
                console.log(pesan.Message);
                swal('gagal' + pesan.Pesan);
            });
    }
    function getChanges(){
        $('#list-history-changes').empty()
        $.get("/karyawan/tutor/jadwalchanges/get/"+$('#UUIDKelas').val(), (ele)=>{
            console.log(ele)
            JadwalChanges = ele
            JadwalChanges.sort((a,b)=> b.IDJadwalChange - a.IDJadwalChange).forEach((ele)=>{
                console.log(ele.JadwalChanges[0].TanggalFrom)
                let ChangesSebelum =""
                let ChangesSesudah =""
                let ChangesButton = ele.Status == 'OPN'?"<a class=\"btn btn-sm btn-danger text-white\""+
                    "onclick=\"answerChanges("+ele.IDJadwalChange+","+false+")\" role=\"button\">Tolak</a>"+
                    "<a class=\"btn btn-sm btn-success text-white\"  onclick=\"answerChanges("+ele.IDJadwalChange+","+true+")\"  role=\"button\">Terima</a>":""
                let StatusChange = ele.Status == 'OPN'?'Permintaan perubahan jadwal':ele.Status=='CLS'?' Disetujui':' Ditolak'
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
                console.log(ChangesSebelum)
                $('#list-history-changes').append(
                    "<a style=\"cursor: pointer\" onclick=\"showHistoryChanges("+ele.IDJadwalChange+")\" class=\"list-group-item list-group-item-action\">"+
                        "<h2>"+ele.JadwalChanges[0].TanggalFrom+
                        "<span class=\"text-success\">( "+StatusChange+" )</span>"+

                        "</h2>"+
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
                        ChangesButton+
                    "</a>"
                );
            })
        });
    }
    function showHistoryChanges(id){

        if($('#history-changes-'+id+':hidden').length == 1){

        $('#history-changes-'+id).show();
        }else{

        $('#history-changes-'+id).hide();
        }
    }
    function answerChanges(id,answer){
        $.get('/karyawan/tutor/jadwalchanges/answer/'+id+'/'+answer,(ele)=>{
            
            getChanges()
            swal(ele)
        })     
    }
</script>
@endpush
@endsection
