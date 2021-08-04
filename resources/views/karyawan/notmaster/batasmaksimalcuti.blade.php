@extends('karyawan.layouts.layout')
@section('title','Master batas maksimal cuti')
@section('content')
<input type="hidden" value="{{session()->get('Level')}}" id="level-user">
<div class="row">
    <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master<small></small></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <table id="tabeldata" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Maksimal cuti (hitungan hari)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
                </div>
    
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalupdate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="formdata-edit">
                    @csrf
                    <input type="hidden" name="idmaster" id="medit-idmaster">
                    <div class="form-group">
                        <label for="">Maksimal cuti (hitungan hari)</label>
                        <input type="number" class="form-control" id="medit-data" name="data">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="update()" type="button" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
    <script>
        let master_data = []
        let table_data = $('#tabeldata').DataTable()
        let UrlLevel = $('level-user').val()==1?'/karyawan/owner/':'/karyawan/admin/'
        $(document).ready(function () {
            getData()
        });
        function getData(){
            $.get(UrlLevel+"master/maksimalcuti/getdata" ).done(ele=>{
                master_data = ele
                showData()  
            })
        }
        function showData(){
            table_data.clear().draw()
            let i =0
            master_data.forEach(ele=>{
                let btnUpdate = " <a data-toggle=\"modal\" data-target=\"#modalupdate\" onclick=\"editData("+ele.id+")\"  class=\"btn btn-primary btn-sm\" href=\"javascript:void(0)\" role=\"button\">   <i class=\"fa fa-pencil\"></i></a>"
                i++
                table_data.row.add([
                   i,
                   ele.hari+' hari',
                   btnUpdate
                ]).draw()
            })
        }
     
        function editData(id){
            let data = master_data.filter(ele=>ele.id==id)
            $('#medit-data').val(data[0].hari)
            $('#medit-idmaster').val(data[0].id)
        }
        function update(){
            $.ajax({
                type: "post",
                url: UrlLevel+"master/maksimalcuti/update",
                data: $('#formdata-edit').serialize(),
                success: function (response) {
                    getData()
                    $('#modalupdate').modal('hide')
                    swal(response)
                }
            });
        }

    </script>
@endpush