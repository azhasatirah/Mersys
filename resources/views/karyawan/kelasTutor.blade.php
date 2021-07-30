@extends('karyawan.layouts.layout')
@section('title','Program Saya')
@section('kelas','current-page')
@section('content')
<div class="table-responsive">

    <table id="tabeldata" class="table  table-dark projects">
        <thead>
            <tr>
                <th style="width: 1%">No</th>
                <th style="width: 10%">Kode Kelas</th>
                <th style="width: 15%">Nama Kelas</th>
                <th style="width:15%">Materi</th>
                <th style="width: 20%">Pertemuan</th>
                <th style="width: 17%">Status</th>
                <th style="width: 5%">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Kursus as $item)
    
            <tr style="font-size:12px" class="bg-dark">
                <td >{{$loop->iteration}}</td>
                <td>{{$item['KodeKursus']}}</td>
                <td>
                    {{$item['NamaProgram']}}
    
                </td>
                <td>
                    {{$item['NamaMateri']}}
                </td>
                <td class="project_progress">
                    <div class="progress progress_sm">
                        <div class="progress-bar bg-green" role="progressbar"
                            data-transitiongoal="{{$item['Pertemuan']*(100/$item['TotalPertemuan'])}}"></div>
                    </div>
                    @if ($item['Pertemuan']==$item['TotalPertemuan'])
                    <p>Selesai ( {{$item['TotalPertemuan']}} Pertemuan )</p>
                    @else
                    <p>pertemuan ke {{$item['Pertemuan']}} dari {{$item['TotalPertemuan']}}</p>
                    @endif
                </td>
                <td>
                    <a type="button" class="btn btn-success btn-sm">{{$item['StatusJadwal']}}</a>
                </td>
                <td>
                    <a href="{{url('karyawan/tutor/kelas/show')}}/{{$item['UUIDKursus']}}" class="btn btn-primary btn-sm">
                   
                        Buka
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- {{-- Modal create jadwal --}} -->
    <div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date" class="col-form-label">Tanggal mulai:</label>
                        <input type="date" onchange="setFirstDay()" id="start_date"name="bank"class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="time" class="col-form-label">Jam:</label>
                        <input type="time" id="start_time" name="bank"class="form-control" >
                    </div>
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" value="1" id="senin" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="senin">Senin</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" value="2" id="selasa" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="selasa">Selasa</label>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input value="3" type="checkbox" id="rabu" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="rabu">Rabu</label>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input value="4" type="checkbox" id="kamis" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="kamis">Kamis</label>
                            </div>                           
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input value="5" type="checkbox" id="jumat" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="jumat">Jumat</label>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input value="6" type="checkbox" id="sabtu" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="sabtu">Sabtu</label>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input value="0" type="checkbox" id="minggu" class="form-check-input">
                                <label class="form-check-lavel mt-2" for="minggu">Minggu</label>
                            </div>                            
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                    <a id="tombolcreate"  onclick="create_jadwal()" class="btn text-white btn-sm btn-primary">Buat</a>
                </div>
                </form>
            </div>
        </div>
    </div>


    
    <!-- Modal -->
    <div class="modal fade" id="modalshowjadwal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jadwal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <table style="width:100%" class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th style="width:10%">Hari</th>
                                <th style="width:20%">Tanggal</th>
                                <th style="width:10%">Jam</th>
                                <th style="width:10%">Pertemuan ke</th>
                                <th style="width:20%">Materi</th>
                                <th style="width:30%"></th>
                            </tr>
                            </thead>
                            <tbody id="tbody_show_jadwal">

                            </tbody>
                    </table>
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
        let jadwal_tutor=[];
        let materi = [];
        const id_kursus_siswa = $('#id_kursus_siswa').val();
        const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $(document).ready(function () {

            $('#tabeldata').DataTable();
        });
        function create_jadwal(){

            var start_date = $('#start_date');
            var start_time = $('#start_time');
            var total_pertemuan = $('#total_pertemuan');
            var hours = start_time.val();
            var id_kursus_siswa = $('#id_kursus_siswa');
            var senin = $('#senin');  var selasa = $('#selasa');  var rabu = $('#rabu');  var kamis = $('#kamis');  var jumat = $('#jumat');  var sabtu = $('#sabtu');  var minggu = $('#minggu');
            var tmp_meet_in_week =[
                {'aktif':senin.is(':checked'),'hari':senin.val()},
                {'aktif':selasa.is(':checked'),'hari':selasa.val()},
                {'aktif':rabu.is(':checked'),'hari':rabu.val()},
                {'aktif':kamis.is(':checked'),'hari':kamis.val()},
                {'aktif':jumat.is(':checked'),'hari':jumat.val()},
                {'aktif':sabtu.is(':checked'),'hari':sabtu.val()},
                {'aktif':minggu.is(':checked'),'hari':minggu.val()},
            ];
            var meet_in_week = tmp_meet_in_week.filter(ele => ele.aktif == true);
            // mengatur tanggal awal
            var flat_date = meet_in_week.map(ele => 
                new Date(start_date.val()).setDate(
                    new Date(start_date.val()).getDate() + 
                    (ele.hari - new Date(start_date.val()).getDay()) +
                    (
                        ele.hari - new Date(start_date.val()).getDay()<0?7:0
                    )

                )
            );
            console.log(flat_date);
            var date = flat_date.sort((a,b)=>a-b).map(ele=>
                new Date(ele).getFullYear()+'-'+String(new Date(ele).getMonth()+1).padStart(2,'0')+'-'+String(new Date(ele).getDate()).padStart(2,'0')
            );
     
            var a = total_pertemuan.val()%meet_in_week.length;
            var c = total_pertemuan.val() % meet_in_week.length==0?total_pertemuan.val()/meet_in_week.length:(total_pertemuan.val()-(total_pertemuan.val()%meet_in_week.length))/meet_in_week.length;
            var jadwal_siswa = [];
            var date_increament = 0;
            //keep it up sware -3-
           // jadwal maker
            for(var i=0;i < c;i++){
                for(var j=0;j < date.length;j++){
                var tmp_date = new Date(new Date(date[j]).setDate(new Date(date[j]).getDate()+date_increament));
                var tmp_jadwal = tmp_date.getFullYear()+'-'+String(tmp_date.getMonth()+1).padStart(2,'0')+'-'+String(tmp_date.getDate()).padStart(2,'0');
                jadwal_siswa.push(
                    {'tanggal':tmp_jadwal,'jam':hours}
                    );
                }
                date_increament += 7;
            }
            if(a!=0){
                for(var j=0;j < a;j++){
                var tmp_date = new Date(new Date(date[j]).setDate(new Date(date[j]).getDate()+date_increament));
                var tmp_jadwal = tmp_date.getFullYear()+'-'+String(tmp_date.getMonth()+1).padStart(2,'0')+'-'+String(tmp_date.getDate()).padStart(2,'0');
                jadwal_siswa.push(
                    {'tanggal':tmp_jadwal,'jam':hours}
                );
                date_increament+=7;
                }
            }
            console.log(jadwal_siswa);
            getAndSetNewestJadwalTutor(start_date.val());
            checkJadwalTutor(jadwal_siswa);
            
        }
        function checkJadwalTutor(jadwal_siswa){
            //tmp tanggal jadwal
            var jadwal = jadwal_tutor;
            tmp_old_sch = [];
            tmp_new_sch =[];
            tmp_old_sch_hours = [];
            tmp_new_sch_hours =[];
            if(jadwal.length ==0){
                console.log(jadwal_siswa);
                $('#modalcreate').modal('hide');
                $('#modalshowjadwal').modal('show');
                var ite = 0;
                $('#tbody_show_jadwal').empty();
                jadwal_siswa.sort((a,b)=>new Date(a.tanggal) - new Date(b.tanggal)).forEach((ele)=>{
                    $('#tbody_show_jadwal').append(
                        "<tr>"+
                            "<td scope=\"row\">"+hari[new Date(ele.tanggal).getDay()]+"</td>"+
                            "<td>"+ele.tanggal+"</td>"+
                            "<td>"+ele.jam+"</td>"+
                            "<td>"+(ite+1)+"</td>"+
                            "<td>"+materi[ite].NamaMateri+"</td>"+
                            "<td>"+
                                "<a class=\"btn btn-success btn-sm text-white\">Jadwal Ditemukan</a>"+
                            "</td>"+
                        "</tr>"
                    );
                    ite++;
                });
            }else{

                jadwal_siswa.forEach(ele=>tmp_new_sch.push(ele.tanggal));
                jadwal.forEach(ele=>tmp_old_sch.push(ele.tanggal));
                jadwal_siswa.forEach(ele=>tmp_new_sch_hours.push(ele.jam));
                jadwal.forEach(ele=>tmp_old_sch_hours.push(ele.jam));
                //jadwal checker 
                check_jadwal = tmp_new_sch.findIndex(new_sch => 
                    tmp_old_sch.some((old_sch)=>new_sch == old_sch)
                );
                check_jam = tmp_new_sch_hours.findIndex(new_sch => 
                    tmp_old_sch_hours.some((old_sch)=>new_sch == old_sch)
                )
                //cek jadwal tutor berdasarkan tanggal
                //nilai lebih dari 0 = index jadwal yg tidak kosong
                //
                var report = check_jadwal < 0?jadwal_siswa:check_jadwal;
                
                console.log(report);
                console.log(check_jam);
            }
        }
        function setFirstDay(){
            var start_date = $('#start_date').val();
            var firs_day = new Date(start_date).getDay();
            switch(firs_day){
                case 0:
                    $('#minggu').prop('checked',true);
                    $('#senin').prop('checked',false);
                    $('#selasa').prop('checked',false);
                    $('#rabu').prop('checked',false);
                    $('#kamis').prop('checked',false);
                    $('#jumat').prop('checked',false);
                    $('#sabtu').prop('checked',false);
                    break;
                case 1:
                    $('#senin').prop('checked',true);
                    $('#minggu').prop('checked',false);
                    $('#selasa').prop('checked',false);
                    $('#rabu').prop('checked',false);
                    $('#kamis').prop('checked',false);
                    $('#jumat').prop('checked',false);
                    $('#sabtu').prop('checked',false);
                    break;
                case 2:
                    $('#selasa').prop('checked',true);
                    $('#minggu').prop('checked',false);
                    $('#senin').prop('checked',false);
                    $('#rabu').prop('checked',false);
                    $('#kamis').prop('checked',false);
                    $('#jumat').prop('checked',false);
                    $('#sabtu').prop('checked',false);
                    break;
                case 3:
                    $('#rabu').prop('checked',true);
                    $('#minggu').prop('checked',false);
                    $('#senin').prop('checked',false);
                    $('#selasa').prop('checked',false);
                    $('#kamis').prop('checked',false);
                    $('#jumat').prop('checked',false);
                    $('#sabtu').prop('checked',false);
                    break;
                case 4:
                    $('#kamis').prop('checked',true);
                    $('#minggu').prop('checked',false);
                    $('#senin').prop('checked',false);
                    $('#selasa').prop('checked',false);
                    $('#rabu').prop('checked',false);
                    $('#jumat').prop('checked',false);
                    $('#sabtu').prop('checked',false);
                    break;
                case 5:
                    $('#jumat').prop('checked',true);
                    $('#minggu').prop('checked',false);
                    $('#senin').prop('checked',false);
                    $('#selasa').prop('checked',false);
                    $('#rabu').prop('checked',false);
                    $('#kamis').prop('checked',false);;
                    $('#sabtu').prop('checked',false);
                    break;
                case 6:
                    $('#sabtu').prop('checked',true);
                    $('#minggu').prop('checked',false);
                    $('#senin').prop('checked',false);
                    $('#selasa').prop('checked',false);
                    $('#rabu').prop('checked',false);
                    $('#kamis').prop('checked',false);
                    $('#jumat').prop('checked',false);
                    break;

            }
        }
        function setdata(total_pertemuan,id_kursus){
            console.log(total_pertemuan);
            console.log(id_kursus);
            $('#total_pertemuan').val(total_pertemuan);
            $('#id_kursus_siswa').val(id_kursus);
            getAndSetMateri(id_kursus);
        }

        function getAndSetNewestJadwalTutor(start_date){
            $.ajax({
                url:'/siswa/getJadwalTutor/'+start_date,
                type:'get',
                success:function(data){
                    console.log(data);
                    jadwal_tutor = data;
                }
            });
        }
        function getAndSetMateri(idksiswa){
            $.ajax({
                url:'/siswa/getMateriByIDKursusSiswa/'+idksiswa,
                type:'get',
                success:function(data){
                    materi = data;
                }
            });
        }
    </script>
    @endpush
@endsection
