@extends('karyawan.layouts.layout')
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
                    <h2 style="color: black"> Program Studi</h2>
                </div>
                <div class="col-md-4">
                    <ul class="nav navbar-right panel_toolbox">

                    </ul>
                </div>
                {{-- nav menu --}}

                <div class="col-md-12" style=" border-bottom: 0.01em solid #0D6c757d;">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button style="padding-left:0px" onclick="changeActiveContent('prodi')" id="btn-prodi"
                            type="button" class="btn btn-nav">Program Studi</button>
                        <button type="button" onclick="changeActiveContent('pertemuan')" id="btn-pertemuan"
                            class="btn btn-nav ">Pertemuan dan materi</button>
                        <button type="button" onclick="changeActiveContent('modul')" id="btn-modul"
                            class="btn btn-nav ">Modul</button>
                        <button type="button" id="btn-tool" onclick="changeActiveContent('tool')"
                            class="btn btn-nav">Tool</button>
                        <button type="button" id="btn-video" onclick="changeActiveContent('video')"
                            class="btn btn-nav">Video</button>
                        <button type="button" id="btn-bahantutor" onclick="changeActiveContent('bahantutor')"
                            class="btn btn-nav">Bahan Tutor</button>

                    </div>
                </div>

                <hr>
            </div>
            <div class="x_content">

                {{-- konten program studi dan harga --}}
                <div style="display: none" id="content-prodi" class="row mt-3">

                    <form class="col-md-12" id="form-prodi">
                        @csrf
                        <input type="hidden" name="idprodi" value="{{$Prodi[0]->IDProgram}}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga-program">Harga Program</label>
                                <input type="text" name="hargaprodi" id="input-harga-program"
                                    class="form-control rounded" value="{{$Prodi[0]->Harga}}">

                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Harga Tool</label>
                                        <input type="text" name="" id="input-harga-total-tool"
                                            class="form-control rounded" readonly placeholder="">
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Harga Modul</label>
                                        <input type="text" name="" id="input-harga-total-modul"
                                            class="form-control rounded" readonly placeholder="">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Subtotal (Harga Lunas)</label>
                                <input type="text" name="" id="input-harga-total" class="form-control rounded" readonly
                                    placeholder="">
                                
                            </div>
                            <div class="form-group">
                                <label for="">Cicilan</label>
                                <select class="custom-select" onchange="showCicilan()" name="cicilanprodi"
                                    id="input-cicilan-prodi">
                                    <option value="n" @if ($Prodi[0]->Cicilan =='n'){{'selected'}} @endif>Tidak</option>
                                    <option value="y" @if ($Prodi[0]->Cicilan =='y'){{'selected'}} @endif>Iya</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1"></div>
                        {{-- info prodi --}}

                        <div class="col-md-5 ">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="namaprodi" id="input-nama-prodi" class="form-control rounded"
                                    value="{{$Prodi[0]->NamaProdi}}">
                                
                            </div>

                            <div class="form-group">
                                <label for="">Level</label>
                                <select class="custom-select rounded" name="levelprodi" id="input-level-prodi">
                                    @foreach ($LevelProgram as $level)
                                    <option value="{{$level->IDLevel}}" @if ($level->IDLevel ==
                                        $Prodi[0]->IDLevel){{'selected'}}@endif>{{$level->NamaLevel}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori Program</label>
                                <select class="custom-select rounded" name="kategoriprodi" id="input-kategori-prodi">
                                    @foreach ($KategoriProgram as $kategoriprogram)
                                    <option value="{{$kategoriprogram->IDKategoriProgram}}" @if ($kategoriprogram->
                                        IDKategoriProgram ==
                                        $Prodi[0]->IDKategoriProgram){{'selected'}}@endif>{{$kategoriprogram->KategoriProgram}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori Global Program</label>
                                <select class="custom-select rounded" name="kategoriglobalprodi"
                                    id="input-kategori-global-prodi">
                                    @foreach ($KategoriGlobalProgram as $kategoriglobal)
                                    <option value="{{$kategoriglobal->IDKategoriGlobalProgram}}" @if ($kategoriglobal->
                                        IDKategoriGlobalProgram ==
                                        $Prodi[0]->IDKategoriGlobalProgram){{'selected'}}@endif>{{$kategoriglobal->KategoriGlobalProgram}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="col-md-12" id="table-cicilan">

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th style="width: 17%">Cicilan</th>
                                    <th>Harga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Cicilan as $cicilan)
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="" id=""
                                            value="{{$cicilan->Cicilan}}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="" id=""
                                            value="{{$cicilan->Harga}}">
                                    </td>
                                    <td>
                                        <a name="" id="" class="btn btn-danger btn-sm" href="#" role="button">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#cicilan-modal-add">
                            Tambah cicilan
                        </button>
                       
                    </div>
                </div>
                <!-- Button trigger modal -->

                


                {{-- konten pertemuan dan materi --}}

                <div style="display: none" id="content-pertemuan" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 5%">Pertemuan</th>
                                <th>Materi</th>
                                <th>Kategori</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($MateriProgram as $materiprogram)
                            <tr>
                                <td scope="row">
                                    <input type="text" class="form-control" readonly
                                        value="{{$materiprogram->NoRecord}}" name="" id="">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name=""
                                        value="{{$materiprogram->NamaMateri}}" id="">
                                </td>
                                <td>
                                    <select class="custom-select" name="" id="">
                                        @foreach ($KategoriMateri as $kategorimateri)

                                        <option value="{{$kategorimateri->IDKategoriMateri}}" @if ($kategorimateri->
                                            IDKategoriMateri == $materiprogram->IDKategoriMateri)

                                            @endif>{{$kategorimateri->NamaKategoriMateri}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>

                                    <a name="" id="" class="btn btn-danger btn-sm" href="#" role="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <a name="" id="" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Pertemuan</a>
                    </table>

                </div>
                {{-- konten Modul --}}

                <div style="display: none" id="content-modul" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 20%">Nama</th>
                                <th>Modul</th>
                                <th>Harga</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Modul as $modul)

                            <tr>
                                <td scope="row">
                                    <input type="text" class="form-control" value="{{$modul->Judul}}" name="" id="">
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-primary"
                                        href="{{url('karyawan/admin/program/stream/modul')}}/{{explode('.',$modul->Modul)[0]}}"
                                        target="_blank" role="button">{{$modul->Modul}}</a>
                                    {{-- <input type="file" class="form-control-file" name="" id="" placeholder="" aria-describedby="fileHelpId">   --}}
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{$modul->Harga}}" name="" id="">
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-danger btn-sm" href="#" role="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <a name="" id="" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Modul</a>
                    </table>

                </div>
                {{-- konten Tool --}}

                <div style="display:none" id="content-tool" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 40%">Nama</th>
                                <th>Harga</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Tool as $tool)

                            <tr>
                                <td scope="row">
                                    <input type="text" class="form-control" value="{{$tool->NamaTool}}" name="" id="">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{$tool->Harga}}" name="" id="">
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-danger btn-sm" href="#" role="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <a name="" id="" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Tool</a>
                    </table>

                </div>
                {{-- konten Video --}}

                <div style="display: none" id="content-video" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 40%">Judul</th>
                                <th>Link</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Video as $video)
                            <tr>
                                <td scope="row">
                                    <input type="text" class="form-control" value="{{$video->Judul}}" name="" id="">
                                </td>
                                <td>
                                    <iframe src="{{$video->Link}}" frameborder="0" allowfullscreen></iframe>
                                    <input type="text" class="form-control" value="{{$video->Link}}" name="" id="">
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-danger btn-sm" href="#" role="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <a name="" id="" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Video</a>
                        <h5>Format link : https://www.youtube.com/embed/id_video</h5>
                    </table>

                </div>
                {{-- konten Bahan Tutor --}}

                <div style="display: none" id="content-bahantutor" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 35%">Nama</th>
                                <th>File</th>
                                <th style="width: 35%">Tipe Bahan</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($BahanTutor as $bahantutor)
                            <tr>
                                <td scope="row">
                                    <input type="text" class="form-control" value="{{$bahantutor->NamaBahan}}" name=""
                                        id="">
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-primary"
                                        href="{{url('program_studi/bahan_tutor')}}/{{$bahantutor->File}}"
                                        target="_blank" role="button">{{$bahantutor->File}}</a>
                                    {{-- <input type="file" class="form-control-file" name="" id="" placeholder="" aria-describedby="fileHelpId">   --}}
                                </td>
                                <td>
                                    <select class="custom-select" name="" id="">
                                        <option value="presentasi" @if($bahantutor->Type ==
                                            'presentasi'){{'selected'}}@endif >Presentasi (PPT)</option>
                                        <option value="kurikulum" @if($bahantutor->Type ==
                                            'kurikulum'){{'selected'}}@endif>Kurikulum</option>
                                        <option value="pegangantutor" @if($bahantutor->Type ==
                                            'pegangantutor'){{'selected'}}@endif>Pegangan Tutor</option>
                                    </select>
                                </td>
                                <td>
                                    <a name="" id="" class="btn btn-danger btn-sm" href="#" role="button">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <a name="" id="" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Bahan Tutor</a>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cicilan-modal-add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="cicilan-form-add">
                <div class="modal-header">
                    <h5 class="modal-title">Cicilan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label for="">Dicicil berapa kali</label>
                      <input type="text" class="form-control" name="cicilan-cicilan" id="cicilan-cicilan-add" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Harga cicilan</label>
                        <input type="text" class="form-control" name="cicilan-harga" id="cicilan-harga-add" aria-describedby="helpId" placeholder="">
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a  onclick="addItem('cicilan-form-add')" class=" text-white btn btn-primary">Save</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-pertemuan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-modul" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-tool" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-video" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-bahantutor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add-cicilan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-cicilan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    let active_content = "prodi";
    const btn_prodi = $('#btn-prodi');
    const btn_pertemuan = $('#btn-pertemuan');
    const btn_modul = $('#btn-modul');
    const btn_tool = $('#btn-tool');
    const btn_video = $('#btn-video');
    const btn_bahantutor = $('#btn-bahantutor');
    const content_prodi = $('#content-prodi');
    const content_pertemuan = $('#content-pertemuan');
    const content_modul = $('#content-modul');
    const content_tool = $('#content-tool');
    const content_video = $('#content-video');
    const content_bahantutor = $('#content-bahantutor');
    let program_studi;
    let pertemuan_materi;
   

    //items//
    let CicilanCreate =0;
    let modul = 0;
    let tool = 0;
    let video = 0;
    let bahantutor = 0;

    //HARGA//
    let hargaTotalModul=0;
    let hargaTotalTool=0;


    toastr.options = {
        'allowHtml': true,
        'maxOpened':1,
        'tapToDismiss':false,
        'timeOut' : 0,
        "positionClass": "toast-bottom-full-width",
        'extendedTimeOut' : 0,
        'preventDuplicates' :true
    }
    $(document).ready(function () {
        showContent();
        showCicilan();
        //fungsi input map program studi
        setProgramStudi();
        console.log(program_studi);
    });

    $('#content-prodi').on('change', function () {
        showToastProgramStudi();
    });
    function showToastProgramStudi(){
        if(prodiIsChange()){
            toastr.success(
                '<div id="prodi-changed" class="d-flex justify-content-between">'+
                    '<p >Perhatian - Kamu belum menyimpan perubahan!</p>'+
                    '<a onclick="updateProdi()" id="" class="ml-4 btn btn-primary btn-sm" href="javascript:void(0)" role="button">Simpan perubahan</a>'+
                '</div>'
            );
        }else{
            toastr.clear();
        }
    }
    function setProgramStudi(){
        program_studi = {
            'program-harga': $('#input-harga-program').val(),
            'program-cicilan': $('#input-cicilan-prodi').val(),
            'program-nama': $('#input-nama-prodi').val(),
            'program-level': $('#input-level-prodi').val(),
            'program-kategori-program': $('#input-kategori-prodi').val(),
            'program-kategori-global-program': $('#input-kategori-global-prodi').val(),
        }
    }
    function prodiIsChange(){
        let ps = program_studi;
        let isChange = 
            ps['program-harga']!= $('#input-harga-program').val()||
            ps['program-cicilan']!= $('#input-cicilan-prodi').val()||
            ps['program-nama']!= $('#input-nama-prodi').val()||
            ps['program-level']!= $('#input-level-prodi').val()||
            ps['program-kategori-program']!= $('#input-kategori-prodi').val()||
            ps['program-kategori-global-program']!= $('#input-kategori-global-prodi').val();
        return isChange;
    }
    function showContent() {
        switch (active_content) {
            case 'prodi':
                btn_prodi.addClass('active');
                btn_pertemuan.removeClass('active');
                btn_modul.removeClass('active');
                btn_tool.removeClass('active');
                btn_video.removeClass('active');
                btn_bahantutor.removeClass('active');
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
                content_prodi.hide();
                content_pertemuan.hide();
                content_modul.hide();
                content_tool.hide();
                content_video.hide();
                content_bahantutor.show();
                break;
        }
    }

    function showCicilan() {
        if ($('#input-cicilan-prodi').val() == 'y') {
            $('#table-cicilan').show();
        } else {
            $('#table-cicilan').hide();
        }
    }
    //mengganti tab yang aktif
    function changeActiveContent(data) {
        if(prodiIsChange()){
            swal({
                title: "Perhatian!",
                text: "Anda belum menyimpan perubahan yang ada!",
                icon: "warning",
                button: "Oke",
            });
        }else{
            active_content = data;
            showContent();
        }
    }

    function updateProdi() {
        console.log('okei');
        toastr.clear();
        // setProgramStudi();
        // $.post('/karyawan/admin/master/program/update', $('#form-prodi').serialize())
        //     .done(function (pesan) {
        //         swal(pesan.Pesan);
        //     }).fail(function (pesan) {
        //         console.log(pesan.Message);
        //         swal('gagal' + pesan.Pesan);
        // });
 
    }
    function resetItems(){
        CicilanCreate =0;
        modul = 0;
        tool = 0;
        video = 0;
        bahantutor = 0;
    }
    function addItem(item){
        $.post('/admin/program/',$('#'+item).serialize());
    }
</script>
@endpush
@endsection