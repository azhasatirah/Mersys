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

    #toast-container>.toast-success {
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
                    <div class="col-md-12" style="display: none" id="prodi-changes-control">
                        <div class="col-md-12 mx-3 mb-3 bg-dark text-white" style="width:25rem;border-radius:5px">
                            <div style="margin: 15px">
                                <h4>Anda telah mengubah data program studi</h4>
                                <a onclick="resetProdi()" class="btn btn-sm btn-danger text-white"
                                    href="javascript:void(0)" role="button">Reset</a>
                                <a onclick="updateProdi()" class="btn btn-sm btn-primary text-white"
                                    href="javascript:void(0)" role="button">Simpan perubahan</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="display: none" id="prodi-changes-control">
                        <div class="col-md-12 mx-3 mb-3 bg-dark text-white" style="width:25rem;border-radius:5px">
                            <div style="margin: 15px">
                                <h4>Anda telah mengubah data cicilan</h4>
                                <a onclick="resetProdiCicilan()" class="btn btn-sm btn-danger text-white"
                                    href="javascript:void(0)" role="button">Reset</a>
                                <a onclick="updateProdiCicilan()" class="btn btn-sm btn-primary text-white"
                                    href="javascript:void(0)" role="button">Simpan perubahan</a>
                            </div>
                        </div>
                    </div>
                    <form class="col-md-12" id="form-prodi">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
                        <input type="hidden" id="idprodi" name="idprodi" value="{{$Prodi[0]->IDProgram}}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga-program">Harga Program</label>
                                <input type="text" name="hargaprodi" id="input-harga-program"
                                    class="form-control rounded" >


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
                                    <option value="n">Tidak</option>
                                    <option value="y">Iya</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1"></div>
                        {{-- info prodi --}}
                        <div class="col-md-5 ">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="namaprodi" id="input-nama-prodi" class="form-control rounded">

                            </div>

                            <div class="form-group">
                                <label for="">Level</label>
                                <select class="custom-select rounded" name="levelprodi" id="input-level-prodi">
                                    @foreach ($LevelProgram as $level)
                                    <option value="{{$level->IDLevel}}" >{{$level->NamaLevel}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori Program</label>
                                <select class="custom-select rounded" name="kategoriprodi" id="input-kategori-prodi">
                                    @foreach ($KategoriProgram as $kategoriprogram)
                                    <option value="{{$kategoriprogram->IDKategoriProgram}}">{{$kategoriprogram->KategoriProgram}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kategori Global Program</label>
                                <select class="custom-select rounded" name="kategoriglobalprodi"
                                    id="input-kategori-global-prodi">
                                    @foreach ($KategoriGlobalProgram as $kategoriglobal)
                                    <option value="{{$kategoriglobal->IDKategoriGlobalProgram}}" >{{$kategoriglobal->KategoriGlobalProgram}}
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
                            <tbody id="list-cicilanss-prodi">
                            



                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm ml-3" data-toggle="modal"
                            data-target="#cicilan-modal-add">
                            Tambah cicilan
                        </button>

                    </div>
                </div>
                {{-- konten pertemuan dan materi --}}
                <div style="display: none" id="content-pertemuan" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 3%">Pertemuan</th>
                                <th>Materi</th>
                                <th>Tugas / PR</th>
                                <th style="width: 15%">Kategori</th>
                                <th style="width: 7%"></th>
                            </tr>
                        </thead>
                        <tbody id="list-pertemuan" >
                        </tbody>
                        <a name="" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button"
                        data-toggle="modal" data-target="#modal-add-pertemuan">
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
                        <tbody id="list-modul"></tbody>
                        <a data-target="#modal-add-modul" data-toggle="modal" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
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
                        <tbody id="list-tool"></tbody>
                        <a data-toggle="modal" data-target="#modal-add-tool" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
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
                                <th>Video</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody id="list-video"></tbody>
                        <a data-toggle="modal" data-target="#modal-add-video" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Video</a>
                    </table>

                </div>
                {{-- konten Bahan Tutor --}}
                <div style="display: none" id="content-bahantutor" class="row mt-3">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th style="width: 35%">Nama</th>
                                <th>File</th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>
                        <tbody id="list-bahan">
                        </tbody>
                        <a data-toggle="modal" data-target="#modal-add-bahan" class="btn btn-sm btn-primary ml-3" href="javascript:void(0)" role="button">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Tambah Bahan Tutor</a>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cicilan-modal-add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: 400px">
            <div class="row mt-5" id="modal-add-cicilan-loading" style="display:none ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    
                    <img class="img-fluid" 
                    src="{{asset('images/load.gif')}}" alt="" srcset="">
                </div>
                <div class="col-md-2"></div>
            </div>
            <section id="modal-add-cicilan-content">

                <form id="form-cicilan-add">
                    @csrf
                    <input type="hidden" id="cicilanidprogram" name="cicilanidprogram">
                    <div class="modal-header">
                        <h5 class="modal-title">Cicilan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Dicicil berapa kali</label>
                            <input type="text" class="form-control" name="cicilancicilan" id="cicilan-cicilan-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Harga cicilan</label>
                            <input type="text" class="form-control" name="cicilanharga" id="cicilan-harga-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a onclick="storeCicilan()" class=" text-white btn btn-primary">Save</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-pertemuan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: 400px">
            <div class="row mt-5" id="modal-add-pertemuan-loading" style="display:none ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    
                    <img class="img-fluid" 
                    src="{{asset('images/load.gif')}}" alt="" srcset="">
                </div>
                <div class="col-md-2"></div>
            </div>
            <section id="modal-add-pertemuan-content">

                <form id="form-pertemuan-add">
                    @csrf
                    <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                    <div class="modal-header">
                        <h5 class="modal-title">Pertemuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Materi</label>
                            <input type="text" class="form-control" name="pertemuanmateri" id="pertemuan-materi-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Kategori Materi</label>
                            <select class="custom-select" name="pertemuankategori" id="pertemuan-kategori-add">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tugas / PR</label>
                            <input type="text" class="form-control" name="pertemuanhomework" id="pertemuan-homework-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a onclick="storePertemuan()" class=" text-white btn btn-primary">Save</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-modul" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: 400px">
            <div class="row mt-5" id="modal-add-modul-loading" style="display:none ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    
                    <img class="img-fluid" 
                    src="{{asset('images/load.gif')}}" alt="" srcset="">
                </div>
                <div class="col-md-2"></div>
            </div>
            <section id="modal-add-modul-content">

                <form id="form-modul-add" enctype="multipart/form-data">
                    @csrf
                    <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah modul</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" id="modul-nama-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="">Modul</label>
                          <input type="file" class="form-control" name="modul" id="modul-modul-add" >
                        </div>
                        <div class="form-group">
                            <label for="">Harga</label>
                            <input type="text" class="form-control" name="harga" id="modul-harga-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="storeModul()" id="btn-store-modul" class=" text-white btn btn-primary">Save</button>
                </div>
            </section>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-add-tool" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: 400px">
            <div class="row mt-5" id="modal-add-tool-loading" style="display:none ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    
                    <img class="img-fluid" 
                    src="{{asset('images/load.gif')}}" alt="" srcset="">
                </div>
                <div class="col-md-2"></div>
            </div>
            <section id="modal-add-tool-content">

                <form id="form-tool-add">
                    @csrf
                    <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah tool</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Tool</label>
                            <input type="text" class="form-control" name="namatool" id="tool-nama-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Harga Tool</label>
                            <input type="text" class="form-control" name="hargatool" id="tool-harga-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a onclick="storeTool()" class=" text-white btn btn-primary">Save</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-video" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: 400px">
            <div class="row mt-5" id="modal-add-video-loading" style="display:none ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    
                    <img class="img-fluid" 
                    src="{{asset('images/load.gif')}}" alt="" srcset="">
                </div>
                <div class="col-md-2"></div>
            </div>
            <section id="modal-add-video-content">

                <form id="form-video-add">
                    @csrf
                    <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah video</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" class="form-control" name="judul" id="video-judul-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Embed video</label>
                            <input type="text" class="form-control" name="video" id="video-video-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a onclick="storeVideo()" class=" text-white btn btn-primary">Save</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-bahan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="height: 400px">
            <div class="row mt-5" id="modal-add-bahan-loading" style="display:none ">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    
                    <img class="img-fluid" 
                    src="{{asset('images/load.gif')}}" alt="" srcset="">
                </div>
                <div class="col-md-2"></div>
            </div>
            <section id="modal-add-bahan-content">

                <form id="form-bahan-add" enctype="multipart/form-data">
                    @csrf
                    <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="nama" id="bahan-nama-add"
                                aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="">Bahan</label>
                          <input type="file" class="form-control" name="modul" id="bahan-bahan-add" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a onclick="storeBahan()" id="btn-store-bahan" class=" text-white btn btn-primary">Save</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>


<!-- Modal edit cicilan --> 
<div class="modal fade" id="cicilan-modal-edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-cicilan-edit">
                @csrf
                <input type="hidden" id="cicilanidprogramedit" name="cicilanidprogram">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Cicilan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Dicicil berapa kali</label>
                        <input type="text" class="form-control" name="cicilancicilan" id="cicilan-cicilan-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Harga cicilan</label>
                        <input type="text" class="form-control" name="cicilanharga" id="cicilan-harga-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a onclick="updateCicilan()" class=" text-white btn btn-primary">Edit</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-pertemuan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-pertemuan-edit">
                @csrf
                <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                <input type="hidden" name="idmateriprogram" id="pertemuan-idmateriprogram-edit">
                <div class="modal-header">
                    <h5 class="modal-title">Edit pertemuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pertemuan ke</label>
                        <input type="text" class="form-control" readonly name="pertemuanmateri" id="pertemuan-pertemuan-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Materi</label>
                        <input type="text" class="form-control" name="pertemuanmateri" id="pertemuan-materi-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Kategori Materi</label>
                        <select class="custom-select" name="pertemuankategori" id="pertemuan-kategori-edit">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tugas / PR</label>
                        <input type="text" class="form-control" name="pertemuanhomework" id="pertemuan-homework-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a onclick="updatePertemuan()" class=" text-white btn btn-primary">Edit</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-tool" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-tool-edit">
                @csrf
                <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                <input type="hidden" id="tool-idtool-edit" name="idtool">
                <div class="modal-header">
                    <h5 class="modal-title">Edit tool</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Tool</label>
                        <input type="text" class="form-control" name="namatool" id="tool-nama-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Harga Tool</label>
                        <input type="text" class="form-control" name="hargatool" id="tool-harga-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a onclick="updateTool()" class=" text-white btn btn-primary">Edit</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-video" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-video-edit">
                @csrf
                <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                <input type="hidden" id="video-idvideo-edit" name="idvideo">
                <div class="modal-header">
                    <h5 class="modal-title">Edit video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Judul</label>
                        <input type="text" class="form-control" name="judul" id="video-judul-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Embed vide0</label>
                        <input type="text" class="form-control" name="video" id="video-video-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a onclick="updateVideo()" class=" text-white btn btn-primary">Edit</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-modul" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-modul-edit">
                @csrf
                <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                <input id="modul-idmodul-edit" type="hidden" name="idmodul">
                <div class="modal-header">
                    <h5 class="modal-title">Edit modul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="nama" id="modul-nama-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="">Modul</label>
                      <input type="file" class="form-control" name="modul" id="modul-modul-edit" >
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="text" class="form-control" name="harga" id="modul-harga-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a onclick="updateModul()" class=" text-white btn btn-primary">Edit</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-bahan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-bahan-edit" enctype="multipart/form-data">
                @csrf
                <input  type="hidden" value="{{$Prodi[0]->IDProgram}}" name="idprogram">
                <input type="hidden" id="bahan-idbahan-edit" name="idbahan">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bahan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="nama" id="bahan-nama-edit"
                            aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="">Bahan</label>
                      <input type="file" class="form-control" name="modul" id="bahan-bahan-edit" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a onclick="updateBahan()" id="btn-update-bahan" class=" text-white btn btn-primary">Edit</a>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
    let csrf_token = $('csrf_token').val();
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
    let program_studi = [];
    let pertemuan_materi;
    let id_prodi = $('#idprodi').val();;


    //items in server
    let cicilan_ss = [];
    let pertemuan_ss = [];
    let tool_ss = [];
    let video_ss = [];
    let bahantutor_ss = [];
    let kategori_materi= [];
    let modul_ss = [];
    let bahan_ss = [];
    //items in client
    let cicilan_cs = [];
    let modul_cs = [];
    let tool_cs = [];
    let video_cs = [];
    let bahantutor_cs = [];
    //HARGA//
    let hargaTotalModul = 0;
    let hargaTotalTool = 0;

    $(document).ready(function () {

        showContent();
        showCicilan();
        getCoreData()
        showPertemuan();
        showVideo()
        showBahan()

    });
    //kunai
    function getCoreData(){
        let prodi = new Promise(
            (resolve,reject)=>{
                $.get('/karyawan/admin/prodidetail/getprodi/'+id_prodi).done((ele)=>{
                    program_studi = ele['Prodi']
                    cicilan_ss = ele['Cicilan']
                    resolve(cicilan_ss)
                })
            }
        )
        let tool = new Promise(
            (resolve,reject)=>{
                $.get('/karyawan/admin/prodidetail/gettool/'+id_prodi).done((ele)=>{
                    tool_ss = ele
                    resolve(tool_ss)
                })
            }
        )
        let modul = new Promise(
            (resolve, reject )=>{
                $.get('/karyawan/admin/prodidetail/getmodul/'+ id_prodi).done((ele)=>{
                    modul_ss = ele
                    resolve(modul_ss)
                });
            }
        )
        Promise.all([prodi,tool,modul]).then((ele)=>{
            setProgramStudi()
            showModul()
            showTool()
            countHarga()
        })
    }
    function countHarga(){
       
        let HargaProgram = program_studi[0].Harga
        let HargaTool = 0
        let HargaModul = 0
        let HaragaTotal = 0
        tool_ss.filter(ele=>ele.IDProgram == program_studi[0].IDProgram).forEach(ele=>HargaTool += ele.Harga)
        modul_ss.filter(ele=>ele.IDProgram == program_studi[0].IDProgram).forEach(ele=>HargaModul += ele.Harga)
        HargaTotal = HargaProgram + HargaTool + HargaModul
        $('#input-harga-total').val('Rp '+HargaTotal.toLocaleString('id-ID'));
        $('#input-harga-total-tool').val('Rp '+HargaTool.toLocaleString('id-ID'));
        $('#input-harga-total-modul').val('Rp '+HargaModul.toLocaleString('id-ID'));

    }
    content_prodi.on('keyup', function () {
        showProdiChangesControl();
    });
    content_prodi.on('change', function () {
        showProdiChangesControl();
    });

    //mengganti tab yang aktif
    function changeActiveContent(data) {
        if (prodiIsChange()) {
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

    //prodi
    function showCicilan() {
        if ($('#input-cicilan-prodi').val() == 'y') {
            $('#table-cicilan').show();
        } else {
            $('#table-cicilan').hide();
        }
    }
    function showProdiChangesControl() {
        if (prodiIsChange()) {
            $('#prodi-changes-control').show();
        } else {
            $('#prodi-changes-control').hide();
        }
    }
    function setProgramStudi() {
        $('#cicilanidprogram').val(id_prodi)
        $('.idprogram').val(id_prodi)
        $('#input-harga-program').val(program_studi[0].Harga);
        $('#input-nama-prodi').val(program_studi[0].NamaProdi);
        $('#input-cicilan-prodi').val(program_studi[0].Cicilan);
        $('#input-level-prodi').val(program_studi[0].IDLevel);
        $('#input-kategori-prodi').val(program_studi[0].IDKategoriProgram);
        $('#input-kategori-global-prodi').val(program_studi[0].IDKategoriGlobalProgram);
        showCicilan()
        showCicilanSS();
    }
    function prodiIsChange() {
        let ps = program_studi;
        let isChange =
            ps[0].Harga != $('#input-harga-program').val() ||
            ps[0].Cicilan != $('#input-cicilan-prodi').val() ||
            ps[0].NamaProdi != $('#input-nama-prodi').val() ||
            ps[0].IDLevel != $('#input-level-prodi').val() ||
            ps[0].IDKategoriProgram != $('#input-kategori-prodi').val() ||
            ps[0].IDKategoriGlobalProgram != $('#input-kategori-global-prodi').val();
        return isChange;
    }
    
    function updateProdi() {
        $.post('/karyawan/admin/master/program/update', $('#form-prodi').serialize())
            .done(function (pesan) {
                $('#prodi-changes-control').hide();
                getCoreData();
                swal(pesan.Pesan);
            }).fail(function (pesan) {
                console.log(pesan.Message);
                swal('gagal' + pesan.Pesan);
        });

    }

    function editCicilanSS(id){
        let cicilan = cicilan_ss.filter(ele=> ele.IDCicilan == id)
        $('#cicilan-cicilan-edit').val(cicilan[0].Cicilan)
        $('#cicilan-harga-edit').val(cicilan[0].Harga)
        $('#cicilanidprogramedit').val(cicilan[0].IDCicilan)
    }

    function showCicilanSS(){
        let element_cicilan = $('#list-cicilanss-prodi')
        element_cicilan.empty();
        if(cicilan_ss.length != 0){
            cicilan_ss.forEach((ele)=>{
                element_cicilan.append(
                    "<tr>"+
                        "<td>"+
                            "<input type=\"number\" readonly class=\"form-control\" value=\""+ele.Cicilan+"\">"+
                        "</td>"+
                        "<td>"+
                            "<input type=\"text\" readonly class=\"form-control\" value=\"Rp "+ele.Harga.toLocaleString('id-ID')+"\">"+
                        "</td>"+
                        "<td>"+
                            "<a onclick=\"deleteCicilanSS("+ele.IDCicilan+")\" class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                                "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                            "</a>"+
                            "<a onclick=\"editCicilanSS("+ele.IDCicilan+")\" data-toggle=\"modal\" data-target=\"#cicilan-modal-edit\" class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                                "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                            "</a>"+
                        "</td>"+
                    "</tr>"
                )
            })
        }
    }
    function storeCicilan(){
        $('#modal-add-cicilan-content').hide();
        $('#modal-add-cicilan-loading').show()
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/storecicilan",
            data: $('#form-cicilan-add').serialize(),
            success: function (response) {
                $('#cicilan-modal-add').modal('hide')
                $('#modal-add-cicilan-content').show();
                $('#modal-add-cicilan-loading').hide()
                swal(response)
                getCoreData()
            }
        });
    }
    function updateCicilan(){
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/updatecicilan",
            data: $('#form-cicilan-edit').serialize(),
            
            success: function (response) {
                $('#cicilan-modal-edit').modal('hide')
                swal(response)
                getCoreData()
            }
        });
    }

    function deleteCicilanSS(id){
        $.get('/karyawan/admin/master/cicilan/delete/'+id, (ele)=>{
            getCoreData()
            swal(ele['Pesan'])
        });
    }
    function showPertemuan(){
        $('#list-pertemuan').empty()
        $('#pertemuan-kategori-add').empty()
            $('#pertemuan-kategori-edit').empty()
        $.get('/karyawan/admin/prodidetail/getpertemuan/'+id_prodi).done((ele)=>{
            kategori_materi = ele['KategoriMateri']
            pertemuan_ss = ele['PertemuanMateri']
        }).done((ele)=>{
            let option_kategori = ""
            kategori_materi.forEach(ele => option_kategori += "<option value=\""+ele.IDKategoriMateri+"\">"+ele.NamaKategoriMateri+"</option>")
            $('#pertemuan-kategori-add').append(option_kategori)
            $('#pertemuan-kategori-edit').append(option_kategori)
            pertemuan_ss.forEach((ele)=>{
                let btn = pertemuan_ss.length == ele.NoRecord ?
                    "<a class=\"btn btn-danger btn-sm\" data-toggle=\"modal\"  onclick=\"deletePertemuan("+ele.IDMateriProgram+")\" href=\"javascript:void(0)\" role=\"button\">"+
                        "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                    "</a>"+
                    "<a class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#modal-edit-pertemuan\" onclick=\"editPertemuan("+ele.IDMateriProgram+")\" href=\"javascript:void(0)\" role=\"button\">"+
                        "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                    "</a>":
                    "<a class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#modal-edit-pertemuan\" onclick=\"editPertemuan("+ele.IDMateriProgram+")\" href=\"javascript:void(0)\" role=\"button\">"+
                        "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                    "</a>"
                $('#list-pertemuan').append(
                    "<tr>"+
                        "<td scope=\"row\">"+
                            "<p>"+ele.NoRecord+"</p>"+
                        "</td>"+
                        "<td>"+
                            "<p>"+ele.NamaMateri+"</p>"+
                        "</td>"+
                        "<td>"+
                            "<p>"+(ele.Homework==null?'':ele.Homework)+"</p>"+
                        "</td>"+
                        "<td>"+
                            kategori_materi.filter(km=>km.IDKategoriMateri == ele.IDKategoriMateri)[0].NamaKategoriMateri+
                        "</td>"+
                        "<td>"+
                            btn+
                        "</td>"+
                    "</tr>"
                );  
            })
        })
    }
    function editPertemuan(id){
        let pertemuan = pertemuan_ss.filter(ele => ele.IDMateriProgram == id)
        $('#pertemuan-idmateriprogram-edit').val(pertemuan[0].IDMateriProgram);
        $('#pertemuan-pertemuan-edit').val(pertemuan[0].NoRecord);
        $('#pertemuan-materi-edit').val(pertemuan[0].NamaMateri);
        $('#pertemuan-homework-edit').val(pertemuan[0].Homework);
        $('#pertemuan-kategori-edit').val(pertemuan[0].IDKategoriMateri);

    }
    function storePertemuan(){
        $('#modal-add-pertemuan-content').hide();
        $('#modal-add-pertemuan-loading').show()
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/storepertemuan",
            data: $('#form-pertemuan-add').serialize(),
            success: function (response) {
                $('#modal-add-pertemuan').modal('hide')
                $('#modal-add-pertemuan-content').show();
                $('#modal-add-pertemuan-loading').hide()
                swal(response)
                showPertemuan()
            }
        });
    }
    function deletePertemuan(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Materi ini akan hilang setelah dihapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              $.get('/karyawan/admin/prodidetail/deletepertemuan/'+id).done((ele)=>{
                  swal(ele)
                  showPertemuan()
              })
            } else {
                swal("Dibatalkan!");
            }
        });
    }
    function updatePertemuan(){
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/updatepertemuan",
            data: $('#form-pertemuan-edit').serialize(),
            
            success: function (response) {
                $('#modal-edit-pertemuan').modal('hide')
                swal(response)
                showPertemuan()
            }
        });
    }
    function showTool(){
        $('#list-tool').empty();
        tool_ss.forEach((ele)=> hargaTotalTool += ele.Harga)
        tool_ss.forEach((ele)=>{
            $('#list-tool').append(
                "<tr>"+
                    "<td scope=\"row\">"+
                        "<p>"+ele.NamaTool+"</p >"+
                        "</td>"+
                    "<td>"+
                        "<p>Rp "+ele.Harga.toLocaleString('id-ID')+"</p>"+
                    "</td>"+
                    "<td>"+
                        "<a onclick=\"deleteTool("+ele.IDTool+")\" class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                            "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                        "</a>"+
                        "<a onclick=\"editTool("+ele.IDTool+")\" data-toggle=\"modal\" data-target=\"#modal-edit-tool\" class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                            "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                        "</a>"+
                    "</td>"+
                "</tr>"
            );
        })
    }
    function storeTool(){
        $('#modal-add-tool-content').hide();
        $('#modal-add-tool-loading').show()
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/storetool",
            data: $('#form-tool-add').serialize(),
            
            success: function (response) {
                swal(response)
                $('#modal-add-tool').modal('hide')
                $('#modal-add-tool-content').show();
                $('#modal-add-tool-loading').hide()
                getCoreData()
            }
        });

    }
    function editTool(id){
        let tool = tool_ss.filter(ele => ele.IDTool == id)
        $('#tool-idtool-edit').val(tool[0].IDTool);
        $('#tool-nama-edit').val(tool[0].NamaTool);
        $('#tool-harga-edit').val(tool[0].Harga);
    }
    function updateTool(){
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/updatetool",
            data: $('#form-tool-edit').serialize(),
            async: false,
            success: function (response) {
                swal(response)
                $('#modal-edit-tool').modal('hide')
                getCoreData()
            }
        });
    }
    function deleteTool(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Tool ini akan hilang setelah dihapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              $.get('/karyawan/admin/prodidetail/deletetool/'+id).done((ele)=>{
                  swal(ele)
                  getCoreData()
              })
            } else {
                swal("Dibatalkan!");
            }
        });
    }
    function showVideo(){
        $('#list-video').empty();
        $.get('/karyawan/admin/prodidetail/getvideo/'+id_prodi).done((ele)=>{
            video_ss = ele
            video_ss.forEach((ele)=>{
                $('#list-video').append(
                    "<tr>"+
                        "<td scope\"row\">"+
                            "<h5>"+ele.Judul+"</h5>"+
                        "</td>"+
                        "<td>"+
                           ele.Link+
                        "</td>"+
                        "<td>"+
                            "<a onclick=\"deleteVideo("+ele.IDVideo+")\" class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                                "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                            "</a>"+
                            "<a data-toggle=\"modal\" data-target=\"#modal-edit-video\" onclick=\"editVideo("+ele.IDVideo+")\" class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                                "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                            "</a>"+
                        "</td>"+
                    "</tr>"
                )
            })
        })
    }
    function storeVideo(){
        $('#modal-add-video-content').hide();
        $('#modal-add-video-loading').show()
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/storevideo",
            data: $('#form-video-add').serialize(),
            success: function (response) {
                swal(response)
                $('#modal-add-video').modal('hide')
                $('#modal-add-video-content').show();
                $('#modal-add-video-loading').hide()
                showVideo()
            }
        })
    }
    function editVideo(id){
        let video = video_ss.filter(ele=> ele.IDVideo == id)
        $('#video-judul-edit').val(video[0].Judul);
        $('#video-video-edit').val(video[0].Link);
        $('#video-idvideo-edit').val(video[0].IDVideo);
    }
    function updateVideo(){
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/updatevideo",
            data: $('#form-video-edit').serialize(),
            async: false,
            success: function (response) {
                swal(response)
                $('#modal-edit-video').modal('hide')
                showVideo()
            }
        })
    }
    function deleteVideo(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Video ini akan hilang setelah dihapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              $.get('/karyawan/admin/prodidetail/deletevideo/'+id).done((ele)=>{
                  swal(ele)
                  showVideo()
              })
            } else {
                swal("Dibatalkan!");
            }
        });
    }
    function showModul(){
        $('#list-modul').empty()
        modul_ss.forEach((ele)=> hargaTotalModul += ele.Harga)
        modul_ss.forEach((ele)=>{
            $('#list-modul').append(
                "<tr>"+
                    "<td scope=\"row\">"+
                        "<p>"+ele.Judul+"</p>"+
                    "</td>"+
                    "<td>"+
                        "<a class=\"btn btn-sm btn-primary\""+
                        "href=\"/karyawan/admin/program/stream/modul/"+ele.Modul.split('.')[0]+"\""+
                        "target=\"_blank\" role=\"button\">"+ele.Modul+"</a>"+
                    "</td>"+
                    "<td>"+
                        "<p>Rp "+ele.Harga.toLocaleString('id-ID')+"</p>"+
                    "</td>"+
                    "<td>"+
                        "<a onclick=\"deleteModul("+ele.IDModul+")\" class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                            "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                        "</a>"+
                        "<a data-toggle=\"modal\" data-target=\"#modal-edit-modul\" onclick=\"editModul("+ele.IDModul+")\" class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                            "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                        "</a>"+
                    "</td>"+
                "</tr>"
            );
        })
    }

    function storeModul(){
        $('#btn-store-modul').attr('disbled',true);
        $('#modal-add-modul-content').hide();
        $('#modal-add-modul-loading').show()
        let form = $('#form-modul-add')
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/storemodul",
            data: new FormData(form[0]),
            contentType: false,       
            cache: false,             
            processData:false,
            success: function (response) {
                $('#modal-add-modul').modal('hide')
                $('#modal-add-modul-content').show();
                $('#modal-add-modul-loading').hide()
                swal(response)
                getCoreData()
                $('#btn-store-modul').attr('disbled',false);
            }
        }).done()
    }
    function editModul(id){
        let modul = modul_ss.filter(ele=> ele.IDModul == id)
        $('#modul-idmodul-edit').val(modul[0].IDModul)
        $('#modul-nama-edit').val(modul[0].Judul)
        $('#modul-harga-edit').val(modul[0].Harga)
    }
    
    function updateModul(){
        let form = $('#form-modul-edit')
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/updatemodul",
            data: new FormData(form[0]),
            contentType: false,       
            cache: false,             
            processData:false,
            async: false,
            success: function (response) {
                swal(response)
                $('#modal-edit-modul').modal('hide')
                getCoreData()
            }
        })
    }
    function deleteModul(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Modul ini akan hilang setelah dihapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              $.get('/karyawan/admin/prodidetail/deletemodul/'+id).done((ele)=>{
                  swal(ele)
                  getCoreData()
              })
            } else {
                swal("Dibatalkan!");
            }
        });
    }
    function showBahan(){
        $('#list-bahan').empty()
        $.get('/karyawan/admin/prodidetail/getbahan/'+ id_prodi).done((ele)=>{
            bahan_ss = ele
            bahan_ss.forEach((ele)=>{
                $('#list-bahan').append(
                    "<tr>"+
                        "<td scope=\"row\">"+
                            "<p>"+ele.NamaBahan+"</p>"+
                        "</td>"+
                        "<td>"+
                            "<a class=\"btn btn-sm btn-primary\""+
                            "href=\"/karyawan/admin/program/stream/modul/"+ele.File.split('.')[0]+"\""+
                            "target=\"_blank\" role=\"button\">"+ele.File+"</a>"+
                        "</td>"+
                        "<td>"+
                            "<a onclick=\"deleteBahan("+ele.IDBahanTutor+")\" class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                                "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                            "</a>"+
                            "<a data-toggle=\"modal\" data-target=\"#modal-edit-bahan\" onclick=\"editBahan("+ele.IDBahanTutor+")\" class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">"+
                                "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>"+
                            "</a>"+
                        "</td>"+
                    "</tr>"
                );
            })
        });
    }

    function storeBahan(){
        $('#modal-add-bahan-content').hide();
        $('#modal-add-bahan-loading').show()
        $('#btn-store-bahan').attr('disbled',true);
        let form = $('#form-bahan-add')
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/storebahan",
            data: new FormData(form[0]),
            contentType: false,       
            cache: false,             
            processData:false,
            
            success: function (response) {
                swal(response)
                $('#modal-add-bahan').modal('hide')
                $('#modal-add-bahan-content').show();
                $('#modal-add-bahan-loading').hide()
                showBahan()
                $('#btn-store-bahan').attr('disbled',false);
            }
        })
    }
    function editBahan(id){
        let bahan = bahan_ss.filter(ele=> ele.IDBahanTutor == id)
        $('#bahan-idbahan-edit').val(bahan[0].IDBahanTutor)
        $('#bahan-nama-edit').val(bahan[0].NamaBahan)
    }
    
    function updateBahan(){
        let form = $('#form-bahan-edit')
        $.ajax({
            type: "post",
            url: "/karyawan/admin/prodidetail/updatebahan",
            data: new FormData(form[0]),
            contentType: false,       
            cache: false,             
            processData:false,
            
            success: function (response) {
                swal(response)
                $('#modal-edit-bahan').modal('hide')
                showBahan()
            }
        })
    }
    function deleteBahan(id){
        swal({
            title: "Apakah anda yakin?",
            text: "Bahan tutor ini akan hilang setelah dihapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              $.get('/karyawan/admin/prodidetail/deletebahan/'+id).done((ele)=>{
                  swal(ele)
                  showBahan()
              })
            } else {
                swal("Dibatalkan!");
            }
        });
    }

</script>
@endpush
@endsection