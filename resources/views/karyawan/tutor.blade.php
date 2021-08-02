@extends('karyawan.layouts.layout')
@section('title','Dasbor')

@section('content')
  <!-- top tiles -->
  <!-- /top tiles -->
  <input type="hidden" id="csrf" name="_token" value="{{ csrf_token() }}">
  <div class="row">
      <div class="col-md-12 col-sm-12 ">
          <div class="dashboard_graph">

              <div class="row x_title">
                  <div class="col-md-6">
                      <h3>Jadwal hari ini</h3>
                  </div>
                  <div class="col-md-6">
            
                  </div>
              </div>
              <div class="table-responsive">

                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                          
                            <th>Nama Siswa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody  id="table-jadwal">

                    </tbody>
                </table>
              </div>

              <div class="clearfix"></div>
          </div>
      </div>

  </div>
  @push('scripts')
      
  <script>
    let JadwalSemi = [],JadwalPrivate = []
    let TableJadwal = $('#table-jadwal')
    $(document).ready(function () {
        getData()
    });
    function getData(){
        $.get('/karyawan/tutor/dasbor/getdata',function(Data){
            JadwalPrivate = Data[0]
            JadwalSemi = Data[1]
            appendRowTablePrivate()
            appendRowTableSemi()
        })
    }
    function appendRowTablePrivate(){
        var datenow = new Date().toLocaleString('en-US',{timeZone:'Asia/Bangkok'});
        var today = Date.parse(datenow);

        var now = today.getFullYear()+'-'+String(today.getMonth()+1).padStart(2,'0')+'-'+String(today.getDate()).padStart(2,'0');
        var jam = String(today.getHours()).padStart(2,'0')+':'+String(today.getMinutes()).padStart(2,'0')+':'+today.getMilliseconds();

        TableJadwal.empty()
        JadwalPrivate.forEach((data) =>{

            var b_mulai = "<form id=\"formstart"+data.IDKursusMateri+"\">"+
                "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\">"+
            "<input type=\"hidden\" name=\"idkursusmateri\" value=\""+data.IDKursusMateri+"\">"+
            "<input type=\"hidden\" name=\"karyawan\" value=\""+data.IDTutor+"\">"+
            "<input type=\"hidden\" name=\"idjadwal\" value=\""+data.IDJadwal+"\">"+
            "</form>"+
            "<button onclick=\"startKelas(\'"+data.IDKursusMateri+"\',\'"+data.KodeKelas+"\')\" id=\"btnstart"+data.IDKursusMateri+"\" class=\"btn text-white btn-sm btn-primary\">Mulai</button>"

            var b_batalkan = "<a class=\"text-white btn btn-small btn-primary\">Batalkan</a>";
            let option = data.Status == 'CLS'?'<a class=\"btn btn-sm text-white btn-success\">Selesai</a>':
                    data.Status == 'CFM'? 
                    "<a href=\"/karyawan/tutor/kelas/show/"+data.KodeKelas+"\" target=\"blank\"  class=\"btn text-white btn-sm btn-primary\">Kelas dimulai, buka</a>":
                    now==data.Tanggal.split(' ')[0]&&
                    Date.parse(jam)>= Date.parse(data.Tanggal.split(' ')[1])?b_mulai:
                    Date.parse(now)>Date.parse(data.Tanggal.split(' ')[0])?b_batalkan:
                    ''
            TableJadwal.append(
                "<tr>"+
                    "<td>"+
                        data.Tanggal.split(' ')[0]+
                    "</td>"+
                    "<td>"+
                        data.Tanggal.split(' ')[1]+
                    "</td>"+
                    "<td>"+
                        data.NamaProdi +
                    "</td>"+
                    "<td>"+
                        data.NamaSiswa+
                    "</td>"+
                    "<td>"+
                        option+
                    "</td>"+
                "</tr>"
            );
        });
    }
    function appendRowTableSemi(){
        var a=0;
        var datenow = new Date().toLocaleString('en-US',{timeZone:'Asia/Bangkok'});
        var today = Date.parse(datenow);

        var now = today.getFullYear()+'-'+String(today.getMonth()+1).padStart(2,'0')+'-'+String(today.getDate()).padStart(2,'0');
        var jam = String(today.getHours()).padStart(2,'0')+':'+String(today.getMinutes()).padStart(2,'0')+':'+today.getMilliseconds();
        let jadwal_semi = Object.values(JadwalSemi)
        jadwal_semi.forEach((data) =>{
            let stanggal = data[0].Tanggal.split(' ')[0]
            let sjam = data[0].Tanggal.split(' ')[1]
            var b_mulai =
            "<button onclick=\"startKelasSemi(\'"+data[0].Tanggal+"\')\" id=\"btnstart"+stanggal+sjam+"\" class=\"btn text-white btn-sm btn-primary\">Mulai</button>"
            let option = data.every(de=>de.Status == 'CLS')?'Selesai semua':
                    data[0].Status == 'CFM'? '':
                    now==stanggal&&
                    Date.parse(jam)>= Date.parse(sjam)?b_mulai:
                    Date.parse(now)>Date.parse(stanggal)?'kelas terlewat':
                    ''
            let resRowspan =data.some(ds=>ds.Status == 'CFM'||ds.Status == 'CLS')? '':"rowspan=\""+(data.length+1)+"\""
            TableJadwal.append(
                "<tr>"+
                    "<td rowspan=\""+(data.length+1)+"\">"+stanggal+"</td>"+
                    "<td rowspan=\""+(data.length+1)+"\">"+sjam+"</td>"+
                    "<th>Kelas semi private jam "+sjam+"</th>"+
                    "<th>Siswa semi private jam "+sjam+"</th>"+
                    "<td "+resRowspan+">"+
                        option+
                    "</td>"+
                "</tr>"
            )
            data.forEach(ele=>{
                let append_data = ele.Status == 'CFM'?                  
                    "<tr>"+
                        "<td>"+ele.NamaProdi+"</td>"+
                        "<td>"+ele.NamaSiswa+"</td>"+
                        "<td>"+
                            "<a href=\"/karyawan/tutor/kelas/show/"+ele.KodeKelas+"\" target=\"blank\"  class=\"btn text-white btn-sm btn-primary\">Kelas dimulai, buka</a>"+
                        "</td>"+
                    "</tr>":
                    ele.Status == 'CLS'?                  
                    "<tr>"+
                        "<td>"+ele.NamaProdi+"</td>"+
                        "<td>"+ele.NamaSiswa+"</td>"+
                        "<td>"+
                            "<a class=\"btn btn-sm text-white btn-success\">Selesai</a>"+
                        "</td>"+
                    "</tr>":
                    "<tr>"+
                        "<td>"+ele.NamaProdi+"</td>"+
                        "<td>"+ele.NamaSiswa+"</td>"+
                    "</tr>"
                TableJadwal.append(append_data)
            })
        })
    }
    function startKelas(id,KodeKelas,NoRecord,NamaMateri){
        $('#btnstart'+id).attr('disabled',true)
        $.post('/karyawan/tutor/kursus/start',$('#formstart'+id).serialize())
        .done(function(param){
            getData();
            //$.get('/karyawan/tutor/kursus/event/'+ KodeKelas);
            console.log(param);
        }).fail(function(param){
            console.log('error');
        })
    }
    function startKelasSemi(semi){
        let semi_jadwal = Object.values(JadwalSemi).filter(ele=>ele[0].Tanggal==semi)[0]
        let semi_data ={
            '_token':$('#csrf').val(),
            'karyawan':semi_jadwal[0].IDTutor,
            'idjadwal[]':[],
            'idkursusmateri[]':[]
        }
        semi_jadwal.forEach(ele=>{
            semi_data['idjadwal[]'].push(ele.IDJadwal)
            semi_data['idkursusmateri[]'].push(ele.IDKursusMateri)
        })
        $.post('/karyawan/tutor/kursus/startsemi',semi_data)
        .done(function(param){
            getData();
            //$.get('/karyawan/tutor/kursus/event/'+ KodeKelas);
            console.log(param);
        }).fail(function(param){
            console.log('error');
        })
        
    }
  </script>
  @endpush

@endsection


