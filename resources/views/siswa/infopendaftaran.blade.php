<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('/assets/scss/welcome.scss')}}">
    <script src="https://kit.fontawesome.com/b49839d706.js" crossorigin="anonymous"></script>
    <title>Pendaftaran siswa baru!</title>
  </head>
  <body>
    <div class="container" id="boarddata" style="height: 40rem" >
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
                    <h5>Hi {{session()->get('NamaUser')}}!</h5>
                    <p>Terimakasih sudah mengisi 
                        formulir pendaftaran, Langkah selanjutnya 
                        adalah membayar biaya pendaftaran, 
                        <a class="link" style="color:black" href="{{$Link}}">Klik</a>
                    </p>
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