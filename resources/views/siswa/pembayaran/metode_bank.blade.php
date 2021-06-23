@extends('siswa.layouts.nav')
@section('title','Info pembayaran')
@section('step','info')
@section('content')
<div class="col nav-pembayaran shadow-sm">
    <ul class="step-nav my-3">
        <li class="detail active">
            Detail
        </li>
        <li class="metode active">
            Metode Pembayaran
        </li>
        <li class="pembayaran">
            Pembayaran 
        </li>
    </ul>
</div>

<div class="title-item mt-2">
    <i class="fa fa-shopping-cart"></i>
    Transfer pembayaran
</div>
<div class="card mt-2 item shadow-sm">
    <div class="item-info">
        <span class="item-title">
            Nama Rekening:
        </span>
        <p class="item-data">
            {{$Pembayaran['Pembayaran'][0]->NamaRekening}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Nomor Rekening:
        </span>
        <p class="item-data">
            {{$Pembayaran['Pembayaran'][0]->NoRekening}}
        </p>
    </div>
        
    <div class="item-info">
        <span class="item-title">
            Batas Waktu:
        </span>
        <p class="item-data">
            {{
                date('d M Y, h:m',strtotime(
                    '+1 day',strtotime( $Pembayaran['Pembayaran'][0]->created_at)
                ))
            }}
        </p>
    </div>

    <div class="item-harga">
        <span class="item-title">
            Total Pembayaran :
        </span>
        <p class="item-data">
            Rp {{number_format($Pembayaran['Pembayaran'][0]->Total)}}
        </p>
    </div>
</div>

<div class="title-item mt-2">
    <i class="fa fa-file-text"></i>
    Bukti Pembayaran
</div>
<form action="{{url('/siswa/pembayaran/bukti')}}" 
class="form"
enctype="multipart/form-data" method="POST">
@csrf
    <div class="card mt-2 item shadow-sm">
        <div class="col-md-12 my-4 " style="width: 80%;margin-left:auto;margin-right:auto"
        id="tabdaftar">
            <input type="hidden" value="{{$Pembayaran['Pembayaran'][0]->IDPembayaran}}" name="idpembayaran">
            <div class="mb-3">
                <label for="formFile" class="form-label">Bukti Pembayaran</label>
                <input class="form-control" name="file" type="file" id="formFile">
            </div>
            <div class="form-floating ">
                <input id='inUsernameDaftar' autocomplete="off" type="text" class="form-control form-control-sm ss-input" name="namarekening" placeholder="username" id="floatingInput">
                <label for="inUsernameDaftar">
                    Nama Rekening
                </label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm ss-input" name="norekening" placeholder="username" 
                id="inNoHP">
                <label for="inNoHP">Nomor Rekening</label>
            </div>
            <select name="bank" required class="form-select mt-3 ss-input" 
            id="inJenisKelamin"aria-label="Default select example">
                <option value="11" selected>Nama Bank</option>
                @foreach ($Bank as $bank)    
                <option value="{{$bank->IDBank}}">{{$bank->NamaBank}}</option>
                @endforeach
            </select> 
            <div class="form-floating ">
                <input type="hidden" name="jumlah" id="valJumlah">
                <input id='displayJumlah' autocomplete="off" type="text" 
                class="form-control form-control-sm ss-input" 
                onkeyup="formatInputJumlah()" style="font-size: 25px"
                placeholder="Jumlah" id="floatingInput">
                <label for="inUsernameDaftar">
                    Jumlah di transfer
                </label>
            </div>
            <div id="validNoHP" class="validasi"></div>
        </div>
    </div>
    <div class="card item mt-4 shadow-sm">

        <button type="submit" class="btn btn-primary my-3">
            Upload Bukti Pembayaran
        </button>
    </div>
</form>
<script>
    let jumlahTransfer=0;
    function formatInputJumlah(){
        let inputJumlah = document.getElementById('displayJumlah');
        let jumlahTransferString = inputJumlah.value;
        let cleanJumlahTransfer = jumlahTransferString.replace(/[\D\s\._\-]+/g, "")
        jumlahTransfer = parseInt(cleanJumlahTransfer)
        inputJumlah.value = jumlahTransferString == ""? 0 : jumlahTransfer.toLocaleString( "en-US")
        document.getElementById('valJumlah').value = jumlahTransfer
    }
</script>
@endsection