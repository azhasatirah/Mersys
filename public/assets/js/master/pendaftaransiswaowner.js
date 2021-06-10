var TabelData = $('#tabeldata').DataTable();
$(document).ready(function(){
    $('#tabeldata').DataTable();
    adminShowData();
});
function adminShowData(){
    $.get('/karyawan/owner/pendaftaran/siswa/getdata',function(Data){
        console.log(Data);
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data.Siswa.forEach((data) =>{
                a++;
                var TombolAksi =
                    "<a class=\"btn btn-success btn-sm text-white\"href=\"/karyawan/owner/pendaftaran/siswa/pembayaran/"+data.UUIDSiswa+"\">"+
                    "<i class=\"fa fa-check\"></i> Cek Pembayaran</a>";
                TabelData.row.add([
                    a,
                    data.KodeSiswa,
                    data.NamaSiswa,
                    data.Alamat,
                    data.Email,
                    data.Status=='OPN'&& data.Pembayaran.length ==0?'Menunggu bukti pembayaran':
                    data.Status=='OPN'&&data.Pembayaran.length > 0 ?'Sedang di cek admin':
                    data.Status=='CFM'?'Segera verifikasi bukti pembayaran':'Done',
                    data.created_at,
                    data.Status=='CFM'?TombolAksi:''
                ]).draw();
            })
        }
    })
}