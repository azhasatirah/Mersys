@extends('karyawan.layouts.layout')
@section('title','Program Studi')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kategori Program <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a class="btn btn-primary btn-sm"href="{{url('/karyawan/master/kategoriprogram/create')}}">Tambah Program</a>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody >

                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        var TabelData = $('#tabeldata').DataTable();
        $(document).ready(function(){
            var Status = {!!json_encode($Status)!!};
            console.log(Status);
            $('#tabeldata').DataTable();
            showData();
        });

        function showData(){
            $.get('/karyawan/master/kategoriprogram/getdata',function(Data){
                if(Data.Status=='success'){
                    $('#datatabel').empty();
                    var a=0;
                    TabelData.clear().draw();
                    Data.KategoriProgram.forEach((data) =>{
                        a++;
                        var TombolAksi = "<a class=\"btn btn-primary btn-sm\"href=\"{{url('/karyawan/master/kategoriprogram/edit')}}/"+data.KodeKategoriProgram+"\">"+
                                        "<i class=\"fa fa-edit\"></i></a>"+
                                        "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteKategori('"+data.KodeKategoriProgram+"')\">"+
                                        "<i class=\"fa fa-trash\"></i></a>";
                        TabelData.row.add([
                            a,
                            data.KategoriProgram,
                            TombolAksi
                        ]).draw();
                    })
                }
            })
        }
        function deleteKategori(Kode){
            swal({
                title: "Apakah kamu yakin?",
                text: "Kamu tidak dapat mengembalikan data yang telah dihapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get('/karyawan/master/kategoriprogram/delete/'+Kode,function(Pesan){
                        console.log(Pesan);
                        if(Pesan.Status='success'){
                            swal("Data berhasi dihapus!", {
                                icon: "success",
                            });
                            showData();
                        }else{
                            swal("Terjadi kesalahan!", {
                                icon: "error",
                            });
                        }
                    });

                } else {
                    swal("Dibatalkan!");
                }
            });

        }
    </script>
@endpush
{{-- append(
                            '<tr>'+
                                '<th scope="row">'+1+'</th>'+
                                '<td>'+data.KategoriProgram+'</td>'+
                                '<td>'+
                                    '<a class="btn btn-primary btn-sm"href="{{url('/karyawan/master/kategoriprogram/edit')}}/'+data.KodeKategoriProgram+'">'+
                                        '<i class="fa fa-edit"></i>'+
                                    '</a>'+
                                    '<a class="btn btn-danger btn-sm text-white"onclick="deleteKategori('+data.KodeKategoriProgram+')">'+
                                        '<i class="fa fa-trash"></i>'+
                                    '</a>'+
                                '</td>'+
                            '</tr>'
                        ) --}}