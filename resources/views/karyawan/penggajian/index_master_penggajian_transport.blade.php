@extends('karyawan.layouts.layout')
@section('title','Master biaya transport')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master biaya transport<small></small></h2>
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
                                <th>Kota</th>
                                <th>Blok</th>
                                <th>Biaya transport</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah master biaya transport</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formdata-create">
                @csrf
                <div class="form-group">
                    <label for="">Kota</label>
                    <select id="create-kota" class="custom-select select-kota" name="kota" ></select>
                </div>
                <div class="form-group">
                    <label for="">Blok</label>
                    <select id="create-blok" class="custom-select select-blok" name="blok" ></select>
                </div>
                <div class="form-group">
                    <label for="">Biaya transport</label>
                    <input type="text" id="create-biaya" onkeyup="formatUang('create-biaya')" class="form-control" name="biaya">
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
                    <input type="hidden" name="penggajiantransport" id="edit-penggajiantransport">
                    <div class="form-group">
                        <label for="">Kota</label>
                        <select class="custom-select select-kota" id="edit-kota" name="kota" ></select>
                    </div>
                    <div class="form-group">
                        <label for="">Blok</label>
                        <select class="custom-select select-blok" id="edit-blok" name="blok" ></select>
                    </div>
                    <div class="form-group">
                        <label for="">Biaya transport</label>
                        <input type="text" onkeyup="formatUang('edit-biaya')" class="form-control" id="edit-biaya" name="biaya">
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
        let master_biaya_transport = [],Kota = [],Blok = []
        let TabelMasterPenggajian = $('#tabeldata').DataTable()
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get("/karyawan/owner/masterpenggajian/transport/getdata" ).done(ele=>{
                master_biaya_transport = ele[0]
                Kota = ele[1]
                Blok = ele[2]
                showData() 
                appendSelectBlokKota() 
                appendSelectBlokKotaEdit()
            })
        }
        function appendSelectBlokKota(){
            $('#create-kota').empty()
            $('#create-kota').append('<option value=\'0\'>pilih kota</option>')
            Kota.filter(ele=>ele.Status==='OPN').forEach(ele=>{
                $('#create-kota').append(
                    '<option value=\''+ele.IDKota+'\'>'+ele.NamaKota+'</option>'
                )
            })
            $('#create-blok').empty()
            $('#create-blok').append('<option value=\'0\'>pilih blok</option>')
            Blok.filter(ele=>ele.Status==='OPN').forEach(ele=>{
                $('#create-blok').append(
                    '<option value=\''+ele.IDBlok+'\'>'+ele.NamaBlok+'</option>'
                )
            })
        }
        $('#create-kota').on('change',()=>{
            let idkota = parseInt($('#create-kota').val())
            $('#create-blok').empty()
            $('#create-blok').append('<option value=\'0\'>pilih blok</option>')
            Blok.filter(ele=>ele.Status==='OPN'&&ele.IDKota === idkota).forEach(ele=>{
                $('#create-blok').append(
                    '<option value=\''+ele.IDBlok+'\'>'+ele.NamaBlok+'</option>'
                )
            })
        })
        $('#edit-kota').on('change',()=>{
            let idkota = parseInt($('#edit-kota').val())
            $('#edit-blok').empty()
            $('#edit-blok').append('<option value=\'0\'>pilih blok</option>')
            Blok.filter(ele=>ele.IDKota===idkota).forEach(ele=>{
                let status = ele.Status === 'DEL'?' (Dihapus)':''
                $('#edit-blok').append(
                    '<option value=\''+ele.IDBlok+'\'>'+ele.NamaBlok+status+'</option>'
                )
            })
        })
        function appendSelectBlokKotaEdit(){
            $('#edit-kota').empty()
            $('#edit-kota').append('<option value=\'0\'>pilih kota</option>')
            Kota.forEach(ele=>{
                let status = ele.Status === 'DEL'?' (Dihapus)':''
                $('#edit-kota').append(
                    '<option value=\''+ele.IDKota+'\'>'+ele.NamaKota+status+'</option>'
                )
            })
            $('#edit-blok').empty()
            $('#edit-blok').append('<option value=\'0\'>pilih blok</option>')
            Blok.forEach(ele=>{
                let status = ele.Status === 'DEL'?' (Dihapus)':''
                $('#edit-blok').append(
                    '<option value=\''+ele.IDBlok+'\'>'+ele.NamaBlok+status+'</option>'
                )
            })
        }
        function showData(){
            TabelMasterPenggajian.clear().draw()
            let i =0
            master_biaya_transport.forEach(ele=>{
                let nama_kota = Kota.filter(k=>k.IDKota===ele.IDKota)[0].NamaKota
                let nama_blok = Blok.filter(k=>k.IDBlok===ele.IDBlok)[0].NamaBlok
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.IDMasterPenggajianTransport+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDMasterPenggajianTransport+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                TabelMasterPenggajian.row.add([
                   i,
                   nama_kota,
                   nama_blok,
                   numberToIDR(ele.Biaya),
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
     
        function store(){
            $.ajax({
                type: "post",
                url: "/karyawan/owner/masterpenggajian/transport/store",
                data: $('#formdata-create').serialize(),
                success: function (response) {
                    $('#create-biaya').val('')
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function editData(id){
            let data = master_biaya_transport.filter(ele=>ele.IDMasterPenggajianTransport==id)
            $('#edit-kota').val(data[0].IDKota)
            $('#edit-blok').val(data[0].IDBlok)
            $('#edit-biaya').val(numberToIDR(data[0].Biaya))
            $('#edit-penggajiantransport').val(data[0].IDMasterPenggajianTransport)
        }
        function update(){
            $.ajax({
                type: "post",
                url: "/karyawan/owner/masterpenggajian/transport/update",
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
                title: "Apakah anda yakin menghapus master biaya tranport ini?",
                text: "Data ini akan hilang setelah di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get('/karyawan/owner/masterpenggajian/transport/delete/'+id).done((res)=>{
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