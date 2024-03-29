@extends('siswa.layouts.layout')
@section('title','Nilai')
@section('kelas','current-page')
@section('content')


@if (count($errors)>0)
    <input type="hidden" value="{{$errors->first('msg')}}" id="errormsg">
@endif

<div class="x_content">
    
    <a name="" id="" class="btn btn-primary btn-sm" 
    href="{{url('siswa/sertifikat/depan')}}/{{$Kursus[0]->UUID}}" role="button">
    Sertifikat Depan</a>
    <a name="" id="" class="btn btn-primary btn-sm" 
    href="{{url('siswa/sertifikat/belakang')}}/{{$Kursus[0]->UUID}}" role="button">
    Sertifikat Belakang</a>
    <a name="" id="" class="btn btn-primary btn-sm" 
    href="{{url('siswa/rapor')}}/{{$Kursus[0]->UUID}}" role="button">
    Rapor</a>
    <div class="row grid_slider mt-5">
        <div class="col-md-6 col-sm-6  ">
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Program <span
                        class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" value="{{$Kursus[0]->NamaProdi}}" style="width: 340px" name="kategoriprogram" id="first-name" readonly required="required" class="form-control ">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Siswa <span
                        class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" value="{{$Kursus[0]->NamaSiswa}}"  style="width: 340px" name="namanilai" id="first-name" required="required" readonly class="form-control ">
                </div>
            </div>
           
        </div>
        <div class="col-md-6 col-sm-6  ">
            
        </div>
        <div class="ln_solid"></div>
        
    </div>
    <table id="tabeldata" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Materi</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach ($Nilai as $n)  
            <tr>
                <td>#</td>
                <td>{{$n['Jenis']}}</td>
                <td>Nilai Rata = {{$n['Nilai']}}</td>
                <td></td>
            </tr>   
                @foreach ($n['Content'] as $content)              
                <tr>
                <td>#</td>
                    <td>- - - {{$content->NamaNilai}}</td>
                    <td>{{$content->Nilai}}</td>
                    <td></td>
                </tr>
                @endforeach     
            @endforeach
        </tbody>
    </table>
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tabeldata').DataTable();
            showError();
        });
        function showError(){
            let errorMsg = $('#errormsg').val();
            if(errorMsg != undefined){
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg,
                })
            }
        }
        function showData(){
       var Tutor = function(){
           var tmp =null;
           $.ajax({
               'async':false,
               'type':'GET',
               'url':'/karyawan/admin/getdata/tutor',
               'success': function (data){
                   tmp = data;
               }
           });

           return tmp;
        }();
        $.get('/karyawan/admin/jadwal/getdata',function(Data){
            if(Data.Status=='success'){
                console.log(Data);
                $('#datatabel').empty();
                var a=0;
                TabelData.clear().draw();
                Data.forEach((data) =>{
                    a++;
                    Tutor.forEach((val)=>{"<option value=\"+val.IDKaryawan+\"></option>"});
                    var AddTutor = "<button type=\"button\""+  
                                    "onclick=\"editJadwal("+data.IDJadwal+")\""+
                                    "class=\"btn btn-primary btn-sm\""+ 
                                    "data-toggle=\"modal\" data-target=\"#modaladdtutor\" >"+
                                        "Pilih Tutor "+
                                    "</button>";
                    TabelData.row.add([
                        a,
                        data.Tanggal.split(' ')[0],
                        data.Tanggal.split(' ')[1],
                        data.NamaMateri,
                        data.KodeKursus,
                        data.NamaSiswa,
                        AddTutor,
                        data.IDTuto==null?'Belum memilih tutor':data.IDTutor
                    ]).draw();
                });
                getTutor();
            }
        })
    }
        function deleteData(id){
            swal({
                title: "Apakah kamu yakin?",
                text: "Data akan dihapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.replace('/siswa/nilai/destroy/'+id);

                } else {
                    swal("Dibatalkan!");
                }
            });
        }
    </script>
@endpush
@endsection