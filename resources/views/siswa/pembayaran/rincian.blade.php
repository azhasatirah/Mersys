@extends('siswa.layouts.nav')
@section('title','Rincian Pembayaran')
@section('content')
<div class="col nav-pembayaran shadow-sm">
    <ul class="step-nav my-3">
        <li class="detail ">
            Rincian Pembayaran
        </li>
    </ul>
</div>
<div class="title-item mt-2">
    <i class="fa fa-shopping-cart"></i>
    Info Pembelian
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
            Total transaksi:
        </span>
        <p class="item-data">
            Rp {{number_format($Pembayaran[0]->Total)}}
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
</div>

<div class="title-item mt-2">
    <i class="fa fa-file-text"></i>
    Detail Pembayaran
</div>
@foreach ($BuktiPembayaran as $pembayaran)
    <div class="card mt-2 item shadow-sm">
        @if ($Pembayaran[0]->Hutang == 'y')
        <div class="p-4">
            <h4>Pembayaran ke {{$pembayaran->NoUrut}}</h4>
        </div>
        @endif
        <div class="item-info">
            <span class="item-title">
                Nama Rekening:
            </span>
            <p class="item-data">
                {{$pembayaran->NamaRekening}}
            </p>
        </div>
        <div class="item-info">
            <span class="item-title">
                No Rekening:
            </span>
            <p class="item-data">
                {{$pembayaran->NoRekening}}
            </p>
        </div>
        <div class="item-info">
            <span class="item-title">
                Di bayar tanggal:
            </span>
            <p class="item-data">
                {{$pembayaran->created_at}}
            </p>
        </div>
        <div class="item-info">
            <span class="item-title">
                Status:
            </span>
            <p class="item-data">
                @php 
                    if($Pembayaran[0]->Status=='OPN' && count($BuktiPembayaran)==0){echo 'Lakukan pembayaran dan upload bukti pembayaran';}
                    elseif($Pembayaran[0]->Status=='OPN' && count($BuktiPembayaran)>0){echo 'Sedang di cek Admin';}
                    elseif($Pembayaran[0]->Status=='CMF' && count($BuktiPembayaran)>0){echo 'Sedang di cek Owner';}
                    elseif($pembayaran->Status=='CLS'){echo 'Di konfirmasi';}
                    else{echo 'Dibatalkan';}
                @endphp
            </p>
        </div>
        <div class="item-info">
            <span class="item-title">
                Jumlah Ditransfer:
            </span>
            <p class="item-data">
                Rp. {{number_format($pembayaran->JumlahDitransfer)}}
            </p>
        </div>
    </div>
@endforeach
<div class="card item mt-4 shadow-sm">
    @if (session()->get('StatusUser')=='CFM')
    @endif
    @if (count($PembayaranOPN)>0)
        
    <a href="{{url('siswa/pembayaran/metode/bank')}}/{{$PembayaranOPN[0]->UIDPembayaran}}" class="btn btn-success mt-3">
        Bayar cicilan ke {{$PembayaranOPN[0]->NoUrut}}
    </a>
    @endif
    <a href="{{url('siswa/transaksi')}}" class="btn btn-primary mt-2 mb-3">
        Lihat Riwayat Transaksi
    </a>
</div>
@endsection
