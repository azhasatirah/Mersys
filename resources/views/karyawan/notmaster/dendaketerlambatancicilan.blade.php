@extends('karyawan.layouts.layout')
@section('title','Master denda keterlambatan cicilan')
@section('content')
<input type="hidden" value="{{session()->get('Level')}}" id="level-user">
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master biaya denda keterlambatan bayar cicilan<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="button" onclick="clearFormCreate()" class="btn btn-primary btn-sm" 
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
                                <th>Range hari dari</th>
                                <th>Range hari sampai</th>
                                <th>Denda persen</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah master</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formdata-create">
                @csrf
                <div class="form-group">
                    <label for="">Range hari dari</label>
                    <input type="number" class="form-control" id="mcreate-range-from" name="range_from">
                </div>
                <div class="form-group">
                    <label for="">Range hari sampai</label>
                    <input type="number" class="form-control" id="mcreate-range-to" name="range_to">
                </div>
                <div class="form-group">
                    <label for="">Denda persen</label>
                    <input type="number" class="form-control" id="mcreate-denda" name="denda">
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
                    <input type="hidden" name="idmaster" id="medit-idmaster">
                    <div class="form-group">
                        <label for="">Range hari dari</label>
                        <input type="number" class="form-control" id="medit-range-from" name="range_from">
                    </div>
                    <div class="form-group">
                        <label for="">Range hari sampai</label>
                        <input type="number" class="form-control" id="medit-range-to" name="range_to">
                    </div>
                    <div class="form-group">
                        <label for="">Denda persen</label>
                        <input type="number" class="form-control" id="medit-denda" name="denda">
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
        let master_data = []
        let table_data = $('#tabeldata').DataTable()
        let UrlLevel = $('level-user').val()==1?'/karyawan/owner/':'/karyawan/admin/'
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get(UrlLevel+"master/dendatelatcicilan/getdata" ).done(ele=>{
                master_data = ele
                showData()  
            })
        }
        function showData(){
            table_data.clear().draw()
            let i =0
            master_data.forEach(ele=>{
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.id+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.id+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                table_data.row.add([
                   i,
                   ele.range_from,
                   ele.range_to,
                   ele.denda+'%',
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
     
        function store(){
            $.ajax({
                type: "post",
                url: UrlLevel+"master/dendatelatcicilan/store",
                data: $('#formdata-create').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function editData(id){
            let data = master_data.filter(ele=>ele.id==id)
            $('#medit-range-from').val(data[0].range_from)
            $('#medit-range-to').val(data[0].range_to)
            $('#medit-denda').val(data[0].denda)
            $('#medit-idmaster').val(data[0].id)
        }
        function update(){
            $.ajax({
                type: "post",
                url: UrlLevel+"master/dendatelatcicilan/update",
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
                title: "Apakah anda yakin menghapus master ini?",
                text: "Data ini akan hilang setelah di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get(UrlLevel+'master/dendatelatcicilan/delete/'+id).done((res)=>{
                        swal(res) 
                        getData()
                   
                    })
                } else {
                    swal("Dibatalkan!");
                }
            })
        }
        function clearFormCreate(){
            $('#mcreate-denda').val('')
            $('#mcreate-range-from').val('')
            $('#mcreate-range-to').val('')
        }
    </script>
@endpush