var TabelData = $('#tabeldata').DataTable();
var Aktifasi;
let role = $('#role').val()==1?'owner':'admin'
$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
});

function showData(){
    console.log('hi')
    $.ajax({
        type: "get",
        url: '/karyawan/pendaftaran/karyawan/getdata',
        success: function (Data) {
            console.log(Data,Data.Status)
            if(Data.Status=='success'){
                $('#datatabel').empty();
                var a=0;
                TabelData.clear().draw();
                Data['AkunKaryawan'].forEach((data) =>{
                    console.log(data)
                    var TombolAksi = "<a class=\"btn btn-primary btn-sm\"onClick=\"confirmKaryawan(\'"+data.IDKaryawan+"\')\">"+
                                    "<i class=\"fa fa-check\"></i></a>";
                    if(Data.Status === 'OPN' && role === 'admin'){
                        a++;
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
                    }
                    if(Data.Status === 'CFM' && role === 'owner'){
                        a++;
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
                    }
                })
            }
        }
    });
    // $.get('/karyawan/pendaftaran/karyawan/getdata').done(Data=>{
    //     console.log(Data,Data.Status)
    //     if(Data.Status=='success'){
    //         $('#datatabel').empty();
    //         var a=0;
    //         TabelData.clear().draw();
    //         Data['AkunKaryawan'].forEach((data) =>{
    //             console.log(data)
    //             var TombolAksi = "<a class=\"btn btn-primary btn-sm\"onClick=\"confirmKaryawan(\'"+data.IDKaryawan+"\')\">"+
    //                             "<i class=\"fa fa-check\"></i></a>";
    //             if(Data.Status === 'OPN' && role === 'admin'){
    //                 a++;
    //                 TabelData.row.add([
    //                     a,
    //                     data.NamaKaryawan,
    //                     data.TanggalLahir,
    //                     data.TempatLahir,
    //                     data.JenisKelamin,
    //                     data.Alamat,
    //                     data.NoHP,
    //                     TombolAksi
    //                 ]).draw();
    //             }
    //             if(Data.Status === 'CFM' && role === 'owner'){
    //                 a++;
    //                 TabelData.row.add([
    //                     a,
    //                     data.NamaKaryawan,
    //                     data.TanggalLahir,
    //                     data.TempatLahir,
    //                     data.JenisKelamin,
    //                     data.Alamat,
    //                     data.NoHP,
    //                     TombolAksi
    //                 ]).draw();
    //             }
    //         })
    //     }
    // })
}
function confirmKaryawan(id){
    $.get('/karyawan/'+role+'pendaftaran/karyawan/'+id,res=>{
        swal(res)
        showData()
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