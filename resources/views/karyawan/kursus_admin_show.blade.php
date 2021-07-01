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
                    </div>
                </div>

                <hr>
            </div>
            <div class="x_content">
                <div style="display: none" id="content-jadwal" class=" mt-3">
                        <table id="tabeldata" style="width: 100%" class="table table-hover">
                            <thead style="width: 100%">
                                <tr>
                                    <th>Per</th>
                                    <th>Tanggal</th>
                                    <th>Materi</th>
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
    
            </div>
        </div>
    </div>
</div>
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
<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />
@push('scripts')
<script src="{{asset('assets/js/moment.js')}}"></script>
    <script>
    let token = $('#token').val();
        //data from database
    let DataKelas = [],Absen = [],Changes = [],jadwal = []

    let UIDKelas = window.location.href.split('/')[7]
    let active_content = "jadwal";
    const btn_jadwal = $('#btn-jadwal');
    const btn_ubahjadwal = $('#btn-ubahjadwal');
    const content_ubahjadwal = $('#content-ubahjadwal');
    const content_jadwal = $('#content-jadwal');

    let ReqJadwalChanges = [];

    let TabelJadwal = $('#tabeldata').DataTable({
        "scrollX": true,
    })
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
                content_ubahjadwal.hide();
                content_jadwal.show();
                break;
            case 'ubahjadwal':
                btn_jadwal.removeClass('active');
                btn_ubahjadwal.addClass('active');
                content_jadwal.hide();
                content_ubahjadwal.show();
                break;
        }
    }
    function getData(){
        Promise.resolve($.get("/karyawan/admin/kursus/getdata/"+UIDKelas))
        .then((ele)=>{
            DataKelas = ele['DataKelas'][0]
            Absen = ele['Absen']
            Changes = ele['Changes']
            jadwal = Object.values(ele['ActiveJadwal'])
            showDataJadwal()
            showDataKelas()
            showChanges()
      
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
    function showDataJadwal(){
        TabelJadwal.clear()
        Absen.forEach((ele)=>{
            TabelJadwal.row.add([
                ele.Pertemuan,
                ele.Tanggal,
                ele.Materi,
                ele.KehadiranTutor,
                ele.KehadiranSiswa
            ]).draw()
        })
        //input select change 
  
        $('#input-ubah-jadwal-select').empty();
        $('#input-ubah-jadwal-select').append('<option>pilih</option>');
        $('#input-ubah-jadwal-select').append('<option value="all">Izin Cuti</option>');
        jadwal.forEach((ele)=>{
            $('#input-ubah-jadwal-select').append(
                "<option value=\""+ele.NoRecord+"\">Ubah pertemuan ke "+ele.NoRecord+"</option>"
            )
        })
    }
    function showChanges(){
        $('#list-history-changes').empty()
        Changes.sort((a,b)=> b.IDJadwalChange - a.IDJadwalChange).forEach((ele)=>{
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
            console.log('jam only')
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
            setAndShowDataModalChanges(JadwalChanged)
        }
        if(jadwal[jadwalChangedIndex].Tanggal.split(' ')[0] != reqTanggal){
            let reqJadwal = jadwal[jadwalChangedIndex].Tanggal.split(' ')[0] != reqTanggal
            && jadwal[jadwalChangedIndex].Tanggal.split(' ')[1] != reqJam ?reqTanggal+' '+reqJam:
            jadwal[jadwalChangedIndex].Tanggal.split(' ')[0] != reqTanggal
            && jadwal[jadwalChangedIndex].Tanggal.split(' ')[1] == reqJam? reqTanggal+' '+jadwal[jadwalChangedIndex].Tanggal.split(' ')[1]:''
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
                        'TanggalFrom': ele.Tanggal,
                        'TanggalTo':tmp_new_jadwal[ite+1].Tanggal+' '+tmp_new_jadwal[ite+1].Tanggal.split(' ')[1]
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
        $.post("/karyawan/admin/kursus/jadwalchanges/store", ReqJadwalChanges, (ele) =>{
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
        console.log(DataChanges)
        ReqJadwalChanges = DataChanges
        console.log(ReqJadwalChanges)
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
    </script>
@endpush
@endsection