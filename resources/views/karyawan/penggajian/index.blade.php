@extends('karyawan.layouts.layout')
@section('title','Daftar karyawan')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar karyawan<small></small></h2>
              
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode karyawan</th>
                                <th>Nama Karyawan</th>
                                <th>Posisi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Karyawan as $item)
                                
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->KodeKaryawan}}</td>
                                <td>{{$item->NamaKaryawan}}</td>
                                <td>{{$item->RoleKaryawan}}</td>
                                <td><a class="btn btn-sm btn-primary" href="{{url('karyawan/owner/penggajian/karyawan')}}/{{$item->UIDKaryawan}}" role="button">Lihat</a></td>
                            </tr>
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        let tabel =    $('#tabeldata').DataTable()
        $(document).ready(function () {
            
    
        });
    </script>
@endpush