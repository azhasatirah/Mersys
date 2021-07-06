@extends('karyawan.layouts.layout')
@section('title','Diskon promo')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Promo <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-primary btn-sm" 
                    data-toggle="modal" data-target="#modalcreate" >
                        Tambah promo 
                    </button>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Diskon</th>
                                <th>Nama Siswa</th>
                                <th>Nilai</th>
                                <th>Program</th>
                                <th>Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="data-table">
    
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
</div>

<!-- {{-- Modal create data --}} -->
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah promo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formdata-create">
            @csrf
            <div class="form-group">
                <label for="">Hari</label>
                <select class="custom-select" name="kodehari">
                    <option value="0">Minggu</option>
                    <option value="1">Senin</option>
                    <option value="2">Selasa</option>
                    <option value="3">Rabu</option>
                    <option value="4">Kamis</option>
                    <option value="5">Jumat</option>
                    <option value="6">Sabtu</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Mulai</label>
                <input type="time" class="form-control" name="start">
            </div>
            <div class="form-group">
                <label for="">Sampai</label>
                <input type="time" class="form-control" name="end">
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button onclick="store()" type="button" class="btn btn-primary">Tambah</button>
    </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalupdate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="formdata-create">
                    @csrf
                    <div class="form-group">
                        <label for="">Hari</label>
                        <select class="custom-select" name="kodehari" id="edit-hari">
                            <option value="0">Minggu</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Mulai</label>
                        <input type="time" class="form-control" id="edit-start" name="start">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai</label>
                        <input type="time" class="form-control" id="edit-end" name="end">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="update()" type="button" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
    <script>
        let Jadwal = []
        $(document).ready(function () {
            getData()
            $('#tabeldata').DataTable();
        });
        function store(){
            $.ajax({
                type: "post",
                url: "/karyawan/admin/diskon/store",
                data: $('#formdata').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function getData(){
            $.get("/karyawan/admin/diskon/getdata",(ele)=>{
                Jadwal = ele
            })
        }

        function deleteData(id){
            swal({
                title: "Anda yakin?",
                text: "Promo di siswa akan hilang!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get("/karyawan/admin/diskon/delete/"+id,(ele)=>{
                        getData()
                        swal(ele)
                    })
                } else {
                    swal("Dibatalkan!");
                }
            })

        }
    </script>
@endpush