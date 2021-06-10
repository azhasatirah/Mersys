@extends('siswa.layouts.layout')
@section('title','Nilai Evaluasi')
@section('kelas','current-page')
@section('content')
@if (count($errors)>0)
    <input type="hidden" value="{{$errors->first('msg')}}" id="errormsg">
@endif
    
    <div class="x_content">
        
        <a  class="btn btn-primary" href="{{url('siswa/evaluasi')}}/{{$Kursus[0]->UUID}}" role="button">Evaluasi</a>
        <div class="row grid_slider mt-5">
            <div class="col-md-6 col-sm-6  ">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Program <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" value="{{$Kursus[0]->NamaProdi}}" style="width: 340px" name="kategoriprogram"  readonly required="required" class="form-control ">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Siswa <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" value="{{$Kursus[0]->NamaSiswa}}"  style="width: 340px" name="namanilai"  required="required" readonly class="form-control ">
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
                    <th>Pertemuan</th>
                    <th>Materi</th>
                    <th>Plus (+)</th>
                    <th>Minus (-)</th>
                    <th>Saran</th>
                    <th style="width: 16%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($NilaiEvaluasi as $item)
                    <tr>
                        <td>
                            {{$item['NoRecord']}}
                        </td>
                        <td>
                            {{$item['NamaMateri']}}
                        </td>
                        <td>
                            {{$item['Plus']}}
                        </td>
                        <td>
                            {{$item['Minus']}}
                        </td>
                        <td>
                            {{$item['Saran']}}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@push('scripts')
    <script>
        function deleteData(id){
            swal({
                title: "Apakah kamu yakin?",
                text: "Data akan dihapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.replace('/karyawan/tutor/nilaieval/destroy/'+id);

                } else {
                    swal("Dibatalkan!");
                }
            });
        }
    </script>
@endpush
@endsection