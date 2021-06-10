@extends('karyawan.layouts.layout')
@section('title','Program Saya')
@section('content')
<table id="tabeldata" class="table  table-dark projects">
    <thead>
        <tr>
            <th style="width: 1%">No</th>
            <th style="width: 10%">Kode Siswa</th>
            <th style="width: 15%">Nama Siswa</th>
            <th style="width: 5%">Opsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Siswa as $item)

        <tr class="bg-dark">
            <td >{{$loop->iteration}}</td>
            <td>{{$item[0]->KodeSiswa}}</td>
            <td>
                {{$item[0]->NamaSiswa}}

            </td>
            <td>
                <a href="{{url('karyawan/tutor/kelas')}}/{{$item[0]->UUIDSiswa}}" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    Lihat
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    @push('scripts')
    <script>
        $(document).ready(function () {

            $('#tabeldata').DataTable();
        });
    </script>
    @endpush
@endsection
