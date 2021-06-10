var TabelData = $('#tabeldata').DataTable();
var ProgramStudi;
var KategoriMateri;
var CicilanCreate = 0;


$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
});

$(function(){
    $(document).on('click','#tombolcreate',function(){
        storeData();
    });
    $('#modaledit').on('show.bs.modal',function(event){
        var Button = $(event.relatedTarget);
        var IDData = Button.data('id');
        editData(IDData);     
    })
});
function hapuscicilancreate(id){
    $('#cicilanjeniscreate'+id).remove();
}
function injumlahcicilancreate(id){
    $('#labeljumlahcicilancreate'+id).empty().append($('#injumlahcicilancreate'+id).val()+'x');
}
function clearFormCreate(){
    $('.form-control').val('');
}

function setSelectKategori(id){
    $('#editkategori').find('option').remove();
    $.get('/karyawan/admin/master/kategoriprogram/getdata').done(
        (data) => {
            data['KategoriProgram'].forEach(
                (val)=> {
                    var select = val.IDKategoriProgram==id?'selected':'';
                    $('#editkategori').append(
                        "<option value=\""+val.IDKategoriProgram+"\""+select+">"+
                        val.KategoriProgram+"</option>"
                    );
                }
            );
        }
    );
}


function showData(){
    $.get('/karyawan/admin/master/program/getdata',function(Data){
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data.ProgramStudi.forEach((data) =>{

                a++;
                var TombolAksi ="<a class=\"btn btn-primary btn-sm text-white\""+ 
                "href=\"/karyawan/admin/master/program/show/"+data.UUIDProgram+"\">"+
                "detail</a>"+
                    "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteData('"+data.IDProgram+"')\">"+
                        "<i class=\"fa fa-trash\"></i></a>";
                TabelData.row.add([
                    a,
                    data.KodeProgram,
                    data.NamaProdi,
                    data.TotalPertemuan,
                    'Rp '+formatNumber(data.Harga),
                    data.Cicilan=='y'?'Ya':'Tidak',
                    data.NamaLevel,
                    data.KategoriProgram,
                    TombolAksi
                ]).draw();
            })
        }
    })
}
function editData(id){
    $.get('/karyawan/admin/master/program/edit/'+id,function(data){
        $('#editid').val(data[0].IDProgram);
        $('#editprogram').val(data[0].NamaProdi);
        $('#edittotalpertemuan').val(data[0].TotalPertemuan);
        $('#editharga').val(data[0].Harga);
        setSelectLevel(data[0].IDLevel);
        setSelectKategori(data[0].IDKategoriProgram);
        $('#editcicilan').val(data[0].Cicilan);
    });
}

function storeData(){
    //console.log($('#formdata').serialize());
    $.post('/karyawan/admin/master/program/store',$('#formdata').serialize())
    .done(function(pesan){
        console.log(pesan);
        showData();
        swal(pesan.Pesan);
        $('#modalcreate').modal('hide');
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
            $.get('/karyawan/admin/master/program/delete/'+ID,function(Pesan){
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
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}