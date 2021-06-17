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
                            <th>Kode Kursus</th>
                            <th>Nama Prodi</th>
                            <th>Kode Siswa</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Kursus as $item)
                            <tr>
                                <td>{{$item['KodeKursus']}}</td>
                                <td>{{$item['NamaProdi']}}</td>
                                <td>{{$item['KodeSiswa']}}</td>
                                <td>{{$item['NamaSiswa']}}</td>
                                <td>{{$item['TanggalOrder']}}</td>
                                <td>{{$item['ReadStatus']}}</td>
                                <td>
                                    @if ($item['Status'])
                                    <a class="btn btn-sm btn-primary" 
                                    href="{{url('karyawan/admin/kursus/show')}}/{{$item['UIDKursus']}}" role="button">Absensi</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>
@endsection