var TabelData = $('#tabeldata').DataTable();
$(document).ready(function(){
    $('#tabeldata').DataTable();
    adminShowData();
});
function adminShowData(){
    $.get('/karyawan/admin/pendaftaran/siswa/getdata',function(Data){
        console.log(Data);
        $('#datatabel').empty();
        var a=0;
        TabelData.clear().draw();
        Data.forEach((data) =>{

            a++;
            var TombolAksi =
                "<a class=\"btn btn-success btn-sm text-white\"href=\"/karyawan/admin/pendaftaran/siswa/pembayaran/"+data.UUIDSiswa+"\">"+
                "<i class=\"fa fa-check\"></i> Cek Pembayaran</a>";
            TabelData.row.add([
                a,
                data.KodeSiswa,
                data.NamaSiswa,
                data.Alamat,
                data.Email,
                data.Status=='OPN'&& data.Pembayaran.length ==0?'Menunggu bukti pembayaran':
                data.Status=='OPN'&&data.Pembayaran.length > 0 ?'Butuh di verifikasi admin':
                data.Status=='CFM'?'Sedang di Cek Owner':'Done',
                data.created_at,
                data.Status=='OPN' && data.Pembayaran.length > 0?TombolAksi:''
            ]).draw();
        })
    
    })
}