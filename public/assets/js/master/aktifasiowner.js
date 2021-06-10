var TabelData = $('#tabeldata').DataTable();
var Aktifasi;

$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
});

function showData(){
    $.get('/karyawan/owner/pendaftaran/karyawan/getdata',function(Data){console.log(Data);
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data['AkunKaryawan'].forEach((data) =>{


            if(Data.Status == 'OPN'){

            }
                a++;
                var TombolAksi = "<a class=\"btn btn-primary btn-sm\"href=\"/karyawan/owner/pendaftaran/karyawan/update/"+data.IDKaryawan+"\">"+
                                "<i class=\"fa fa-check\"></i></a>";
                TabelData.row.add([
                    a,
                    data.NamaKaryawan,
                    data.TanggalLahir,
                    data.TempatLahir,
                    data.JenisKelamin,
                    data.Alamat,
                    data.NoHP,
                    TombolAksi
                ]).draw();
            })
        }
    })
}

function storeData(){
    //console.log($('#formdata').serialize());
    $.post('/karyawan/admin/master/aktifasi/store',$('#formdata').serialize())
    .done(function(pesan){
        showData();
        swal(pesan.Pesan);
    }).fail(function(pesan){
        console.log(pesan.Message);
        swal('gagal'+pesan.Pesan);
    });
}