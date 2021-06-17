@extends('karyawan.layouts.layout')
@section('title','Daftar kursus')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kursus<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Per</th>
                            <th>Tanggal</th>
                            <th>Materi</th>
                            <th>Kehadiran Tutor</th>
                            <th>Kehadiran Siswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Absen as $item)
                            <tr>
                                <td>{{$item['Pertemuan']}}</td>
                                <td>{{$item['Tanggal']}}</td>
                                <td>{{$item['Materi']}}</td>
                                <td>{{$item['KehadiranSiswa']}}</td>
                                <td>{{$item['KehadiranTutor']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>
@endsection