@extends('karyawan.layouts.layout')
@section('title','Jadwal semi private')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jadwal semi private <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-primary btn-sm" 
                    data-toggle="modal" data-target="#modalcreate" >
                        Tambah data 
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
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Sampai</th>
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
                <form id="formdata-edit">
                    @csrf
                    <input type="hidden" name="idjadwalsemiprivate" id="edit-jadwalsemiprivate">
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
        let jadwal_semi = []
        let TabelJadwalSemi = $('#tabeldata').DataTable()
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get("/karyawan/admin/jadwal/semiprivate/getdata" ).done(ele=>{
                jadwal_semi = ele
                showData()  
            })
        }
        function showData(){
            TabelJadwalSemi.clear().draw()
            let i =0
            jadwal_semi.forEach(ele=>{
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.IDJadwalSemiPrivate+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDJadwalSemiPrivate+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                TabelJadwalSemi.row.add([
                   i,
                   ele.Hari,
                   ele.Start,
                   ele.End,
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
     
        function store(){
            $.ajax({
                type: "post",
                url: "/karyawan/admin/jadwal/semiprivate/store",
                data: $('#formdata-create').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function editData(id){
            let data = jadwal_semi.filter(ele=>ele.IDJadwalSemiPrivate==id)
            $('#edit-hari').val(data[0].KodeHari)
            $('#edit-start').val(data[0].Start)
            $('#edit-end').val(data[0].End)
            $('#edit-jadwalsemiprivate').val(data[0].IDJadwalSemiPrivate)
        }
        function update(){
            $.ajax({
                type: "post",
                url: "/karyawan/admin/jadwal/semiprivate/update",
                data: $('#formdata-edit').serialize(),
                success: function (response) {
                    getData()
                    $('#modalupdate').modal('hide')
                    swal(response)
                }
            });
        }
        function deleteData(id) {
            swal({
                title: "Apakah anda yakin menghapus jadwal ini?",
                text: "Jadwal ini akan hilang setelah di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get('/karyawan/admin/jadwal/semiprivate/delete/'+id).done((res)=>{
                        swal(res) 
                        getData()
                   
                    })
                } else {
                    swal("Dibatalkan!");
                }
            })
        }
    </script>
@endpush