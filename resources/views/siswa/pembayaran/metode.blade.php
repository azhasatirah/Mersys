@extends('siswa.layouts.nav')
@section('title','Metode pembayaran')
@section('content')
<div class="col nav-pembayaran shadow-sm">
    <ul class="step-nav my-3">
        <li class="detail active">
            Detail
        </li>
        <li class="metode ">
            Metode Pembayaran
        </li>
        <li class="pembayaran">
            Pembayaran 
        </li>
    </ul>
</div>
<form action="{{url('siswa/pembayaran/metode/bank')}}" class="form" method="POST">
    @csrf
    <div class="title-item mt-2">
        <i class="fa fa-credit-card-alt"></i>
        Pilih Metode Pembayaran
    </div>
    <div class="card mt-2 item shadow-sm">

        <div class="item-info">
            <span class="item-title">
                Transfer Bank:
            </span>
            @foreach ($Metode as $MetodeBank)
            <div class="form-check">
                <input class="form-check-input" class="input-bank" value="{{$MetodeBank->IDMetodePembayaran}}"
                    type="radio" name="metode">
                <label class="form-check-label" for="flexRadioDefault1">
                    <img class="logo-bank" src="{{asset('images/logo-bank')}}/{{$MetodeBank->LogoBank}}" alt=""
                        srcset="">
                </label>
            </div>
            @endforeach
        </div>

    </div>
    <input type="hidden" value="{{$KodeTransaksi}}" name="transaksi">
    <div class="card item mt-4 shadow-sm">
        <button type="submit" class="btn btn-primary my-3">
            Gunakan Metode ini
        </button>
    </div>
</form>
@endsection
