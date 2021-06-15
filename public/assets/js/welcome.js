$(document).ready(function(){
    if($('#errors').val()!=='[]'){
        var error =$('#errors').val();
        var newerror=error.replace(/\[/g,'').replace(/]/g,'').replace(/"/g,'');
        swal('',newerror);
    }

    // if($('#errors').val()==''){

    // }
});
$(function(){
    $('#inUsernameDaftar').keyup(function(){
        cekUsername($('#inUsernameDaftar'));
    });
    $('#inEmailDaftar').keyup(function(){
        cekEmail($('#inEmailDaftar'));
    });
    $('#inPasswordDaftar').keyup(function(){
        passwordAssist($('#inPasswordDaftar'));
    });
    $(document).on('click','#btnDaftar',function(){
        validasiFormDaftar();
    });
    $(document).on('click','#btnMasuk',function(){
        validasiFormMasuk();
    })
});
function validasiFormDaftar(){
    var IsValid=false;
    IsValid = validasiInput(
        $('#inNamaLengkap'),
        $('#inNamaLengkap').val()==''?1:0,
        $('#validNamaLengkap'),
        '* Nama tidak boleh kosong'
    )&& validasiInput(
        $('#inJenisKelamin'),
        $('#inJenisKelamin').val()==''?1:0,
        $('#validJenisKelamin'),
        '* Pilih Jenis Kelamin'
    )&&validasiInput(
        $('#inTanggalLahir'),
        $('#inTanggalLahir').val()==''?1:0,
        $('#validTanggalLahir'),
        '* Tanggal lahir tidak boleh kosong!'
    )&&validasiInput(
        $('#inTempatLahir'),
        $('#inTempatLahir').val()==''?1:0,
        $('#validTempatLahir'),
        '* Tempat lahir tidak boleh kosong!'
    )&&validasiInput(
        $('#inAlamat'),
        $('#inAlamat').val()==''?1:0,
        $('#validAlamat'),
        '* Alamat tidak boleh kosong!'
    )&&validasiInput(
        $('#inNoHP'),
        $('#inNoHP').val()==''?1:0,
        $('#validNoHP'),
        '* No HP tidak boleh kosong!'
    )&&validasiInput(
        $('#inUsernameDaftar'),
        $('#inUsernameDaftar').val()==''?1:0,
        $('#validUsernameDaftar'),
        '* Username tidak boleh kosong!'
    )&&validasiInput(
        $('#inPasswordDaftar'),
        $('#inPasswordDaftar').val()==''?1:0,
        $('#validPasswordDaftar'),
        '* Password tidak boleh kosong!'
    );
    if(IsValid){
        storeDaftar();
        //showSyarat();
    }
}
function validasiFormMasuk(){
    var IsValid=false;
    IsValid = validasiInput(
        $('#inUsernameMasuk'),
        $('#inUsernameMasuk').val()==''?1:0,
        $('#validUsernameMasuk'),
        '* Username tidak boleh kosong!'
    )&&validasiInput(
        $('#inPasswordMasuk'),
        $('#inPasswordMasuk').val()==''?1:0,
        $('#validPasswordMasuk'),
        '* Password tidak boleh kosong!'
    );
    if(IsValid){
        $('#datamasuk').submit();
    }
}
function storeDaftar(){
    $('#datadaftar').submit();
}
// function showSyarat(){
//     $('#modal-syarat').modal('show');
// }
function cekUsername(ele){
    let formData = $('#datadaftar').serialize()
    $.get('auth/cekusername/'+ $('#inUsernameDaftar').val(),data=>
        validasiInput(ele,data,$('#validUsernameDaftar'),'* Username sudah dipakai!')
    );
}
function cekEmail(ele){
    $.get('auth/cekemail/'+ $('#inEmailDaftar').val(),data=>
        validasiInput(ele,data,$('#validEmailDaftar'),'* Email sudah dipakai!')
    );
}
function passwordAssist(ele){
    const lower = (val) => val == val.toLowerCase();
    const upper = (val) => val == val.toUpperCase();
    const number = (val) => !isNaN(val*1);
    const char = (val) => Array.from(val);
    const level = (val) => val.length==0?{'pesan':'* Kosong ','status':0}:val.length<=8?{'pesan':'* Password terlalu pendek','status':1}:val.some(lower) && val.some(upper) &&val.some(number) ?{'pesan':'* Password kuat','status':0}:{'pesan':'* Gunakan kombinasi huruf besar dan angka','status':1};
    let val = level(char($('#inPasswordDaftar').val()));
    validasiInput(ele,val.status,$('#validPasswordDaftar'),val.pesan);
}

function validasiInput(ele,status,elePesan,pesan){
    if(status==0){
        ele.addClass('ss-input');
        ele.removeClass('ss-input-danger');
        elePesan.hide();
        elePesan.empty();
        return true;
    }else{
        ele.addClass('ss-input-danger');
        ele.removeClass('ss-input');
        elePesan.empty();
        elePesan.append(pesan);
        elePesan.show();
        return false;
    }
}
// function tombolDaftar(){
//     console.log(window.location.search.substring(1));
//     $('#formdaftar').show();
//     $('#formlogin').hide();
// }
// function tombolLogin(){
//     console.log(window.location.search);
//     $('#formdaftar').hide();
//     $('#formlogin').show();
// }