@extends('karyawan.layouts.layout')
@section('title','Daftar kursus')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kursus<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" style="width: 100%" class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Kode Kursus</th>
                            <th>Nama Prodi</th>
                            <th>Kode Siswa</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>
{{-- @foreach ($Kursus as $item)
<tr>
    <td>{{$item['KodeKursus']}}</td>
    <td>{{$item['NamaProdi']}}</td>
    <td>{{$item['KodeSiswa']}}</td>
    <td>{{$item['NamaSiswa']}}</td>
    <td>{{$item['TanggalOrder']}}</td>
    <td>{{$item['ReadStatus']}}</td>
    <td>
        @if ($item['Status'])
        <a class="btn btn-sm btn-primary" 
        href="{{url('karyawan/kursus/show')}}/{{$item['UIDKursus']}}" role="button">Absensi</a>
        @endif

        <a class="btn btn-sm btn-danger text-white"  href="javascript:void(0)"
        onclick="deleteKursus('{{$item['UIDKursus']}}')" role="button">Delete</a>

    </td>
</tr>
@endforeach --}}
@push('scripts')
    <script>
        let Tabel =  $('#tabeldata').DataTable({
                "scrollX": true,
                "ordering": false,
                "deferRender": true,
                "lengthMenu":[[5,50,-1],[5,50,"All"]]
            });
        $(document).ready(function () {
            getData()
           
        });
        function getData(){
            Tabel.clear()
            $.get('/karyawan/kursus/get' ).done((ele)=>{
                ele.sort((a,b)=> new Date(b.TanggalOrder).getTime() - new Date(a.TanggalOrder).getTime()).forEach(data => {
                    let btn_absen = data['Status']?
                        "<a class=\"btn btn-sm btn-primary\""+
                        "href=\"/karyawan/kursus/show/"+data['UIDKursus']+"\" role=\"button\">Absensi</a>":""
                    let btn_delete = "<a class=\"btn btn-sm btn-danger text-white\"  href=\"javascript:void(0)\""+
                    "onclick=\"deleteKursus(\'"+data['UIDKursus']+"\')\" role=\"button\">Delete</a>"

                    Tabel.row.add([
                        data['KodeKursus'],
                        data['NamaProdi'],
                        data['KodeSiswa'],
                        data['NamaSiswa'],
                        data['TanggalOrder'],
                        data['ReadStatus'],
                        btn_absen+btn_delete
                    ]).draw()
                })
            })
        }
        function deleteKursus(uid){
            swal({
              title: "Apakah anda yakin menghapus program studi ini?",
              text: "program studi akan hilang di halaman siswa dan tutor!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((willDelete) => {
              if (willDelete) {
                $.get('/karyawan/kursus/delete/'+uid).done((res)=>{
                    swal({
                        icon : 'success',
                        title: "Deleted!",
                        text: res,
                        type: "success",
                        timer: 1000,
                        button: false
                    })
                    getData()
                })
              } else {
                  swal("Dibatalkan!");
              }
          })
        }
    </script>
@endpush
@endsection