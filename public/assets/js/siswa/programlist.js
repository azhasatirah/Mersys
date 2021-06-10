$(document).ready(function(){

});

$(function(){
    $(document).on('click','.kategori',function(){
        console.log('okee');
    });
});

function showHarga(ID){
    console.log(ID);
    if($('#h'+ID).css('display')=='none'){
        if($('#c'+ID).val()=='y'){
            $('#h'+ID).show();
            $.get('/siswa/program/harga/'+ID,function(Items){
                console.log(Items);
                $('#hc'+ID).empty();
                
                Items.Harga.forEach((item)=>{  
                    $('#hc'+ID).append(
                        "<li class=\"list-group-item\">"+
                            "<div class=\"row\">"+
                                "<div  style=\"text-align:left\" class=\"col-6\">"+
                                    "<span> Cicilan "+item.Cicilan+" Kali</span>"+
                                "</div>"+
                                "<div style=\"text-align:right\" class=\"col-6\">"+
                                    "<form action=\"/siswa/transaksi/program\" method='post'>"+
                            
                                        "<input type=\"hidden\" name=\"_token\" value=\""+$('#csrf').val()+"\"> "+
                                        "<input type=\"hidden\" name=\"idcicilan\" value=\""+item.IDCicilan+"\"> "+
                                        "<input type=\"hidden\" name=\"harga\" value=\""+item.Harga+"\"> "+
                                        "<input type=\"hidden\" name=\"cicilan\" value=\"y\"> "+
                                        "<input type=\"hidden\" name=\"program\" value=\""+$('#ip'+ID).val()+"\">  "+         
                                        "<button type=\"submit\" class=\"btn btn-sm btn-success\">Pilih</button>"+
                                    "</form>"+
                                "</div>"+
                            "</div>"+
                        "</li>"
                    );
                });
            });
        }else{

            $('#h'+ID).show();
        }
    }else{
        $('#h'+ID).hide();
    }

}