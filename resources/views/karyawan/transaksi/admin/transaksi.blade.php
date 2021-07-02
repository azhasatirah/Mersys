@extends('karyawan.layouts.layout')
@section('title','Transaksi')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Transaksi <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" style="width: 100%" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Status</th>
                            <th>Nama Siswa</th>
                            <th>Program</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                            <th>Cicilan</th>
                            <th>Tanggal</th>
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


<!-- Modal -->
<div class="modal fade" id="modal-edit-transaksi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaksi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-transaksi">
                    @csrf
                    <div class="form-group">
                      <label for="">Kode Transaksi</label>
                      <input type="text" readonly class="form-control" name="kodetransaksi" id="update-transaksi-kodetransaksi">
                    </div>
                    <div class="form-group">
                        <label for="">Program</label>
                        <select class="custom-select" onchange="changeProgram()" name="programstudi" id="update-transaksi-program"></select>
                    </div>
                    <div class="form-group">
                        <label for="">Cicilan</label>
                        <select class="custom-select" id="update-transaksi-cicilan" onchange="isCicilan()" name="cicilan" >
                            <option value="n">Tidak</option>
                            <option value="y">Ya</option>
                        </select>
                    </div>
                    <div style="display: none" id="choose-cicilan" class="form-group">
                        <label for="">Dicicil berapa kali</label>
                        <select class="custom-select" onclick="chooseCicilan()" name="idcicilan" id="update-transaksi-idcicilan"></select>
                    </div>
                    <div class="form-group">
                        <label for="">Diskon</label>
                        <input type="text" onchange="countHargaTotal()" class="form-control" id="update-transaksi-diskon" name="diskon" aria-describedby="helpId" >
                    </div>
                    <div class="form-group">
                        <label for="">PPN</label>
                        <select class="custom-select" onchange="countHargaTotal()" id="update-transaksi-ppn"  name="ppn" >
                            <option value="n">Tidak</option>
                            <option value="y">Ya</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="">Subtotal</label>
                      <input type="text" class="form-control" name="subtotal" id="update-transaksi-subtotal" readonly >
                    </div>
                    <div class="form-group">
                      <label for="">Total</label>
                      <input type="text" class="form-control" name="total" id="update-transaksi-total" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="updateTransaksi()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        let Transaksi = [],ProgramStudi = [],Cicilan=[]
        var TabelData = $('#tabeldata').DataTable({
                "scrollX": true
            });

        var KategoriMateri;

        $(document).ready(function(){
       
            showData();
        });
        function showData(){
            $.get('/karyawan/admin/transaksi/getdata',function(Data){
                    Transaksi = Data[0]
                    ProgramStudi = Data[1]
                    Cicilan = Data[2]
                    var a=0;
                    TabelData.clear().draw();
                    Transaksi.forEach((data) =>{
                        a++;
                        var TombolAksi =
                            "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteData('"+data.IDTransaksi+"')\">"+
                                "<i class=\"fa fa-trash\"></i></a>";
                        var TombolVerif = 
                        "<a class=\"btn btn-success btn-sm text-white\"href=\"/karyawan/admin/transaksi/detail/"+data.UUIDTransaksi+"\">"+
                        "<i class=\"fa fa-check\"></i></a>";
                        var TombolDelete = 
                        "<a class=\"btn btn-danger btn-sm text-white\" onclick=\"deleteTransaksi("+data.IDTransaksi+")\">"+
                        "<i class=\"fa fa-trash\"></i></a>";
                        let TombolEdit =  "<a data-toggle=\"modal\" data-target=\"#modal-edit-transaksi\" class=\"btn btn-primary btn-sm text-white\" onclick=\"setModalEdit("+data.IDTransaksi+")\">"+
                        "<i class=\"fa fa-pencil\"></i></a>";
                        TabelData.row.add([
                            a,
                            data.KodeTransaksi,
                            data.Status,
                            data.NamaSiswa,
                            data.NamaProdi,
                            'Rp '+formatNumber(data.SubTotal),
                            'Rp '+formatNumber(data.Total),
                            data.Cicilan=='y'?'Ya':'Tidak',
                            data.created_at,
                            data.KodeStatus=='waitForAdmin'?TombolVerif:
                            data.KodeStatus == 'waitForPayment'?TombolDelete+TombolEdit:
                            data.Status
                        ]).draw();
                    })
                    showProgramStudi()
                
            })
        }
        function showProgramStudi(){
            $('#update-transaksi-program').empty()
            ProgramStudi.forEach(ele=>{
                $('#update-transaksi-program').append(
                    "<option value=\""+ele.IDProgram+"\">"+ele.NamaProdi+"</option>"
                )
            })
        }
        function setModalEdit(id){
            $('#choose-cicilan').hide();
            let Data = Transaksi.filter(ele=>ele.IDTransaksi == id)
            $('#update-transaksi-kodetransaksi').val(Data[0].KodeTransaksi)
            $('#update-transaksi-program').val(Data[0].IDProgram)
            $('#update-transaksi-cicilan').val(Data[0].Hutang)
            $('#update-transaksi-diskon').val(Data[0].Diskon)
            $('#update-transaksi-PPN').val(Data[0].ppn)
            $('#update-transaksi-subtotal').val(Data[0].SubTotal)
            $('#update-transaksi-total').val(Data[0].Total)
            changeCicilan(Data[0].IDProgram)
        }
        function changeProgram(){
            let Data = $('#update-transaksi-program').val()
            changeCicilan(Data)
        }
        function isCicilan(){
            let data = $('#update-transaksi-cicilan').val()
            if(data == 'y'){
                $('#choose-cicilan').show()
                chooseCicilan()
            }else{
                $('#choose-cicilan').hide()
                let idprogram = $('#update-transaksi-program').val();
                $('#update-transaksi-subtotal').val(ProgramStudi.filter(ele=>ele.IDProgram == idprogram)[0].Harga)
                countHargaTotal()

            }
        }
        function chooseCicilan(){
            let idcicilan = $('#update-transaksi-idcicilan').val()
            let Data = Cicilan.filter(ele=>ele.IDCicilan == idcicilan)
            $('#update-transaksi-subtotal').val(Data[0].Harga)
            countHargaTotal()
        }
        function countHargaTotal(){
            let subtotal = $('#update-transaksi-subtotal').val()
            let diskon = $('#update-transaksi-diskon').val()
            let ppn = $('#update-transaksi-ppn').val()
            let total = ppn =='y'?parseInt(parseInt(subtotal) + parseInt(subtotal*10/100)) - diskon:subtotal-diskon
            $('#update-transaksi-total').val(total)
        }
        function changeCicilan(id){
            $('#update-transaksi-cicilan').val('n')
            isCicilan()
            $('#update-transaksi-idcicilan').empty()
            let Data = Cicilan.filter(ele=> ele.IDProgram == id)
            $('#update-transaksi-cicilan').attr('disabled',false);
            if(Data.length == 0){
                $('#update-transaksi-cicilan').attr('disabled',true);
            }
            Data.forEach(ele=>{
                $('#update-transaksi-idcicilan').append(
                    "<option value=\""+ele.IDCicilan+"\">dicicil "+ele.Cicilan+" kali</option>"
                );
            })
        }
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }  
        function deleteTransaksi(id) {
            swal({
              title: "Apakah anda yakin menghapus transaksi ini?",
              text: "Transaksi ini belum ada bukti pembayaran, bisa saja siswa sudah mengirim pembayaran tapi belum mengupload bukti!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                $.get('/karyawan/admin/transaksi/delete/'+id).done((res)=>{
                    swal(res) 
                    showData()
                })
              } else {
                  swal("Dibatalkan!");
              }
          })
        }
        function updateTransaksi(){
            $.ajax({
                type: "post",
                url: "/karyawan/admin/transaksi/update",
                data: $('#form-edit-transaksi').serialize(),
                success: function (response) {
                    showData()
                    $('#modal-edit-transaksi').modal('hide')
                    swal(response)
                }
            });
        }
    </script>
@endpush