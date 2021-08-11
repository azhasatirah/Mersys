@extends('karyawan.layouts.layout')
@section('title','Master blok kota')
@section('content')
<input type="hidden" value="{{session()->get('Level')}}" id="level-user">
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master blok kota<small></small></h2>
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
                                <th>Kota</th>
                                <th>Blok</th>
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
                    <label for="">Kota</label>
                    <select class="custom-select select-kota" name="kota" id="mcreate-kota"></select>
                </div>
                <div class="form-group">
                    <label for="">Nama blok kota</label>
                    <input type="text" class="form-control" id="mcreate-blok" name="blok">
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
                    <input type="hidden" name="idblok" id="medit-idmaster">
                    <div class="form-group">
                        <label for="">Kota</label>
                        <select class="custom-select select-kota" name="kota" id="medit-kota"></select>
                    </div>
                    <div class="form-group">
                        <label for="">Nama blok kota</label>
                        <input type="text" class="form-control" id="medit-blok" name="blok">
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
        let kota = []
        let table_data = $('#tabeldata').DataTable()
        let UrlLevel = $('level-user').val()==1?'/karyawan/owner/':'/karyawan/admin/'
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get(UrlLevel+"master/blok/getdata" ).done(ele=>{
                master_data = ele[0]
                kota = ele[1]
                showData() 
                appendSelectKota() 
            })
        }
        function appendSelectKota(){
            $('.select-kota').empty()
            kota.forEach(ele=>{
                console.log(true)
                $('.select-kota').append(
                    '<option value=\''+ele.IDKota+'\'>'+ele.NamaKota+'</option>'
                )
            })
        }
        function showData(){
            table_data.clear().draw()
            let i =0
            master_data.forEach(ele=>{
                let NamaKota = kota.filter(k=>k.IDKota==ele.IDKota)[0].NamaKota
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.IDBlok+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDBlok+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                table_data.row.add([
                   i,
                   NamaKota,
                   ele.NamaBlok,
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
     
        function store(){
            $.ajax({
                type: "post",
                url: UrlLevel+"master/blok/store",
                data: $('#formdata-create').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function editData(id){
            let data = master_data.filter(ele=>ele.IDKota==id)
            $('#medit-kota').val(data[0].IDKota)
            $('#medit-blok').val(data[0].NamaBlok)
            $('#medit-idmaster').val(data[0].IDBlok)
        }
        function update(){
            $.ajax({
                type: "post",
                url: UrlLevel+"master/blok/update",
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
                    $.get(UrlLevel+'master/blok/delete/'+id).done((res)=>{
                        swal(res) 
                        getData()
                   
                    })
                } else {
                    swal("Dibatalkan!");
                }
            })
        }
        function clearFormCreate(){
            $('#mcreate-blok').val('')
        }
    </script>
@endpush