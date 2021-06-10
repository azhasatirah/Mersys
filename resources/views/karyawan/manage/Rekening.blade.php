@extends('karyawan.layouts.layout')
@section('title',' Rekening')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Rekening <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <button type="button" class="btn btn-primary btn-sm" 
                    data-toggle="modal" data-target="#modalcreate" >
                        Tambah Rekening 
                    </button>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Rekening</th>
                            <th>Nomor Rekening</th>
                            <th>Nama Bank</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
    
            </div>
        </div>
    </div>
</div>

{{-- Modal create data --}}
<div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formdata">
      @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nama Rekening:</label>
                <input type="text" name="namarekening"class="form-control" >
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nomor Rekening:</label>
                <input type="text" name="nomorrekening"class="form-control" >
            </div>
            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Nama Bank:</label>
                <select name="bank"class="select2_single form-control" tabindex="-1">
                    <option>Pilih</option>
                    @foreach($Bank["Bank"] as $Bank)
                    <option value="{{$Bank->IDBank}}">{{$Bank->NamaBank}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button id="tombolcreate" type="button" class="btn btn-primary">Tambah</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Modal create data --}}
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formdataedit">
        @csrf
          <div class="modal-body">
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Nama Rekening:</label>
                  <input type="text" id="editnamarekening" name="namarekening"class="form-control" >
                  <input type="hidden" name="id" id="editid">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Nomor Rekening:</label>
                <input type="text" id="editnorekening" name="nomorrekening"class="form-control" >
        
            </div>
              <div class="form-group ">
                  <label for="recipient-name" class="col-form-label">Bank:</label>
                  <select id="editbank" name="bank"class="select2_single form-control" tabindex="-1">
                  </select>
              </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button id="tomboledit" type="button" class="btn btn-primary">Edit</button>
          </div>
          </form>
      </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('assets/js/master/rekening.js')}}"></script>

@endpush