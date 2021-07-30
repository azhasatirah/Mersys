@extends('karyawan.layouts.layout')
@section('title','Diskon promo')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Promo <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-primary btn-sm" 
                    data-toggle="modal" data-target="#modalcreate" >
                        Tambah promo 
                    </button>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    
                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Diskon</th>
                                <th>Nama Siswa</th>
                                <th>Nilai</th>
                                <th>Program</th>
                                <th>Dibuat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="data-table">
    
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
</div>

<!-- {{-- Modal create data --}} -->
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah promo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formdata">
      @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">Nama Siswa</label>
                <select class="custom-select" name="idsiswa" id="input-create-siswa"> </select>
            </div>
            <div class="form-group">
              <label for="">Diskon</label>
              <input type="number" class="form-control" name="nilai" id="input-create-nilai" aria-describedby="helpId" placeholder="">
            </div>
            <div class="form-group">
                <label for="">Program</label>
                <select class="custom-select" name="idprogram" id="input-create-program">
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button onclick="store()" type="button" class="btn btn-primary">Tambah</button>
        </div>
        </form>
    </div>
  </div>
</div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            getData()
            $('#tabeldata').DataTable({
             
            });
        });
        function store(){
            $.ajax({
                type: "post",
                url: "/karyawan/admin/diskon/store",
                data: $('#formdata').serialize(),
                success: function (response) {
                    getData()
                    $('#modalcreate').modal('hide')
                    swal(response)
                }
            });
        }
        function getData(){
            $.get("/karyawan/admin/diskon/getdata",(ele)=>{
                let inputSiswa = $('#input-create-siswa')
                let promo = $('#data-table')
                inputSiswa.empty()
                promo.empty()
                inputSiswa.append("<option>Pilih</option>")
                ele[1].forEach((ele)=>{
                    inputSiswa.append(
                        "<option value=\""+ele.IDSiswa+"\">"+ele.NamaSiswa+"</option>"
                    )
                })
                ele[2].forEach(ele=>{
                    $('#input-create-program').append(
                        "<option value=\""+ele.IDProgram+"\">"+ele.NamaProdi+"</option>"
                    );
                })
                let i =0
                ele[0].forEach((ele)=>{
                    i++
                    let btnDelete = 
                    "<a onclick=\"deleteData("+ele.IDDiskon+")\" class=\"btn btn-sm text-white btn-danger\" href=\"javascript:void(0)\" role=\"button\">"+
                        "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i>"+
                    "</a>"
                    promo.append(
                        "<tr>"+
                            "<td>"+i+"</td>"+
                            "<td>"+ele.KodeDiskon+"</td>"+
                            "<td>"+ele.NamaSiswa+"</td>"+
                            "<td>Rp "+ele.Nilai.toLocaleString('id-ID')+"</td>"+
                            "<td>"+ele.NamaProdi+"</td>"+
                            "<td>"+ele.created_at+"</td>"+
                            "<td>"+btnDelete+"</td>"+
                        "</tr>"
                    )
                })
            })
        }

        function deleteData(id){
            swal({
                title: "Anda yakin?",
                text: "Promo di siswa akan hilang!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.get("/karyawan/admin/diskon/delete/"+id,(ele)=>{
                        getData()
                        swal(ele)
                    })
                } else {
                    swal("Dibatalkan!");
                }
            })

        }
    </script>
@endpush