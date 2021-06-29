@extends('karyawan.layouts.layout')
@section('title','Jadwal')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jadwal <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kursus</th>
                            <th>Nama Siswa</th>
                            <th>Prodi</th>
                            <th>Tanggal Mulai</th>
                            <th>Tambah Tutor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modaladdtutor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Tutor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @csrf
        <div class="modal-body">

            <form method="POST" id="formSetTutor" action="{{url('karyawan/admin/jadwal/updatetutor')}}" >
            @csrf
            <input type="hidden" name="kursussiswa" id="kursussiswa-set-tutor"
             class="val-idkursussiswa">
            <input type="hidden" name="tutor" id="tutor-set-tutor">
            </form>
            <ul class="list-group " id="list-tutor-set-tutor">

            </ul>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
   
    </div>
  </div>
</div>
@endsection

@push('scripts')
    <script>
    
    var TabelData = $('#tabeldata').DataTable();
    var ProgramStudi;
    var KategoriMateri;
    var CicilanCreate = 0;
  

    $(document).ready(function(){
        $('#tabeldata').DataTable();
        showData();
    });

    $(function(){
        $(document).on('click','#tombolcreate',function(){
            storeData();
        });
        $(document).on('click','#tomboledit',function(){
            updateData();
        });
        $('#modaledit').on('show.bs.modal',function(event){
            var Button = $(event.relatedTarget);
            var IDData = Button.data('id');
            editData(IDData);     
        })
    });

    function showData(){
       var Tutor = function(){
           var tmp =null;
           $.ajax({
               'async':false,
               'type':'GET',
               'url':'/karyawan/admin/getdata/tutor',
               'success': function (data){
                   tmp = data;
               }
           });

           return tmp;
        }();
        $.get('/karyawan/admin/jadwal/getdata',function(Data){
            if(Data.Status=='success'){
                $('#datatabel').empty();
                var a=0;
                TabelData.clear().draw();
                Data.Jadwal.forEach((data) =>{
                    
                    a++;
                    Tutor.forEach((val)=>{"<option value=\"+val.IDKaryawan+\"></option>"});
                    var AddTutor = "<button type=\"button\""+  
                                    "onclick=\"editJadwal("+data.IDKursusSiswa+")\""+
                                    "class=\"btn btn-primary btn-sm\""+ 
                                    "data-toggle=\"modal\" data-target=\"#modaladdtutor\" >"+
                                        "Pilih Tutor "+
                                    "</button>";
                    TabelData.row.add([
                        a,
                        data.KodeKursus,
                        data.NamaSiswa,
                        data.NamaProdi,
                        data.Tanggal,
                        AddTutor,
                        data.IDTutor==null?'Belum memilih tutor':data.IDTutor
                    ]).draw();
                });
  
            }
        })
    }

    function editJadwal(id_kursus) {
        $('#kursussiswa-set-tutor').val(id_kursus);
        showFreeTutor(id_kursus);
    }
    function showFreeTutor(id_kursus){
        $('#list-tutor-set-tutor').empty()
        let tmp_jadwal_siswa;
        let tea;
        let start_date;
        $.ajax({
            url: '/karyawan/admin/getJadwalSiswa/' + id_kursus,
            type: 'get',
            success: function (data) {
                tmp_jadwal_siswa = data;
            },
            async: false
        });
        start_date = tmp_jadwal_siswa[0].Tanggal;
        $.ajax({
            url: '/karyawan/admin/getJadwalTutor/' + start_date,
            type: 'get',
            success: function (data) {
                tea = data[0];
            },
            async: false
        });
        let fil_tea=[]; 
        tea.forEach((ele)=>{
            if(ele.teaStatus != false){
                if(filterDate(ele.Data,tmp_jadwal_siswa).length==0){
                    fil_tea.push({
                        'IDTutor':ele.IDTutor,
                        'Nama':ele.Nama
                    });
                }
            }else{
                fil_tea.push({
                        'IDTutor':ele.IDTutor,
                        'Nama':ele.Nama
                });
            }
        }); 
        fil_tea.forEach((ele)=>{
            $('#list-tutor-set-tutor').append(
                '<li class=\"list-group-item d-flex justify-content-between\">'+
                    ele.Nama+
                    '<button onclick=\"setTutor('+ele.IDTutor+')\" class=\"btn btn-sm btn-primary\">Pilih</button>'+
                '</li>'
            );
        });

    }
    function setTutor(idTutor){
        $('#tutor-set-tutor').val(idTutor);
        $('#formSetTutor').submit();
    }
    function filterDate(jadwal,jadwal_siswa){
        const dataFilter = (ele) => {
            tmp_old_sch = [];
            tmp_new_sch = [];
            tmp_old_sch_hours = [];
            tmp_new_sch_hours = [];
            //jadwal_siswa.forEach(ele => tmp_new_sch.push(ele.Tanggal));
            jadwal_siswa.forEach(ele => tmp_new_sch.push(ele.Tanggal.split(' ')[0]));
            ele.forEach(ele => tmp_old_sch.push(ele.Tanggal.split(' ')[0]));
            //jadwal_siswa.forEach(ele => tmp_new_sch_hours.push(ele.jam));
            jadwal_siswa.forEach(ele => tmp_new_sch_hours.push(
                ele.Tanggal.split(' ')[1].split(':')[0] + ':' +
                ele.Tanggal.split(' ')[1].split(':')[1]
            ));
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
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    </script>

@endpush