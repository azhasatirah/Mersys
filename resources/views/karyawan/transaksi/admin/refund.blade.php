@extends('karyawan.layouts.layout')
@section('title','Buat transaksi refund')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <label for="">Buat refund</label>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <select class="custom-select" id="input-pilih-transaksi">
                    </select>
                </div>
            </div>
            <div class="col-md-5"></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let TransaskiSelesai = [],RefundSelesai = []
    getData()
    function getData(){
        $.get('/karyawan/admin/transaksi/refund/getdata').done((ele)=>{
            console.log(ele)
            TransaksiSelesai = ele['TransaksiSelesai']
            RefundSelesai = ele['TransaksiRefund']
            showData();
        });
    }
    function showData(){
        let pilih_transaksi = $('#input-pilih-transaksi')
        pilih_transaksi.empty()
        pilih_transaksi.append( "<option value=\"0\">Pilih</option>")
        TransaksiSelesai.forEach((ele)=>{
            pilih_transaksi.append(
                "<option value=\""+ele.IDTransaksi+"\">"+ele.KodeTransaksi+"</option>"
            );
        })
    }
</script>
@endpush