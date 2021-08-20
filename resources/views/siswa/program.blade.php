@extends('siswa.layouts.layout')
@section('title','Program Saya')
@section('content')

<input type="hidden" value="{{session()->get('msg')}}" id="msg">
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
        <div class="table-responsive">

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
            </tbody>
          </table>
        </div>
        <!-- end project list -->

      </div>
    </div>
  </div>
</div>

<input type="hidden" id="diskon-value"
  value="
  {{-- @if(count($Program[0]['Diskon'])>0){{$Program[0]['Diskon'][0]->Nilai}}@else 0 @endif --}}
  ">
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      {{-- kunai --}}
      
      <div class=" ">
        <div class="pricing">
          <div class="title bg-primary">
            <h2 >Nama Program</h2>
            <h1 id="display-nama-prodi"></h1>
            <span id="display-pertemuan"></span>
          </div>
          <div class="x_content">
            <div class="">
              <div id="create-first" class="pricing_features">
                <ul class="list-unstyled text-left">
                  <ul class="list-group" style="margin-top:-20px">
                    <li style="list-style-type: none"><i class="fa fa-dollar text-success"></i> <strong> Harga</strong></li>
                    <div id="price-list"></div>
                  </ul>
                </ul>
              </div>
              <div id="create-sec" style="display: none" class="pricing_features">
                <ul class="list-unstyled text-left">
                  <section id="pembayaran-info"></section>
                  <li id="display-modul"></li>
                  <li id="display-tool"></li>
                  <section id="info-harga-tool"></section>
                  <div class="form-group mt-3">
                    <label for="">Tempat belajar</label>
                    <select class="custom-select" id="study-place">
                      <option value="studio">Studio</option>
                      <option value="online">Online</option>
                      <option value="homeclass">Homeclass</option>
                    </select>
                  </div>
                  <section style="display: none" id="blok-homeclass">
                    <div class="form-group mt-2">
                      <label for="">Kota</label>
                      <select class="custom-select" id="kota"></select>
                    </div>
                    <div class="form-group mt-2">
                      <label for="">Blok</label>
                      <select class="custom-select" id="blok"></select>
                    </div>
                    <section id="info-harga-homeclass"></section>
                  </section>
                  <div class="form-group mt-2">
                    <label style="margin-bottom: 0px">Total</label>
                    <p><span class="text-success" id="display-subtotal" style="font-size: 20px"></span></p>
                  </div>
                </ul>
                <button type="button" id="btn-store-transaksi" onclick="storeTransaksi()" class="btn btn-primary btn-sm">Buat transaksi</button>
              </div>
            </div>
            <div class="pricing_footer">
              <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-success btn-block"
                role="button">Batal</a>

            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<input type="hidden" name="_token" id="csrf" value="{{ csrf_token() }}" />
<input type="hidden" id="idsiswa" value="{{session()->get('IDUser')}}">




@endsection
@push('scripts')
<script>

  let DiskonAktif = [],
    Siswa = $('#idsiswa').val(),modalData
  let url_data = window.location.href.split('/')
  let id1 = url_data[5]
  let id2 = url_data[6]
  let ProgramStudi = [],Kota=[],Blok=[],Homeclass=[]
  // active program / selected program
  let programa = []
  let post_data = {'_token':$('#csrf').val()}
  let tmp_tools = [],tmp_homeclass=0
  let table_data = $('#tabeldata').DataTable()
  $(document).ready(function () {
    getDiskon()
    getData()
  });
  $('#kota').on('change',()=>{
    filterBlokByKota()
    setAndShowHomeclass()
  })
  $('#blok').on('change',()=>{
    setAndShowHomeclass()
  })
  $('#study-place').on('change',()=>{
    if($('#study-place').val()==='homeclass'){
      setAndShowHomeclass()
    }else{
      tmp_homeclass = 0
      let total_tool = tmp_tools.reduce((acc,ele)=>{
        return acc +parseInt(ele.Harga)
      },0)
      let total = total_tool + post_data.subtotal 
      $('#display-subtotal').html(numberToIDR(parseInt(total)))
      $('#blok-homeclass').hide()
    }
  })
  //kunaiz
  function setAndShowHomeclass(){
      tmp_homeclass = countHomeclass()
      let total_tool = tmp_tools.reduce((acc,ele)=>{
        return acc +parseInt(ele.Harga)
      },0)
      let diskon_val = programa.Diskon.length>0?programa.Diskon[0].Nilai:0
      let total = total_tool + post_data.subtotal + countHomeclass()
      $('#info-harga-homeclass').empty()
      $('#study-place').val()==='homeclass'&&$('#info-harga-homeclass').append('<li>Total homeclass <span class="text-success text-lg">'+numberToIDR(tmp_homeclass)+'</span></li>')
      $('#display-subtotal').html(numberToIDR(total-diskon_val))
      $('#blok-homeclass').show()
  }
  function getDiskon() {
    Promise.resolve($.get("/siswa/diskon/getdata/" + Siswa)).then((ele) => {
      DiskonAktif = ele
      showDiskon()
    })

  }

  function showDiskon() {
    let kat_program = window.location.href.split('/')[5] == '3023364374c24e03afdd50430940db3c' ?
      'semua program reguler' : 'semua program bulanan'
    if (DiskonAktif.length > 0) {
      if (DiskonAktif[0].Type == kat_program) {

      }
    }
  }


  function getData(){
    $.get("/siswa/program/get/"+id1+"/"+id2).done(data=>{
      ProgramStudi = data[0]
      Blok = data[1]
      Kota = data[2]
      Homeclass = data[3]
      Blok = Blok.filter(ele=>{
        return Homeclass.some(hc=>hc.IDBlok === ele.IDBlok && hc.IDKota === ele.IDKota)
      })
      Kota = Kota.filter(ele=>Homeclass.some(hc=>hc.IDKota===ele.IDKota))
      appendAddRowTableData()
      appendOptionKota()
      appendOptionBlok()
      filterBlokByKota()
    })
  }
  function appendOptionKota(){
    $('#kota').empty()
    Kota.forEach(ele=>{
      $('#kota').append('<option value=\''+ele.IDKota+'\'>'+ele.NamaKota+'</option>')
    })
  }
  function appendOptionBlok(){
    $('#blok').empty()
    Blok.forEach(ele=>{
      $('#blok').append('<option value=\''+ele.IDBlok+'\'>'+ele.NamaBlok+'</option>')
    })
  }
  function filterBlokByKota(){
    let kota = parseInt($('#kota').val())
    $('#blok').empty()
    Blok.filter(ele=>ele.IDKota === kota).forEach(ele=>{
      $('#blok').append('<option value=\''+ele.IDBlok+'\'>'+ele.NamaBlok+'</option>')
    })
  }
  function countHomeclass(){
    let pertemuan = programa.TotalPertemuan
    let kota = $('#kota').val()
    let blok = $('#blok').val()
    let homeclass_price = Homeclass.filter(ele=>ele.IDKota === parseInt(kota) && ele.IDBlok === parseInt(blok))[0].Biaya
    let total = parseInt(homeclass_price)*parseInt(pertemuan) 
    total = $('#study-place').val()!=='homeclass'?0:total
    return total
  }
  function appendAddRowTableData(){
    table_data.clear().draw()
    let ite = 0 
    ProgramStudi.forEach(ele=>{
      let b_detail = "<a href=\"javascript:void(0)\" onclick=\"getDetail("+ele.IDProgram+")\" data-toggle=\"modal\" data-target=\"#modaldetail\""+
                      "class=\"btn btn-primary btn-sm\"><i class=\"fa fa-folder\"></i> Detail </a>"
      ite++
      table_data.row.add([
        ite,
        ele.NamaProdi,
        ele.TotalPertemuan+' Pertemuan',
        numberToIDR(ele.HargaLunas),
        b_detail
      ]).draw()
    })
  }
  //create transaksi 
  //total = Harga lunas + diskon 
  //subtotal = total + tool + homeclass
  function storeTransaksi(){
    $('#btn-store-transaksi').prop('disabled',true)
    post_data['tt_kode[]']=[]
    post_data['tt_keterangan[]']=[]
    post_data['tt_total[]']=[]
    if(tmp_homeclass!==0){
      let uniq_code = String(Math.random()).slice(2,6)+String(new Date().getTime()).slice(9,13)
      post_data['tt_kode[]'].push('tth-'+uniq_code)
      post_data['tt_keterangan[]'].push('Biaya homeclass')
      post_data['tt_total[]'].push(tmp_homeclass)
    }
    tmp_tools.length>0&&tmp_tools.forEach(ele=>{
      let uniq_code = String(Math.random()).slice(2,6)+String(new Date().getTime()).slice(9,13)
      post_data['tt_kode[]'].push('ttt-'+uniq_code)
      post_data['tt_keterangan[]'].push(ele.Nama)
      post_data['tt_total[]'].push(ele.Harga)
    })
    if(post_data['tt_kode[]'].length>0){
      let total_tt = post_data['tt_total[]'].reduce((total,item)=>{
        return total + item
      },0)
      post_data.total=parseInt(post_data.subtotal)+parseInt(total_tt)
    }
    post_data.iddiskon = 0
    if(programa.Diskon.length>0){
      post_data.diskon=programa.Diskon[0].Nilai
      post_data.total = post_data.total - programa.Diskon[0].Nilai
      post_data.iddiskon = programa.Diskon[0].IDDiskon
    }
    post_data.tempatbelajar = $('#study-place').val()
    $.ajax({
      type: "post",
      url: "/siswa/transaksi/program",
      data: post_data,
      success: function (response) {
        $('#btn-store-transaksi').prop('disabled',false)
        $('#modaldetail').modal('hide')
        swal(response.Status, response.Message, response.Status)
        getData()
        if(response.Status==='success'){
          setTimeout(function(){
            window.open('/siswa/pembayaran/detail/'+response.Uid)
          },1500)
        }
     //   console.log('congrats',response)
      }
    });

  }
  function createTransaksi(id){
    $('#create-first').hide()
    $('#create-sec').show()
    let cicilan = id!==0?programa.Cicilan.filter(ele=>ele.IDCicilan===id)[0]:0
    let pembayaran_info_title = parseInt(id)===0&&cicilan===0?'Harga lunas':cicilan!==0?'Harga cicilan '+cicilan.Cicilan+'x':''
    let harga = parseInt(id)===0?programa.HargaLunas:cicilan.Harga
    $('#pembayaran-info').append('<li>'+pembayaran_info_title+' <span class="text-success text-lg">'+numberToIDR(harga)+'</span></li>')
    let diskon_val = programa.Diskon.length>0?programa.Diskon[0].Nilai:0
    $('#display-subtotal').html(numberToIDR(harga - diskon_val))
    post_data.hutang = parseInt(id)===0?'n':'y'
    post_data.idcicilan = parseInt(id)
    post_data.idprogram = programa.IDProgram
    post_data.total = harga
    post_data.subtotal = harga
    //ttkode ttc = homeclass , ttt = tools
  }
  function getDetail(id) {
    $('#create-sec').hide()
    $('#create-first').show()
    $('#pembayaran-info').empty()
    $('#info-harga-tool').empty()
    $('#info-harga-homeclass').empty()
    tmp_tools = []
    tmp_homeclass =0
    $('#study-place').val('studio')
    $('#blok-homeclass').hide()
    let DisplayDiskon = $('#display-diskon')
    DisplayDiskon.empty()
    programa = ProgramStudi.filter(ele=>ele.IDProgram===id)[0]
    console.log('trace ',programa)

    $('#display-nama-prodi').html(programa.NamaProdi)
    $('#display-pertemuan').html(programa.TotalPertemuan+' Pertemuan')
    const getListHarga = (id,harga,title) =>{
      //diskon
      //normal
      let show_price = programa.Diskon.length>0?
      "<span class=\"text-grey\" style=\"font-size: 18px; text-decoration: line-through;\" >("+numberToIDR(harga)+")</span>"+
      "<section><span class=\"text-success\" style=\"font-size:18px\">"+numberToIDR(harga-programa.Diskon[0].Nilai)+"</span></section>":
      "<span class=\"text-success\"style=\"font-size:18px\">"+numberToIDR(harga)+"</span></p>"
      return "<li class=\"list-group-item d-flex justify-content-between\">"+
          "<p><strong>"+title+" </strong>"+
            show_price+
          "<button type=\"button\" onclick=\"createTransaksi("+parseInt(id)+")\" class=\"btn btn-sm btn-primary\">Pilih</button>"+
      "</li>"
    }
    $('#price-list').empty()
    $('#price-list').append(getListHarga(0,programa.HargaLunas,'Lunas'))
    programa.Cicilan.length > 0 && programa.Cicilan.forEach(ele=>$('#price-list').append(getListHarga(ele.IDCicilan,ele.Harga,'Dicicil '+ele.Cicilan+'x')))
    $('#display-modul').empty()
    programa.Modul.length>0&& $('#display-modul').append('<i class="fa fa-check text-success"></i>Mendapatkan <strong>Moduls</strong>')
    if(programa.Tool.length>0){
      $('#display-tool').empty()
      let tools=''
      programa.Tool.forEach(ele=>{
          tools+=
          '<div style=\"margin-left:18px\" class=\"form-check\">'+
          '<label class=\"form-check-label\">'+
            '<input type=\"checkbox\" onchange=\"checkTool('+ele.IDTool+')\" class=\"form-check-input\" name=\"take_tool\" id=\"take-tool'+ele.IDTool+'\" >'+
            ele.NamaTool+'  <span class=\"text-success\">('+numberToIDR(ele.Harga)+')</span>'+
          '</label>'+
          '</div>'
      }) 
      $('#display-tool').append(
        '<i class="fa fa-check text-success"></i> Mendapatkan Tools'+
          tools
      );
    }


  }
  function checkTool(id){
    if(tmp_tools.some(ele=>ele.id===id)){
      tmp_tools = tmp_tools.filter(ele=>ele.id!==id)
    }else{
      let tool = programa.Tool.filter(ele=>ele.IDTool === id)[0]
      tmp_tools.push({'id':tool.IDTool,'Harga':tool.Harga,'Nama':tool.NamaTool})
    }
    let total_tool = tmp_tools.reduce((acc,ele)=>{
      return acc +parseInt(ele.Harga)
    },0)
    $('#info-harga-tool').empty()
    let diskon_val = programa.Diskon.length>0?programa.Diskon[0].Nilai:0
    tmp_tools.length>0&&$('#info-harga-tool').append('<li>Total tool <span class="text-success text-lg">'+numberToIDR(total_tool)+'</span></li>')
    let total = total_tool + post_data.subtotal + countHomeclass()
    $('#display-subtotal').html(numberToIDR(total-diskon_val))
  }
  function IDR(number) {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(number);
  }
  function formatUang(id){
            
      let uang = $('#'+id).val()
      let formated_uang = numberToIDR(uang)
      $('#'+id).val(formated_uang)

  }
  function numberToIDR(data){
      let uang = String(data)
      uang = uang.replace('Rp. ','').replaceAll('.','')
      let isnan = isNaN(uang)
      if(isnan||uang ==''){
          // console.log(true)
          uang = '0'
      }
      let formated_uang = 'Rp. '+parseInt(uang).toLocaleString('id-ID')
      return formated_uang
  }
  function IDRToNumber(data){
      let real_data = data.replace('Rp. ','').replaceAll('.','')
      return parseInt(real_data)
  }
</script>
@endpush