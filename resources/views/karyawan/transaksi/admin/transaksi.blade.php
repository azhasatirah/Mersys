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
                    <div class="form-group">
                        <label for="">Program</label>
                        <select class="custom-select" name="programstudi" id="update-transaksi-program"></select>
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
                        <select class="custom-select" name="idcicilan" id="update-transaksi-idcicilan"></select>
                    </div>
                    <div class="form-group">
                        <label for="">Diskon</label>
                        <input type="text" class="form-control" id="update-transaksi-diskon" name="diskon" aria-describedby="helpId" >
                    </div>
                    <div class="form-group">
                        <label for="">PPN</label>
                        <select class="custom-select" id="update-transaksi-cicilan" onchange="isCicilan()" name="cicilan" >
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
        let Transaksi = []
        var TabelData = $('#tabeldata').DataTable({
                "scrollX": true
            });
        var ProgramStudi;
        var KategoriMateri;

        $(document).ready(function(){
       
            showData();
        });
        function showData(){
            $.get('/karyawan/admin/transaksi/getdata',function(Data){
                    Transaksi = Data
                    var a=0;
                    TabelData.clear().draw();
                    Data.forEach((data) =>{
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
                
            })
        }
        function setModalEdit(id){
            let Data = Transaksi.filter(ele=>ele.IDTransaksi == id)
            console.log(Data)
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
    </script>
@endpush