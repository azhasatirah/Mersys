@extends('karyawan.layouts.layout')
@section('title','Jadwal')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jadwal<small></small></h2>
                {{-- <ul class="nav navbar-right panel_toolbox">
                    <a class="btn btn-primary btn-sm"href="{{url('/karyawan/master/levelprogram/create')}}">Tambah Level</a>
                </ul> --}}
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover" id='tabeldata'>
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>ID Siswa</th> --}}
                            <th>Nama Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($Jadwal as $Data)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$Data->NamaSiswa}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm"href="{{url('/karyawan/master/levelprogram/edit')}}/{{$Data->KodeLevel}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-danger btn-sm text-white"onclick="deleteLevel('{{$Data->KodeLevel}}')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach --}}
                </table>
    
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/master/jadwal.js')}}"></script>
@endpush