@extends('siswa.layouts.layout')
@section('title','Program Saya')
@section('content')

<table id="tabeldata" class="table  table-dark projects">
    <thead>
        <tr>
            <th style="width: 1%">No</th>
            <th style="width: 20%">Nama Program</th>
            <th>Materi</th>
            <th style="width: 30%">Pertemuan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Kursus as $item)

        <tr class="bg-dark"  style="font-size:14px">
            <td>{{$loop->iteration}}</td>
            <td>
                <h6>{{$item['NamaProgram']}}</h6>

            </td>
            <td>
                <h6> {{$item['NamaMateri']}}</h6>
            </td>
            <td class="project_progress">
                <div class="progress progress_sm">
                    <div class="progress-bar bg-green" role="progressbar"
                        data-transitiongoal="{{$item['Pertemuan']*(100/$item['TotalPertemuan'])}}"></div>
                </div>
                @if ($item['NamaMateri']!='Kelas selesai')
                    
                <p>pertemuan ke {{$item['Pertemuan']}} dari {{$item['TotalPertemuan']}}</p>
                @else
                Selesai ( {{$item['TotalPertemuan']}} Pertemuan )
                @endif
            </td>
            <td>
                <a type="button" class="btn btn-success btn-xs">{{$item['NamaMateri']=='Kelas selesai'?'Selesai':$item['StatusJadwal']}}</a>
            </td>
            <td>
                @if($item['NamaMateri']=='Kelas selesai'||$item["JadwalExist"])
                <a href="{{url('siswa/kursus/show')}}/{{$item['UUIDKursus']}}" class="btn btn-primary btn-xs">
                    <i class="fa fa-folder"></i>
                    Buka
                </a>
                @else
                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modalcreate"
                    onclick="setdata({{$item['TotalPertemuan']}},{{$item['IDKursus']}},{{$item['IDProgram']}})">
                    <i class="fa fa-edit"></i>
                    Buat Jadwal
                </a>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- {{-- Modal create jadwal --}} -->
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Jadwal</h5>
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
                    <a id="tombolcreate" onclick="create_jadwal()" class="btn text-white btn-sm btn-primary">Buat</a>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal -->
<form action="{{url('siswa/jadwal/store')}}" method="POST">
    <div class="modal fade" id="modalshowjadwal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" style="overflow-y:initial" role="document">
            <div class="modal-content">
                @csrf
                <div id="wizard_verticle" style="height:auto" class="form_wizard  wizard_horizontal">

                    <div class="stepContainer">
                        <!-- aktif add style display block and  class content -->
                        <!-- step 1 data program -->
                        <div id="step-1" style="display:block" class="content">
                            <div class="modal-header">
                                <h5 class="modal-title">Jadwal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="max-height: 60vh;overflow-y:auto">
                                <table style="width:100%" class="table table-striped table-inverse table-responsive">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th style="width:10%">Hari</th>
                                            <th style="width:20%">Tanggal</th>
                                            <th style="width:10%">Jam</th>
                                            <th style="width:10%">Pertemuan ke</th>
                                            <th style="width:20%">Materi</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tbody_show_jadwal" >

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
    let tea;
    let schque;
    let data_tutor;
    let materi = [];
    let jam_maker = []
    const id_kursus_siswa = $('#id_kursus_siswa').val();
    const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    let step = 1;

    $(document).ready(function () {
        $('#tabeldata').DataTable();
        $('[data-toggle="tooltip"]').tooltip(); 
     
    });

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
            $('#jadwal-jam-'+hari).empty();
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

    function create_jadwal() {

        let start_date = $('#start_date');
        let start_time = $('#start_time');
        let total_pertemuan = $('#total_pertemuan');
        let hours = start_time.val();
        let id_kursus_siswa = $('#id_kursus_siswa');
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
        let a = total_pertemuan.val() % jam_maker.length;
        //hasil pembagian total pertemuan tanpa sisa bagi ( max perulangan)
        let c = total_pertemuan.val() % jam_maker.length == 0 ? total_pertemuan.val() / jam_maker.length : (
            total_pertemuan.val() - (total_pertemuan.val() % jam_maker.length)) / jam_maker.length;
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
      
    
        getAndSetNewestJadwalTutor(start_date.val());
        checkJadwalTutor(jadwal_siswa);

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

    // TODO: return data filter

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

    function setdata(total_pertemuan, id_kursus, id_program) {

        $('#total_pertemuan').val(total_pertemuan);
        $('#id_kursus_siswa').val(id_kursus);
        $('#id_program').val(id_program);
        getAndSetMateri(id_program);
    }
    function getAndSetMateri(idprogram) {
        $.ajax({
            url: '/siswa/getMateriByIDProgram/' + idprogram,
            type: 'get',
            success: function (data) {
          
                materi = [];
                materi = data;
            },
            async: false
        });
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




    
</script>
@endpush
@endsection

<!-- 
{{-- @if($item["StatusJadwal"]=='Jadwal belum dibuat')
  <div class="form-group">
      <form action="{{url('siswa/jadwal/store')}}" method="POST">
@csrf
<input type="hidden" value="{{$item['IDProgram']}}" name="idprogram">
<input type="hidden" value="{{$item['IDKursus']}}" name="idkursus">
<input type="hidden" value="{{$item['NoRecord']}}" name="norecord">
<input type="hidden" value="{{$item['NamaMateri']}}" name="namamateri">
<input style="display:" class="mb-1" type="datetime-local" name="jadwal" id="jadwal">
<button type="submit" class="btn btn-sm btn-danger ">Buat Jadwal</button>
@if($item["StatusJadwal"]=='Jadwal belum dibuat'&&intval($item['Pertemuan'])>=1)
<a href="{{url('siswa/jadwal/show')}}/{{$item['UUIDKursus']}}" class="btn btn-primary btn-sm">
    <i class="fa fa-folder"></i>
    Lihat Jadwal
</a>
@endif
</form>
</div>

@else --}}

{{-- @foreach($Kursus as $item)
    <form class="bg-white" action="{{url('siswa/jadwal/store')}}" method="POST">
@csrf



<a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
<a href="#" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>


<div class="card mx-2 my-2 item shadow-sm">
    <input type="hidden" value="{{$item['IDProgram']}}" name="idprogram">
    <input type="hidden" value="{{$item['IDKursus']}}" name="idkursus">
    <input type="hidden" value="{{$item['NoRecord']}}" name="norecord">
    <input type="hidden" value="{{$item['NamaMateri']}}" name="namamateri">
    <div class="item-info">
        <span class="item-title">
            Program:
        </span>
        <p class="item-data">
            {{$item["NamaProgram"]}}
        </p>
    </div>


    <div class="item-info">
        <span class="item-title">
            Total Pertemuan:
        </span>
        <p class="item-data">
            {{$item["TotalPertemuan"]}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Sisa Pertemuan:
        </span>
        <p class="item-data">
            {{$item["SisaPertemuan"]}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Pertemuan ke:
        </span>
        <p class="item-data">
            {{$item["Pertemuan"]}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Materi:
        </span>
        <p class="item-data">
            {{$item["NamaMateri"]}}
        </p>
    </div>
    Jadwal:
    <div class="item-info">
        <span class="item-title">
        </span>
        <p class="item-data">
            {{$item["StatusJadwal"]}}
        </p>
    </div>
    @if($item["StatusJadwal"]=='Jadwal belum dibuat')
    <div class="form-group">
        <input style="display:" type="datetime-local" name="jadwal" id="jadwal">
        <button type="submit" class="btn btn-sm btn-primary ">Buat Jadwal</button>
    </div>
    @else
    <a href="{{url('siswa/jadwal/show')}}/{{$item['UUIDKursus']}}" class="btn btn-sm btn-primary btn-block mt-2">Lihat
        Jadwal</a>
    @endif
</div>
</form>
@endforeach --}} -->


