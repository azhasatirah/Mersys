@extends('karyawan.layouts.layout')
@section('title','Daftar kursus')
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

<!-- {{-- Modal create jadwal --}} -->
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
<div class="row">
    <div class="col-md-12">
        <div class="x_panel text-black" style="font-size: 15px;font-color:black">

            <p id="data-kelas"></p>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="row">

                {{-- nav menu --}}

                <div class="col-md-12" style=" border-bottom: 0.01em solid #0D6c757d;">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" onclick="changeActiveContent('jadwal')" id="btn-jadwal"
                            class="btn btn-nav ">Jadwal</button>           
                        <button type="button" id="btn-ubahjadwal" onclick="changeActiveContent('ubahjadwal')"
                            class="btn btn-nav">Perubahan Jadwal</button>
                        <button type="button" id="btn-nilai" onclick="changeActiveContent('nilai')"
                            class="btn btn-nav">Nilai</button>
                        <button type="button" id="btn-evaluasi" onclick="changeActiveContent('evaluasi')"
                            class="btn btn-nav">Nilai Evaluasi</button>
                    </div>
                </div>

                <hr>
            </div>
            <div class="x_content">
                <div style="display: none" id="content-jadwal" class=" mt-3">
                    <button data-toggle="modal" onclick="setTypeRemakeJadwal(1)" data-target="#modalcreate"  class="btn btn-primary btn-sm mb-3" role="button">Buat ulang jadwal <i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button data-toggle="modal" onclick="setTypeRemakeJadwal(2)" data-target="#modalcreate"  class="btn btn-danger btn-sm mb-3" role="button">Reset jadwal <i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <table id="tabeldata" style="width: 100%" class="table table-hover">
                            <thead style="width: 100%">
                                <tr>
                                    <th>Per</th>
                                    <th>Tanggal</th>
                                    <th>Materi</th>
                                    <th>Tutor</th>
                                    <th>Kehadiran Tutor</th>
                                    <th>Kehadiran Siswa</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                </div>

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
                                            <option value="false">Pilih</option>
                        
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
                <div style="display: none" id="content-nilai" class="row mt-3">
                    <div class="table-responsive">

                        <table style="width:100%;max-width:1000rem" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Materi</th>
                                    <th>Nilai</th>
                                    <th>Jenis</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-nilai">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="display: none" id="content-evaluasi" class="row mt-3">
                    <div class="table-responsive">

                        <table style="width:100%;max-width:1000rem" class="table">
                            <thead>
                                <tr>
                                    <th>Pertemuan</th>
                                    <th>Materi</th>
                                    <th>Plus (+)</th>
                                    <th>Minus (-)</th>
                                    <th>Saran</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-evaluasi">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" style="overflow: auto !important" id="modal-jadwal-changes" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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

<!-- Modal -->
<div class="modal fade" id="modal-change-tutor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti tutor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-change-tutor">
                    @csrf
                    <input type="hidden" name="jadwal" id="change-tutor-jadwal">
                    <div class="form-group">
                        <label for="">Tutor</label>
                        <select class="custom-select" name="tutor" id="change-tutor-tutor">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" onclick="changeTutor()" class="btn btn-primary">Ganti</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />
@push('scripts')
<script src="{{asset('assets/js/moment.js')}}"></script>
    <script>
    let TypeRemakeJadwal = 0
    let token = $('#token').val();
        //data from database
    let DataKelas = [],Absen = [],Changes = [],jadwal = [],Evaluasi = [],Nilai = [],Tutor = []

    let UIDKelas = window.location.href.split('/')[6]
    let active_content = "jadwal";
    const btn_jadwal = $('#btn-jadwal');
    const btn_ubahjadwal = $('#btn-ubahjadwal');
    const btn_evaluasi = $('#btn-evaluasi');
    const btn_nilai = $('#btn-nilai');
    const content_nilai = $('#content-nilai');
    const content_evaluasi = $('#content-evaluasi');
    const content_ubahjadwal = $('#content-ubahjadwal');
    const content_jadwal = $('#content-jadwal');

    let ReqJadwalChanges = [];

    let TabelJadwal = $('#tabeldata').DataTable({
        "scrollX": true,
    })

    //kunaiss
    let materi
    let jam_maker = []
    const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(),0,1);
        var today = new Date(this.getFullYear(),this.getMonth(),this.getDate());
        var dayOfYear = ((today - onejan + 86400000)/86400000);
        return Math.ceil(dayOfYear/7)
    }
    $(document).ready(function () {
        getData()
        showContent()
    });
    function changeActiveContent(data) {
        active_content = data
        showContent();
    }
    function showContent() {
        switch (active_content) {
            case 'jadwal':
                btn_jadwal.addClass('active');
                btn_ubahjadwal.removeClass('active');
                btn_nilai.removeClass('active')
                btn_evaluasi.removeClass('active')
                content_nilai.hide()
                content_evaluasi.hide()
                content_ubahjadwal.hide();
                content_jadwal.show();
                break;
            case 'ubahjadwal':
                btn_jadwal.removeClass('active');
                btn_ubahjadwal.addClass('active');
                btn_nilai.removeClass('active')
                btn_evaluasi.removeClass('active')
                content_nilai.hide()
                content_evaluasi.hide()
                content_jadwal.hide();
                content_ubahjadwal.show();
                break;
            case 'evaluasi':
                btn_jadwal.removeClass('active');
                btn_evaluasi.addClass('active');
                btn_ubahjadwal.removeClass('active');
                btn_nilai.removeClass('active');
                content_nilai.hide();
                content_ubahjadwal.hide();
                content_jadwal.hide();
                content_evaluasi.show();
                break;
            case 'nilai':
                btn_jadwal.removeClass('active');
                btn_nilai.addClass('active');
                btn_ubahjadwal.removeClass('active')
                btn_evaluasi.removeClass('active')
                content_ubahjadwal.hide()
                content_evaluasi.hide()
                content_jadwal.hide();
                content_nilai.show();
                break;
        }
    }
    function getData(){
        Promise.resolve($.get("/karyawan/kursus/getdata/"+UIDKelas))
        .then((ele)=>{
            console.log(ele)
            DataKelas = ele['DataKelas'][0]
            Absen = ele['Absen']
            Changes = ele['Changes']
            jadwal = Object.values(ele['ActiveJadwal'])
            Evaluasi = ele['Evaluasi']
            Nilai = ele['Nilai']
            Tutor = ele['Tutor']
            showDataJadwal()
            showDataKelas()
            showChanges()
            showEvaluasi()
            showNilai()
            appendChangeTutorSelectOption()
        })
    }
    function showEvaluasi(){
        let TabelEvaluasi = $('#tbody-evaluasi')
        TabelEvaluasi.empty()
 
        Evaluasi.forEach(ele=>{
            TabelEvaluasi.append(
                "<tr>"+
                    "<td>"+ele.Pertemuan+"</td>"+
                    "<td>"+ele.Materi+"</td>"+
                    "<td>"+ele.Plus+"</td>"+
                    "<td>"+ele.Minus+"</td>"+
                    "<td>"+ele.Saran+"</td>"+
                "</tr>"
            )
        })
    }
    function showNilai(){
        let TabelNilai = $('#tbody-nilai')
        TabelNilai.empty()
        let i =0

        Nilai.forEach(ele=>{
            i++
            TabelNilai.append(
                "<tr>"+
                    "<td>"+i+"</td>"+
                    "<td>"+ele.NamaNilai+"</td>"+
                    "<td>"+ele.Nilai+"</td>"+
                    "<td>"+ele.Jenis+"</td>"+
                "</tr>"
            )
        })
    }
    function showDataKelas(){
        $('#data-kelas').html(
            "Kursus : "+DataKelas.NamaProdi+"<br>"+
            "Kode Kursus : "+DataKelas.KodeKursus+"<br>"+
            "Nama Siswa : "+DataKelas.NamaSiswa+"<br>"+
            "Nama Tutor : "+DataKelas.NamaKaryawan+"<br>"
        );
    }
    function deleteAbsen(id){
        $.get("/reset/absen/"+id ).done(res=>swal(res))
    }
    function showDataJadwal(){
        TabelJadwal.clear()
        console.log(Absen)
        Absen.forEach((ele)=>{
            //console.log(ele)
            let btn_fill_siswa = "<button class=\"btn ml-2 btn-primary btn-sm\" onclick=\"absen(1,"+ele.IDSiswa+","+ele.IDJadwal+")\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>"
            let btn_fill_tutor = "<button class=\"btn ml-2 btn-primary btn-sm\" onclick=\"absen(2,"+ele.IDTutor+","+ele.IDJadwal+")\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>"
            let btn_dela = "<button class=\"btn ml-2 btn-primary btn-sm\" onclick=\"deleteAbsen("+ele.IDJadwal+")\"><i class=\"fa fa-plus-trash\" aria-hidden=\"true\"></i></button>"
            let btn_change_tutor = ele.KehadiranTutor == 'Belum mulai'||ele.KehadiranTutor == 'Alpha'?
             "<button data-toggle=\"modal\" data-target=\"#modal-change-tutor\" class=\"btn ml-2 btn-primary btn-sm\" onclick=\"setModalChangeTutor("+ele.IDJadwal+","+ele.IDTutor+")\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>":""
            TabelJadwal.row.add([
                ele.Pertemuan,
                ele.Tanggal,
                ele.Materi,
                ele.Tutor+btn_change_tutor,
                ele.KehadiranTutor + (ele.AbsenTutor==true?btn_fill_tutor:''),
                ele.KehadiranSiswa + (ele.AbsenSiswa==true?btn_fill_siswa:'')
                // btn_dela

            ]).draw()
        })
        //input select change 
  
        $('#input-ubah-jadwal-select').empty();
        $('#input-ubah-jadwal-select').append('<option>pilih</option>');
        $('#input-ubah-jadwal-select').append('<option value="all">Izin Cuti</option>');
        jadwal.filter(jwl=>jwl.StatusMateri != 'CLS').forEach((ele)=>{
            $('#input-ubah-jadwal-select').append(
                "<option value=\""+ele.NoRecord+"\">Ubah pertemuan ke "+ele.NoRecord+"</option>"
            )
        })
    }
    function absen(person, IDPerson, IDJadwal){
        let data = {
            '_token':token,
            'person':person,
            'IDPerson':IDPerson,
            'IDJadwal':IDJadwal
        }
        $.ajax({
            type: "post",
            url: "/karyawan/kursus/absen",
            data: data,
            success: function (response) {
                getData()
                swal(response)
            }
        });
    }
    function showChanges(){
        $('#list-history-changes').empty()
        Changes.sort((a,b)=> b.IDJadwalChange - a.IDJadwalChange).forEach((ele)=>{

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
            statusUbahJadwal()
        })
    }
    function statusUbahJadwal(){
        if(jadwal.length ==0){
            $('#select-ubah-jadwal').hide()
        }
        if(Changes.some(ele=>ele.Status == 'OPN')){
            $('#select-ubah-jadwal').hide()
        }
    }

    //change jadwal
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
            $('#input-ubah-jadwal-tanggal').val(pertemuan.Tanggal.split(' ')[0]);
            $('#input-ubah-jadwal-jam').val(pertemuan.Tanggal.split(' ')[1]);
        }
    }
    function traceJadwalChange(){
        let JadwalChanged =[]
        let InputNoRecord = $('#input-ubah-jadwal-select').val()
        let reqTanggal = $('#input-ubah-jadwal-tanggal').val()
        let reqJam = $('#input-ubah-jadwal-jam').val()
        let jadwalChangedIndex = jadwal.findIndex(ele => ele.NoRecord == InputNoRecord)
        let jadwalPrevChanged = jadwal[jadwalChangedIndex].Tanggal
 
        if(reqJam == jadwal[jadwalChangedIndex].Tanggal.split(' ')[1] && 
        jadwal[jadwalChangedIndex].Tanggal.split(' ')[0] == reqTanggal){
            swal('Anda belum mengubah jadwal')
        }
        if(reqJam != jadwal[jadwalChangedIndex].Tanggal.split(' ')[1] && 
        jadwal[jadwalChangedIndex].Tanggal.split(' ')[0] == reqTanggal){
         
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
                'TanggalFrom': jadwal[jadwalChangedIndex].Tanggal,
                'TanggalTo':jadwal[jadwalChangedIndex].Tanggal.split(' ')[0]+' '+reqJam+':00'
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
            console.log(DataChanges)
            setAndShowDataModalChanges(JadwalChanged)
        }
        let jadwal_not_changed = jadwal.filter(jwd=>jwd.NoRecord != InputNoRecord).filter(jwd=> jwd.StatusMateri != 'CLS')
       // console.log(jadwal_not_changed)
        let is_over_date = jadwal_not_changed.some(jnc=>new Date(jnc.Tanggal.split(' ')[0]).getTime() <= new Date(reqTanggal).getTime() )
        if(is_over_date){
            swal('Tidak bisa mengganti ke tanggal ini, coba ganti ke tanggal lebih kecil')
        }
        if(!is_over_date && jadwal[jadwalChangedIndex].Tanggal.split(' ')[0] != reqTanggal){
            let reqJadwal = reqTanggal+' '+reqJam

            console.log(reqJadwal)
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
                        'TanggalFrom': ele.Tanggal,
                        'TanggalTo':tmp_new_jadwal[ite+1].Tanggal
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
                    'TanggalFrom': jadwal[jadwalChangedIndex].Tanggal,
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
        $.post("/karyawan/kursus/jadwalchanges/store", ReqJadwalChanges, (ele) =>{
             swal(ele)
             $('#input-ubah-jadwal').hide();
             $('#input-ubah-semua-jadwal').hide();
             getData()
        })
    }

    function freezeJadwal(){
        let input_freeze_from = $('#input-libur-mulai').val()
        let input_freeze_to = $('#input-libur-sampai').val()
        let freeze_from = new Date(input_freeze_from).getWeek()
        let freeze_to = new Date(input_freeze_to).getWeek()
        let freeze = ((freeze_to - freeze_from) )*7
        let copyJadwal = jadwal.filter((ele)=>{
            return new Date(ele.Tanggal.split(' ')[0]).getTime() >= new Date(input_freeze_from).getTime()
        })
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
        copyJadwal.forEach((data)=>{
            let tmpDate = moment(data.Tanggal).format('yyyy-MM-DD HH:mm:ss')
         
            let dateTo = moment(tmpDate).add(freeze,'days').format('yyyy-MM-DD HH:mm:ss')
 
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
                'TanggalFrom': data.Tanggal,
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
        ReqJadwalChanges = DataChanges
        setAndShowDataModalChanges(newJadwal)
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
    function filterCheckPrevRecord(jadwal, reqJadwal,jadwalPrevChanged){
        const dataFilter = (ele)=>{
            let oldTanggal = ele.Tanggal
            return (new Date(oldTanggal).getTime()) < (new Date(reqJadwal).getTime())
                && (new Date(oldTanggal).getTime()) >= (new Date(jadwalPrevChanged).getTime())
        }
        let check = jadwal.filter(ele => dataFilter(ele))
        return check
    }
    function showHistoryChanges(id){

        if($('#history-changes-'+id+':hidden').length == 1){

        $('#history-changes-'+id).show();
        }else{

        $('#history-changes-'+id).hide();
        }
    }
    function setdata(total_pertemuan, id_kursus, id_program) {
        $('#total_pertemuan').val(total_pertemuan);
        $('#id_kursus_siswa').val(id_kursus);
        $('#id_program').val(id_program);
        materi = Jadwal
    }
    //kunaiss
    function filterDate(jadwal,jadwal_siswa){
        const dataFilter = (ele) => {
            tmp_old_sch = [];
            tmp_new_sch = [];
            tmp_old_sch_hours = [];
            tmp_new_sch_hours = [];
            jadwal_siswa.forEach(ele => tmp_new_sch.push(ele.tanggal));
            ele.forEach(ele => tmp_old_sch.push(ele.Tanggal.split(' ')[0]));
            jadwal_siswa.forEach(ele => tmp_new_sch_hours.push(ele.jam));
            ele.forEach(ele => tmp_old_sch_hours.push(
                ele.Tanggal.split(' ')[1].split(':')[0] + ':' +
                ele.Tanggal.split(' ')[1].split(':')[1]
            ));
            check_jadwal = tmp_new_sch.some((new_sch) => {
                return tmp_old_sch.some(old_sch => 
                    new_sch == old_sch
                );
            });
            check_jam = tmp_new_sch_hours.some((new_sch) => {
                return tmp_old_sch_hours.some(old_sch =>
                    new Date('2002-10-13' + ' ' + new_sch).getTime() <=
                    new Date(new Date('2002-10-13' + ' ' + old_sch).setHours(
                        new Date('2002-10-13' + ' ' + old_sch).getHours() + 3
                    )).getTime() &&
                    new Date('2002-10-13' + ' ' + new_sch).getTime() >=
                    new Date(new Date('2002-10-13' + ' ' + old_sch).setHours(
                        new Date('2002-10-13' + ' ' + old_sch).getHours() - 3
                    )).getTime()
                );
            });
            return check_jadwal && check_jam;
        };
        let check = jadwal.filter(ele => dataFilter(ele));
        return check;
    }
    //kunai
    function showNewJadwal(jadwal_siswa) {
        $('#modalcreate').modal('hide');
        $('#modalshowjadwal').modal('show');
        let ite = 0;
        $('#tbody_show_jadwal').empty();
        jadwal_siswa.sort((a, b) => new Date(a.tanggal) - new Date(b.tanggal)).forEach((ele) => {
            $('#tbody_show_jadwal').append(

                "<tr>" +
                "<input type=\"hidden\" value=\"" + hari[new Date(ele.tanggal).getDay()] +
                "\" name=\"hari[]\">" +
                "<input type=\"hidden\""+ 
                "id=\"pjadwal-tgl"+(ite+1)+"\""+
                " value=\"" + ele.tanggal + "\" name=\"tanggal[]\">" +
                //kunai
                "<input type=\"hidden\""+
                "id=\"pjadwal-jam"+(ite+1)+"\""+
                " value=\"" + ele.jam + "\" name=\"jam[]\">" +

                "<input type=\"hidden\" value=\"" + (ite + 1) + "\" name=\"norecord[]\">" +
                "<input type=\"hidden\" value=\"" + $('#id_program').val() + "\" name=\"idprogram[]\">" +
                "<input type=\"hidden\" value=\"" + $('#id_kursus_siswa').val() +
                "\" name=\"idkursus[]\">" +
                "<input type=\"hidden\" value=\"" + materi[ite].NamaMateri + "\" name=\"namamateri[]\">" +
                "<td scope=\"row\">" + hari[new Date(ele.tanggal).getDay()] + "</td>" +
                "<td>" + ele.tanggal + "</td>" +
                
                "<td style=\"cursor:pointer\">"+
                    "<div style=\"display:none\" id=\"input-change-jam"+(ite+1)+"\" class=\"form-group\">"+
                        "<input type=\"time\" id=\"val-change-jam"+(ite+1)+"\" class=\"form-control\">"+
                    "</div>"+
                    "<a "+
                        "id=\"btn-change-jam"+(ite+1)+"\""+
                        "class=\"btn btn-primary btn-sm text-white\""+
                        "onclick=\"changeJam("+(ite+1)+")\"" +
                        "data-toggle=\"tooltip\" title=\"Ubah jam\""+
                        ">"+
                        ele.jam+
                    "</a>" +
                    "<a "+
                        "id=\"btn-submit-change-jam"+(ite+1)+"\""+
                        "style=\"display:none\""+
                        "class=\"btn btn-primary btn-sm text-white\""+
                        "onclick=\"updateJam("+(ite+1)+")\"" +
                        "data-toggle=\"tooltip\" title=\"Ubah jam\""+
                        ">"+
                    "Ubah</a>" + 
                    "<a "+
                        "id=\"btn-cancel-change-jam"+(ite+1)+"\""+
                        "style=\"display:none\""+
                        "class=\"btn btn-danger btn-sm text-white\""+
                        "onclick=\"changeJam("+(ite+1)+")\"" +
                        "data-toggle=\"tooltip\" title=\"Ubah jam\""+
                        ">"+
                    "Cancel</a>" +                               
                "</td>" +

                "<td>" + (ite + 1) + "</td>" +
                "<td>" + materi[ite].NamaMateri + "</td>" +

                "</tr>"
            );
            ite++;
        });
        // let tutor_option=[];
        // free_tutor.forEach((ele)=>{
        //     $('#select-tutor').append(
        //         "<option value=\""+ele.IDKaryawan+"\">"+ele.NamaKaryawan+"</option>"
        //     );
        // })

    }
    function updateJam(id){
        let req_tea,req_schque, count_tea =0 , count_schque;
        let jam =$('#val-change-jam'+id).val();
        let tgl =$('#pjadwal-tgl'+id).val();
        let ReqDate =  tgl + " " + jam;
        $.ajax({
            url: '/siswa/getReqChangeJadwalTutor/' + ReqDate,
            type: 'get',
            success: function (data) {
                req_tea = data[0];
                req_schque = data[1];
                // console.log(tea);
            },
            async: false
        });
        req_tea.forEach((ele)=>{
            if(!('Data' in ele)){count_tea+=1}
        })
        //another kunai
        count_schque = req_schque.length
        if((count_tea-count_schque)==0){
            swal('Jadwal penuh')
        }else{
            $('#pjadwal-jam'+id).val(jam);
            changeJam(id);
            $('#btn-change-jam'+id).html(jam);
            swal('Jam berhasil diganti');   
        }

    }
    function changeJam(id){
        $('#val-change-jam'+id).val($('#pjadwal-jam'+id).val());
        if($('#btn-change-jam'+id).css('display')=='inline-block'){
            $('#input-change-jam'+id).show();
            $('#btn-change-jam'+id).hide();
            $('#btn-submit-change-jam'+id).show();
            $('#btn-cancel-change-jam'+id).show();
        }else{
            $('#input-change-jam'+id).hide();
            $('#btn-change-jam'+id).show();
            $('#btn-submit-change-jam'+id).hide();
            $('#btn-cancel-change-jam'+id).hide();
        }
    }
    function checkJadwalTutor(jadwal_siswa) {

        //jks = jadwal kosong tutor; ja = jadwal ada; ajs = antrian jadwal siswa
        // jks = some( tutor->all(jadwal) != siswa->new(jadwal) )
        // ja = (jks - ajs) > 0
        //tmp tanggal jadwal

        // oj = order jadwal kelas
        // anj = antrian jadwal kelas (IDTutor == null) >= oj.start
        // acj = jadwal kelas aktif (Status CFM) >= oj.start
        // aj = jadwal ada
        // * algo
        /*
        * backend
            ns  : newest sch teacher than first date os
            nschque : newest antrean order sch  than first date os
            tmp_tea : teacher(db)
            tmp_class : class(db)
            * false tea mean the tea can take the schedule
            tea{
                ns = tmp_tea.class.sch >= sos? tmp_tea.class.sch :false,
            }
            class{
                nas = tmp_class.sch[stat=OPN] >= sos
            }
            return frontend(tea,class)
        * frontend
            tea = get(tea)
            schque = get(class)
            ftea = tea.length - ftea.filter(ns=false).length - ftea.filter(datafilter)
            ! free schque : ftea - schque
            
        */
        let fil_tea=[]; 
        let fil_schque = filterDate(schque,jadwal_siswa);
        tea.forEach((ele)=>{
            if(ele != false){
                if(filterDate(ele,jadwal_siswa).length>0){
                    fil_tea.push(true);
                }
            }
        }); 
        // let fil_tea = filterDate(TrueTea,jadwal_siswa);
    
        let ftea = tea.length - fil_tea.length;
        let free_schque = ftea - fil_schque.length;

        if (free_schque <= 0) {
            swal({
                icon: 'error',
                title: 'Oops...',
                text: 'jadwal tidak ditemukan , coba ganti jam atau tanggal',
            })

        } else if (free_schque> 0) {
            showNewJadwal(jadwal_siswa);
        };

    }
    function setFirstDay() {
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
    function setTypeRemakeJadwal(id){      
        TypeRemakeJadwal = id
    }
    function reMakeJadwal() {
        //kunaiss
        // total pertemuan = jadwal yang belum ada absen dan tanggl nya lebih besar sama dengan sekarang
        let start_date = $('#start_date');
        console.log('jadwal',jadwal)
        let filtered_jadwal = TypeRemakeJadwal == 1?
        jadwal.filter(ele=> ele.StatusMateri!='CLS'):
        jadwal
        console.log('filtered jadwal',filtered_jadwal,TypeRemakeJadwal)
        // console.log(moment(new Date()).format('Y-MM-DD'))
        let total_pertemuan = filtered_jadwal.length
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
        let meet_in_week = tmp_meet_in_week.filter(ele => ele.aktif == true);
        // mengatur tanggal awal dari setiap minggu
        let flat_date = meet_in_week.map(ele =>
            new Date(start_date.val()).setDate(
                new Date(start_date.val()).getDate() +
                (ele.hari - new Date(start_date.val()).getDay()) +
                (
                    ele.hari - new Date(start_date.val()).getDay() < 0 ? 7 : 0
                )

            )
        );
    
        let date = flat_date.sort((a, b) => a - b).map(ele =>
            new Date(ele).getFullYear() + '-' + String(new Date(ele).getMonth() + 1).padStart(2, '0') + '-' +
            String(new Date(ele).getDate()).padStart(2, '0')
        );
        //sisa bagi total pertemuan dibagi pertemuan dalam seminggu
        let a = total_pertemuan % jam_maker.length;
        //hasil pembagian total pertemuan tanpa sisa bagi ( max perulangan)
        let c = total_pertemuan % jam_maker.length == 0 ? total_pertemuan / jam_maker.length : (
            total_pertemuan - (total_pertemuan % jam_maker.length)) / jam_maker.length;
        let jadwal_siswa = [];
        let date_increament = 0;

        //keep it up sware -3-
        // jadwal maker
        for (let i = 0; i < c; i++) {
            for (let j = 0; j < date.length; j++) {
                let hari = jam_maker.filter(ele=>ele.day_id==new Date(date[j]).getDay())
                for(let jam =0;jam<hari.length;jam++){
                    let tmp_date = new Date(new Date(date[j]).setDate(new Date(date[j]).getDate() + date_increament));
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
        if (a != 0) {
            let indexDay =0 ;
            for (let j = 0; j < a; j++) {
                let hari = jam_maker.filter(ele=>ele.day_id==new Date(date[indexDay]).getDay())
                for(let jam =0;jam<hari.length;jam++){
                    let tmp_date = new Date(new Date(date[indexDay]).setDate(new Date(date[indexDay]).getDate() + date_increament));
                    let tmp_jadwal = tmp_date.getFullYear() + '-' + String(tmp_date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(tmp_date.getDate()).padStart(2, '0');
                    jadwal_siswa.push({
                        'tanggal': tmp_jadwal,
                        'jam': hari[jam].val
                    });
                    j++
                }
                indexDay++
                date_increament += 7;
            }
        }

      jadwalBuiler(jadwal_siswa,filtered_jadwal);
      //kunai
    
        //getAndSetNewestJadwalTutor(start_date.val());
        // checkJadwalTutor(jadwal_siswa);

    }

    function jadwalBuiler(changes,data_jadwal){
        //let filtered_jadwal = jadwal
        console.log('trace one',changes,data_jadwal)
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
                'TanggalFrom': data.Tanggal,
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
        $('#modalcreate').modal('hide')
        ReqJadwalChanges = DataChanges
        setAndShowDataModalChanges(newJadwal)
    }
    function getAndSetNewestJadwalTutor(start_date) {
        $.ajax({
            url: '/siswa/getJadwalTutor/' + start_date,
            type: 'get',
            success: function (data) {
           
                tea = data[0];
                schque = data[1];
                // console.log(tea);
            },
            async: false
        });
    }
    function appendChangeTutorSelectOption(){
        $('#change-tutor-tutor').empty()
        Tutor.forEach(ele=>{
            $('#change-tutor-tutor').append(
                "<option value="+ele.IDKaryawan+">"+ele.NamaKaryawan+"</option>"
            )
        })
    }
    function setModalChangeTutor(jadwal,tutor){
        $('#change-tutor-jadwal').val(jadwal)
        $('#change-tutor-tutor').val(tutor)
    }
    function changeTutor(){
        $.ajax({
            type: "POST",
            url: "/karyawan/kursus/changetutor",
            data: $('#form-change-tutor').serialize(),
            success: function (response) {
                swal(response)
                $('#modal-change-tutor').modal('hide')
                getData()
            }
        });
    }
    </script>
@endpush
@endsection