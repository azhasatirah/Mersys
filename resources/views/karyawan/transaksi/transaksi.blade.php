@extends('karyawan.layouts.layout')
@section('title','Transaksi')
@section('content')

<div class="row">
    <div class="mx-5 d-flex ">
        <div style="min-width:9rem" class="card mr-auto bg-dark text-white ">
            <div class="card-body">
    
                <span>Transaksi selesai</span>
                <h2>{{$TransaksiSelesai}}</h2>
            </div>
         
        </div>
        <div  style="min-width:9rem;margin-left:30px" class="card  bg-dark text-white ">
            <div class="card-body">
    
                <span>Kasbank</span>
                <h2>Rp. {{number_format($KasBank)}}</h2>
            </div>
      
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            
         
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Kode Kursus</th>
                            <th>Status</th>
                            <th>Nama Siswa</th>
                            <th>Program</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                            <th>Cikcilan</th>
                            <th>Tanggal</th>
                            {{-- <th>Aksi</th> --}}
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
        var TabelData = $('#tabeldata').DataTable();
        var ProgramStudi;
        var KategoriMateri;

        $(document).ready(function(){
            $('#tabeldata').DataTable();
            showData();
        });
        function showData(){
            $.get('/karyawan/transaksi/getdata',function(Data){
                    console.log(Data);
                    $('#datatabel').empty();
                    var a=0;
                    TabelData.clear().draw();
                    Data.forEach((data) =>{
                        a++;
                        var TombolDetail = 
                        "<a class=\"btn btn-success btn-sm text-white\"href=\"/karyawan/admin/transaksi/detail/"+data.UUIDTransaksi+"\">"+
                        "Detail</a>";
                        TabelData.row.add([
                            a,
                            data.KodeTransaksi,
                            data.KodeKursus,
                            'Selesai',
                            data.NamaSiswa,
                            data.NamaProdi,
                            'Rp '+formatNumber(data.SubTotal),
                            'Rp '+formatNumber(data.Total),
                            data.Cicilan=='y'?'Ya':'Tidak',
                            data.created_at,
                            ''
                        ]).draw();
                    })
                
            })
        }
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }   
    </script>
@endpush