@extends('karyawan.layouts.nav')
@section('title','Info pembayaran')
@section('step','info')
@section('content')
@if (count($Transaksi)>0)
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
            {{$Transaksi[0]->KodeTransaksi}}
        </p>
    </div>

    <div class="item-info">
        <span class="item-title">
            Jenis transaksi :
        </span>
        <p class="item-data">
            {{$Transaksi[0]->Hutang=='y'?'Transaksi hutang':'Transaksi lunas'}}
        </p>
    </div>
    <div class="item-info">
        <span class="item-title">
            Tanggal dibuat:
        </span>
        <p class="item-data">
            {{$Transaksi[0]->created_at}}
        </p>
    </div>
    <div class="item-harga">
        <span class="item-title">
            Total Transaksi :
        </span>
        <p class="item-data">
            Rp {{number_format($Transaksi[0]->Total)}}
        </p>
    </div>
</div>

@if (count($Pembayaran)>0)
<div class="title-item mt-2">
    <i class="fa fa-file-text"></i>
    Rincian pembayaran
</div>
    {{-- list pembayaran --}}
    @foreach ($Pembayaran as $pembayaran)    
        <div 
        id="p{{$pembayaran['UUIDPembayaran']}}"
         class="card mt-2 item shadow-sm">
            <div class="item-info">
                <span class="item-title">
                    No Urut:
                </span>
                <p class="item-data">
                    {{$pembayaran['NoUrut']}}
                </p>
            </div>
            <div class="item-info">
                <span class="item-title">
                    Kode Pembayaran:
                </span>
                <p class="item-data">
                    {{$pembayaran['KodePembayaran']}}
                </p>
            </div>
            <div class="item-info">
                <span class="item-title">
                    Metode Pembayaran:
                </span>
                <p class="item-data">
                    {{$pembayaran['MetodePembayaran']}}
                </p>
            </div>
            <div class="item-info">
                <span class="item-title">
                    Total Pembayaran:
                </span>
                <p class="item-data">
                    Rp {{number_format($pembayaran['Total'])}}
                </p>
            </div>
            <div class="item-info">
                <span class="item-title">
                    Batas Waktu:
                </span>
                <p class="item-data">
                    {{$pembayaran['created_at']}}
                </p>
            </div>
            <div class="item-harga">
                <span class="item-title">
                    Status Pembayaran:
                </span>
                @php
                    $isAllBuktiDeleted = false;
                    $isAllBuktiDeleted = array_reduce($pembayaran['BuktiPembayaran']->all(), function ($con, $item) {
                        return $con && $item->Status === 'DEL';
                    },true);
                    $StatusPembayaran = '';
                    if($pembayaran['Status']==='OPN'||$isAllBuktiDeleted){
                        $StatusPembayaran = 'Menunggu pembayaran';
                    }
                    if($pembayaran['Status']==='OPN' && !$isAllBuktiDeleted){
                        $StatusPembayaran = 'Menunggu admin';
                    }
                    if($pembayaran['Status']==='CFM'){
                        $StatusPembayaran = 'Menunggu owner';
                    }
                    if($pembayaran['Status']==='CLS'){
                        $StatusPembayaran = 'Selesai';
                    }
                    if($pembayaran['Status']==='DEL'){
                        $StatusPembayaran = 'Dihapus';
                    }
                @endphp
                <p class="item-data">
                    {{$StatusPembayaran}}
                </p>
            </div>   

            <a onclick="showBuktiPembayaran('{{$pembayaran['UUIDPembayaran']}}')" 
            id="bdetailp{{$pembayaran['UUIDPembayaran']}}"
            class="btn btn-sm btn-primary mb-3" href="javascript:void(0)" role="button">
            Show Detail</a>
            {{-- detail pembayaran --}}
            <section id="listbp{{$pembayaran['UUIDPembayaran']}}" style="display: none">
                <div class="item-info">
                    <span class="item-title">
                        Nama Rekening:
                    </span>
                    <p class="item-data">
                        {{$pembayaran['NamaRekening']}}
                    </p>
                </div>
                <div class="item-info">
                    <span class="item-title">
                        Nomor Rekening:
                    </span>
                    <p class="item-data">
                        {{$pembayaran['NoRekening']}}
                    </p>
                </div>
                @if (count($pembayaran['BuktiPembayaran'])>0)
                    
                <div class="title-item mt-2">
                    <i class="fa fa-file-text"></i>
                    Bukti Pembayaran
                </div>
                @endif
                {{-- list bukti pembayaran --}}
                @foreach ($pembayaran['BuktiPembayaran'] as $BuktiPembayaran)  
                <p>Bukti pembayaran ke {{$loop->iteration}}</p>      
                <div class="mb-3">
                    <img src="{{asset('images/BuktiPembayaran')}}/{{$BuktiPembayaran->BuktiFoto}}" 
                    style="width:400px;height:100%"
                    alt="" srcset="">
                </div>
                <div class="form-floating ">
                    <input id='inUsernameDaftar' autocomplete="off" type="text" class="form-control form-control-sm ss-input"
                    value="{{$BuktiPembayaran->NamaRekening}}"
                        name="namarekening" placeholder="username" id="floatingInput" readonly>
                    <label for="inUsernameDaftar">
                        Nama Rekening
                    </label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm ss-input"
                    value="{{$BuktiPembayaran->NoRekening}}"
                    name="norekening" placeholder="username" 
                    id="inNoHP" readonly>
                    <label for="inNoHP">Nomor Rekening</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm ss-input"
                    value="{{$BuktiPembayaran->Bank}}"
                    name="norekening" placeholder="username" 
                    id="inNoHP" readonly>
                    <label for="inNoHP">Bank</label>
                </div>
                <div class="form-floating">
                    <input type="text" class="form-control form-control-sm ss-input"
                    value="Rp {{number_format($BuktiPembayaran->JumlahDitransfer)}}"
                    name="norekening" placeholder="username" 
                    id="inNoHP" readonly>
                    <label for="inNoHP">Jumlah Ditransfer</label>
                </div>
                @if ($BuktiPembayaran->Status == 'OPN' && $pembayaran['Status']==='CFM'&&$pembayaran['Status']!=='CLS')  
                <div>
                    <a onclick="confirmPembayaran('{{$pembayaran['KodePembayaran']}}')"  class="btn btn-sm mt-2 mb-2  btn-success ">
                        Konfirmasi
                    </a>
                    <a onclick="rejectPembayaran('{{$BuktiPembayaran->IDBuktiPembayaran}}')" class="btn btn-sm btn-primary mt-2 mb-2 text-white ">
                        Tolak
                    </a>
                </div>
                @endif
                @if ($pembayaran['Status']==='CFM')  
                <button  class="btn btn-info text-white btn-block btn-sm mt-2 mb-2" role="button">Menunggu dikonfirmasi owner</button>
                @endif
                @if ($BuktiPembayaran->Status == 'DEL' )  
                    <button  class="btn btn-info text-white btn-block btn-sm mt-2 mb-2" role="button">Ditolak</button>
                @endif
                @endforeach
            </section>
        </div>
        @if ($Transaksi[0]->Hutang==='y' && $loop->iteration !== count($Pembayaran))
        <div class="title-item mt-2 text-center text-primary">
            <i style="font-size: 25px;" class="fa fa-arrow-circle-down"></i>
        </div>
        @endif
    @endforeach


@php
    $canDelete = true ;
    $transaksiOngoing = array_reduce($Pembayaran, function ($con, $item) {
        return $con || $item['Status'] === 'CLS';
    });
    if($transaksiOngoing&&$Transaksi[0]->Hutang==='y'){
        $canDelete = false;
    }
    if($Transaksi[0]->Status === 'CLS' &&$Transaksi[0]->Hutang==='y'){
        $canDelete = false;
    }
@endphp
@if ($canDelete)    
<div class="card mt-2 item shadow-sm">
    <a onclick="deleteTransaksi('{{$Transaksi[0]->IDTransaksi}}')" class="btn btn-sm btn-block mt-2 mb-2 btn-danger ">
        Hapus Transaksi
    </a>
</div>
@endif
@else
@endif
@else    
<div class="title-item text-center mt-2">
    <h4 class="text-danger">Transaksi tidak ditemukan</h4>
</div>
<a class="btn btn-primary" href="/karyawan/admin/transaksi" role="button">Kembali</a>
@endif
<script src="{{url('assets/js/sweetalert.js')}}"></script>
<script>
    function showBuktiPembayaran(id){
        const btn_detail_p = $('#bdetailp'+id)
        if($('#listbp'+id).css('display')==='none'){
            $('#listbp'+id).show()
            btn_detail_p.html('Hide Detail')
        }else{
            $('#listbp'+id).hide()
            btn_detail_p.html('Show Detail')
        }
    }
    // id = KodePembayaran
    function confirmPembayaran(id){
        $.get('/karyawan/owner/pembayaran/confirm/'+id).done(res=>{
            swal('Berhasil!','Pembayaran telah dikonfirmasi','success')
            refresh()
        })
    }
    //id = IDBuktiPembayaran
    function rejectPembayaran(id){
        $.get('/karyawan/owner/pembayaran/reject/'+id).done(res=>{
            swal('Berhasil!','Pembayaran telah ditolak','success')
            refresh()
        })
    }
    //id = IDTransaksi
    function deleteTransaksi(id){
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.get('/karyawan/owner/transaksi/delete/'+id).done(res=>{
                    swal('Berhasil!','Transaksi berhasil dihapus','success')
                    refresh()
                })
            } else {
                swal("Dibatalkan!");
            }
        });

    }
    function refresh(){
        setTimeout(()=>location.reload(),2000)
    }
</script>
@endsection