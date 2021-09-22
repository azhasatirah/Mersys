@extends('siswa.layouts.nav')
@section('title','Info Transaksi')
@section('content')
<div class="col nav-pembayaran shadow-sm">
    <ul class="step-nav my-3">
        <li class="detail ">
            Detail
        </li>
        <li class="metode">
            Metode Pembayaran
        </li>
        <li class="pembayaran">
            Pembayaran 
        </li>
    </ul>
</div>
<div class="title-item mt-2">
    <i class="fa fa-shopping-cart"></i>
    Info Transaksi
</div>
<div class="card mt-2 item shadow-sm">
    <div class="item-info">
        <span class="item-title">
            Nama:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->NamaSiswa}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Program:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->NamaProdi}}
        </p>
    </div>
    @if ($Pembayaran[0]->KategoriProgram!=='Costum')
        
    <div class="item-info">
        <span class="item-title">
            Kategori:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->KategoriProgram}}
        </p>
    </div>
    @endif
    @if ( $Pembayaran[0]->TotalPertemuan!==0)
        
    <div class="item-info">
        <span class="item-title">
            Total Pertemuan:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->TotalPertemuan}}
        </p>
    </div>
    @endif
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
            Tanggal Pembelian:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->Tanggal}}
        </p>
    </div>
    @if ( $Pembayaran[0]->Hutang=='y')
    <div class="item-harga">
        <span class="item-title">
            Harga :
        </span>
        <p class="item-data">
           Rp. {{number_format($Pembayaran[0]->Total)}}
        </p>
    </div>
    @endif
</div>

<div class="title-item mt-2">
    <i class="fa fa-file-text"></i>
    Detail Pembayaran
</div>
<div class="card mt-2 item shadow-sm">

    <div class="item-info">
        <span class="item-title">
            Program:
        </span>
        <p class="item-data">
            {{$Pembayaran[0]->NamaProdi}}
        </p>
    </div>
    @if (isset($Cicilan))
    <div class="item-harga">
        <span class="item-title">
            Pembayaran ke 1
        </span>
        <p class="item-data">
        Rp. {{number_format(
                $Cicilan[0]->Harga/$Cicilan[0]->Cicilan + ($Pembayaran[0]->Total-$Cicilan[0]->Harga)
            )}}
        </p>
    </div>
    @else
        <div class="item-harga">
            <span class="item-title">
                Total Pembayaran:
            </span>
            <p class="item-data">
            Rp. {{number_format($Pembayaran[0]->Total)}}
            </p>
        </div>
    @endif

</div>
<div class="card item mt-4 shadow-sm">

    <a href="{{url('siswa/pembayaran/metode')}}/{{$Pembayaran[0]->UUID}}" class="btn btn-primary my-3">
        Pilih Metode Pembayaran
    </a>
</div>
@endsection