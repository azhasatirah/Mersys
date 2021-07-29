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
    .modal{
        overflow-y:auto
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
                                <th>Status</th>
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
            <div class="modal-footer" id="modal-footer-detail">

                {{-- <button type="button" class="btn btn-primary">Edit</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="{{url('assets/js/moment.js')}}"></script>
<script>
      let TabelPenggajian =    $('#tabeldata').DataTable()
        let Penggajian =[],Karyawan =[]

        let NMonth = new Date().getMonth()
        let NYear =  new Date().getFullYear()
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
            $.get("/karyawan/tutor/gaji/getdata").done(ele=>{
                console.log(ele)
                Penggajian = ele[0]
                Karyawan = ele[1]
                //console.log('Master denda keterlambatan',MasterDendaKeterlambatan)
                addRowTablePenggajian()
                showDataKaryawan()
                
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
            console.log(Penggajian)
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
                   ele.Status == 'OPN'?'Belum dikonfirmasi':ele.Status=='CFM'?'Dikonfirmasi':'',
                   btnDetail
                ]).draw()
            })
        }
        function appendFooterModalDetail(data){
      
      //console.log(data)
            $('#modal-footer-detail').empty()
            let btn_tutup = "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Tutup</button>"
            let btn_download = "<button onclick=\"createPDF()\" type=\"button\" class=\"btn btn-success\">Donwload</button>"

            let buttons = btn_tutup+btn_download
            $('#modal-footer-detail').append(buttons)
        }
        function showDetailPenggajian(id){
            $('#ddp-display-data').empty() 
           //kunaisss
            let Data = Penggajian.filter(ele=>ele.IDPenggajian==id)[0]
           appendFooterModalDetail(Data)
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
                        "<td>Nominal denda</td>"+
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
        function formatUang(id){
            
            let uang = $('#'+id).val()
            let formated_uang = numberToIDR(uang)
            $('#'+id).val(formated_uang)

        }
        function numberToIDR(data){
            let uang = String(data)
            uang = uang.replace('Rp. ','').replaceAll('.','')
            let isnan = isNaN(uang)
            if(isnan||uang ==''){
               // console.log(true)
                uang = '0'
            }
            let formated_uang = 'Rp. '+parseInt(uang).toLocaleString('id-ID')
            return formated_uang
        }
        function IDRToNumber(data){
        //kuntod
            let real_data = data.replace('Rp. ','').replaceAll('.','')
            return parseInt(real_data)
        }
</script>
@endpush