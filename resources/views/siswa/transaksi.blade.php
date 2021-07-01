@extends('siswa.layouts.layout')
@section('title','Riwayat Transaksi')
@section('content')
<div class="table-responsive">

    <table id="tabeldata" class="table table-dark table-hover bg-dark projects">
        <thead>
            <tr>
                <th scope="col">Kode Transaksi</th>
                <th scope="col">Program</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal Pembelian</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody >
            @foreach ($Transaksi as $item)
    
            <tr class="bg-dark">
                <th>{{$item['KodeTransaksi']}}</th>
                <td>{{$item['NamaProdi']}}</td>
                <td>
                    {{$item['Status']}}
                </td>
                <td>{{explode(' ',$item['created_at'])[0]}}</td>
                <td>
                    <a href="{{url('siswa/pembayaran/info')}}/{{$item['UUIDTransaksi']}}" class="btn btn-sm btn-primary btn-block mb-2">Detail</a>
                </td>
    
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tabeldata').DataTable();
        });
    </script>
@endpush
@endsection
