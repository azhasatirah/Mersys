<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b49839d706.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('/assets/scss/pembayaran.css')}}">
    <link rel="stylesheet" href="{{url('/assets/scss/welcome.css')}}">

    {{-- <script type="application/javascript" src="{{ asset('js/app.js') }}"></script> --}}
    <title>@yield('title')</title>
  </head>
  <body>
    <input type="hidden" value="{{session()->get('UID')}}" id="uid-user">
    <navbar  class="nav bg-white shadow-sm sticky-top">
      <div class="container" >
        <div class="d-flex justify-content-between">
          <a href="" class="navbar-brand">
            <img src="{{asset('images/icons/merachel.png')}}" height="70px" width="auto" alt="" srcset="">  
          </a>
          <button class="btn text-dark" id="nav-icon" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarToggleExternalContent" 
            aria-controls="navbarToggleExternalContent" aria-expanded="false" 
            aria-label="Toggle navigation">
            <i class="fa fa-navicon"></i>
          </button> 
        </div>
        <div class="d-flex justify-content-center">

          <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-white p-1">
              <div class="container" >
                @if (session()->get('StatusUser')=='CLS')
        
                <a href="{{url('siswa/kursus')}}" class="btn nav-collapse mb-1" >
                  Program Saya
                </a>
                <a href="{{url('siswa/transaksi')}}" class="btn nav-collapse mb-1" >
                  Riwayat Transaksi
                </a>
                <a href="{{url('siswa/program/global')}}" class="btn nav-collapse mb-1" >
                  Transaksi 
                </a>
                @endif
                <form method="POST" id="dataLogout" action="{{url('/auth/logout')}}">@csrf</form>
                <a href="#" id="btnLogout" class="btn nav-collapse mb-1" >
                  Logout
                </a>
              </div>
            </div>
          </div>  
        </div>
      </div>
    </navbar>

    <div class="row board">
        @yield('content')
    </div>
    @yield('scontent')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="{{url('/assets/karyawan/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      let soundNotif = new Audio('/audio/notif/kei.mp3');
      $(document).ready(function () {
        console.log($('#uid-user').val());
      });
      // window.Echo.channel('Pendaftaran').listen('.'+$('#uid-user').val(), function (e) {
      //   console.log(e);
      //   soundNotif.play();
      //   swal({
      //         title: "Pendaftaran anda sudah di konfirmasi!",
      //         text: "Anda harus login ulang",
      //         icon: "success",
      //         buttons: true,
      //         dangerMode: true,
      //     }).then((willDelete) => {
      //         if (willDelete) {
      //           $('#dataLogout').submit();
      //         } else {
      //             swal("Dibatalkan!");
      //         }
      //     });

      // });
      $(function(){
        $(document).on('click','#btnLogout',function(){
          swal({
              title: "Yakin ingin keluar?",
              text: "Kamu harus login untuk magakses halaman ini lagi!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                $('#dataLogout').submit();
              } else {
                  swal("Dibatalkan!");
              }
          });
        });
      });

  </script>
  @stack('script')
    

  </body>
</html>