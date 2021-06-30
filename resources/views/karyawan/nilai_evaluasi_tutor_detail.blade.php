@extends('karyawan.layouts.layout')
@section('title','Nilai Evaluasi')
@section('kelas','current-page')
@section('content')
@if (count($errors)>0)
    <input type="hidden" value="{{$errors->first('msg')}}" id="errormsg">
@endif
    
    <div class="x_content">
        
        <a  class="btn btn-primary" href="{{url('karyawan/tutor/evaluasi')}}/{{$Kursus[0]->UUID}}" role="button">Evaluasi</a>
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
                        <td>
                            @if ($item['Plus'] == 'Belum dinilai')
                                <a  class="btn btn-primary btn-sm" href="javascript:void(0)" role="button"
                                data-toggle="modal" data-target="#modal-add-materi-{{$item['IDKursusMateri']}}">
                                    <i class="fa fa-plus" aria-hidden="true"></i> add
                                </a>
                                <div class="modal fade" id="modal-add-materi-{{$item['IDKursusMateri']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Evaluasi materi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <form action="{{url('karyawan/tutor/nilaieval/store')}}" method="POST">
                                                <input type="hidden"  name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="idkursussiswa" value="{{$item['IDKursusSiswa']}}">
                                                <input type="hidden" name="idkursusmateri" value="{{$item['IDKursusMateri']}}">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="pertemuan-eva">Pertemuan ke</label>
                                                    <input type="text" value="{{$item['NoRecord']}}"
                                                    readonly name="norecord" id="idkursusmateri-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                                                </div>
                                                <div class="form-group">
                                                    <label for="materi-eva">Materi</label>
                                                    <input type="text" 
                                                    value="{{$item['NamaMateri']}}"
                                                    readonly name="materieva" id="materi-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                                                </div>
                                                <div class="form-group">
                                                    <label for="plus-eva">Nilai (+)</label>
                                                    <input type="text" name="pluseva" id="plus-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                                                </div>
                                                <div class="form-group">
                                                    <label for="minus-eva">Nilai (-)</label>
                                                    <input type="text" name="minuseva" id="minus-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                                                </div>
                                                <div class="form-group">
                                                    <label for="saran-eva">Saran</label>
                                                    <input type="text" name="saraneva" id="saran-eva" class="form-control" require placeholder="" aria-describedby="helpId">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <a  class="btn btn-primary btn-sm" href="javascript:void(0)"
                            data-target="#modal-edit-materi-{{$item['IDKursusMateri']}}" data-toggle="modal"
                            role="button">
                                <i class="fa fa-pencil" aria-hidden="true"></i> edit
                            </a>
                            <a  class="btn btn-danger btn-sm" href="javascript:void(0)"
                            onclick="deleteData({{$item['IDNilaiEvaluasi']}})" role="button">
                                <i class="fa fa-trash" aria-hidden="true"></i> delete
                            </a>
                            {{-- modal edit --}}
                            <div class="modal fade" id="modal-edit-materi-{{$item['IDKursusMateri']}}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Nilai Evaluasi </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <form action="{{url('karyawan/tutor/nilaieval/update')}}" method="POST">
                                            <input type="hidden"  name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" value="{{$item['IDNilaiEvaluasi']}}" name="idnilaievaluasi">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="pertemuan-eva">Pertemuan ke</label>
                                                <input type="text" value="{{$item['NoRecord']}}"
                                                readonly name="idkursusmateri" class="form-control" require placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="form-group">
                                                <label for="materi-eva">Materi</label>
                                                <input type="text" 
                                                value="{{$item['NamaMateri']}}"
                                                readonly name="materieva"  class="form-control" require placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="form-group">
                                                <label for="plus-eva">Nilai (+)</label>
                                                <input type="text" name="pluseva"
                                                value="{{$item['Plus']}}"
                                                class="form-control" require placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="form-group">
                                                <label for="minus-eva">Nilai (-)</label>
                                                <input type="text" name="minuseva" 
                                                value="{{$item['Minus']}}"
                                               class="form-control" require placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="form-group">
                                                <label for="saran-eva">Saran</label>
                                                <input type="text" name="saraneva"
                                                value="{{$item['Saran']}}"
                                               class="form-control" require placeholder="" aria-describedby="helpId">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
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