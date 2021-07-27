@extends('karyawan.layouts.layout')
@section('title','Master denda keterlambatan')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master denda keterlambatan<small></small></h2>
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
                                <th>Menit min</th>
                                <th>Menit max</th>
                                <th>Denda</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah master denda keterlambatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formdata-create">
                @csrf
                <div class="form-group">
                    <label for="">Menit min</label>
                    <input type="number" class="form-control" name="minutemin">
                </div>
                <div class="form-group">
                    <label for="">Menit max</label>
                    <input type="number" class="form-control" name="minutemax">
                </div>
                <div class="form-group">
                    <label for="">Denda</label>
                    <input type="text" id="create-denda" onkeyup="formatUang('create-denda')" class="form-control" name="denda">
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
                    <input type="hidden" name="iddendaterlambat" id="edit-iddendaterlambat">
                    <div class="form-group">
                        <label for="">Menit min</label>
                        <input type="number" class="form-control" id="edit-minutemin" name="minutemin">
                    </div>
                    <div class="form-group">
                        <label for="">Menit max</label>
                        <input type="number" class="form-control" id="edit-minutemax" name="minutemax">
                    </div>
                    <div class="form-group">
                        <label for="">Denda</label>
                        <input type="text" class="form-control" onkeyup="formatUang('edit-denda')" id="edit-denda" name="denda">
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
        let master_denda_terlambat = []
        let TabelDendaTerlambat = $('#tabeldata').DataTable()
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get("/karyawan/owner/masterpenggajian/denda/getdata" ).done(ele=>{
                master_denda_terlambat = ele
                showData()  
            })
        }
        function showData(){
            TabelDendaTerlambat.clear().draw()
            let i =0
            master_denda_terlambat.forEach(ele=>{
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.IDDendaTerlambat+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDDendaTerlambat+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                TabelDendaTerlambat.row.add([
                   i,
                   ele.MinuteMin,
                   ele.MinuteMax,
                   numberToIDR(ele.Denda),                    
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
     
        function store(){
            $.ajax({
                type: "post",
                url: "/karyawan/owner/masterpenggajian/denda/store",
                data: $('#formdata-create').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function editData(id){
            let data = master_denda_terlambat.filter(ele=>ele.IDDendaTerlambat==id)
            $('#edit-minutemin').val(data[0].MinuteMin)
            $('#edit-minutemax').val(data[0].MinuteMax)
            $('#edit-denda').val(numberToIDR(data[0].Denda))
            $('#edit-iddendaterlambat').val(data[0].IDDendaTerlambat)
        }
        function update(){
            $.ajax({
                type: "post",
                url: "/karyawan/owner/masterpenggajian/denda/update",
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
                title: "Apakah anda yakin menghapus denda keterlambatan ini?",
                text: "Data ini akan hilang setelah di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get('/karyawan/owner/masterpenggajian/denda/delete/'+id).done((res)=>{
                        swal(res) 
                        getData()
                   
                    })
                } else {
                    swal("Dibatalkan!");
                }
            })
        }
        function formatUang(id){
            
            let uang = $('#'+id).val()
            let formated_uang = numberToIDR(uang)
            $('#'+id).val(formated_uang)

        }
        function numberToIDR(data){
            let uang = String(data)
            uang = uang.replace('Rp. ','').replaceAll('.','')
            let isnan = isNaN(uang)
            if(isnan||uang ==''){
                console.log(true)
                uang = '0'
            }
            let formated_uang = 'Rp. '+parseInt(uang).toLocaleString('id-ID')
            return formated_uang
        }
        // function rupiahToInteger(data){
        //     let real_data = data.replace('Rp. ','').replaceAll('.','')
        //     return parseInt(real_data)
        // }
    </script>
@endpush