@extends('karyawan.layouts.layout')
@section('title','Kas Bank')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel text-black" style="font-size: 15px;font-color:black">
            <p id="data-karyawan">


            </p>
        </div>
    </div>
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kas Bank<small></small></h2>
              
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode kasbank</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Keterngan</th>
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
        let TabelData = $('#tabeldata').DataTable()
        let KasBank = []
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get('/karyawan/owner/kasbank/getdata').done(ele=>{
                KasBank = ele
                addRowTableKasBank()
            })
        }
        function addRowTableKasBank(){
            TabelData.clear().draw()
            let i=1
            KasBank.forEach(ele=>{
                let Total = ele.Total >= 0?
                '<span class=\"text-success\">'+numberToIDR(ele.Total)+'</span>':
                '<span class=\"text-danger\">'+numberToIDR(ele.Total*-1)+'</span>'
                TabelData.row.add([
                    i,
                    ele.KodeKasBank,
                    ele.Tanggal,
                    Total,
                    ele.Keterangan,
                    'hae'
                ]).draw()
            })
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

            if(String(data).indexOf('Rp. ')>=0){
                let real_data = data.replace('Rp. ','').replaceAll('.','')
                return parseInt(real_data)
            }else{
         
                return data
            }
        }
    </script>
@endpush