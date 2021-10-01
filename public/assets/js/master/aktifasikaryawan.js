var TabelData = $('#tabeldata').DataTable();
var Aktifasi;
let role = $('#role').val()==1?'owner':'admin'
let LocalData = []
console.log(role)
$(document).ready(function(){
    $('#tabeldata').DataTable();
    getData();
});

function getData(){
    $.get('/karyawan/pendaftaran/karyawan/getdata').done((Data)=>{
        console.log(Data,Data.Status)
        if(Data.Status=='success'){
            LocalData = Data['AkunKaryawan']
            console.log(LocalData)
            showData()
        }
    })
}
function showData(){
    var a=0;
    TabelData.clear().draw();
    LocalData.forEach((data) =>{
        console.log('loop all data')
        var TombolAksi = "<a class=\"btn btn-primary btn-sm\"onClick=\"confirmKaryawan(\'"+data.IDKaryawan+"\')\">"+
                        "<i class=\"fa fa-check\"></i></a>";
        if(Data.Status === 'OPN' && role === 'admin'){
            console.log(data)
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
            console.log(data)
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
function confirmKaryawan(id){
    $.get('/karyawan/'+role+'pendaftaran/karyawan/'+id,res=>{
        swal(res)
        getData()
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