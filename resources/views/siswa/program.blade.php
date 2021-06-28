@extends('siswa.layouts.layout')
@section('title','Program Saya')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Projects</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
  

            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">



          <!-- start project list -->
          <table id="tabeldata" class="table table-striped projects">
            <thead>
              <tr>
                <th style="width: 1%">#</th>
                <th style="width: 20%">Nama</th>
                <th>Pertemuan</th>
                <th>Harga</th>
                <th style="width: 20%"></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($Program as $item)
                    
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                      <a>{{$item['NamaProdi']}}</a>
                      <br />
                      <small></small>
                    </td>
                    <td>
                        {{$item['TotalPertemuan']}} Pertemuan
                    </td>
                    <input type="hidden" id="IDProgram{{$item['IDProgram']}}" value="{{$item['Tool']}}">
                    <td>
                      <h4 style="font-size:18px;" class=" text-white">
                        <div class="row">
                          <div class="col-md-9">
                            <span 
                            class="
                            @if (count($item['Diskon'])>0)       
                            bg-dark
                            @else
                            bg-success
                            @endif
                            
                            " 
                            @if (count($item['Diskon'])>0) 
                                
                            style="text-decoration: line-through"
                            @endif
                            >Rp. {{number_format($item['HargaLunas'])}}</span> <br>
                            @if (count($item['Diskon'])>0)       
                              <span  class="bg-success" >Rp. {{number_format($item['HargaLunas']*$item['Diskon'][0]->Nilai/100)}}</span> 
                            @endif
                          </div>
                          @if (count($item['Diskon'])>0) 
                              
                          <div id="display-diskon-val" class="col-md-3">
                            <div style="height: 60px;width:60px;text-align:center;border-radius:38px" class="bg-success">
                             <h5 style="padding-top: 7px" id="diskon-val">{{$item['Diskon'][0]->Nilai}}% OFF</h5>
                           </div>

                          </div>
                          @endif
                        </div>
                      </p>
                    </td>
                    <td>
                      <a href="#" onclick="getDetail({{$item['IDProgram']}})" data-toggle="modal" data-target="#modaldetail"class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> Detail </a>
                    </td>
                  </tr>
                @endforeach

               
            </tbody>
          </table>
          <!-- end project list -->

        </div>
      </div>
    </div>
  </div>
<input type="hidden" id="diskon-value" value="@if(count($Program[0]['Diskon'])>0){{$Program[0]['Diskon'][0]->Nilai}}@else 0 @endif">
  <div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
                    <div class=" ">
                        <div class="pricing">
                            <div class="title bg-primary">
                                <h2 id="display-nama-prodi"> </h2>
                                <h1 id="display-harga-lunas">Rp. 500.000</h1>
                                <span id="display-pertemuan">30 Pertemuan</span>
                            </div>
                            <div class="x_content">
                                <div class="">
                                    <div class="pricing_features">
                                        <ul class="list-unstyled text-left">
                                            <li id="display-tool" >
                                              
                                            </li>
                                            <li id="display-modul" >
                                           
                                            </li>
                                            <hr>
                                            {{--
                                              * TODO: Add UUID Program To Data
                                              --}}
                                              
                                              
                                              <ul class="list-group " style="margin-top:-20px">
                                                <li><i class="fa fa-dollar text-success"></i> <strong>Harga</strong></li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <div><strong> Lunas</strong> 
                                                      <span class="text-gray" style="font-size:18px;
                                                      @if (count($Program[0]['Diskon'])>0)text-decoration:line-through @endif" id="pembayaran-lunas" ></span>
                                                      @if (count($Program[0]['Diskon'])>0)
                                                      <span class="text-success" style="font-size:18px" id="display-harga-diskon"></span>
                                                      @endif
                                                    </div>
                                                    <form method="POST" action="{{url('siswa/transaksi/program')}}" >
                                                    <input type="hidden" id="csrf" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="idcicilan" value="0">
                                                    <input type="hidden" name="cicilan" value="n">
                                                    <input type="hidden" id="hargalunas" name="harga" >
                                                    <input type="hidden" class="program" name="program">
                                                    <button type="submit" class="btn btn-sm btn-primary">Pilih</button>
                                                    </form>
                                                </li>
                                                <div id="display-cicilan" >
                                                  
                                                </div>
                                            </ul>
                                         

                                        </ul>
                                    </div>
                                </div>
                                <div class="pricing_footer">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-success btn-block" role="button">Kembali</a>
                           
                                </div>
                            </div>
                        </div>
                    </div>

  
        </div>
    </div>
  </div>
  <input type="hidden" id="idsiswa" value="{{session()->get('IDUser')}}">


  
{{-- <div class="list-group">
        @foreach($Program as $Item)
        <a href="#" onclick="showHarga('{{$Item->UUID}}')" style="text-align:left" class="list-group-item
list-group-item-action">
<div class="row">
    <div class="col-2">
        <img style="width:70px;height:auto" src="https://gpatindia.com/wp-content/uploads/2018/12/study-materials.png"
            alt="">
    </div>
    <div class="col-10">
        <span style="font-size:15px">{{$Item->NamaProdi}}</span> <br>
        <span style="font-size:13px">Rp. {{number_format($Item->Harga)}}</span> <br>
        <span style="font-size:12px">{{$Item->TotalPertemuan}} Pertemuan</span>
    </div>
</div>
</a>
<input type="hidden" id="c{{$Item->UUID}}" value="{{$Item->Cicilan}}">
<ul class="list-group" style="display:none" id="h{{$Item->UUID}}">
    <li class="list-group-item">
        <div class="row">
            <div style="text-align:left" class="col-6">
                <span>Lunas</span>
            </div>
            <div style="text-align:right" class="col-6">
                <form action="{{url('siswa/transaksi/program')}}" method='post'>
                    <input type="hidden" id="csrf" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="idcicilan" value="0">
                    <input type="hidden" name="cicilan" value="n">
                    <input type="hidden" name="harga" value="{{$Item->Harga}}">
                    <input type="hidden" id="ip{{$Item->UUID}}" name="program" value="{{$Item->IDProgram}}">
                    <button type="submit" class="btn btn-sm btn-success">Pilih</button>
                </form>
            </div>
        </div>
    </li>
    <div id="hc{{$Item->UUID}}"></div>
</ul>
@endforeach
</div> --}}
@endsection
@push('scripts')
<script >
let DiskonAktif = [] , Siswa = $('#idsiswa').val()
$(document).ready(function(){

    $('#tabeldata').DataTable();
    getDiskon() 
});
function getDiskon(){
  Promise.resolve( $.get("/siswa/diskon/getdata/"+Siswa)).then((ele)=>{
    DiskonAktif = ele
    showDiskon()
  })

}
function showDiskon(){
  let kat_program = window.location.href.split('/')[5] =='3023364374c24e03afdd50430940db3c'?'semua program reguler':'semua program bulanan'
  if(DiskonAktif.length>0){
    if(DiskonAktif[0].Type==kat_program){
      
    }
  }
}
function getDetail(id){
  let diskon_value = $('#diskon-value').val()
  console.log(diskon_value)
  $.get('/siswa/jprogram/getDetail/'+id,(data)=>{
    $('#display-modul').empty();
    $('#display-tool').empty();
    $('#display-cicilan').empty();
    $('#display-nama-prodi').html(data[0].NamaProdi);
    $('#display-harga-lunas').html(IDR(data[0].HargaLunas));
    $('#display-harga-diskon').html(IDR(data[0].HargaLunas*diskon_value/100));
    $('#display-pertemuan').html(data[0].TotalPertemuan + ' Pertemuan');
    //show harga lunas
    $('#pembayaran-lunas').html('('+IDR(data[0].HargaLunas)+')');
    //input harga lunas
    $('#hargalunas').val(diskon_value == 0 ?data[0].HargaLunas:data[0].HargaLunas*diskon_value/100);
    $('.program').val(data[0].IDProgram);
    if(data[0].Tool!=false){
      $('#display-tool').append(
        '<i class="fa fa-check text-success"></i>Mendapatkan Tools'
      );
    }
    if(data[0].Modul!=false){
      $('#display-modul').append(
        '<i class="fa fa-check text-success"></i>Mendapatkan <strong>Moduls</strong>'
      );
    }
    if(data[0].Cicil=='y'){

      data[0].Cicilan.forEach((cicil)=>{
        $('#display-cicilan').append(
          '<li style=\"margin-top:0px\" class="list-group-item d-flex justify-content-between">'+
              '<div>'+
                '<strong> Cicilan '+cicil.Cicilan+'x </strong> '+
                '<span class=\"text-success\" style=\"font-size:18px\" >'+
                  '(' + IDR(cicil.Harga)+')'+  
                '</span>'+
              '</div>'+
              '<form method=\"POST\" action=\"/siswa/transaksi/program\" >'+
              '<input type=\"hidden\"  name=\"_token\" value=\"'+$("#csrf").val()+'\">'+
              '<input type=\"hidden\" name=\"idcicilan\" value=\"'+cicil.IDCicilan+'"\>'+
              '<input type=\"hidden\" name=\"cicilan\" value=\"y"\>'+
              '<input type=\"hidden\" id=\"hargalunas\" name=\"harga\" value=\"'+cicil.Harga+'\">'+
              '<input type=\"hidden\" value=\"'+cicil.IDProgram+'\" class=\"program\" name=\"program\">'+
              '<button type=\"submit\" class=\"btn btn-sm btn-primary\">Pilih</button>'+
              '</form>'+
          '</li>'
        );
      });
    }
  })
}
function IDR(number){
       return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(number);
    }
</script>
@endpush