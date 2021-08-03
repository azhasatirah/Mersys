@extends('karyawan.layouts.layout')
@section('title','Nilai')
@section('kelas','current-page')
@section('content')


@if (count($errors)>0)
    <input type="hidden" value="{{$errors->first('msg')}}" id="errormsg">
@endif
<input type="hidden" value="{{session()->get('msg')}}" id="msg">
<div class="x_content">
    
    <a name="" id="" class="btn btn-primary btn-sm" 
    href="{{url('karyawan/tutor/sertifikat/depan')}}/{{$Kursus[0]->UUID}}" role="button">
    Sertifikat Depan</a>
    <a name="" id="" class="btn btn-primary btn-sm" 
    href="{{url('karyawan/tutor/sertifikat/belakang')}}/{{$Kursus[0]->UUID}}" role="button">
    Sertifikat Belakang</a>
    <a name="" id="" class="btn btn-primary btn-sm" 
    href="{{url('karyawan/tutor/rapor')}}/{{$Kursus[0]->UUID}}" role="button">
    Rapor</a>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="modal-create-ef" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluasi final</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="POST" action="{{url('karyawan/tutor/nilai/evaluasifinal/store')}}">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" value="{{$Kursus[0]->UUID}}" name="uidkursus">
                    <input type="hidden" value="{{$Kursus[0]->IDKursusSiswa}}" name="idkursus">

                    <div class="form-group">
                        <label for="">Evaluasi final</label>
                        <textarea class="form-control" name="evaluasifinal"  rows="3"></textarea>
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @if (count($EvaluasiFinal)>0)
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit-ef">
        Edit Evaluasi final
     </button>
    <div class="modal fade" id="modal-edit-ef" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluasi final</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form method="POST" action="{{url('karyawan/tutor/nilai/evaluasifinal/update')}}">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" value="{{$Kursus[0]->IDKursusSiswa}}" name="idkursus">
                    <input type="hidden" value="{{$Kursus[0]->UUID}}" name="uidkursus">
                    <input type="hidden" value="{{$EvaluasiFinal[0]->IDEvaluasiFinal}}" name="idevaluasifinal">

                    <div class="form-group">
                      <label for="">Evaluasi final</label>
                      <textarea class="form-control" name="evaluasifinal"  rows="3">{{$EvaluasiFinal[0]->EvaluasiFinal}}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @else
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create-ef">
        Evaluasi final
      </button>
    @endif
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
            <small class="text-muted"></small>
           <div class="form-group">
             <label class=" col-md-3 col-sm-3 label-align">Evaluasi final</label>
             <div class="col-md-6 col-sm-6" >

                 <textarea style="width: 21.2rem" readonly class="form-control" rows="4">{{count($EvaluasiFinal)>0?$EvaluasiFinal[0]->EvaluasiFinal:''}}</textarea>
             </div>
           </div>
        </div>
        <div class="col-md-6 col-sm-6  ">
            <form id="demo-form2" method="POST" data-parsley-validate 
            action="{{url('/karyawan/tutor/nilai/store')}}"
            class="form-horizontal form-label-left">
            @csrf
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jenis Penilaian <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        {{-- <input type="text" style="width: 340px" name="kategoriprogram" id="first-name" required="required" class="form-control "> --}}
                        <select  style="width: 340px" name="jenis" class="form-control">
                            <option>Pilih</option>
                            @foreach ($JenisNilai as $jnilai) 
                            <option value="{{$jnilai->IDJenisNilai}}">{{$jnilai->Jenis}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="kursus" value="{{$Kursus[0]->IDKursusSiswa}}">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Materi <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" style="width: 340px" name="namanilai" id="first-name" required="required" class="form-control ">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nilai <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="number" style="width: 340px" name="nilai" id="first-name" required="required" class="form-control ">
                    </div>
                </div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </form>
            
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
                    <td><a class="btn btn-danger"
                        onclick="deleteData({{$content->IDNilai}})"
                        href="javascript:void(0)" role="button"><i class="fa fa-trash"></i></a></a></td>
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
            showMsg()
        });
        function showMsg(){
            let msg = $('#msg').val()
            if(msg.length>0){
                swal(msg)
            }

        }
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
                    window.location.replace('/karyawan/tutor/nilai/destroy/'+id);

                } else {
                    swal("Dibatalkan!");
                }
            });
        }
    </script>
@endpush
@endsection