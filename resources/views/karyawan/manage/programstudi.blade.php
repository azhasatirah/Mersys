@extends('karyawan.layouts.layout')
@section('title','Program Studi')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Program Studi <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a  class="btn btn-primary btn-sm" 
                    href="{{url('karyawan/admin/master/program/create')}}" >
                        Tambah Program 
                    </a>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="tabeldata" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Program</th>
                            <th>Nama Program</th>
                            <th>Total Pertemuan</th>
                            <th>Harga</th>
                            <th>Cicilan</th>
                            <th>Level</th>
                            <th>Kategori</th>
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
                <label for="recipient-name" class="col-form-label">Nama Program:</label>
                <input type="text" name="namaprogram"class="form-control" >
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Total Pertemuan:</label>
                <input type="text" name="totalpertemuan"class="form-control" >
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Harga:</label>
                <input type="text" name="harga"class="form-control" >
            </div>
            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Level:</label>
                <select name="level"class="select2_single form-control" tabindex="-1">
                    <option>Pilih</option>
                    @foreach($LevelProgram["LevelProgram"] as $Level)
                    <option value="{{$Level->IDLevel}}">{{$Level->NamaLevel}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Kategori Program:</label>
                <select name="kategoriprogram"class="select2_single form-control" tabindex="-1">
                    <option>Pilih</option>
                    @foreach($KategoriProgram["KategoriProgram"] as $KategoriProgram)
                    <option value="{{$KategoriProgram->IDKategoriProgram}}">{{$KategoriProgram->KategoriProgram}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Cicilan:</label>
                <select  name="cicilan" id="cicilancreate" class="select2_single form-control" tabindex="-1">
                    <option value="y">Ya</option>
                    <option selected value="n">Tidak</option>
                </select>
            </div>
            <div id="hargacicilancreate"></div>
            <div id="tambahcicilancreate"></div>
 
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
                  <label for="recipient-name" class="col-form-label">Program:</label>
                  <input type="text" id="editprogram" name="namaprodi"class="form-control" >
                  <input type="hidden" name="id" id="editid">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Total Pertemuan:</label>
                <input type="text" id="edittotalpertemuan" name="totalpertemuan"class="form-control" >
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Harga:</label>
                <input type="text" id="editharga" name="harga"class="form-control" >
            </div>
            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Level:</label>
                <select id="editlevel" name="level"class="select2_single form-control" tabindex="-1">
                </select>
            </div>
            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Kategori:</label>
                <select id="editkategori" name="kategori"class="select2_single form-control" tabindex="-1">
                </select>
            </div>

            <div class="form-group ">
                <label for="recipient-name" class="col-form-label">Cicilan:</label>
                <select id="editcicilan" name="cicilan"class="select2_single form-control" tabindex="-1">
                    <option value="y">Ya</option>
                    <option value="n">Tidak</option>
                </select>
            </div>
            <div id="hargacicilanedit"></div>
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
    <script src="{{asset('assets/js/master/programstudi.js')}}"></script>

@endpush