var TabelData = $('#tabeldata').DataTable();
var ProgramStudi;
var KategoriMateri;

$(document).ready(function(){
    $('#tabeldata').DataTable();
    showData();
});
function showData(){
    $.get('/karyawan/admin/transaksi/getdata',function(Data){
        if(Data.Status=='success'){
            $('#datatabel').empty();
            var a=0;
            TabelData.clear().draw();
            Data.Transaksi.forEach((data) =>{
                console.log(data);
                a++;
                var TombolAksi =
                    "<a class=\"btn btn-danger btn-sm text-white\"onclick=\"deleteData('"+data.IDTransaksi+"')\">"+
                        "<i class=\"fa fa-trash\"></i></a>";
                var TombolVerif = 
                "<a class=\"btn btn-success btn-sm text-white\"href=\"/karyawan/admin/transaksi/detail/"+data.UUIDTransaksi+"\">"+
                "<i class=\"fa fa-check\"></i></a>";
                TabelData.row.add([
                    a,
                    data.KodeTransaksi,
                    data.Status=='OPN'?'Belum Bayar':
                    data.Status=='PND'?'Belum di verifikasi':
                    data.Status=='CFM'?'Sedang diproses':
                    data.Status=='CLS'?'Selesai':'Dibatalkan',
                    data.NamaSiswa,
                    data.NamaProdi,
                    'Rp '+formatNumber(data.SubTotal),
                    'Rp '+formatNumber(data.Total),
                    data.Cicilan=='y'?'Ya':'Tidak',
                    data.created_at,
                    data.Status=='PND'?TombolAksi +TombolVerif:TombolAksi
                ]).draw();
            })
        }
    })
}
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}   