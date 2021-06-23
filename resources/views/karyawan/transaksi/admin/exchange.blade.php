@extends('karyawan.layouts.layout')
@section('title','Buat transaksi refund')
@section('content')
<input type="hidden" id="csrf-token" name="_token" value="{{ csrf_token() }}" />
<div class="row bg-white" >
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1">
                <label for="">Exchange</label>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select onchange="showDetailTransaksi()" class="custom-select" id="input-pilih-transaksi">
                    </select>
                </div>
            </div>
            <div class="col-md-7"></div>
        </div>
    </div>
    <section style="display: none" id="informasi-transaksi">

        <div class="col-md-12">
            <h4>Informasi transaksi</h4>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Kode Transaksi</label>
                      <input type="text" id="info-kode-transaksi" class="form-control" readonly >
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nama siswa</label>
                      <input type="text" id="info-nama-siswa" class="form-control" readonly >
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nama prodi</label>
                      <input type="text" id="info-nama-prodi" class="form-control" readonly >
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Total pertemuan</label>
                      <input type="text" id="info-total-pertemuan" class="form-control" readonly >
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Total pertemuan selesai</label>
                      <input type="text" id="info-pertemuan-selesai" class="form-control" readonly >
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Total transaksi</label>
                      <input type="text" id="info-total-transaksi" class="form-control" readonly >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Total dibayar</label>
                      <input type="text" id="info-total-dibayar" class="form-control" readonly >
                    </div>
                </div>
            </div>
            <button data-toggle="modal" data-target="#modal-create-exchange" onclick="createExchange()" type="button" id="btn-transaksi-exchange" class="btn btn-sm btn-primary">Buat transaksi exchange</button>
        </div>
    </section>

    <div id="transaksi-exchange" class="col-md-12">
        <table id="table-exchange" class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Status</th>
                    <th>Nama Siswa</th>
                    <th>Program</th>
                    <th>Sub Total</th>
                    <th>Total</th>
                    <th>Cicilan</th>
                    <th>Tanggal</th>
                    {{-- <th>Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modal-create-exchange" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat transaksi exchange</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    {{-- kunai --}}
                    
                    <div class="form-group">
                      <label for="">Kode transaksi</label>
                      <input type="text" class="form-control" readonly  id="inputex-kode-transaksi" >
                    </div>
                    <div class="form-group">
                        <label for="">Harga program sebelumnya</label>
                        <input type="text" class="form-control" readonly  id="inputex-harga-old" >
                      </div>
                    <div class="form-group">
                        <label for="">Total pembayaran sebelumnya</label>
                        <input type="text" class="form-control" readonly  id="inputex-pembayaran-old" >
                    </div>
                    <div class="form-group">
                        <label for="">Total pertemuan selesai</label>
                        <input type="text" class="form-control" readonly  id="inputex-pertemuan-old" >
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" class="form-control"   id="inputex-keterangan">
                      </div>
                    <div class="form-group">
                        <label for="">Prodi baru</label>
                        <select class="custom-select" onchange="showInputexNewPrice()" id="inputex-prodi">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Harga kursus baru</label>
                        <input type="text" class="form-control" readonly  id="inputex-harga-new" >
                    </div>
                    <div class="form-group">
                        <label for="">Harga yang harus dibayar</label>
                        <input type="text" class="form-control"  id="inputex-harga-final" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btn-store-exchange" onclick="storeExchange()" class="btn btn-primary">Buat</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let TableExchange = $('#table-exchange').DataTable()
    let TransaskiSelesai = [],TransaksiExchange = [],ProgramStudi=[],ExchangeID =''
    getData()
    function getData(){
        $.get('/karyawan/admin/transaksi/exchange/getdata').done((ele)=>{
            console.log(ele)
            TransaksiSelesai = ele['TransaksiSelesai']
            TransaksiExchange = ele['TransaksiExchange']
            ProgramStudi = ele['ProgramStudi']
            showDataTransaksiSelesai();
            showSelectProdi()
            showTableExchange()
        });
    }
    function showSelectProdi(){
        let select_prodi = $('#inputex-prodi')
        console.log(select_prodi,ProgramStudi)
        select_prodi.empty()
        select_prodi.append("<option value=\"false\">pilih</option>")
        ProgramStudi.forEach((ele)=>{
            select_prodi.append(
                "<option value=\""+ele.IDProgram+"\">"+ele.NamaProdi+"</option>"
            )
        })
    }
    function showDataTransaksiSelesai(){
        let pilih_transaksi = $('#input-pilih-transaksi')
        pilih_transaksi.empty()
        pilih_transaksi.append( "<option value=\"0\">Pilih</option>")
        TransaksiSelesai.forEach((ele)=>{
            pilih_transaksi.append(
                "<option value=\""+ele.IDTransaksi+"\">"+ele.KodeTransaksi+"</option>"
            );
        })
    }
    function showTableExchange(){
        TableExchange.clear().draw()
        let a = 0
        TransaksiExchange.forEach((data)=>{
            a++
            TableExchange.row.add([
                    a,
                    data.KodeTransaksi,
                    data.Status=='CFM'?'Sedang di cek owner':data.Status=='CLS'?'Selesai':'Dihapus',
                    data.NamaSiswa,
                    data.NamaProdi,
                    data.SubTotal,
                    data.Total,
                    data.Hutang=='n'?'Tidak':'Iya',
                    data.Tanggal
            ]).draw();
        })
    }
    function showDetailTransaksi(){
        ExchangeID = $('#input-pilih-transaksi').val()
        let data = TransaksiSelesai.filter(ele=>ele.IDTransaksi == ExchangeID)
        $('#info-nama-siswa').val(data[0].NamaSiswa)
        //$('#info-kode-siswa').val(data[0].KodeSiswa)
        $('#info-nama-prodi').val(data[0].NamaProdi)
        //$('#info-kode-kursus').val(data[0].KodeKursus)
        $('#info-total-pertemuan').val(data[0].TotalPertemuan)
        $('#info-pertemuan-selesai').val(data[0].PertemuanTerakhir.length)
        $('#info-total-transaksi').val(data[0].Total)
        $('#info-total-dibayar').val(data[0].TotalDibayar)
        $('#info-kode-transaksi').val(data[0].KodeTransaksi)
        $('#transaksi-exchange').hide();
        $('#informasi-transaksi').show()
    }
    //kunai
    function createExchange(){
        let data = TransaksiSelesai.filter(ele=>ele.IDTransaksi == ExchangeID)[0]
        $('#inputex-kode-transaksi').val('TREX-'+ data.KodeTransaksi.split('-')[1])
        $('#inputex-harga-old').val(data.Total)
        $('#inputex-pembayaran-old').val(data.TotalDibayar)
        $('#inputex-pertemuan-old').val(data.PertemuanTerakhir.length)
        $('#inputex-keterangan').val('Transaksi tukar program')
    }
    function showInputexNewPrice(){
        let data = TransaksiSelesai.filter(ele=>ele.IDTransaksi == ExchangeID)[0]
        let newprodi = ProgramStudi.filter(ele=>ele.IDProgram == $('#inputex-prodi').val())[0]
        $('#inputex-harga-new').val(newprodi.Harga)
        let newharga = data.TotalDibayar - newprodi.Harga 
        let hargafinal = newharga >=0?0:newharga*-1
        $('#inputex-harga-final').val(hargafinal)
    }
    function storeExchange(){
        $('#btn-store-exchange').attr('disabled',true)
        let transaksi = TransaksiSelesai.filter(ele=>ele.IDTransaksi == ExchangeID)[0]
        let data = {
            '_token':$('#csrf-token').val(),
            'KodeTransaksi':'TREX-'+ transaksi.KodeTransaksi.split('-')[1],
            'IDSiswa':transaksi.IDSiswa,
            'Total':$('#inputex-harga-final').val(),
            'Keterangan':$('#inputex-keterangan').val(),
            'IDProgram':$('#inputex-prodi').val(),
            'IDKursusSiswa':transaksi.IDKursusSiswa,
            'IDTransaksi':transaksi.IDTransaksi
        }
        $.ajax({
            type: "post",
            url: "/karyawan/admin/transaksi/exchange/store",
            data: data,
            async:false,
            success: function (response) {
                getData()
                $('#modal-create-exchange').modal('hide')
                swal(response)
                $('#transaksi-exchange').show();
                $('#btn-store-exchange').attr('disabled',false)
            }
        });
    }
</script>
@endpush