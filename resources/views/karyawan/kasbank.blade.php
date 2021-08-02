@extends('karyawan.layouts.layout')
@section('title','Kas Bank')
@section('content')
<!-- Modal -->
<div class="modal fade" id="modal-create-kasbank" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="type-perubahan"></span> Kas Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-create">
                    <input type="hidden" name="typekasbank" id="create-kasbank-type">
                    @csrf
                    <div class="form-group">
                      <label for="">Total</label>
                      <input type="text" onkeyup="formatUang('create-kasbank-total')" id="create-kasbank-total" class="form-control" name="total" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="">Keterangan</label>
                      <input type="text" class="form-control" name="keterangan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
       
                <button type="button" onclick="storeSpecialKasBank()" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit-kasbank" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit <span id="type-edit-perubahan"></span> Kas Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    <input type="hidden" name="typekasbank" id="edit-kasbank-type">
                    <input type="hidden" name="idkasbank" id="edit-kasbank-id">
                    @csrf
                    <div class="form-group">
                      <label for="">Total</label>
                      <input type="text" onkeyup="formatUang('edit-kasbank-total')" id="edit-kasbank-total" class="form-control" name="total" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="">Keterangan</label>
                      <input type="text" class="form-control" id="edit-kasbank-keterangan" name="keterangan">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
       
                <button type="button" onclick="updateSpecialKasBank()" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel text-black" style="font-size: 15px;font-color:black">
            <!-- Button trigger modal -->
            <button type="button" onclick="setSpecialKasBank(1)" class="btn btn-primary btn-sm btn-danger" data-toggle="modal" data-target="#modal-create-kasbank">
            Tarik Kas Bank
            </button>
            <button type="button" onclick="setSpecialKasBank(2)" class="btn btn-primary btn-sm btn-success" data-toggle="modal" data-target="#modal-create-kasbank">
            Masukan Kas Bank
            </button>
            

            <p id="data-aaa">


            </p>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kas Bank<small></small></h2>
              
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode kasbank</th>
                                <th>Tanggal</th>
                                <th>Kas Bank sebelum</th>
                                <th>Perubahan</th>
                                <th>Kas Bank Akhir</th>
                                <th>Keterangan</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
    <script>
        let TabelData = $('#tabeldata').DataTable()
        let KasBank = []
        let typePerubahan 
        $(document).ready(function () {
            getData()
        });
        function deleteKasBank(id){
            swal({
                title: "Apakah anda yakin menghapus kas bank ini?",
                text: "Data ini akan hilang setelah di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#modal-edit-kasbank').modal('hide')
                    $.get("/karyawan/owner/kasbank/delete/"+id).done(response=>swal(response))
                    getData()
                } else {
                    swal("Dibatalkan!");
                }
            })
        }
        function setSpecialKasBank(type){
            typePerubahan = type
            console.log(typePerubahan)
            if(typePerubahan==1){
                $('#create-kasbank-type').val(1)
                $('#type-perubahan').html('Tarik')
            }
            if(typePerubahan==2){
                $('#create-kasbank-type').val(2)
                $('#type-perubahan').html('Masukan')
            }
        }
        function storeSpecialKasBank(){
            $('#modal-create-kasbank').modal('hide')
            $.ajax({
                type: "post",
                url: "/karyawan/owner/kasbank/store",
                data: $('#form-create').serialize(),
                success: function (response) {
                    getData()
                    swal(response)
                }
            });
        }
        function updateSpecialKasBank(){
            $('#modal-edit-kasbank').modal('hide')
            $.ajax({
                type: "post",
                url: "/karyawan/owner/kasbank/update",
                data: $('#form-edit').serialize(),
                success: function (response) {
                    getData()
                    swal(response)
                }
            });
        }
        function getData(){
            $.get('/karyawan/owner/kasbank/getdata').done(ele=>{
                KasBank = ele
       
                addRowTableKasBank()
            })
        }
        function addRowTableKasBank(){
            TabelData.clear().draw()
            let i=1
            KasBank.forEach(ele=>{
                let Total = ele.Total >= 0?
                '<span class=\"text-success\">'+numberToIDR(ele.Total)+'</span>':
                '<span class=\"text-danger\">'+numberToIDR(ele.Total*-1)+'</span>'
                let PrefixKode = ele.KodeKasBank.split('-')[0]
                let btn = 
                "<button type=\"button\" onclick=\"deleteKasBank("+ele.IDKasBank+")\" class=\"btn btn-primary btn-sm btn-danger\" >"+
                "<i class=\"fa fa-trash\"></i>"+
                "</button>"+
                "<button type=\"button\" onclick=\"setDataEdit("+ele.IDKasBank+")\" data-toggle=\"modal\" data-target=\"#modal-edit-kasbank\" class=\"btn btn-primary btn-sm btn-primary\" >"+
                "<i class=\"fa fa-pencil\"></i>"+
                "</button>"
                TabelData.row.add([
                    i,
                    ele.KodeKasBank,
                    ele.Tanggal,
                    numberToIDR(ele.PrevTotal),
                    Total,
                    numberToIDR(ele.PrevTotal+ele.Total),
                    ele.Keterangan,
                    PrefixKode=='SBK'?btn:
                    "<button type=\"button\" onclick=\"deleteKasBank("+ele.IDKasBank+")\" class=\"btn btn-primary btn-sm btn-danger\" >"+
                    "<i class=\"fa fa-trash\"></i>"+
                    "</button>"+
                ]).draw()
                i++
            })
        }
        function setDataEdit(id){
            let kas = KasBank.filter(ele=>ele.IDKasBank==id)
            let edit_total = kas[0].Total>=0?kas[0].Total:kas[0].Total*-1
            $('#edit-kasbank-id').val(kas[0].IDKasBank)
            $('#edit-kasbank-type').val(kas[0].Total>=0?2:1)
            $('#edit-kasbank-total').val(numberToIDR(edit_total))
            $('#edit-kasbank-keterangan').val(kas[0].Keterangan)
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

            if(String(data).indexOf('Rp. ')>=0){
                let real_data = data.replace('Rp. ','').replaceAll('.','')
                return parseInt(real_data)
            }else{
         
                return data
            }
        }
    </script>
@endpush