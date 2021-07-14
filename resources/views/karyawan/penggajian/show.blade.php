@extends('karyawan.layouts.layout')
@section('title','Jadwal semi private')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar karyawan<small></small></h2>
              
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
</div>

@endsection
@push('scripts')
    <script>
        let TabelPenggajian =    $('#tabeldata').DataTable()
        $(document).ready(function () {
            
    
        });
        function getData(){
            $.get("/karyawan/owner/masterpenggajian/transport/getdata" ).done(ele=>{
                master_biaya_transport = ele
                showData()  
            })
        }
        function showData(){
            TabelMasterPenggajian.clear().draw()
            let i =0
            master_biaya_transport.forEach(ele=>{
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.IDMasterPenggajianTransport+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                let btnDelete = " <a onclick=\"deleteData("+ele.IDMasterPenggajianTransport+")\"  class=\"btn btn-danger btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-trash-o\"></i></a>"
                i++
                TabelMasterPenggajian.row.add([
                   i,
                   ele.Blok,
                   'Rp '+ele.Biaya.toLocaleString('id-ID'),
                   btnUpdate+btnDelete
                ]).draw()
            })
        }
    </script>
@endpush