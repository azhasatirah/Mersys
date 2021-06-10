
var TabelData = $('#tabeldata').DataTable();
$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
});

$(function(){
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


function showData(){
    $.get('/karyawan/admin/master/kategorimateri/getdata',function(Data){
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data.KategoriMateri.forEach((data) =>{
                a++;
                var TombolAksi ="<button type=\"button\" class=\"btn btn-primary btn-sm editmodal\""+
                    "data-toggle=\"modal\" data-target=\"#modaledit\" "+
                    "data-id=\""+data.IDKategoriMateri+"\">"+
                        "<i class=\"fa fa-edit\"></i>"+
                    "</button>"+
                    "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteData('"+data.IDKategoriMateri+"')\">"+
                        "<i class=\"fa fa-trash\"></i></a>";
                TabelData.row.add([
                    a,
                    data.KodeKategoriMateri,
                    data.NamaKategoriMateri,
                    TombolAksi
                ]).draw();
            })
        }
    })
}

function editData(id){
    $.get('/karyawan/admin/master/kategorimateri/edit/'+id,function(data){
        $('#editid').val(data[0].IDKategoriMateri);
        $('#editnama').val(data[0].NamaKategoriMateri);
    });
}

function storeData(){
    //console.log($('#formdata').serialize());
    $.post('/karyawan/admin/master/kategorimateri/store',$('#formdata').serialize())
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
    $.post('/karyawan/admin/master/kategorimateri/update',$('#formdataedit').serialize())
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
            $.get('/karyawan/admin/master/kategorimateri/delete/'+ID,function(Pesan){
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