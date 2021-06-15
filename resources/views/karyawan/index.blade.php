@extends('karyawan.layouts.layout')
@section('title','Dasbor')

@section('content')
  <!-- top tiles -->

  @if(session()->get('Level')!=3)
  <div class="row" style="display: inline-block;">
      <div class="tile_count">
          <div class="col-md-3 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Jumlah siswa</span>
              <div class="count">{{$Dasbor['JumlahSiswa']}}</div>
            
          </div>
          <div class="col-md-3 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Jumlah karyawan</span>
              <div class="count">{{$Dasbor['JumlahKaryawan']}}</div>
          </div>
          @if(session()->get('Level')==1)
          <div class="col-md-3 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Omset</span>
              <div 
              style="font-size:17px"
              class="count green">Rp. {{number_format($Dasbor['Omset'])}}</div>
          </div>
          @endif
          <div class="col-md-3 col-sm-4  tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Transaksi</span>
              <div class="count">{{$Dasbor['Transaksi']}}</div>
             
          </div>
      </div>
  </div>
  @endif
  <!-- /top tiles -->

  <div class="row">
      <div class="col-md-12 col-sm-12 ">
          <div class="dashboard_graph">

              <div class="row x_title">
                  <div class="col-md-6">
                      <h3>Aktifitas user</h3>
                  </div>
                  <div class="col-md-6">
            
                  </div>
              </div>

              <div class="col-md-9 col-sm-9 ">
                  <div id="chart_plot_01" class="demo-placeholder"></div>
              </div>
              <div class="col-md-3 col-sm-3  bg-white">
                  <div class="x_title">
                      <h2>Keterangan</h2>
                      <div class="clearfix"></div>
                  </div>

                  <div class="col-md-12 col-sm-12 ">
                      <div>
                          <p>Karyawan</p>
                          <div class="">
                              <div 
                              style="
                              background-color:rgba(38, 185, 154, 0.38);
                              width:50px;height:50px;
                              border-radius:50%
                              "
                              ></div>
                         
                          </div>
                      </div>
                      <div>
                          <p>Siswa</p>
                          <div class="">
                            <div 
                            style="
                            background-color:rgba(3, 88, 106, 0.38);
                            width:50px;height:50px;
                            border-radius:50%
                            "
                            ></div>
                          </div>
                      </div>
                  </div>

              </div>

              <div class="clearfix"></div>
          </div>
      </div>

  </div>
  @push('scripts')
      
  <script>
      var e = [
                [gd(2012, 1, 1), 17],
                [gd(2012, 1, 2), 74],
                [gd(2012, 1, 3), 6],
                [gd(2012, 1, 4), 39],
                [gd(2012, 1, 5), 20],
                [gd(2012, 1, 6), 85],
                [gd(2012, 1, 7), 7]
            ], a = [
                [gd(2012, 1, 1), 82],
                [gd(2012, 1, 2), 23],
                [gd(2012, 1, 3), 66],
                [gd(2012, 1, 4), 9],
                [gd(2012, 1, 5), 119],
                [gd(2012, 1, 6), 6],
                [gd(2012, 1, 7), 9]
            ]
            $("#chart_plot_01").length && (console.log("Plot1"), $.plot($("#chart_plot_01"), [e, a], {
            series: {
                lines: {
                    show: !1,
                    fill: !0
                },
                splines: {
                    show: !0,
                    tension: .4,
                    lineWidth: 1,
                    fill: .4
                },
                points: {
                    radius: 0,
                    show: !0
                },
                shadowSize: 2
            },
            grid: {
                verticalLines: !0,
                hoverable: !0,
                clickable: !0,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: "#fff"
            },
            colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [1, "day"],
                axisLabel: "Date",
                axisLabelUseCanvas: !0,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: "Verdana, Arial",
                axisLabelPadding: 10
            },
            yaxis: {
                ticks: 8,
                tickColor: "rgba(51, 51, 51, 0.06)"
            },
            tooltip: !1
        }))
  </script>
  @endpush

@endsection


