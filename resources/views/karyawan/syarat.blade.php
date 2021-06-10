@extends('karyawan.layouts.layout')
@section('title','Syarat dan ketentuan')
@section('content')
@if (count($errors)>0)
    <input type="hidden" value="{{$errors->first('msg')}}" id="msg">
    
@endif
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Syarat dan ketentuan <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    {{-- <button type="button" class="btn btn-primary btn-sm" 
                    data-toggle="modal" data-target="#modalcreate" >
                        Tambah  
                    </button> --}}
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 80%"></th>
                            <th style="width: 15%">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>

<!-- {{-- Modal create data --}} -->
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 100rem" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Syarat dan Ketentuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formdata" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">
            <div class="form-group">
              <label for="sk">Syarat dan ketentuan</label>
              <input type="file" class="form-control-file" name="content" 
                placeholder="">
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

<!-- {{-- Modal create data --}} -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Syarat dan Ketentuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formdataedit" method="POST" action="{{url('/karyawan/owner/syarat/update')}}" enctype="multipart/form-data">
        @csrf
          <div class="modal-body">
            <div class="form-group">
                <label for="sk">Syarat dan ketentuan</label>
                <input type="file" class="form-control-file" name="file" 
                id="sk" placeholder="" >
            </div>
            <input type="hidden" id="editid" name="idsyarat">
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Edit</button>
          </div>
          </form>
      </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        let TabelData = $('#tabeldata').DataTable();


$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
    showMsg();
});
function showMsg(){
            let msg = $('#msg').val();
            if(msg != undefined){
                swal({
                    title: 'Info',
                    text: msg,
                })
            }
        }

$(function(){
    $(document).on('click','#tombolcreate',function(){
        storeData();
    });
    $(document).on('click','#tomboledit',function(){
        updateData();
    });
    $('#modaledit').on('show.bs.modal',function(event){
        let Button = $(event.relatedTarget);
        let IDData = Button.data('id');
        editData(IDData);     
    })
});

function clearFormCreate(){
    $('.form-control').val('');
}


function showData(){
    $.get('/karyawan/owner/syarat/getdata',function(Data){
        $('#datatabel').empty();
        let a=0;
        TabelData.clear().draw();
        Data.forEach((data) =>{
            a++;
            let TombolAksi ="<button type=\"button\" class=\"btn btn-primary btn-sm editmodal\""+
                "data-toggle=\"modal\" data-target=\"#modaledit\" "+
                "data-id=\""+data.IDSyarat+"\">"+
                    "<i class=\"fa fa-edit\"></i>"+
                "</button>";
            TabelData.row.add([
                a,
                'Syarat dan Ketentuan',
                TombolAksi
            ]).draw();
        })
    })
}

function editData(id){
    $.get('/karyawan/owner/syarat/edit/'+id,function(data){
  
        $('#editid').val(data[0].IDSyarat);
        $('#syarat-edit').val(data[0].Content);
    });
}

function storeData(){

    $.post('/karyawan/owner/syarat/store',$('#formdata').serialize())
    .done(function(pesan){
        showData();
        swal(pesan);
        $('#modalcreate').modal('hide');
        clearFormCreate();
    }).fail(function(pesan){
     
        swal('gagal'+pesan.Pesan);
    });
}

function updateData(){

    $.post('/karyawan/owner/syarat/update',$('#formdataedit').serialize())
    .done(function(pesan){
        showData();
        swal(pesan);
        $('#modaledit').modal('hide');
        clearFormCreate();
    }).fail(function(pesan){
       
        swal('gagal'+pesan.Pesan);
    });
}

    </script>
@endpush