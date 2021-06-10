@extends('karyawan.layouts.layout')
@section('title','Jadwal')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jadwal <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <input type="hidden" id="csrf" name="_token" value="{{ csrf_token() }}">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
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
    </div>
</div>



<div class="modal fade" id="modalendkelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @csrf
        <div class="modal-body">


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
   
    </div>
  </div>
</div>
@endsection
{{-- "<form id=\"formend"+data.IDKursusMateri+"\" method=\"POST\">"+
    "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\">"+
"<input type=\"hidden\" name=\"idkursusmateri\" value=\""+data.IDKursusMateri+"\">"+
"<input type=\"hidden\" name=\"karyawan\" value=\""+data.IDTutor+"\">"+
"<a onclick=\"endKelas("+data.IDKursusMateri+")\" class=\"btn text-white btn-small btn-primary\">Akhiri kelas</a>"+
"</form>"; --}}
@push('scripts')
    <script>
    // setInterval(console.log('wkw'),1000);
    var TabelDataJadwal = $('#tabeldata').DataTable();
    var ProgramStudi;
    var KategoriMateri;
    var CicilanCreate = 0;
    var mulai = false;
  

    $(document).ready(function(){
        $('#tabeldata').DataTable();
        showDataJadwal();
    });

    $(function(){
        $(document).on('click','#tombolcreate',function(){
            storeData();
        });
        $(document).on('click','#tomboledit',function(){
            updateData();
        });
        $(document).on('change','#cicilancreate',function(){
            CicilanCreate += 1;
            if($('#cicilancreate').val()=='y'){
                $('#hargacicilancreate').empty().append(
                "<div class=\"form-group\" id=\"cicilanjeniscreate"+CicilanCreate+"\" style=\"margin-left:12px\">"+
                    "Cicilan <span id=\"labeljumlahcicilancreate"+CicilanCreate+"\"></span>"+
                    "<div class=\"row mt-1 \" >"+
                        "<div class=\"col col-md-5\" style=\"padding-left: 10px;\">"+
                        "<input type=\"number\" id=\"injumlahcicilancreate"+CicilanCreate+"\" onkeyup=\"injumlahcicilancreate("+CicilanCreate+")\" name=\"jumlahcicilan[]\" class=\"form-control\" placeholder=\"Dicicil berapa kali\">"+
                        "</div>"+
                        "<div class=\"col col-md-5\" >"+
                        "<input type=\"text\" name=\"hargacicilan[]\" class=\"form-control\" placeholder=\"Harga Cicilan\">"+
                        "</div>"+
                        "<div class=\"col col-md-2\" >"+
                        "</div>"+     
                    "</div>"+
                "</div>"
                );
                $('#tambahcicilancreate').empty().append(
                    "<div class=\"form-group\" style=\"margin-left:12px\">"+
                        "<a id=\"btntambahcicilancreate\" class=\"btn btn-sm btn-primary text-white\">Tambah cicilan</a>"+
                    "</div>"
                );
            }else{
                $('#hargacicilancreate').empty();
                $('#tambahcicilancreate').empty();
            }
        });
        $(document).on('click','#btntambahcicilancreate',function(){
            CicilanCreate += 1;
            $('#hargacicilancreate').append(
                "<div class=\"form-group\" id=\"cicilanjeniscreate"+CicilanCreate+"\" style=\"margin-left:12px\">"+
                    "Cicilan <span id=\"labeljumlahcicilancreate"+CicilanCreate+"\"></span>"+
                    "<div class=\"row mt-1 \" >"+
                        "<div class=\"col col-md-5\" style=\"padding-left: 10px;\">"+
                        "<input type=\"number\" id=\"injumlahcicilancreate"+CicilanCreate+"\" onkeyup=\"injumlahcicilancreate("+CicilanCreate+")\" name=\"jumlahcicilan[]\" class=\"form-control\" placeholder=\"Dicicil berapa kali\">"+
                        "</div>"+
                        "<div class=\"col col-md-5\" >"+
                        "<input type=\"text\" name=\"hargacicilan[]\" class=\"form-control\" placeholder=\"Harga Cicilan\">"+
                        "</div>"+
                        "<div class=\"col col-md-2\" >"+
                        "<a onclick=\"hapuscicilancreate("+CicilanCreate+")\" class=\"btn btn-danger text-white\"><i class=\"fa fa-trash\"></i></a>"+
                        "</div>"+     
                    "</div>"+
                "</div>"
            );
        });

        $(document).on('change','#editcicilan',function(){
            if($('#editcicilan').val()=='y'){
                $('#hargacicilanedit').empty().append(
                    "<div class=\"form-group\">"+
                    "<label for=\"recipient-name\" class=\"col-form-label\">Harga Cicilan:</label>"+
                    "<input type=\"text\" id=\"createhargacicilan\" name=\"hargacicilan\"class=\"form-control\" >"+
                    "</div>"
                );
            }else{
                $('#hargacicilanedit').empty();
            }
        });
        $('#modaledit').on('show.bs.modal',function(event){
            var Button = $(event.relatedTarget);
            var IDData = Button.data('id');
            editData(IDData);     
        })
    });
    function hapuscicilancreate(id){
        $('#cicilanjeniscreate'+id).remove();
    }
    function injumlahcicilancreate(id){
        $('#labeljumlahcicilancreate'+id).empty().append($('#injumlahcicilancreate'+id).val()+'x');
    }
    function clearFormCreate(){
        $('.form-control').val('');
    }

    function dialogEndKelas(NamaKelas,IDKursusMateri,NamaMateri,KodeKelas){
        swal({
              title: "Akhiri Kelas "+NamaKelas+"?",
              text: "Materi " +NamaMateri+" akan selesai!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                endKelas(IDKursusMateri,KodeKelas);
              } else {
                  swal("Dibatalkan!");
              }
          });
    }

    function showDataJadwal(){
        $.get('/karyawan/tutor/jadwal/getdata',function(Data){
  
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
                    var b_mulai = "<form id=\"formstart"+data.IDKursusMateri+"\" method=\"POST\">"+
                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\">"+
                    "<input type=\"hidden\" name=\"idkursusmateri\" value=\""+data.IDKursusMateri+"\">"+
                    "<input type=\"hidden\" name=\"karyawan\" value=\""+data.IDTutor+"\">"+
                    "<a onclick=\"startKelas(\'"+data.IDKursusMateri+"\',\'"+data.KodeKelas+"\')\" class=\"btn text-white btn-small btn-primary\">Mulai</a>"+
                    "</form>";
                    var b_akhir ="<a  onclick=\"dialogEndKelas(\'"+data.NamaProdi+"\',\'"+data.IDKursusMateri+"\',\'"+data.NamaMateri+"\',\'"+data.KodeKelas+"\')\"  class=\"btn text-white btn-small btn-primary\">Akhiri kelas</a>"+
                    "<form id=\"formend"+data.IDKursusMateri+"\" method=\"POST\">"+
                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\">"+
                    "<input type=\"hidden\" name=\"idkursusmateri\" value=\""+data.IDKursusMateri+"\">"+
                    "<input type=\"hidden\" name=\"karyawan\" value=\""+data.IDTutor+"\">"+
                  
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
    function startKelas(id,KodeKelas){
        $.post('/karyawan/tutor/kursus/start',$('#formstart'+id).serialize())
        .done(function(param){
            showDataJadwal();
            $.get('/karyawan/tutor/kursus/event/'+ KodeKelas);
            console.log(param);
        }).fail(function(param){
            console.log('error');
        })
    }
    function endKelas(id,KodeKelas){
        $.post('/karyawan/tutor/kursus/end',$('#formend'+id).serialize())
        .done(function(param){
            showDataJadwal();
            $.get('/karyawan/tutor/kursus/event/'+ KodeKelas);
            console.log(param);
        }).fail(function(param){
            console.log('error');
        })
    }

    function updateData(){
        console.log($('#formdataedit').serialize());
        $.post('/karyawan/admin/master/program/update',$('#formdataedit').serialize())
        .done(function(pesan){
            showDataJadwal();
            swal(pesan.Pesan);
            $('#modaledit').modal('hide');
            clearFormCreate();
        }).fail(function(pesan){
            console.log(pesan.Message);
            swal('gagal'+pesan.Pesan);
        });
    }

    function deleteData(ID){
        swal({
            title: "Apakah kamu yakin?",
            text: "Data akan dihapus!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.get('/karyawan/admin/master/program/delete/'+ID,function(Pesan){
                    if(Pesan.Status='success'){
                        swal("Data berhasi dihapus!", {
                            icon: "success",
                        });
                        showDataJadwal();
                    }else{
                        swal("Terjadi kesalahan!", {
                            icon: "error",
                        });
                    }
                });
            } else {
                swal("Dibatalkan!");
            }
        });
        
        
    }
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    </script>

@endpush