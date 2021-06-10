@extends('siswa.layouts.layout')
@section('title','Jadwal ')
@section('content')
<style>tr{background: black}</style>
<table id="tabel-jadwal" class="table ">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" />
    <thead class="thead-dark">
        <tr>
            <th scope="col">Hari</th>
            <th scope="col">Jam</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nama Materi</th>
            <th scope="col">Tutor</th>
            <th scope="col">Status</th>
            <th scope="col">Absen</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody id="datatabel" ></tbody>
</table>
<input type="hidden" id="idkelas" value="{{$IDKelas}}">

@push('scripts')
<script>
    var TabelJadwal = $('#tabel-jadwal').DataTable();
    $(document).ready(function(){
        $('#tabel-jadwal').DataTable();
        showJadwal();
    });
    
    window.Echo.channel('Event'+$('#idkelas').val()).listen('.Kelas', function (e) {
        console.log(e);
        showJadwal();

    });
    function showJadwal(){
        $.get('/siswa/jadwal/getdata/'+$('#idkelas').val(),(data)=>{
            $('#datatabel').empty();
            TabelJadwal.clear().draw();
            data.forEach((element) => {
                let tmp_btn = element['Status']=='Berlangsung'&&element['Absen']=='Belum Absen'?
                    "<a onclick=\"masukKelas("+element['IDJadwal']+")\" class=\"btn btn-primary\">Absen</a>"
                    :element['Status']=='Berlangsung'&&element['Absen']=='masuk'?
                    "<a class=\"btn btn-success\">Berlangsung</a>"
                    :element['Status']=='Terlewat'?
                    "<a class=\"btn btn-success\">Kelas tidak dibuka</a>":
                    "<a class=\"btn btn-info\">"+element['Status']+"</a>";
                let btn =
                    "<form class=\'text-white\' id=\"formdata"+element['IDJadwal']+"\">"+
                        "<input type=\"hidden\" name=\"idjadwal\" value=\""+element['IDJadwal']+"\">"+
                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#token').val()+"\">"+
                        "<input type=\"hidden\" name=\"uuidjadwal\" value=\""+element['UUIDProgram']+"\">"+
                        tmp_btn+
                    "</form>";
               let rowNode = TabelJadwal.row.add([
                    element['Hari'],
                    element['Jam'],
                    element['Tanggal'],
                    element['NamaMateri'],
                    element['NamaTutor'],
                    element['Status'],
                    element['Absen'],
                    btn
                ]).draw();

            });
        });
    }
    function masukKelas(id){
        console.log($('#formdata'+id).serialize());
        $.post('/siswa/absen',$('#formdata'+id).serialize()).done((data)=>{
            showJadwal();
            console.log(data);
        }).fail(function(){
            console.log('gagal');
            swal('gagal');
        });
    }
//action="{{url('siswa/absen')}}"

</script>
@endpush
@endsection

{{-- <div class="container-fluid text-center ">

    <table style="width:70rem;margin-left:auto;margin-right:auto" class="table table-dark">
        <thead>
            <tr>
            <th scope="col">Hari</th>
            <th scope="col">Jam</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nama Materi</th>
            <th scope="col">Tutor</th>
            <th scope="col">Status</th>
            <th scope="col">Absen</th>
            <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Jadwal as $item)
            <tr>
                <th scope="row">{{$item['Hari']}}</th>
                <td>{{$item['Jam']}}</td>
                <td>{{$item['Tanggal']}}</td>
                <td>{{$item['NamaMateri']}}</td>
                <td>{{$item['NamaTutor']}}</td>
                <td>{{$item['Status']}}</td>
                <td>{{$item['Absen']}}</td>
                <td>
                
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div> --}}