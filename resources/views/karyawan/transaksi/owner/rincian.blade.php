@extends('karyawan.layouts.nav')
@section('title','Info pembayaran')
@section('step','info')
@section('content')
<div class="title-item mt-2">
    <i class="fa fa-shopping-cart"></i>
    Info Transaksi
</div>
<div class="card mt-2 item shadow-sm">
    <div class="item-info">
        <span class="item-title">
            Kode Transaksi:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->KodeTransaksi}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Total Transaksi:
        </span>
        <p class="item-data">
            Rp {{number_format($Pembayaran[0]->TotalTransaksi)}}
        </p>
    </div>
    @if ($Pembayaran[0]->Hutang=='y')
        
    <div class="item-info">
        <span class="item-title">
            Cicilan Ke :
        </span>
        <h3 class="item-data">
            {{$Pembayaran[0]->NoUrut}}
        </h3>
    </div>
    @endif

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
            {{$Pembayaran[0]->NamaRekening}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Nomor Rekening:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->NoRekening}}
        </p>
    </div>
        
    <div class="item-info">
        <span class="item-title">
            Batas Waktu:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->created_at}}
        </p>
    </div>

    <div class="item-harga">
        <span class="item-title">
            Total Pembayaran :
        </span>
        <p class="item-data">
            Rp {{number_format($Pembayaran[0]->Total)}}
        </p>
    </div>
</div>

<div class="title-item mt-2">
    <i class="fa fa-file-text"></i>
    Bukti Pembayaran
</div>

    <div class="card mt-2 item shadow-sm">
        <div class="col-md-12 my-4 " style="width: 80%;margin-left:auto;margin-right:auto"
        id="tabdaftar">
            <input type="hidden" value="{{$Pembayaran[0]->IDPembayaran}}" name="idpembayaran">
            <div class="mb-3">
                <img src="{{asset('images/BuktiPembayaran')}}/{{$Pembayaran[0]->BuktiFoto}}" 
                style="width:400px;height:100%"
                alt="" srcset="">
            </div>
            <div class="form-floating ">
                <input id='inUsernameDaftar' autocomplete="off" type="text" class="form-control form-control-sm ss-input"
                value="{{$Pembayaran[0]->NamaRekeningPengirim}}"
                 name="namarekening" placeholder="username" id="floatingInput" readonly>
                <label for="inUsernameDaftar">
                    Nama Rekening
                </label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm ss-input"
                value="{{$Pembayaran[0]->NoRekeningPengirim}}"
                name="norekening" placeholder="username" 
                id="inNoHP" readonly>
                <label for="inNoHP">Nomor Rekening</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm ss-input"
                value="{{$Pembayaran[0]->BankPengirim}}"
                name="norekening" placeholder="username" 
                id="inNoHP" readonly>
                <label for="inNoHP">Bank</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control form-control-sm ss-input"
                value="Rp {{number_format($Pembayaran[0]->JumlahDitransfer)}}"
                name="norekening" placeholder="username" 
                id="inNoHP" readonly>
                <label for="inNoHP">Jumlah Ditransfer</label>
            </div>
            <div id="validNoHP" class="validasi"></div>
        </div>
    </div>
    <div class="card  item mt-2 mb-2 shadow-sm">
        @if ($Pembayaran[0]->StatusPembayaran == 'CFM')  
        <a onclick="confirmTransaksi()"  class="btn btn-sm btn-block mt-3 mb-1  btn-success ">
            Konfirmasi
        </a>
        <form id="form-konfirmasi" action="{{url('karyawan/owner/transaksi/konfirmasi')}}" 
        method="post">
        @csrf
            <input type="hidden" name="pembayaran" value="{{$Pembayaran[0]->KodePembayaran}}">
        </form>
        @endif
        <a type="submit" href="{{url('karyawan/owner/transaksi')}}" class="btn mb-3 btn-sm   btn-primary ">
            Kembali
        </a>
    </div>
    <script>
        function confirmTransaksi(){
            document.getElementById('form-konfirmasi').submit()
        }
    </script>

@endsection