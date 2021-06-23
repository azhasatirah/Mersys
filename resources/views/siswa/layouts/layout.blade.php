<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') </title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Bootstrap -->
    <link href="{{ url('/assets/karyawan/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('/assets/karyawan/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('/assets/karyawan/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('/assets/karyawan/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{ url('/assets/karyawan/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url('/assets/karyawan/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url('/assets/karyawan/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ url('/assets/karyawan/build/css/custom.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
  

    {{-- <script type="application/javascript" src="{{ asset('js/app.js') }}"></script>--}}
    @stack('styles')
  </head>

  <body class="nav-md">
    @php
        $Profile = DB::table('siswa')->where('UUID',session()->get('UID'))->first();
    @endphp
    <input type="hidden" value="{{session()->get('UID')}}" id="uid-user">
    <input type="hidden" value="{{session()->get('Level')}}" id="level-user">
    <input type="hidden" value="{{session()->get('StatusUser')}}" id="status-user">
    <input type="hidden" value="{{session()->get('IDUser')}}" id="id-user">

    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"> <span>Merachel
              </span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img 
                style="max-height: 60px;max-width:60px;height: 60px;width:60px;object-fit:cover"
                src="{{$Profile->PhotoProfile}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Halo,</span>
                <h2>{{session()->get('NamaUser')}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
      
                <ul class="nav side-menu">

                  <!-- Menu Owner -->
                  @if (session()->get('StatusUser')=='CLS')
                  <li><a href="{{url('siswa/program/global')}}"><i class="fa fa-square"></i>Transaksi</a></li>
                  <li><a href="{{url('siswa/kursus')}}"><i class="fa fa-square"></i>Program Saya</a></li>
                  <li><a href="{{url('siswa/transaksi')}}"><i class="fa fa-square"></i>Riwayat Transaksi</a></li>
                  @endif

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img 
                    style="max-height: 30px;max-width:30px;height: 30px;width:30px;object-fit:cover"
                    src="{{$Profile->PhotoProfile}}" alt="">{{session()->get('NamaUser')}}
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="{{url('siswa/profile')}}/{{session()->get('UID')}}"> Profile</a>
                      <form method="POST" id="dataLogout" action="{{url('/auth/logout')}}">@csrf</form>
                    <a class="dropdown-item" id="btnLogout"  href="#logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span id="count-notif" class="badge bg-green"></span>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" 
                  id="notif-list"
                  role="menu" aria-labelledby="navbarDropdown1">


                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <!-- Button trigger modal -->
        
        <!-- Modal -->
        <div class="modal fade" id="skmodal" tabindex="-1" role="dialog" 
        data-backdrop="static"
        aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Syarat dan Ketentuan</h5>
              </div>
              <div class="modal-body">
                <iframe
                style="width:100%;height:700px"
                 src="/siswa/program/stream/modul/sk060521022054" frameborder="0"></iframe>
          
              </div>
              <div class="modal-footer">
                <button onclick="showTest()" class="btn btn-primary btn-sm">Setuju dan Lanjutkan</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="test-psikologi-modal" tabindex="-1" role="dialog"
        data-backdrop="static"
         aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Tes Psikologi</h5>
              </div>
              <div class="modal-body" >
                <div style="height: 700px">
                  
                  <p>
                    <a target="blank" class="btn btn-sm btn-success" href="https://akupintar.id/tes-kemampuan" role="button">Ikuti test disini</a>
                    kemudian upload screecshot hasil test. <br>
                    contoh hasil test:
                    <img
                    style="height: auto;width:100%"
                    src="{{asset('images/ex-test-psikologi.png')}}" alt="" srcset="">
                  </p>
                  <form action="{{url('siswa/psikologi/store')}}" method="post"
                  id="form-psikologi"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="">Upload hasil test</label>
                      <input type="file" class="form-control-file" name="file" id="" placeholder="" >
                    </div>
                    <input type="hidden" name="idsiswa" value="{{session()->get('IDUser')}}">
                  </form>
              </div>
            </div>
            <div class="modal-footer">
              <button onclick="submitPsikologi()" class="btn btn-primary">Simpan</button>
            </div>
            </div>
          </div>
        </div>

        <!-- page content -->
        <div class="right_col" role="main">
          @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Created by DNIZTechno
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{url('/assets/karyawan/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.js')}}"></script>

    <!-- Bootstrap -->
    <script src="{{url('/assets/karyawan/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{url('/assets/karyawan/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{url('/assets/karyawan/vendors/nprogress/nprogress.js')}}"></script>
    <!-- Chart.js')}} -->
    <script src="{{url('/assets/karyawan/vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js')}} -->
    <script src="{{url('/assets/karyawan/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{url('/assets/karyawan/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{url('/assets/karyawan/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{url('/assets/karyawan/vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{url('/assets/karyawan/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{url('/assets/karyawan/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{url('/assets/karyawan/vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{url('/assets/karyawan/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{url('/assets/karyawan/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{url('/assets/karyawan/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <!-- Custom Theme Scripts -->
    <!-- <script src="{{url('/assets/karyawan/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js')}}"></script> -->
    <script src="{{url('/assets/karyawan/build/js/custom.min.js')}}"></script>
    <script>
      let soundNotif = new Audio('/audio/notif/kei.mp3');
      let RoleNotif = [];
      let UserNotif = [];
      let Notif = [];
      $(document).ready(function () {
        showNotif();
        siswaBaru();
      });
      function submitPsikologi(){
        $('#form-psikologi').submit();
      }
      function siswaBaru(){
        if($('#status-user').val()=='CLS'){
          let HasilTestPsikologi = getHasilTest();
    
          if(HasilTestPsikologi.length == 0){
            $('#skmodal').modal('show');
          }
        }
      }
      function showTest(){
        $('#skmodal').modal('hide');
        $('#test-psikologi-modal').modal('show');
      }
      function getHasilTest(){
        let Data;
        $.ajax({
            type: "get",
            url: "/siswa/psikologi/get/"+$('#id-user').val(),
            async: false,
            success: function (data) {
        
              Data = data;
            }
        });
        return Data;
      }
      function getNotif(){
        Notif =[];
        $.ajax({
              type: "get",
              url: "/siswa/notif",
              async: false,
              success: function (response) {
          
                RoleNotif = response;
              }
            });
        $.ajax({
          type: "get",
          url: "/notif/user/"+$('#uid-user').val(),
          async: false,
          success: function (response) {
        
            UserNotif = response;
          }
        });
        RoleNotif.forEach(ele=>Notif.push(ele));
        UserNotif.forEach(ele=>Notif.push(ele));
      //  return Notif;
      }
      function showNotif(){
        getNotif();

        $('#notif-list').empty();
        $('#count-notif').html(Notif.length==0?'':Notif.length);
        Notif.forEach((data)=>{
          $('#notif-list').append(
            '<li class=\"nav-item\">'+
              '<a class=\"dropdown-item\" '+
              'onclick=\"openNotif(\''+data['Link']+'\',\''+data['IDNotif']+'\')\">'+
                '<span class=\"image\"><img src=\"'+data['NotifFromProfile']+'\" alt=\"Profile Image\" /></span>'+
                '<span>'+
                  '<span>'+data['NotifFrom']+'</span>'+
                  '<span class=\"time\">'+data['Tanggal']+'</span>'+
                '</span>'+
                '<span class=\"message\">'+
                  ''+data['Notif']+''+
                '</span>'+
              '</a>'+
            '</li>'
          );
        });
      }
      function openNotif(link,idNotif){
        $.ajax({
          type: "get",
          url: "/notif/update/"+idNotif,
          async: false,
          success: function (response) {
   
          }
        });
        window.location.replace(link);
      }
      // window.Echo.channel('Notif').listen('.siswa', function (e) {
      //   console.log(e);
      //   soundNotif.play();
      //   showNotif();
      // });
      // window.Echo.channel('Notif').listen('.'+$('#uid-user').val(), function (e) {
      //   console.log(e);
      //   soundNotif.play();
      //   showNotif();
      // });
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
              text: "Kamu harus login untuk mengakses halaman ini lagi!",
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
    @stack('scripts')
  </body>
</html>
