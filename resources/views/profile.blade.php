@extends('karyawan.layouts.layout')
@section('title',$Data[0]->NamaKaryawan)
@section('content')
<style>
  .input-profile{
      cursor: pointer;
  }
  .ss-input{
      border-radius:0px;
  }
  .ss-input-danger{
      border-radius:0px;
      border: solid 1px rgb(248, 2, 2)
  }
</style>


<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Profile </h2>
        <ul class="nav navbar-right panel_toolbox">


          <li>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-3 col-sm-3  profile_left">
          <div class="profile_img">
            <div id="crop-avatar">
              <!-- Current avatar -->
              <img class="img-responsive avatar-view" 
              style="max-height: 200px;max-width:200px;height: 200px;width:200px;object-fit:cover"
                src="{{$Data[0]->PhotoProfile}}" alt="Avatar" title="Change the avatar">
            </div>
          </div>
          <h3>{{$Data[0]->NamaKaryawan}}</h3>

          <ul class="list-unstyled user_data">
            <li><i class="fa fa-map-marker user-profile-icon"></i> {{$Data[0]->Alamat}}
            </li>

            <li>
              @if ($Data[0]->JenisKelamin=='laki-laki')
              <i class="fa fa-male" aria-hidden="true"></i>
              @else
              <i class="fa fa-female" aria-hidden="true"></i>
              @endif
              {{$Data[0]->JenisKelamin}}
            </li>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" 
            data-toggle="modal" data-target="#modalUbahPassword">
              Ubah password
            </button>
          </ul>

<!-- Modal ubah password-->
<div class="modal fade" id="modalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form-ubah-password" action="{{url('karyawan/password/update')}}"
      method="POST">
      @csrf
      <div class="modal-body">
        <div class="container-fluid">
          <div class="form-group">
            <label for="">Password baru</label>
            <input type="password"
              class="form-control" name="newpassword" id="new-password" aria-describedby="helpId" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Konfirmasi password baru</label>
            <input type="password"
              id="confirm-new-password"
              class="form-control" name="" 
              aria-describedby="helpId" placeholder="">
              <small id="help-confirm-password" class="form-text text-danger"></small>
          </div>
          <div class="form-group">
            <label for="">Masukan password lama</label>
            <input type="password"
              class="form-control" name="oldpassword" id="" aria-describedby="helpId" placeholder="">
          </div>
  
          
        </div>
      </div>
    </form>
    <div class="modal-footer">
      <button type="button" onclick="changePassword()" class="btn btn-primary">Ganti</button>
    </div>
    </div>
  </div>
</div>


          <br />

        </div>
        <form action="{{url('karyawan/profile/update')}}" id="formdata" method="POST">
          @csrf
          <div class="col-md-7 col-sm-7">
              <input type="hidden" name="uid" value="{{$Data[0]->UUID}}">
              <input type="hidden" name="iduser" value="{{$Data[0]->IDKaryawan}}">
              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" readonly
                  value="{{$Data[0]->NamaKaryawan}}"
                  class="rounded  form-control input-profile" name="nama" id="inNama" aria-describedby="helpId" placeholder="">
                <small id="helpId" class="form-text "></small>
              </div>
              <div class="form-group">
                  <label for="">Username</label>
                  <input type="text" readonly 
                      value="{{$Data[0]->Username}}"
                      class="rounded  form-control input-profile" name="username" id="inUsername" aria-describedby="helpId" placeholder="">
                  <small id="validUsername" class="form-text "></small>
              </div>
              <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" readonly 
                      value="{{$Data[0]->Email}}"
                      class="rounded  form-control input-profile" name="email" id="inEmail" aria-describedby="helpId" placeholder="">
                  <small id="validEmail" class="form-text "></small>
              </div>
              <div class="form-group">
                  <label for="">Photo Profile   
                      <small id="helpId" class="form-text ">Contoh URL gambar : https://google.com/profile.png</small>
                  </label>
                  <input type="text" readonly
                  value="{{$Data[0]->PhotoProfile}}"
                    class="rounded  form-control input-profile" name="photoprofile" id="inPhotoProfile" aria-describedby="helpId" placeholder="">
              </div>
              <div class="form-group">
                <label for="">Alamat</label>
                <textarea readonly
                class="rounded  form-control input-profile" name="alamat" id="inAlamat" rows="3">{{$Data[0]->Alamat}}</textarea>
              </div>
              <div class="form-group">
                <label for="">No HP</label>
                <input type="text" readonly
                value="{{$Data[0]->NoHP}}"
                 class="rounded  form-control input-profile" name="nohp" id="inNoHP" aria-describedby="helpId" placeholder="">
                <small id="helpId" class="form-text "></small>
              </div>
          </div>
          <div class="col-md-2 col-sm-2 ">
              <a  name="" id="btn-edit" onclick="switchMode('edit')" class="btn btn-primary" href="javascript:void(0)" role="button"> Mode Edit</a>
              <a  name="" style="display: none" id="btn-batal" onclick="switchMode('view')" class="btn btn-primary" href="javascript:void(0)" role="button"> Batal</a>
              <a   style="display: none"  id="btn-reset" onclick="resetForm()" class="btn btn-primary" href="javascript:void(0)" role="button"> Reset</a>
              <button  style="display: none"   id="btn-save" class="btn btn-primary" type="submit" role="button">Save</button>
              <a  style="display: none"   id="btn-save-false" class="btn disabled btn-danger text-white"  role="button">Save</a>
          </div>
          </form>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="msg" value="{{Session::get('msg')}}">
@endsection
@push('scripts')

<script>
    let valid = true;
    let profile = [];
    $(document).ready(function () {
        $('#tabeldata').DataTable();
        profile = {
          'nama':$('#inNama').val(),
          'username':$('#inUsername').val(),
          'email':$('#inEmail').val(),
          'photo':$('#inPhotoProfile').val(),
          'alamat':$('#inAlamat').val(),
          'nohp':$('#inNoHP').val()
        };

        if($('#msg').val()){
            swal({
                icon: 'success',
                title: $('#msg').val(),
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
    function switchMode(mode){
        switch(mode){
            case 'edit':
                $('.input-profile').attr('readonly',false);
                $('#btn-edit').hide();
                $('#btn-batal').show();
                showButtonSave();
                break;
            case 'view':
              resetForm();
                $('.input-profile').attr('readonly',true);
                $('#btn-batal').hide();
                showButtonSave();
                $('#btn-edit').show();
                $('#btn-save').hide();
                break;
        }
    }
    $(function(){
        $('#inUsername').keyup(function(){
            cekUsername($('#inUsername'));
        });
        $('#inEmail').keyup(function(){
            cekEmail($('#inEmail'));
        });
        $('#formdata').keyup(function(){
            checkShowResetBtn();
        });
    });

    function resetForm(){
      $('.input-profile').attr('readonly',false);
      $('#inNama').val(profile.nama);
      $('#inUsername').val(profile.username);
      $('#inEmail').val(profile.email);
      $('#inPhotoProfile').val(profile.photo);
      $('#inAlamat').val(profile.alamat);
      $('#inNoHP').val(profile.nohp);
      checkShowResetBtn();
    }
    function checkShowResetBtn(){
      if(
        $('#inNama').val() != profile.nama ||
        $('#inUsername').val()!=profile.username||
        $('#inEmail').val()!= profile.email||
        $('#inPhotoProfile').val()!=profile.photo||
        $('#inAlamat').val()!=profile.alamat||
        $('#inNoHP').val()!= profile.nohp
      ){
        $('#btn-reset').show()
      }else{
        $('#btn-reset').hide()
      }

    }
    function showButtonSave(){
      if(valid){
        $('#btn-save').show();
        $('#btn-save-false').hide();
      }else{
        $('#btn-save-false').show();
        $('#btn-save').hide();
      }
    }
    function cekUsername(ele){
        $.post('/auth/cekusername/',$('#formdata').serialize(),data=>
            validasiInput(ele,data,$('#validUsername'),'* Username sudah dipakai!')
        );
    }
    function cekEmail(ele){
        $.post('/auth/cekemail/',$('#formdata').serialize(),data=>
            validasiInput(ele,data,$('#validEmail'),'* Email sudah dipakai!')
        );
    }
    function validasiInput(ele,status,elePesan,pesan){
        if(pesan == '* Username sudah dipakai!'&& (status==0||profile.username==$('#inUsername').val())){
            valid = true;
            showButtonSave();
            ele.addClass('ss-input');
            ele.removeClass('ss-input-danger');
            elePesan.hide();
            elePesan.empty();
            return true;
        }if(pesan == '* Email sudah dipakai!'&& (status==0||profile.email==$('#inEmail').val())){
            valid = true;
            showButtonSave();
            ele.addClass('ss-input');
            ele.removeClass('ss-input-danger');
            elePesan.hide();
            elePesan.empty();
            return true;
        }else if(status==0){
            valid = true;
            showButtonSave();
            ele.addClass('ss-input');
            ele.removeClass('ss-input-danger');
            elePesan.hide();
            elePesan.empty();
            return true;
        }else{
            valid = false;
            showButtonSave();
            ele.addClass('ss-input-danger');
            ele.removeClass('ss-input');
            elePesan.empty();
            elePesan.append(pesan);
            elePesan.addClass('text-danger');
            elePesan.show();
            return false;
        }
    }
    function changePassword(){
      let newPass = $('#new-password').val();
      let confirmPass = $('#confirm-new-password').val();
      console.log(newPass,confirmPass);
      if(newPass == confirmPass){
        $('#form-ubah-password').submit();
      }else{
        $('#help-confirm-password').html('password tidak sama');
      }
    }
</script>
@endpush