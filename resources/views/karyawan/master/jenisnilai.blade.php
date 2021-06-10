@extends('karyawan.layouts.layout')
@section('title','Kategori Materi')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jenis Nilai <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-primary btn-sm" 
                    data-toggle="modal" data-target="#modalcreate" >
                        Tambah Data 
                    </button>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>

{{-- Modal create data --}}
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formdata">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Jenis Nilai:</label>
            <input type="text" name="jenisnilai"class="form-control" >
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button id="tombolcreate" type="button" class="btn btn-primary">Tambah</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Modal Edit Data --}}
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formdataedit">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Jenis Nilai:</label>
              <input type="text" id="editnama" name="jenisnilai"class="form-control" >
              <input type="hidden" name="id" id="editid">
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button id="tomboledit" type="button" class="btn btn-primary">Edit</button>
          </div>
          </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
    <script>

        var TabelData = $('#tabeldata').DataTable();
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

        function clearFormCreate(){
            $('.form-control').val('');
        }


        function showData(){
            $.get('/karyawan/admin/jenisnilai/getdata',function(Data){
                $('#datatabel').empty();
                var a=0;
                TabelData.clear().draw();
                Data.forEach((data) =>{
                    a++;
                    var TombolAksi ="<button type=\"button\" class=\"btn btn-primary btn-sm editmodal\""+
                        "data-toggle=\"modal\" data-target=\"#modaledit\" "+
                        "data-id=\""+data.IDJenisNilai+"\">"+
                            "<i class=\"fa fa-edit\"></i>"+
                        "</button>"+
                        "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteData('"+data.IDJenisNilai+"')\">"+
                            "<i class=\"fa fa-trash\"></i></a>";
                    TabelData.row.add([
                        a,
                        data.Jenis,
                        TombolAksi
                    ]).draw();
                })
            
            })
        }

        function editData(id){
            $.get('/karyawan/admin/jenisnilai/getdata/detail/'+id,function(data){
                console.log(id);
                console.log(data);
                $('#editid').val(data[0].IDJenisNilai);
                $('#editnama').val(data[0].Jenis);
            });
        }

        function storeData(){
            //console.log($('#formdata').serialize());
            $.post('/karyawan/admin/jenisnilai/store',$('#formdata').serialize())
            .done(function(pesan){
                showData();
                swal(pesan.Pesan);
                $('#modalcreate').modal('hide');
                clearFormCreate();
            }).fail(function(pesan){
                console.log(pesan.Message);
                swal('gagal'+pesan.Pesan);
            });
        }

        function updateData(){
            $.post('/karyawan/admin/jenisnilai/update',$('#formdataedit').serialize())
            .done(function(pesan){
                showData();
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
                    $.get('/karyawan/admin/jenisnilai/destroy/'+ID,function(Pesan){
                        if(Pesan.Status='success'){
                            swal("Data berhasi dihapus!", {
                                icon: "success",
                            });
                            showData();
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
    </script>

@endpush