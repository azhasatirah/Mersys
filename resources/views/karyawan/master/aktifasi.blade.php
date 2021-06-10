@extends('karyawan.layouts.layout')
@section('title','Aktifasi Akun Karyawan')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
               
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
         
                </table>
    
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/master/aktifasi.js')}}"></script>
@endpush