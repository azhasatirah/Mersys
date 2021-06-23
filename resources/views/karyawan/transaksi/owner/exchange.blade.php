@extends('karyawan.layouts.layout')
@section('title','Buat transaksi refund')
@section('content')
<input type="hidden" id="csrf-token" name="_token" value="{{ csrf_token() }}" />
<div class="row bg-white" >

    <div id="transaksi-exchange" class="col-md-12">
        <table id="table-exchange" class="table">
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
@endsection
@push('scripts')
<script>
    let TableExchange = $('#table-exchange').DataTable()
    let TransaksiExchange = []
    getData()
    function getData(){
        $.get('/karyawan/owner/transaksi/exchange/getdata').done((ele)=>{
            console.log(ele)
            TransaksiExchange = ele['TransaksiExchange']
            showTableExchange()
        });
    }

    function showTableExchange(){
        TableExchange.clear().draw()
        let a = 0
        TransaksiExchange.forEach((data)=>{
            let button = data.Status == 'CFM'?
            "<a class=\"btn btn-sm btn-primary text-white\" onclick=\"confirmExchange("+data.IDTransaksi+")\">Konfirmasi</a>":
            ""
            a++
            TableExchange.row.add([
                    a,
                    data.KodeTransaksi,
                    data.Status=='CFM'?'Sedang di cek owner':data.Status=='CLS'?'Selesai':'Dihapus',
                    data.NamaSiswa,
                    data.NamaProdi,
                    data.SubTotal,
                    data.Total,
                    data.Hutang=='n'?'Tidak':'Iya',
                    data.Tanggal,
                    button
            ]).draw();
        })
    }
    //kunai
    function confirmExchange(id){
        swal({
              title: "Anda yakin?",
              text: "Konfirmasi transaksi ini!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                updateExchange(id)
              } else {
                  swal("Dibatalkan!");
              }
          });
    }
    function updateExchange(id){
        $.get('/karyawan/owner/transaksi/exchange/confirm/'+id).done((res)=>{
            swal(res)
            getData()
        })
    }
</script>
@endpush