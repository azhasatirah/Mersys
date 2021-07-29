@extends('karyawan.layouts.layout')
@section('title','Master pendapatan per pertemuan')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master penggajian <small></small></h2>
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
                                <th>Kategori global</th>
                                <th>Kategori</th>
                                <th>Level</th>
                                <th>Jenis</th>
                                <th>Pendapatan per pertemuan</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah master penggajian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formdata-create">
                @csrf
                <div class="form-group">
                    <label for="">Kategori global</label>
                    <select class="custom-select select-kategori-global-program" name="idkategoriglobalprogram">
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Kategori</label>
                    <select class="custom-select select-kategori-program" name="idkategoriprogram">
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Level</label>
                    <select class="custom-select select-level-program" name="idlevel">
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Jenis</label>
                    <select class="custom-select" name="jenisprogram">
                        <option value="private">Private</option>
                        <option value="semi">Semi Private</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Pendapatan per pertmuan</label>
                    <input type="text" onkeyup="formatUang('create-pendapatan')" id="create-pendapatan" class="form-control" name="pendapatan">
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
                    <div class="form-group">
                        <label for="">Kategori global</label>
                        <select class="custom-select select-kategori-global-program" name="idkategoriglobalprogram">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select id="edit-kategori" class="custom-select select-kategori-program" name="idkategoriprogram">
                        </select>
                    </div>
                    <input type="hidden" name="idmasterpenggajian" id="edit-masterpenggajian">
                    <div class="form-group">
                        <label for="">Level</label>
                        <select id="edit-level" class="custom-select select-level-program" name="idlevel">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Jenis</label>
                        <select id="edit-jenis" class="custom-select" name="jenisprogram">
                            <option value="private">Private</option>
                            <option value="semi">Semi Private</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pendapatan per pertmuan</label>
                        <input id="edit-pendapatan" type="text" onkeyup="formatUang('edit-pendapatan')" class="form-control" name="pendapatan">
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
        let master_penggajian = [],level = [],kategori_program = [],kategori_global_program =[]
        let TabelMasterPenggajian = $('#tabeldata').DataTable()
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get("/karyawan/owner/masterpenggajian/getdata" ).done(ele=>{
                master_penggajian = ele[0]
                level = ele [1]
                kategori_program = ele[2]
                kategori_global_program = ele[3]
                appendKategoriGlobalOption()
                appendLevelOption()
                appendKategoriOption()
                showData()  
            })
        }
        function appendKategoriGlobalOption(){
            $('.select-kategori-global-program').empty()
            kategori_global_program.forEach(ele=>{
                $('.select-kategori-global-program').append("<option value=\""+ele.IDKategoriGlobalProgram+"\">"+ele.KategoriGlobalProgram+"</option>")
            })
        }
        function appendKategoriOption(){
            $('.select-kategori-program').empty()
            kategori_program.forEach(ele=>{
                $('.select-kategori-program').append("<option value=\""+ele.IDKategoriProgram+"\">"+ele.KategoriProgram+"</option>")
            })
        }
        function appendLevelOption(){
            $('.select-level-program').empty()
            level.forEach(ele=>{
                $('.select-level-program').append("<option value=\""+ele.IDLevel+"\">"+ele.NamaLevel+"</option>")
            })
        }
        function showData(){
            TabelMasterPenggajian.clear().draw()
            let i =0
            master_penggajian.forEach(ele=>{
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.IDMasterPenggajian+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDMasterPenggajian+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                TabelMasterPenggajian.row.add([
                   i,
                   ele.KategoriGlobalProgram,
                   ele.KategoriProgram,
                   ele.Level,
                   ele.JenisProgram == 'semi'?'Semi Private':'Private',
                   'Rp '+ele.Pendapatan.toLocaleString('id-ID'),
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
     
        function store(){
            $.ajax({
                type: "post",
                url: "/karyawan/owner/masterpenggajian/store",
                data: $('#formdata-create').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function editData(id){
            let data = master_penggajian.filter(ele=>ele.IDMasterPenggajian==id)
            $('#edit-level').val(data[0].IDLevel)
            $('#edit-kategori').val(data[0].IDKategoriProgram)
            $('#edit-jenis').val(data[0].JenisProgram)
            $('#edit-pendapatan').val(numberToIDR(data[0].Pendapatan))
            $('#edit-masterpenggajian').val(data[0].IDMasterPenggajian)
        }
        function update(){
            $.ajax({
                type: "post",
                url: "/karyawan/owner/masterpenggajian/update",
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
                title: "Apakah anda yakin menghapus master penggajian ini?",
                text: "Data ini akan hilang setelah di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get('/karyawan/owner/masterpenggajian/delete/'+id).done((res)=>{
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
               // console.log(true)
                uang = '0'
            }
            let formated_uang = 'Rp. '+parseInt(uang).toLocaleString('id-ID')
            return formated_uang
        }
        function IDRToNumber(data){
            let real_data = data.replace('Rp. ','').replaceAll('.','')
            return parseInt(real_data)
        }
    </script>
@endpush