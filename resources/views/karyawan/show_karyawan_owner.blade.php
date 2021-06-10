@extends('karyawan.layouts.layout')
@section('title','Daftar Karyawan')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar Karyawan <small></small></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Karyawan as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->KodeKaryawan}}</td>
                            <td>{{$item->NamaKaryawan}}</td>
                            <td>{{$item->Alamat}}</td>
                            <td>{{$item->Email}}</td>
                            <td>{{$item->Status=='CLS'?'Aktif':'Tidak Aktif'}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId{{$item->KodeKaryawan}}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="modelId{{$item->KodeKaryawan}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{$item->NamaKaryawan}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img src="{{$item->PhotoProfile}}" 
                                                style="width:180px;height:200px;
                                                border-radius:5px;
                                                object-fit:cover" 
                                                alt="">
                                            </div>
                                            <div class="col-md-7">
                                                <p>
                                                    Nama : {{$item->NamaKaryawan}} <br>
                                                    Email : {{$item->Email}} <br>
                                                    Jenis Kelamin : {{$item->JenisKelamin}} <br>
                                                    Alamat : {{$item->Alamat}} <br>   
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    
<script>
    $(document).ready(function () {
        $('#tabeldata').DataTable();
    });
</script>
@endpush