@extends('karyawan.layouts.layout')
@section('title','Program Studi')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Program Studi <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a class="btn btn-primary btn-sm"href="{{url('/karyawan/master/program/create')}}">Tambah Program</a>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Program</th>
                            <th>Nama Program</th>
                            <th>Total Pertemuan</th>
                            <th>Harga</th>
                            <th>Nama Level</th>
                            <th>Kategori</th>
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
    <script src="{{asset('assets/js/master/programstudi.js')}}"></script>
@endpush