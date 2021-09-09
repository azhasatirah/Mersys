@extends('karyawan.layouts.layout')
@section('title','Nilai')
@section('kelas','current-page')
@section('content')

<div class="x_content">
    <section id="button-result"></section>
    <div class="modal fade" id="modal-create-ef" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluasi final</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="form-create-evaluasi-final" >
                <div class="modal-body">
                    @csrf

                    <input type="hidden" id="create-evaluasi-final-idkursus" name="idkursus">

                    <div class="form-group">
                        <label for="">Evaluasi final</label>
                        <textarea  class="form-control" name="evaluasifinal"  rows="3"></textarea>
                      </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" onclick="storeEvaluasiFinal()" class="btn btn-primary">Simpan</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <section id="button-evaluasi"></section>
    {{-- @if (count($EvaluasiFinal)>0)
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-edit-ef">
        Edit Evaluasi final
     </button>

    @else
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-create-ef">
        Evaluasi final
      </button>
    @endif --}}
    <div class="modal fade" id="modal-edit-ef" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evaluasi final</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="form-edit-evaluasi-final">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="edit-eval-idevaluasifinal" name="idevaluasifinal">

                    <div class="form-group">
                      <label for="">Evaluasi final</label>
                      <textarea id="edit-eval-evaluasi-final" class="form-control" name="evaluasifinal"  rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <a onclick="updateEvaluasiFinal()" href="javascript:void(0)" class="btn btn-primary">Edit</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row grid_slider mt-5">
        <div class="col-md-6 col-sm-6  ">
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Program <span
                        class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input  style="width: 340px" name="kategoriprogram" id="data-kursus-program" readonly required="required" class="form-control ">
                </div>
            </div>

            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Siswa <span
                        class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input   style="width: 340px" name="namanilai" id="data-kursus-nama-siswa" required="required" readonly class="form-control ">
                </div>
            </div>
            <small class="text-muted"></small>
           <div class="form-group">
             <label class=" col-md-3 col-sm-3 label-align">Evaluasi final</label>
             <div class="col-md-6 col-sm-6" >

                 <textarea style="width: 21.2rem" id="data-kursus-evaluasi-final" readonly class="form-control" rows="4"></textarea>
             </div>
           </div>
        </div>
        <div class="col-md-6 col-sm-6  ">
            <form id="form-nilai"
            class="form-horizontal form-label-left">
            @csrf
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jenis Penilaian <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        {{-- <input type="text" style="width: 340px" name="kategoriprogram" id="first-name" required="required" class="form-control "> --}}
                        <select  style="width: 340px" id="option-jenis-nilai" name="jenis" class="form-control"></select>
                    </div>
                </div>
                <input type="hidden" name="kursus" id="form-nilai-kursus">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Materi <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" style="width: 340px" name="namanilai" id="form-nilai-materi" required="required" class="form-control form-nilai">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nilai <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="number" style="width: 340px" name="nilai" id="form-nilai-nilai" required="required" class="form-control form-nilai">
                    </div>
                </div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        
                        <a href="javascript:void(0)" class="btn btn-success" onclick="storeNilai()">Tambah</a>
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
                <th>Jenis</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- @php
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
            @endforeach --}}
        </tbody>
    </table>
</div>
@push('scripts')
    <script>
        let IDKursus = window.location.href.split('/')[6]
        let Kursus=[],Nilai=[],EvalFinal=[],JenisNilai=[],SertifikasiKursus = []
        let TableNilai  = $('#tabeldata').DataTable()
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get('/karyawan/tutor/nilai/getdata/'+IDKursus,(Data)=>{
                console.log(Data)
                Kursus = Data[2]
                FinalEval = Data[1]
                Nilai = Data[0]
                JenisNilai = Data[3]
                initData()
                appendJenisNilaiOption()
                showDataNilai()
            })
        }
        function storeNilai(){
            $.ajax({
                type: "post",
                url: "/karyawan/tutor/nilai/store",
                data: $('#form-nilai').serialize(),
                success: function (response) {
                    swal(response)
                    $('.form-nilai').val('')
                    $('#option-jenis-nilai').val(0)
                    getData()
                }
            });
        }
        function initData(){
            let init_final_eval = FinalEval.length >0?FinalEval[0].EvaluasiFinal:''
            $('#form-nilai-kursus').val(Kursus.IDKursusSiswa)
            $('#data-kursus-program').val(Kursus.NamaProdi)
            $('#data-kursus-nama-siswa').val(Kursus.NamaSiswa)
            $('#data-kursus-evaluasi-final').val(init_final_eval)
            $('#button-evaluasi').empty()
            if(FinalEval.length>0){
                $('#button-evaluasi').append(
                    '<button type=\"button\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#modal-edit-ef\">'+
                        'Edit Evaluasi Final'+
                    '</button>'
                )
                $('#edit-eval-idevaluasifinal').val(FinalEval[0].IDEvaluasiFinal)
                $('#edit-eval-evaluasi-final').val(FinalEval[0].EvaluasiFinal)
            }
            if(FinalEval.length===0){
                $('#create-evaluasi-final-idkursus').val(Kursus.IDKursusSiswa)
                $('#button-evaluasi').append(
                    '<button type=\"button\" class=\"btn btn-primary btn-sm\" data-toggle=\"modal\" data-target=\"#modal-create-ef\">'+
                        'Tambah Evaluasi Final'+
                    '</button>'
                )
            }
            if(Nilai.length>0){
                $('#button-result').append(
                    '<a class=\"btn btn-primary btn-sm\" '+
                    'href=\"/karyawan/tutor/sertifikat/depan/'+IDKursus+'\" target=\"blank\" role=\"button\">'+
                    'Sertifikat Depan</a>'+
                    '<a class=\"btn btn-primary btn-sm\"' +
                    'href=\"/karyawan/tutor/sertifikat/belakang/'+IDKursus+'\" target=\"blank\" role=\"button\">'+
                    'Sertifikat Belakang</a>'+
                    '<a class=\"btn btn-primary btn-sm\" '+
                    'href=\"/karyawan/tutor/rapor/'+IDKursus+'\" target=\"blank\" role=\"button\">'+
                    'Rapor</a>'
                )
            }
            // if(SertifikasiKursus.length ===0&&Nilai.length>0){
            //     $('#button-evaluasi').append(
            //         '<button type=\"button\" class=\"btn btn-success btn-sm\">Tutup kursus</button>'
            //     )
            // }
        }
        function updateEvaluasiFinal(){
            $.ajax({
                type: "post",
                url: "/karyawan/tutor/nilai/evaluasifinal/update",
                data:$('#form-edit-evaluasi-final').serialize(),
                success: function (response) {
                    $('#modal-edit-ef').modal('hide')
                    swal(response)
                    getData()
                }
            });
        }
        function storeEvaluasiFinal(){
            $.ajax({
                type: "post",
                url: "/karyawan/tutor/nilai/evaluasifinal/store",
                data:$('#form-create-evaluasi-final').serialize(),
                success: function (response) {
                    $('#modal-create-ef').modal('hide')
                    swal(response)
                    getData()
                }
            });
        }
        function appendJenisNilaiOption(){
            $('#option-jenis-nilai').append('<option value=\'0\'>Pilih</option>')
            JenisNilai.forEach(ele=>{
                $('#option-jenis-nilai').append(
                    '<option value=\''+ele.IDJenisNilai+'\'>'+ele.Jenis+'</option>'
                )
            })
        }
        function showDataNilai(){
            TableNilai.clear().draw()
            let i =0
            Nilai.forEach(ele=>{
                i++
                let btn_del = '<a class=\"btn btn-danger\"'+
                        'onclick=\"deleteData('+ele.IDNilai+')\"'+
                        'href=\"javascript:void(0)\" role=\"button\"><i class=\"fa fa-trash\"></i></a></a>'
                TableNilai.row.add([
                    i,
                    ele.NamaNilai,
                    ele.Jenis,
                    ele.Nilai,
                    btn_del
                ]).draw()
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
                    $.get('/karyawan/tutor/nilai/destroy/'+id).done(ele=>{
                        swal(ele)
                        getData()
                    })
                } else {
                    swal("Dibatalkan!");
                }
            });
        }
    </script>
@endpush
@endsection