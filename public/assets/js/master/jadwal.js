var TabelData = $('#tabeldata').DataTable();
var Jadwal;

$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
});

function showData(){
    $.get('/karyawan/admin/master/jadwal/getdata',function(Data){console.log(Data);
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data['Jadwal'].forEach((data) =>{


            if(Data.Status == 'CFM'){

            }
                a++;
                var TombolAksi = 
                "<a class=\"btn btn-primary btn-sm\"href=\"/karyawan/admin/master/jadwal/edit/"+data.NamaSiswa+"\">"+
                                "<i class=\"fa fa-edit\"></i></a>";
                TabelData.row.add([
                    a,
                    // data.IDSiswa,
                    data.NamaSiswa,
                
                    TombolAksi
                ]).draw();
            })
        }
    })
}

function storeData(){
    //console.log($('#formdata').serialize());
    $.post('/karyawan/admin/master/jadwal/store',$('#formdata').serialize())
    .done(function(pesan){
        showData();
        swal(pesan.Pesan);
    }).fail(function(pesan){
        console.log(pesan.Message);
        swal('gagal'+pesan.Pesan);
    });
}