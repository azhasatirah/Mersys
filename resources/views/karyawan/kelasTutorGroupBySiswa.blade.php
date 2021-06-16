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
            <td>{{$item['KodeSiswa']}}</td>
            <td>
                {{$item['NamaSiswa']}}

            </td>
            <td>
                <a href="{{url('karyawan/tutor/kelas')}}/{{$item['UUIDSiswa']}}" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    Lihat
                </a>
                @if (count($item['TestPsiko'])!=0)
                <a data-toggle="modal" data-target="#htp{{$item['UUIDSiswa']}}" href="javascript:void(0)" class="btn btn-primary btn-sm">
                    Hasil test psikologi
                    </a> 
                <div class="modal fade" id="htp{{$item['UUIDSiswa']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <img style="max-width:750px;heigh:auto" src="{{asset('images/hasil-psikologi')}}/{{$item['TestPsiko'][0]->HasilTestPsikologi}}"
                                     alt="">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                    </div>
                        </div>
                    </div>
                </div>
                @endif
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
