<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/assets/scss/welcome.css')}}">
    <script src="https://kit.fontawesome.com/b49839d706.js" crossorigin="anonymous"></script>
    <title>Pendaftaran karyawan!</title>
  </head>
  <body>
    <div class="container" id="boarddata" >
        <div class="card bg-transparent" style="border:none">
            <div class="d-flex justify-content-between mx-3 my-4 form-header">
                <div class="back-button">
                    <i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i>
                </div>
                <div class=" ">
                    <img src="{{asset('images/icons/merachel.png')}}" class="logo" alt="" srcset="">
                </div>
                <div></div>
            </div>
            <div class="container-fluid bg-white form-siswa ">
                <div class="row bg-white mx-4">
                    <div class="col-md-12 bg-gray mt-4 ">  
                        <ul class="nav justify-content-center ">
                            <li class="nav-item" role="tablist">
                                <a href="#tabdaftar" active class="nav-link active" role="tab"
                                data-bs-toggle="tab"
                                id="tomboldaftar" aria-controls="tabdaftar">
                                    Daftar
                                </a>
           
                            </li>
                            <li class="nav-item">
                                <a href="#tabmasuk" class="nav-link" role="tan"
                                data-bs-toggle="tab"
                                id="tombolmasuk" aria-controls="tabmasuk">
                                    Masuk
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">

                        <div class="col-md-12 mt-4 tab-pane fade show active" role="tabpanel"
                        id="tabdaftar" aria-labelledby="tomboldaftar">
                            <form id="datadaftar" action="{{url('auth/daftar')}}" method="POST">
                            @csrf
                                {{-- <div class="form-floating md-3">
    
                                </div> --}}
                                {{-- <select name="peran" class="form-select ss-input" aria-label="Default select example">
                                    <option selected>Daftar sebagai</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="karyawan">Karyawan</option>
                                </select> --}}
                                <input type="hidden" value="karyawan" name="peran">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control ss-input" name="namalengkap" placeholder="username" 
                                    id="inNamaLengkap">
                                    <label for="inNamaLengkap">Nama Lengkap</label>
                                </div>
                                <div id="validNamaLengkap" class="validasi"></div>
                                <select name="jeniskelamin" class="form-select ss-input" 
                                id="inJenisKelamin"aria-label="Default select example">
                                    <option value="" selected>Jenis Kelamin</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                                <div id="validJenisKelamin" class="validasi mt-1"></div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control ss-input" name="tanggallahir" placeholder="username" 
                                    id="inTanggalLahir">
                                    <label for="inTanggalLahir">Tanggal Lahir</label>
                                </div>
                                <div id="validTanggalLahir" class="validasi"></div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control ss-input" name="tempatlahir" placeholder="username" 
                                    id="inTempatLahir">
                                    <label for="inTempatLahir">Tempat Lahir</label>
                                </div> 
                                <div id="validTempatLahir" class="validasi"></div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control ss-input" name="alamat" placeholder="username" 
                                    id="inAlamat">
                                    <label for="inAlamat">Alamat</label>
                                </div>
                                <div id="validAlamat" class="validasi"></div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control ss-input" name="nohp" placeholder="username" 
                                    id="inNoHP">
                                    <label for="inNoHP">No HP</label>
                                </div>  
                                <div id="validNoHP" class="validasi"></div>
                                <div class="form-floating mb-3">
                                    <input id='inEmailDaftar' autocomplete="off" type="text" class="form-control ss-input" name="email" placeholder="username" id="floatingInput">
                                    <label for="inEmailDaftar">
                                        Email
                                    </label>
                                </div>
                                <div id="validEmailDaftar" class="validasi"></div>
                                <div class="form-floating mb-3">
                                    <input id='inUsernameDaftar' autocomplete="off" type="text" class="form-control ss-input" name="username" placeholder="username" id="floatingInput">
                                    <label for="inUsernameDaftar">
                                        Username
                                    </label>
                                </div>
                                <div id="validUsernameDaftar" class="validasi"></div>
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control ss-input" id="inPasswordDaftar" placeholder="Password">
                                    <label for="inPasswordDaftar">Password</label>
                                </div>
                                <div id="validPasswordDaftar" class="validasi mt-1"></div>
                                <div class="d-grid gap-2 mt-4 mb-4">
                                    <button id="btnDaftar" class="btn btn-primary" type="button">Daftar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 mt-4 tab-pane fade" role="tabpanel"
                        style="height: 25rem"
                        aria-labelledby="tombolmasuk" id="tabmasuk">
                            <form id="datamasuk" action="{{url('auth/login')}}" method="post">
                                @csrf
                                <input type="hidden" name="karyawan" value="siswa">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control ss-input" name="username" 
                                    placeholder="username" id="inUsernameMasuk">
                                    <label for="inUsernameMasuk">Username</label>
                                </div>
                                <div id="validUsernameMasuk" class="validasi"></div>
                                <div class="form-floating">
                                    <input type="password" name="password" 
                                    class="form-control ss-input" id="inPasswordMasuk">
                                    <label for="inPasswordMasuk">Password</label>
                                </div>
                                <div id="validPasswordMasuk" class="validasi mt-1"></div>
                                <div class="d-grid gap-2 mt-4 mb-4">
                                    <button id="btnMasuk" class="btn btn-primary" type="button">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="errors" value="{{$errors}}">
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="{{url('/assets/karyawan/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/welcome.js')}}"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </body>
</html>