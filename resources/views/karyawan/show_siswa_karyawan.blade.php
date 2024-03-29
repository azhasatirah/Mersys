@extends('karyawan.layouts.layout')
@section('title','Daftar siswa')
@section('content')
<input type="hidden" id="level-karyawan" value="{{session()->get('Level')}}">
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                @isset($msg)
                    
                <div id="msg-hapus" class="row bg-success text-white">
                    <div class="col-md-11">

                        <h3>Berhasil dihapus!!</h3>
                    </div>
                    <div class="col-md-1 mt-2">
                        <button onclick="heh()" class="btn btn-sm btn-danger text-white">tutup</button>

                    </div>
                </div>
                @endisset
                <h2>Daftar Siswa <small></small></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

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
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalresetpassword{{$item['KodeSiswa']}}">
                                        Reset password
                                    </button>
                                    @if ($item['Status']=='CLS')
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalnona{{$item['IDSiswa']}}">
                                        Non aktifkan
                                    </button>
                                    @endif
                                    @if ($item['Status']=='DEL')
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalaktif{{$item['IDSiswa']}}">
                                            Aktifkan
                                        </button>
                                    @endif
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
                                                        Username : {{$item['Username']}} <br>
                                                        Email : {{$item['Email']}} <br>
                                                        Jenis Kelamin : {{$item['JenisKelamin']}} <br>
                                                        Alamat : {{$item['Alamat']}} <br>   
                                                        Tanggal lahir : {{$item['TanggalLahir']}} <br>
                                                        Tempat lahir : {{$item['TempatLahir']}}<br>
                                                        No HP : {{$item['NoHP']}}<br>
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
                            <div class="modal fade" id="modalnona{{$item['IDSiswa']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                    <h5 class="modal-title">Non aktifkan akunnya {{$item['NamaSiswa']}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
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
                                                            Tanggal lahir : {{$item['TanggalLahir']}} <br>
                                                            Tempat lahir : {{$item['TempatLahir']}}<br>
                                                            No HP : {{$item['NoHP']}}  
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{url('karyawan/deleteakunsiswa')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="idsiswa" value="{{$item['IDSiswa']}}">
                                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                        <!-- Modal -->
                        <div class="modal fade" id="modalresetpassword{{$item['KodeSiswa']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reset password</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="reset-form{{$item['KodeSiswa']}}">
                                            @csrf
                                            <input type="hidden" value="{{$item['IDSiswa']}}" name="resetidsiswa">
                                            <div class="form-group">
                                              <label for="">Masukan password baru</label>
                                              <input type="password" class="form-control" name="resetpassword" id="reset-newpassword{{$item['KodeSiswa']}}" aria-describedby="helpId" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label >Masukan ulang password baru</label>
                                                <input type="password" onkeyup="cekResetPassword('{{$item['KodeSiswa']}}')" class="form-control" name="resetrepassword" id="reset-renewpassword{{$item['KodeSiswa']}}" >
                                                <span style="display: none" id="reset-help-repassword{{$item['KodeSiswa']}}" class="form-text text-danger">* Password tidak sama</span>
                                            </div>
                                        </form>
                            
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button onclick="resetPassword('{{$item['KodeSiswa']}}')" id="reset-btn-reset{{$item['KodeSiswa']}}" class="btn btn-primary text-white">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="modal fade" id="modalaktif{{$item['IDSiswa']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                    <h5 class="modal-title">Aktifkan akunnya {{$item['NamaSiswa']}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
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
                                                            Tanggal lahir : {{$item['TanggalLahir']}} <br>
                                                            Tempat lahir : {{$item['TempatLahir']}}<br>
                                                            No HP : {{$item['NoHP']}} <br>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{url('karyawan/undeleteakunsiswa')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="idsiswa" value="{{$item['IDSiswa']}}">
                                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                            </form>
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
</div>

@endsection
@push('scripts')
    
<script>
    let level_karyawan = parseInt($('#level-karyawan').val())
    $(document).ready(function () {
        $('#tabeldata').DataTable();
        getURLID()
    });
    function getURLID(){
        let url = window.location.hash
        let show = url.split('#')[1]
        let IDdata = url.split('#')[2]
        if(url.length != 0){
            let modal = show=='siswa'?'modelId':'modalPsiko'
            $('#'+modal+IDdata).modal('show')
        }

    }
    function cekResetPassword(id){
        let password = $('#reset-newpassword'+id).val();
        let re_password = $('#reset-renewpassword'+id).val()
        console.log(password)
        if(password != re_password){
            $('#reset-help-repassword'+id).show()
            $('#reset-btn-reset'+id).attr('disabled',true)
        }
        else{
            $('#reset-help-repassword'+id).hide()
            $('#reset-btn-reset'+id).attr('disabled',false)
        }
    }
    function resetPassword(id){
        let url_level = level_karyawan===1?'owner':level_karyawan===2?'admin':false
        console.log('trace on',url_level,level_karyawan)
        if(url_level!==false){
            $.ajax({
                type: "post",
                url: "/karyawan/"+url_level+"/siswa/resetpassword",
                data: $('#reset-form'+id).serialize(),
                success: function (response) {
                    swal(response)
                    $('#modalresetpassword'+id).modal('hide')
                }
            });
        }else{
            swal('Oppss! system bussy')
        }
    }
</script>
@endpush