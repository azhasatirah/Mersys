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
@endsection
@push('scripts')
    <script>
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
                    console.log(Data);
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
                            data.KodeStatus == 'waitForPayment'?TombolDelete:
                            data.Status
                        ]).draw();
                    })
                
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
    </script>
@endpush