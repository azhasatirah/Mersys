var TabelData = $('#tabeldata').DataTable();
var ProgramStudi;
var KategoriMetodePembayaran;

$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
    var data = window.location.search;
    console.log(data);
});

$(function(){
    $(document).on('change','#jenis-create',function(){
        console.log($('#jenis-create').val());
        getDompetByJenis($('#jenis-create').val());
    });
    $(document).on('click','#tombolcreate',function(){
        storeData();
    });
    $(document).on('click','#tomboledit',function(){
        updateData();
    });
    $('#modaledit').on('show.bs.modal',function(event){
        var Button = $(event.relatedTarget);
        var IDData = Button.data('id');
        editData(IDData);     
    })
});

function clearFormCreate(){
    $('.form-control').val('');
}

function getDompetByJenis(Jenis){
    if(Jenis == 'bank'){
        $.get('/karyawan/admin/manage/rekening/getdata', (data) => {
            console.log(data);
            data.Rekening.forEach((dat)=>{
                $('#bank-create').append(
                    "<Option value=\""+dat.IDRekening+"\">"+dat.NamaBank+"</Option>"
                );
            })
        });
    }
}

function setSelectBank(id){
    $('#editbank').find('option').remove();
    $.get('/karyawan/admin/master/bank/getdata').done(
        (data) => {
            data['Bank'].forEach(
                (val)=> {
                    var select = val.IDBank==id?'selected':'';
                    $('#editbank').append(
                        "<option value=\""+val.IDBank+"\""+select+">"+
                        val.NamaBank+"</option>"
                    );
                }
            );
        }
    );
}
function setSelectProgramStudi(id){
    $('#editprogramstudi').find('option').remove();
    $.get('/karyawan/admin/manage/program/getdata').done(
        (data) => {
            data['ProgramStudi'].forEach(
                (val)=> {
                    var select = val.IDProgram==id?'selected':'';
                    $('#editprogramstudi').append(
                        "<option value=\""+val.IDProgram+"\""+select+">"+
                        val.NamaProdi+"</option>"
                    );
                }
            );
        }
    );
}

function showData(){
    $.get('/karyawan/admin/manage/metodepembayaran/getdata',function(Data){
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data.MetodePembayaran.forEach((data) =>{
                a++;
                var TombolAksi ="<button type=\"button\" class=\"btn btn-primary btn-sm editmodal\""+
                    "data-toggle=\"modal\" data-target=\"#modaledit\" "+
                    "data-id=\""+data.IDMetodePembayaran+"\">"+
                        "<i class=\"fa fa-edit\"></i>"+
                    "</button>"+
                    "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteData('"+data.IDMetodePembayaran+"')\">"+
                        "<i class=\"fa fa-trash\"></i></a>";
                TabelData.row.add([
                    a,
                    data.MetodePembayaran,
                    data.NoRekening,
                    data.Jenis,
                    data.NamaBank,
                    TombolAksi
                ]).draw();
            })
        }
    })
}

function editData(id){
    $.get('/karyawan/admin/manage/metodepembayaran/edit/'+id,function(data){
        $('#editid').val(data[0].IDMetodePembayaran);
        $('#editnamaMetodePembayaran').val(data[0].NamaMetodePembayaran);
        $('#editnoMetodePembayaran').val(data[0].NoMetodePembayaran);
        setSelectBank(data[0].IDBank);
    });
}

function storeData(){
    //console.log($('#formdata').serialize());
    $.post('/karyawan/admin/manage/metodepembayaran/store',$('#formdata').serialize())
    .done(function(pesan){
        showData();
        swal(pesan.Pesan);
        $('#modalcreate').modal('hide');
        clearFormCreate();
    }).fail(function(pesan){
        console.log(pesan.Message);
        swal('gagal'+pesan.Pesan);
    });
}

function updateData(){
    console.log($('#formdataedit').serialize());
    $.post('/karyawan/admin/manage/metodepembayaran/update',$('#formdataedit').serialize())
    .done(function(pesan){
        showData();
        swal(pesan.Pesan);
        $('#modaledit').modal('hide');
        clearFormCreate();
    }).fail(function(pesan){
        console.log(pesan.Message);
        swal('gagal'+pesan.Pesan);
    });
}

function deleteData(ID){
    swal({
        title: "Apakah kamu yakin?",
        text: "Data akan dihapus!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.get('/karyawan/admin/manage/metodepembayaran/delete/'+ID,function(Pesan){
                if(Pesan.Status='success'){
                    swal("Data berhasi dihapus!", {
                        icon: "success",
                    });
                    showData();
                }else{
                    swal("Terjadi kesalahan!", {
                        icon: "error",
                    });
                }
            });
        } else {
            swal("Dibatalkan!");
        }
    });

}