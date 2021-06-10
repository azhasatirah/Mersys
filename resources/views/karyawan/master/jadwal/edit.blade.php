@extends('karyawan.layouts.layout')
@section('title','Masukkan Jadwal')
@section('content')
<div class="page-title">
    <div class="title_left">
        <h3>Jadwal Murid</h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5  form-group pull-right top_search">

        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Masukkan Jadwal <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="editjadwal" method="POST" data-parsley-validate 
                action="{{url('/karyawan/master/jadwal/update')}}"
                class="form-horizontal form-label-left">
                @csrf
                <input type="hidden" name="kode" value="">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Siswa<span
                            class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="level" id="first-name" placeholder='siswa1' required="required" class="form-control "  disabled>
                    </div>
                </div>
                <input type="hidden" name="kode" value="">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Program Studi <span
                            class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" name="level" id="first-name" placeholder='Program Studi' required="required" class="form-control "  disabled>
                    </div>
                </div>

                    <input type="hidden" name="kode" value="">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Hari <span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" name="level" id="first-name" placeholder='Hari' required="required" class="form-control ">
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <a href="{{url('/karyawan/master/jadwal')}}" class="btn btn-primary" type="button">Batal</a>
                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
