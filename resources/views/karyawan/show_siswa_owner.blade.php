@extends('karyawan.layouts.layout')
@section('title','Daftar siswa')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar Siswa <small></small></h2>

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
                        @foreach ($Siswa as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item['KodeSiswa']}}</td>
                            <td>{{$item['NamaSiswa']}}</td>
                            <td>{{$item['Alamat']}}</td>
                            <td>{{$item['Email']}}</td>
                            <td>{{$item['Status']=='CLS'?'Aktif':'Tidak Aktif'}}</td>
                            <td>{{$item['created_at']}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId{{$item['KodeSiswa']}}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="modelId{{$item['KodeSiswa']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <img src="{{$item['PhotoProfile']}}" 
                                                style="width:180px;height:200px;
                                                border-radius:5px;
                                                object-fit:cover" 
                                                alt="">
                                            </div>
                                            <div class="col-md-7">
                                                <p>
                                                    Nama : {{$item['NamaSiswa']}} <br>
                                                    Email : {{$item['Email']}} <br>
                                                    Jenis Kelamin : {{$item['JenisKelamin']}} <br>
                                                    Alamat : {{$item['Alamat']}} <br>   
                                                    @if ($item['Psikologi']!=false)
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPsiko{{$item['KodeSiswa']}}">
                                                        Hasil Test Psikologi
                                                    </button>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Modal -->
                        @if ($item['Psikologi']!=false)      
                        <div class="modal fade" id="modalPsiko{{$item['KodeSiswa']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <img style="max-width:750px;heigh:auto" src="{{asset('images/hasil-psikologi')}}/{{$item['Psikologi']}}"
                                             alt="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        {{-- <script>
                            $('#exampleModal').on('show.bs.modal', event => {
                                var button = $(event.relatedTarget);
                                var modal = $(this);
                                // Use above variables to manipulate the DOM
                                
                            });
                        </script> --}}
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