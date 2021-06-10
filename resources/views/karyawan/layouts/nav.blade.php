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

    <title>@yield('title')</title>
  </head>
  <body>


    <div class="row board">
        @yield('content')
    </div>
    <script src="{{url('/assets/karyawan/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>