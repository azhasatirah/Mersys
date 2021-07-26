<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{url('images/favicon.ico')}}" type="image/ico" />

    <title>@yield('title') </title>

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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{--<script type="application/javascript" src="{{ asset('js/app.js') }}"></script>--}}
    @stack('styles')
  </head>

  <body class="nav-md">
    @php
    $Profile = DB::table('karyawan')->where('UUID',session()->get('UID'))->first();
    @endphp
    {{-- <audio id="notif-sound" src="{{asset('audio/notif/notif.mp3')}}"></audio> --}}
    <input type="hidden" value="{{session()->get('UID')}}" id="uid-user">
    <input type="hidden" value="{{session()->get('Level')}}" id="level-user">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"> <span>Merachel</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img     style="max-height:60px;max-width:60px;object-fit:cover;width:60px;height:60px"
                
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
                <h3>General</h3>
                <ul class="nav side-menu">
                  @php
                      $DasborLink = 'karyawan/dasbor';
                      if(session()->get('Level')==3){
                        $DasborLink = 'karyawan/tutor/dasbor';
                      }
                  @endphp
                  <li><a href="{{url($DasborLink)}}"><i class="fa fa-square"></i>Beranda</a></li>
                  <!-- Menu Owner -->
                  @if(session()->get('Level')==1)
                  <li><a><i class="fa fa-dollar"></i> Penggajian <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/owner/penggajian')}}">Penggajian</a></li>
                      <li><a href="{{url('karyawan/owner/masterpenggajian')}}">Master penggajian</a></li>
                      <li><a href="{{url('karyawan/owner/masterpenggajian/transport')}}">Master biaya transport</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-cog"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/owner/transaksi')}}">Transaksi Proses</a></li>
                      <li><a href="{{url('karyawan/owner/transaksi/exchange')}}">Transaksi Exchange</a></li>
                      <li><a href="{{url('karyawan/owner/transaksi/selesai')}}">Transaksi Selesai</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-cog"></i> Pendaftaran <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/owner/pendaftaran/siswa')}}">Pendaftaran Siswa</a></li>
                      <li><a href="{{url('karyawan/owner/pendaftaran/karyawan')}}">Pendaftaran Karyawan</a></li>
                    </ul>
                  </li>
                  <li><a href="{{url('karyawan/owner/kursus')}}"><i class="fa fa-book"></i>Daftar kursus</a></li>
                  <li><a href="{{url('karyawan/owner/karyawan')}}"><i class="fa fa-square"></i>Daftar Karyawan</a></li>
                  <li><a href="{{url('karyawan/owner/siswa')}}"><i class="fa fa-square"></i>Daftar Siswa</a></li>
                  {{-- <li><a href="{{url('karyawan/owner/syarat')}}"><i class="fa fa-square"></i>Syarat dan Ketentuan</a></li> --}}
                  @endif
                  <!-- Menu Admin -->
                  @if(session()->get('Level')==2)   
                  <li><a href="{{url('karyawan/admin/kursus')}}"><i class="fa fa-book"></i>Daftar kursus</a></li>
                  <li><a href="{{url('karyawan/admin/diskon')}}"><i class="fa fa-dollar-sign"></i>Diskon</a></li>       
                  <li><a><i class="fa fa-cog"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/admin/transaksi')}}">Transaksi Proses</a></li>
                      <li><a href="{{url('karyawan/admin/transaksi/exchange')}}">Transaksi Exchange</a></li>
                      <li><a href="{{url('karyawan/admin/transaksi/selesai')}}">Transaksi Selesai</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-cog"></i> Pendaftaran <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/admin/pendaftaran/siswa')}}">Pendaftaran Siswa</a></li>
                      <li><a href="{{url('karyawan/admin/master/aktifasi')}}">Pendaftaran Karyawan</a></li>
                    </ul>
                  </li>
                  <li>
                    <a><i class="fa fa-calendar" aria-hidden="true"></i>Jadwal <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/admin/jadwal')}}"><i class="fa fa-check"></i>Jadwal</a></li>
                      <li><a href="{{url('karyawan/admin/jadwal/semiprivate')}}"><i class="fa fa-calendar-o"></i>Jadwal semi private</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-cog"></i> Manage <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/admin/master/program')}}">Program studi</a></li>
                      <li><a href="{{url('karyawan/admin/manage/rekening')}}">Rekening</a></li>
                      <li><a href="{{url('karyawan/admin/manage/metodepembayaran')}}">Metode Pembayaran</a></li>
                    
                    </ul>
                  </li>
                  <li><a><i class="fa fa-folder"></i> Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('karyawan/admin/master/bank')}}">Bank</a></li>
                      <li><a href="{{url('karyawan/admin/master/levelprogram')}}">Level Program studi</a></li>
                      <li><a href="{{url('karyawan/admin/master/kategoriprogram')}}">Kategori Program</a></li>
                      <li><a href="{{url('karyawan/admin/master/kategoriglobal')}}">Kategori Global Program</a></li>
                      <li><a href="{{url('karyawan/admin/master/kategorimateri')}}">Kategori Materi</a></li>
                      <li><a href="{{url('karyawan/admin/jenisnilai')}}">Jenis Nilai</a></li>
                    </ul>
                  </li>
                  <li><a href="{{url('karyawan/admin/karyawan')}}"><i class="fa fa-square"></i>Daftar Karyawan</a></li>
                  <li><a href="{{url('karyawan/admin/siswa')}}"><i class="fa fa-square"></i>Daftar Siswa</a></li>
                  @endif
                  <!-- Menu Tutor -->
                  @if(session()->get('Level')==3)
                  {{-- <li><a href="{{url('karyawan/tutor/jadwal')}}"><i class="fa fa-calendar" aria-hidden="true"></i> Jadwal</a></li> --}}
                  <li class="@yield('kelas')"><a href="{{url('karyawan/tutor/siswa')}}">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    Kelas</a></li>
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
                    <img style="max-height:30px;max-width:30px;object-fit:cover"
                     src="{{$Profile->PhotoProfile}}" alt="">{{session()->get('NamaUser')}}
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="
                    @if(session()->get('RoleUser')=='karyawan'){{url('karyawan/profile')}}@else{{url('siswa/profile')}}@endif/{{session()->get('UID')}}
                      "> Profile</a>
                   
          
                      <form method="POST" id="dataLogout" action="{{url('/auth/logout')}}">@csrf</form>
                    <a class="dropdown-item" id="btnLogout"  href="#logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green" id="count-notif"></span>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" 
                  id="notif-list"
                  role="menu" aria-labelledby="navbarDropdown1">

                    {{-- <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li> --}}
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    
    <!-- jQuery -->
    <script src="{{url('/assets/karyawan/vendors/jquery/dist/jquery.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    <script src="{{asset('assets/js/sweetalert.js')}}"></script>
    <script>
        let soundNotif = new Audio('/audio/notif/kei.mp3');
        let RoleNotif = [];
        let UserNotif = [];
        let Notif = [];
        let MyRole =$('#level-user').val() ==1?'owner':
        $('#level-user').val()==2?'admin':
        $('#level-user').val()==3?'tutor':'siswa';
      $(document).ready(function () {
        showNotif();
        console.log($('#uid-user').val());
      });
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
      function getNotif(){
        Notif = [];
        switch($('#level-user').val()){
          case '1':
            $.ajax({
              type: "get",
              url: "/karyawan/owner/notif",
              async: false,

              success: function (response) {
                console.log('owner',response);
                RoleNotif = response;
              }
            });
            break;
          case '2':
            console.log('admin');
            $.ajax({
              type: "get",
              url: "/karyawan/admin/notif",
              async: false,
              success: function (response) {
                console.log('admin',response);
                RoleNotif = response;
              }
            });
            break;
          case '3':
            
            $.ajax({
              type: "get",
              url: "/karyawan/tutor/notif",
              async: false,

              success: function (response) {
                console.log('tutor',response);
                RoleNotif = response;
              }
            });
            break;
          case '4':
            $.ajax({
              type: "get",
              url: "/siswa/notif",
              async: false,

              success: function (response) {
                console.log('siswa',response);
                RoleNotif = response;
              }
            });
            break;
        }
        $.ajax({
          type: "get",
          url: "/notif/user/"+$('#uid-user').val(),
          async: false,
          success: function (response) {
            console.log('user',response);
            UserNotif = response;
          }
        });
        console.log(RoleNotif);
        console.log(UserNotif);
        RoleNotif.forEach(ele=>Notif.push(ele));
        UserNotif.forEach(ele=>Notif.push(ele));
      //  return Notif;
      }
      function showNotif(){
        //let Notif = getNotif();
        getNotif();
        console.log(Notif);
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
            console.log(response);
          }
        });
        window.location.replace(link);
      }
      {{--window.Echo.channel('Notif').listen('.'+MyRole, function (e) {
        console.log(e);
        soundNotif.play();
        showNotif();
      });
      window.Echo.channel('Notif').listen('.'+$('#uid-user').val(), function (e) {
        console.log(e);
        soundNotif.play();
        showNotif();
      });--}}
    </script>
    @stack('scripts')
  </body>
</html>
