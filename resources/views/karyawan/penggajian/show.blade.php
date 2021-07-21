@extends('karyawan.layouts.layout')
@section('title','Penggajian')
@section('content')
<style>
   .modal-lg {
    max-width: 2480px !important;
    }
    .modal-dialog{
        margin-left: 20px
    }
    .modal-sm{
        max-width: 70% !important;
        margin-left: auto;
        margin-right:auto
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel text-black" style="font-size: 15px;font-color:black">
            <p id="data-karyawan">


            </p>
            <a style="display: none" id="btn-create-penggajian" onclick="setDataCreatePenggajian()" data-target="#modal-create-penggajian" data-toggle="modal" class="btn btn-primary btn-sm text-white" href="javascript:void(0)" role="button">
                Buat penggajian tahun <span id="btn-create-penggajian-tahun"></span> bulan <span id="btn-create-penggajian-bulan"></span>
            </a>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Penggajian<small></small></h2>
              
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>Total Commision</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
    <div style="display: none" class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <div class="row">
                    <div class="col-md-1">
                        <a class="btn btn-danger btn-sm text-white" href="javascript:void(0)" role="button">Kembali</a>
                    </div>
                    <div class="col-md-11">
                        <h2>Penggajian bulan juli</h2>
                    </div>
                </div>
              
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-create-penggajian" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat penggajian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <h4>Program</h4>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">Program</th>
                                <th style="width:10%">Jumlah Pertemuan</th>
                                <th style="width:10%">Pertemuan ke</th>
                                <th style="width:20%">Tanggal</th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="table-create-penggajian-program">
                        </tbody>
                    </table>
                </div>
                <h4>Gaji Pokok</h4>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%"></th>
                                <th style="width:10%"></th>
                                <th style="width:10%"></th>
                                <th style="width:20%"></th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr>
                                <td>Gaji pokok</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>            
                                    <input type="number" class="form-control" onchange="updateCreatePenggajian('gakok',6)" id="datagakokadd6">                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h4>Penilaian Prestasi Kerja</h4>
                <a onclick="addCreatePenggajian('prestasikerja')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">

                    <table class="table">
    
                        <thead>
                            <tr>
                                <th style="width:40%">
    
                                </th>
                                <th style="width:10%"></th>
                                <th style="width:10%"></th>
                                <th style="width:20%"></th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="cpbodyprestasikerja">
                        </tbody>
                    </table>
                </div>
                <h4>Honor Tambahan</h4>
                <a onclick="addCreatePenggajian('httransport')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">Tunjangan transport di luar murid
                                </th>
                                <th style="width:10%">Tanggal</th>
                                <th style="width:10%">Tujuan/Kegiatan</th>
                                <th style="width:20%">Uang Transport</th>
                                <th style="width:15%">Total Transport</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="cpbodyhttransport">
                        </tbody>
                    </table>
                </div>
                <a onclick="addCreatePenggajian('htlain')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">Lain lain
                                </th>
                                <th style="width:10%">Tanggal</th>
                                <th style="width:10%">Totaljam</th>
                                <th style="width:20%">Keterangan</th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="cpbodyhtlain">
                        </tbody>
                    </table>
                </div>
                <h4>Absensi</h4>
                <a onclick="addCreatePenggajian('absensi')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">
                                </th>
                                <th style="width:10%">Tanggal</th>
                                <th style="width:10%">Waktu keterlambatan</th>
                                <th style="width:20%">Keterangan</th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="cpbodyabsensi">
                        </tbody>
                    </table>
                </div>
                {{-- <table class="table">
                    <thead>
                        <tr>
                            <th style="width:40%"></th>
                            <th style="width:10%"></th>
                            <th style="width:10%"></th>
                            <th style="width:20%"></th>
                            <th style="width:15%">Nominal</th>
                        </tr>
                    </thead>
                    <tbody >
                    </tbody>
                </table> --}}
                <div class="table-responsive">

                    <table class="table">
                        <tbody >
                            <tr>
                                <td style="width:40%">Subtotal</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%" id="penggajian-subtotal"></td>
                                <td style="width:5%" ></td>
                            </tr>
                            <tr>
                                <td style="width:40%">Tax rate</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%" id="penggajian-tax"></td>
                                <td style="width:5%" ></td>
                            </tr>
                            <tr>
                                <td style="width:40%">Other</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%">
                                    <input type="number" class="form-control" value="0" onchange="countGaji()" id="penggajian-other">
                                </td>
                                <td style="width:5%">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%">Total</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%" id="penggajian-total"></td>
                                <td style="width:5%" ></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="storePenggajian()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="modal-edit-penggajian" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdp-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <h4>Program</h4>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">Program</th>
                                <th style="width:10%">Jumlah Pertemuan</th>
                                <th style="width:10%">Pertemuan ke</th>
                                <th style="width:20%">Tanggal</th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="table-detail-penggajian-program">
                        </tbody>
                    </table>
                </div>
                <h4>Gaji Pokok</h4>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%"></th>
                                <th style="width:10%"></th>
                                <th style="width:10%"></th>
                                <th style="width:20%"></th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr>
                                <td>Gaji pokok</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>            
                                    <input type="number" class="form-control" onchange="updateCreatePenggajian('gakok',6)" id="datadtlgakokadd6">                
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h4>Penilaian Prestasi Kerja</h4>
                <a onclick="addCreatePenggajian('prestasikerja')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">

                    <table class="table">
    
                        <thead>
                            <tr>
                                <th style="width:40%">
    
                                </th>
                                <th style="width:10%"></th>
                                <th style="width:10%"></th>
                                <th style="width:20%"></th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="dpbodyprestasikerja">
                        </tbody>
                    </table>
                </div>
                <h4>Honor Tambahan</h4>
                <a onclick="addCreatePenggajian('httransport')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">Tunjangan transport di luar murid
                                </th>
                                <th style="width:10%">Tanggal</th>
                                <th style="width:10%">Tujuan/Kegiatan</th>
                                <th style="width:20%">Uang Transport</th>
                                <th style="width:15%">Total Transport</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="dpbodyhttransport">
                        </tbody>
                    </table>
                </div>
                <a onclick="addCreatePenggajian('htlain')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">Lain lain
                                </th>
                                <th style="width:10%">Tanggal</th>
                                <th style="width:10%">Totaljam</th>
                                <th style="width:20%">Keterangan</th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="dpbodyhtlain">
                        </tbody>
                    </table>
                </div>
                <h4>Absensi</h4>
                <a onclick="addCreatePenggajian('absensi')" class="btn btn-sm btn-primary" href="javascript:void(0)" role="button"><i class="fa fa-plus"></i></a>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:40%">
                                </th>
                                <th style="width:10%">Tanggal</th>
                                <th style="width:10%">Waktu keterlambatan</th>
                                <th style="width:20%">Keterangan</th>
                                <th style="width:15%">Nominal</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="dpbodyabsensi">
                        </tbody>
                    </table>
                </div>
                {{-- <table class="table">
                    <thead>
                        <tr>
                            <th style="width:40%"></th>
                            <th style="width:10%"></th>
                            <th style="width:10%"></th>
                            <th style="width:20%"></th>
                            <th style="width:15%">Nominal</th>
                        </tr>
                    </thead>
                    <tbody >
                    </tbody>
                </table> --}}
                <div class="table-responsive">

                    <table class="table">
                        <tbody >
                            <tr>
                                <td style="width:40%">Subtotal</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%"></td>
                                <td style="width:5%" id="penggajian-subtotal"></td>
                            </tr>
                            <tr>
                                <td style="width:40%">Tax rate</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%"></td>
                                <td style="width:5%" id="penggajian-tax"></td>
                            </tr>
                            <tr>
                                <td style="width:40%">Other</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%"></td>
                                <td style="width:5%">
                                    <input type="number" value="0" onchange="countGaji()" id="penggajian-other">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%">Total</td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:10%"></td>
                                <td style="widtd:20%"></td>
                                <td style="width:15%"></td>
                                <td style="width:5%" id="penggajian-total"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-detail-penggajian" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div id="table-detail-penggajian-wrap" class="modal-body">

  {{-- kunai --}}
  
                <table id="table-detail-penggajian" class="table table-inverse table-responsive">
                    <thead>
         
                    
                        <p style="font-family: Calibri;color:black;text-align:left;font-size:11pt;line-height:28px">
                        <span id="ddp-display-paymenttime" style="font-family: Calibri;color:#4f81bd;font-size:20pt"></span><br>
                        <span style="font-family: Cambria;color:#c0504d;text-align:left;font-size:29pt">MERACHEL ART & FASHION COURSE</span><br>
                            Jln Laksda Adi Sucipto 190 Malang - 65125 <br>
                            <span style="line-height: 2px">(+62)82230447070 </span><br><br>
                            <span style="font-family: Cambria;color:#c0504d;font-size:15pt">
                                PAYMENT FOR
                            </span><br>
                            <span id="ddp-display-nama" style="font-family: Calibri;color:#4f81bd;font-size:14pt">
                            </span>
                        </p>

                    </thead>
                    <tbody id="ddp-display-data">



                    </tbody>
                </table>
                <table id="editor"></table>
                <p>
                    <span style="font-size:11pt;color:#4f81bd">Please check and confirm the payment to MERACHEL ART & FASHION COURSE</span>  <br>
                    <span style="font-size:11pt;color:black">If you have any questions concerning this payment, use the following contact information:</span>  <br>
                    <span style="font-size:11pt;color:black">Meriza / Aisha</span>  <br>
                    <span style="font-size:12pt;color:#4f81bd;font-weight:bold">THANK YOU FOR YOUR COOPERATION!</span> 
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button onclick="createPDF()" type="button" class="btn btn-success">Simpan</button>
                {{-- <button type="button" class="btn btn-primary">Edit</button> --}}
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
@endsection
@push('scripts')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="{{url('assets/js/moment.js')}}"></script>


    <script>
        let token = $('#token').val()
        let TabelPenggajian =    $('#tabeldata').DataTable()
        let KelasTutor = [],Penggajian =[],MasterPenggajian = [],MasterPenggajianTransport=[],Karyawan =[]
        let UIDKaryawan = window.location.href.split('/')[7]
        let CreatePenggajian
        let NMonth = new Date().getMonth()
        let NYear =  new Date().getFullYear()
        let CreatePenggajianMain = []
        let doc = new jsPDF()
        console.log(NMonth,NYear)
        $(document).ready(function () {
            getData()
        });
        function downloadPenggajian(){
            $('#table-detail-penggajian').table2excel({
                'filename':Penggajian[0].NamaKaryawan + Penggajian[0].Tanggal+'.xls',
            })
           // t2e.export()
        }
        //kunai
        function createPDF(){
            let stable= document.getElementById('table-detail-penggajian-wrap').innerHTML
            var style = "<style>";
            style = style + "table {width: 100%;font: 17px Calibri;color:#4f81bd}";
            style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
            style = style + "padding: 2px 3px;text-align: center;}";
            style = style + "</style>";
            var win = window.open('', '', 'height=700,width=700')
            win.document.write('<html><head>');
            win.document.write('<title>Profile</title>');   // <title> FOR PDF HEADER.
            win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
            win.document.write('</head>');
            win.document.write('<body>');
            win.document.write(stable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
            //win.document.write(sscript)
            win.document.write('</body></html>')
            win.document.close()
            win.print()

        }
        function initButtonCreatePenggajian(){
            let penggajianThisMonth = Penggajian.some(ele=>{
                let tanggal = ele.Tanggal.split(' ')[0]
                return new Date(tanggal).getMonth() == new Date().getMonth()
            })
                $('#btn-create-penggajian-tahun').html(new Date().getFullYear())
                $('#btn-create-penggajian-bulan').html(getNameMonth(new Date().getMonth()))
            if(penggajianThisMonth){
                $('#btn-create-penggajian').hide()
            }else{
                $('#btn-create-penggajian').show()
            }
            console.log(penggajianThisMonth)
        }
        function getNameMonth(val){
            let Month = 
            val==0?'Januari':
            val==1?'Februari':
            val==2?'Maret':
            val==3?'April':
            val==4?'Mei':
            val==5?'Juni':
            val==6?'Juli':
            val==7?'Agustus':
            val==8?'September':
            val==9?'Oktober':
            val==10?'November':'Desember'
            return Month
        }
        function getData(){
            $.get("/karyawan/owner/penggajian/karyawan/getdata/"+UIDKaryawan).done(ele=>{
                KelasTutor = ele[0]
                Penggajian = ele[1]
                MasterPenggajian = ele[2]
                MasterPenggajianTransport = ele[3]
                Karyawan = ele[4]
                console.log(Penggajian)
                addRowTablePenggajian()
                showDataKaryawan()
                initButtonCreatePenggajian()
                
            })
        }
        function showDataKaryawan(){
            Karyawan = Karyawan.map(ele=>{
                return {
                    'NamaKaryawan':ele.NamaKaryawan,
                    'KodeKaryawan':ele.KodeKaryawan,
                    'IDKaryawan':ele.IDKaryawan,
                    'RoleKaryawan':ele.RoleKaryawan,
                    'Alamat':ele.Alamat==null?'-':ele.Alamat,
                    'Email':ele.Email,
                    'NoHP':ele.NoHP==null?'-':ele.NoHP,
                }
            });
            $('#data-karyawan').html(
                "Nama Karyawan : "+Karyawan[0].NamaKaryawan+" <br>"+
                "Kode Karyawan : "+Karyawan[0].KodeKaryawan+" <br>"+
                "Posisi : "+Karyawan[0].RoleKaryawan+" <br>"+
                "Alamat : "+Karyawan[0].Alamat+" <br>"+
                "Email : "+Karyawan[0].Email+" <br>"+
                "No Hp : "+Karyawan[0].NoHP
            )
        }
        function addRowTablePenggajian(){
            TabelPenggajian.clear().draw()
            let i =0
            const NamaBulan = bulan => bulan==0?'Januari':bulan==1?'Februari':bulan==2?'Maret':bulan==3?'April':bulan==4?'Mei':bulan==5?'Juni':bulan==6?'Juli':bulan==7?'Agustus':bulan==8?'September':bulan==9?'Oktober':bulan==10?'November':'Desember'
            Penggajian.forEach(ele=>{
                let tgl = ele.Tanggal.split(' ')[0]
                let btnDetail = " <a data-toggle=\"modal\" data-target=\"#modal-detail-penggajian\" onclick=\"showDetailPenggajian("+ele.IDPenggajian+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">Detail <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDPenggajian+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                TabelPenggajian.row.add([
                   i,
                   new Date(tgl).getFullYear(),
                  NamaBulan( new Date(tgl).getMonth()),
                   'Rp '+ele.Total.toLocaleString('id-ID'),
                   btnDetail
                ]).draw()
            })
        }


        //penggajian
        function setDataCreatePenggajian(){
            //nkelas = kelas bulan ini
            CreatePenggajian = []
            let NKelas =KelasTutor.filter(ele=>new Date(ele.Tanggal).getMonth()==NMonth)
            console.log(NKelas)
            NKelas = NKelas.map(ele=>{
                let nkelas_jenisprogram = ele.JenisProgram==""?"private":ele.JenisProgram
                //pendapatan per pertemuan dari master
                let nkelas_harga = MasterPenggajian.filter(mp=>
                        mp.IDLevel == ele.IDLevel&&
                        parseInt(mp.IDKategoriProgram) == parseInt(ele.IDKategoriProgram)&&
                        mp.JenisProgram.toLowerCase() == nkelas_jenisprogram.toLowerCase()
                )
                return {
                    'IDJadwal':ele.IDJadwal,
                    'IDLevel':ele.IDLevel,
                    'IDKursusSiswa':ele.IDKursusSiswa,
                    'JenisProgram':nkelas_jenisprogram,
                    'Kelas':ele.Kelas,
                    'NamaMateri':ele.NamaMateri,
                    'NamaSiswa':ele.NamaSiswa,
                    'NamaProdi':ele.NamaProdi,
                    'NoRecord':ele.NoRecord,
                    'Tanggal':ele.Tanggal,
                    'Harga':nkelas_harga.length >0 ?nkelas_harga[0].Pendapatan:0
                }
            })
            NKelas.forEach(ele=>{
                let total_pertemuan = KelasTutor.filter(kt=>kt.IDKursusSiswa == ele.IDKursusSiswa).length
                if(ele.Kelas){
                    CreatePenggajian.push(
                        {
                            'id':new Date().getTime()+Math.random().toString(16).slice(2),
                            'data':['program',ele.NamaSiswa,ele.NamaProdi,total_pertemuan,ele.NoRecord,ele.Tanggal,ele.Harga]
                        }
                    )
                }
            })

            CreatePenggajian.push(
                {
                    'id':'gakok',
                    'data':['gajipokok',null,null,null,null,null,0]
                }
            )
    
            countGaji()
            appendTableCreatePenggajianProgram()
            appendTableCreatePenggajian()
        }
        function appendTableCreatePenggajianProgram(data){
            let penggajian_program = CreatePenggajian.filter(ele=>ele['data'][0]=='program')
            let tabel = $('#table-create-penggajian-program')
            tabel.empty()
            penggajian_program.forEach(ele=>{
                tabel.append(
                    "<tr>"+
                        "<td>"+ele['data'][2]+"</td>"+
                        "<td>"+ele['data'][3]+"</td>"+
                        "<td>"+ele['data'][4]+"</td>"+
                        "<td>"+ele['data'][5].split(' ')[0]+"</td>"+
                        "<td>"+
                            "<input id=\"data"+ele['id']+"add6\" type=\"number\" class=\"form-control\" value=\""+ele['data'][6]+"\" onchange=\"updateCreatePenggajian(\'"+ele['id']+"\',6)\">"+
                        "</td>"+
                    "</tr>"
                )
            })
            
        }
        function updateCreatePenggajian(id,address){
            let data = $('#data'+id+'add'+address).val()
            console.log('hae',data)
            CreatePenggajian.forEach(ele=>{
                if(ele['id']==id){
                    ele['data'][address] = data
                }
            })
            countGaji()
        }
        function addCreatePenggajian(jenis){
            console.log(jenis)
            switch (jenis) {
                case 'prestasikerja':
                    CreatePenggajian.push(
                        {
                            'id':new Date().getTime()+Math.random().toString(16).slice(2),
                            'data':[jenis,'',null,null,null,'',0]
                        }
                    )
                    break;
                case 'httransport':
                    CreatePenggajian.push(
                        {
                            'id':new Date().getTime()+Math.random().toString(16).slice(2),
                            'data':['honortambahan','Tunjangan transport di luar murid','','','',0,0]
                        }
                    )
                    break;
                case 'htlain':
                    CreatePenggajian.push(
                        {
                            'id':new Date().getTime()+Math.random().toString(16).slice(2),
                            'data':['honortambahan','Lain-lain','','','','',0]
                        }
                    )
                    break;
                case 'absensi':
                    CreatePenggajian.push(
                        {
                            'id':new Date().getTime()+Math.random().toString(16).slice(2),
                            'data':['absensi','Keterlambatan','','','','',0]
                        }
                    )
                    break;
                default:
                    swal('ops ada kesalahan, mohon coba beberapa saat kemudian')
                    break;
            }
            appendTableCreatePenggajian()
        }
        function deleteCreatePenggajian(id){
            console.log(id)
            CreatePenggajian = CreatePenggajian.filter(ele=>ele['id']!=id)
            appendTableCreatePenggajian()
        }
        function appendTableCreatePenggajian(){
            let penggajian = CreatePenggajian.filter(ele=>ele['data'][0]!='program'||ele['data'][0]!='gajipokok')
           $('#cpbodyprestasikerja').empty()
           $('#cpbodyhttransport').empty()
           $('#cpbodyhtlain').empty()
           $('#cpbodyabsensi').empty()
            penggajian.forEach(pg=>{
                let tabel = pg['data'][0]=='absensi'? $('#cpbodyabsensi'):
                pg['data'][0]=='prestasikerja'? $('#cpbodyprestasikerja'):
                pg['data'][0]=='honortambahan'&&pg['data'][1]=='Lain-lain'? $('#cpbodyhtlain'):
                pg['data'][0]=='honortambahan'&&pg['data'][1]=='Tunjangan transport di luar murid'?
                $('#cpbodyhttransport'):false
          
                let data = 
                    pg['data'][0]=='absensi'? 
                
                        "<tr>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add1\" type=\"text\" class=\"form-control\" value=\""+pg['data'][1]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',1)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add3\" type=\"date\" class=\"form-control\" value=\""+pg['data'][3]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',3)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add4\" type=\"text\" class=\"form-control\" value=\""+pg['data'][4]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',4)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add5\" type=\"text\" class=\"form-control\" value=\""+pg['data'][5]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',5)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add6\" type=\"number\" class=\"form-control\" value=\""+pg['data'][6]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',6)\">"+
                            "</td>"+
                            "<td>"+
                                "<a onclick=\"deleteCreatePenggajian(\'"+pg['id']+"\')\" class=\"btn btn-sm btn-danger\" href=\"javascript:void(0)\" role=\"button\"><i class=\"fa fa-trash\"></i></a>"+
                            "</td>"+
                        "</tr>"
                        :
                    pg['data'][0]=='prestasikerja'? 
                        "<tr>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add1\" type=\"text\" class=\"form-control\" value=\""+pg['data'][1]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',1)\">"+
                            "</td>"+
                            "<td></td>"+
                            "<td></td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add5\" type=\"text\" class=\"form-control\" value=\""+pg['data'][5]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',5)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add6\" type=\"number\" class=\"form-control\" value=\""+pg['data'][6]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',6)\">"+
                            "</td>"+
                            "<td>"+
                                "<a onclick=\"deleteCreatePenggajian(\'"+pg['id']+"\')\" class=\"btn btn-sm btn-danger\" href=\"javascript:void(0)\" role=\"button\"><i class=\"fa fa-trash\"></i></a>"+
                            "</td>"+
                        "</tr>"
                        :
                    pg['data'][0]=='honortambahan'&&pg['data'][1]=='Lain-lain'? 
                        "<tr>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add2\" type=\"text\" class=\"form-control\" value=\""+pg['data'][2]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',2)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add3\" type=\"date\" class=\"form-control\" value=\""+pg['data'][3]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',3)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add4\" type=\"text\" class=\"form-control\" value=\""+pg['data'][4]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',4)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add5\" type=\"text\" class=\"form-control\" value=\""+pg['data'][5]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',5)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add6\" type=\"number\" class=\"form-control\" value=\""+pg['data'][6]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',6)\">"+
                            "</td>"+
                            "<td>"+
                                "<a onclick=\"deleteCreatePenggajian(\'"+pg['id']+"\')\" class=\"btn btn-sm btn-danger\" href=\"javascript:void(0)\" role=\"button\"><i class=\"fa fa-trash\"></i></a>"+
                            "</td>"+
                        "</tr>"
                        :
                        "<tr>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add2\" type=\"text\" class=\"form-control\" value=\""+pg['data'][2]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',2)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add3\" type=\"date\" class=\"form-control\" value=\""+pg['data'][3]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',3)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add4\" type=\"text\" class=\"form-control\" value=\""+pg['data'][4]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',4)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add5\" type=\"text\" class=\"form-control\" value=\""+pg['data'][5]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',5)\">"+
                            "</td>"+
                            "<td>"+
                                "<input id=\"data"+pg['id']+"add6\" type=\"number\" class=\"form-control\" value=\""+pg['data'][6]+"\" onchange=\"updateCreatePenggajian(\'"+pg['id']+"\',6)\">"+
                            "</td>"+
                            "<td>"+
                                "<a onclick=\"deleteCreatePenggajian(\'"+pg['id']+"\')\" class=\"btn btn-sm btn-danger\" href=\"javascript:void(0)\" role=\"button\"><i class=\"fa fa-trash\"></i></a>"+
                            "</td>"+
                        "</tr>"

  
                if(tabel!=false){

                tabel.append(data)
                }
            

            })
            
        }
        function countGaji(){
            let other = $('#penggajian-other').val()
            other = other==''?0:other
            let subtotal=0,total=0
            CreatePenggajian.forEach(ele=>{
                if(ele['data'][0]=='absensi'){
                    subtotal -= ele['data'][6]==''?0:parseInt(ele['data'][6])
                }else{
                    subtotal += ele['data'][6]==''?0:parseInt(ele['data'][6])
                }
            })
            total = subtotal + parseInt(other)
            CreatePenggajianMain =[]
            CreatePenggajianMain.push(subtotal,total)
            $('#penggajian-subtotal').html('Rp. '+subtotal.toLocaleString('id-ID'))
            $('#penggajian-total').html('Rp. '+parseInt(total).toLocaleString('id-ID'))
        }
        function storePenggajian(){
            let dataStore = {
                '_token':token,
                'NamaKaryawan':Karyawan[0].NamaKaryawan,
                'IDKaryawan':Karyawan[0].IDKaryawan,
                'Total':CreatePenggajianMain[1],
                'SubTotal':CreatePenggajianMain[0],
                'dt_jenispendapatan[]':[],
                'dt_title[]':[],
                'dt_subtitle[]':[],
                'dt_data1[]':[],
                'dt_data2[]':[],
                'dt_data3[]':[],
                'dt_nominal[]':[],
            }
            CreatePenggajian.filter(ele=>ele['data'][6]!=0)
            .forEach(ele=>{
                dataStore['dt_jenispendapatan[]'].push(ele['data'][0])
                dataStore['dt_title[]'].push(ele['data'][1])
                dataStore['dt_subtitle[]'].push(ele['data'][2])
                dataStore['dt_data1[]'].push(ele['data'][3])
                dataStore['dt_data2[]'].push(ele['data'][4])
                dataStore['dt_data3[]'].push(ele['data'][5])
                dataStore['dt_nominal[]'].push(ele['data'][6])
            })
            $.ajax({
                type: "post",
                url: "/karyawan/owner/penggajian/store",
                data: dataStore,
                success: function (response) {
                    $('#modal-create-penggajian').modal('hide')
                    getData()
                    swal(response)
                }
            });
        }
        //kunai
        function showDetailPenggajian(id){
           // $('#ddp-display-data').empty()
            let Data = Penggajian.filter(ele=>ele.IDPenggajian==id)[0]
            $('#ddp-display-nama').html(Data.NamaKaryawan)
            let Tanggal =Data.Tanggal.split(' ')[0]
            $('#ddp-display-paymenttime').html("PAYMENT "+getNameMonth(new Date(Tanggal).getMonth())+" "+ new Date(Tanggal).getFullYear())
            let DataProgram = Data.Detail.filter(ele=>ele.InfoData.split('[,]')[0]=='program')
            let DataGajiPokok = Data.Detail.filter(ele=>ele.InfoData.split('[,]')[0]=='gajipokok')
            let DataPrestasiKerja = Data.Detail.filter(ele=>ele.InfoData.split('[,]')[0]=='prestasikerja')
            let DataHTTransport = Data.Detail.filter(ele=>ele.InfoData.split('[,]')[0]=='honortambahan'&&ele.InfoData.split('[,]')[1]!='Lain-lain')
            let DataHTLain = Data.Detail.filter(ele=>ele.InfoData.split('[,]')[0]=='honortambahan'&&ele.InfoData.split('[,]')[1]=='Lain-lain')
            let DataAbsensi = Data.Detail.filter(ele=>ele.InfoData.split('[,]')[0]=='absensi')
            remapInfoData(DataProgram,true).forEach(ele=>{
                let pendapatan_pertemuan = ""
                ele.data.forEach(dat=>{
                    pendapatan_pertemuan +=          
                    "<tr font-size:12pt;font-family:Calibri>"+
                        "<td font-size:11pt;font-family:Calibri >"+dat.data3+"</td>"+
                        "<td >"+dat.data4+"</td>"+
                        "<td>"+dat.data5+"</td>"+
                        "<td >"+moment(new Date(dat.data6)).format('DD-MMM-YY')+"</td>"+
                        "<td style=\"text-align:right\">Rp "+dat.nominal.toLocaleString('id-ID')+"</td>"+
                    "</tr> "
                })
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th style=\"width:24%;font-size:18pt;font-family:Calibri\">"+ele.nama+"</th>"+
                        "<th style=\"width:19%\"></th>"+
                        "<th style=\"width:19%\"></th>"+
                        "<th style=\"width:19%\"></th>"+
                        "<th style=\"width:19%\"></th>"+
                    "</tr>"+
                    "<tr style=\"font-size:14pt;font-family:Calibri\">"+
                        "<th >Program</th>"+
                        "<th>Jumlah Pertemuan</th>"+
                        "<th >Pertemuan ke</th>"+
                        "<th>Tanggal</th>"+
                        "<th >Nominal</th>"+
                    "</tr>"+pendapatan_pertemuan
           
                )
            })

            if(DataGajiPokok.length>0){
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th >GAJI POKOK</th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                        "<td >Rp "+DataGajiPokok[0].Nominal.toLocaleString('id-ID')+"</td>"+
                    "</tr>"
                )
            }
            if(DataPrestasiKerja.length>0){
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th >PENILAIAN PRESTASI KERJA</th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                    "</tr>"
                )
            }
            remapInfoData(DataPrestasiKerja,false).forEach(ele=>{
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<td >"+ele.data2+"</td>"+
                        "<td ></td>"+
                        "<td></td>"+
                        "<td >"+ele.data6+"</td>"+
                        "<td style=\"text-align:right\">Rp "+ele.nominal.toLocaleString('id-ID')+"</td>"+
                    "</tr> "
                )
            })
            if(DataHTLain.length>0 || DataHTTransport.length>0){
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th >HONOR TAMBAHAN</th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                        "<th ></th>"+
                    "</tr>"
                )
            }

            if(DataHTTransport.length>0){
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th >Tunjangan transport di luar murid</th>"+
                        "<th >Tanggal</th>"+
                        "<th >Tujuan/Kegiatan</th>"+
                        "<th >Uang Transport</th>"+
                        "<th >Total Transport</th>"+
                    "</tr>"
                )
            }
            remapInfoData(DataHTTransport,false).forEach(ele=>{
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<td >"+ele.data3+"</td>"+
                        "<td >"+ele.data4+"</td>"+
                        "<td>"+ele.data5+"</td>"+
                        "<td >"+ele.data6+"</td>"+
                        "<td style=\"text-align:right\">Rp "+ele.nominal.toLocaleString('id-ID')+"</td>"+
                    "</tr> "
                )
            })
            if(DataHTLain.length>0){
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th >Lain-lain</th>"+
                        "<th >Tanggal</th>"+
                        "<th >Total Jam Kerja</th>"+
                        "<th >Keterangan</th>"+
                        "<th >Nominal</th>"+
                    "</tr>"
                )
            }

            remapInfoData(DataHTLain,false).forEach(ele=>{
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<td >"+ele.data3+"</td>"+
                        "<td >"+ele.data4+"</td>"+
                        "<td>"+ele.data5+"</td>"+
                        "<td >"+ele.data6+"</td>"+
                        "<td style=\"text-align:right\">Rp "+ele.nominal.toLocaleString('id-ID')+"</td>"+
                    "</tr> "
                )
            })
            if(DataAbsensi.length>0){
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<th >ABSENSI</th>"+
                        "<td >Tanggal</td>"+
                        "<td >Waktu keterlambatan</td>"+
                        "<td >Keterangan</td>"+
                        "<td>Nominal</td>"+
                    "</tr>"
                )
            }
            remapInfoData(DataAbsensi,false).forEach(ele=>{
                $('#ddp-display-data').append(
                    "<tr>"+
                        "<td >"+ele.data2+"</td>"+
                        "<td >"+ele.data4+"</td>"+
                        "<td>"+ele.data5+"</td>"+
                        "<td >"+ele.data6+"</td>"+
                        "<td style=\"text-align:right\">Rp "+ele.nominal.toLocaleString('id-ID')+"</td>"+
                    "</tr> "
                )
            })
            $('#ddp-display-data').append(
                "<tr style=\"text-align:right\">"+
                    "<td style=\"text-align:right\">SUBTOTAL</td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td style=\"text-align:right\">Rp "+Data.SubTotal.toLocaleString('id-ID')+"</td>"+
                "</tr>"+
                "<tr style=\"text-align:right\">"+
                    "<td style=\"text-align:right\">TAX RATE</td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td style=\"text-align:right\">Rp "+Data.NilaiPPN.toLocaleString('id-ID')+"</td>"+
                "</tr>"+
                "<tr style=\"text-align:right\">"+
                    "<td style=\"text-align:right\">OTHER</td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td style=\"text-align:right\"></td>"+
                "</tr>"+
                "<tr style=\"text-align:right\">"+
                    "<td style=\"text-align:right\">TOTAL</td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td></td>"+
                    "<td style=\"text-align:right\">Rp "+Data.Total.toLocaleString('id-ID')+"</td>"+
                "</tr>"
            )
    
        }
        function remapInfoData(data,isgroup){
            let group = []
            let new_data = data.map(ele=>{
                let data =ele.InfoData.split('[,]')
                let new_dat ={
                    'data1' : data[0],
                    'data2' : data[1],
                    'data3' : data[2],
                    'data4' : data[3],
                    'data5' : data[4],
                    'data6' : data[5],
                    'nominal':ele.Nominal
                }
                return new_dat
            })
            if(isgroup){
                new_data.forEach(ele=>{
                    if(group.some(dat=>dat.nama==ele.data2)==false){
                        group.push({
                            'nama':ele.data2,
                            'data':[ele]
                        })
                    }else{
                        let ite =0
                        group.forEach(gr=>{
                            if(gr.nama==ele.data2){
                                group[ite].data.push(ele)
                            }
                            ite++
                        })
                    }
                })
                return group
            }else{
                return new_data
            }
        }
    </script>


@endpush