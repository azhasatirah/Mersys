@extends('karyawan.layouts.layout')
@section('title','Tambah Program')
@section('content')

<div class="row">

    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">

            <div class="x_content">

                <h2>Tambah Program</h2>
                <!-- Tabs -->
                <form id="form-data" method="POST" action="{{url('/karyawan/admin/master/program/store')}}"
                enctype="multipart/form-data">
                    @csrf
                    <div id="wizard_verticle" style="height:auto" class="form_wizard  wizard_horizontal">
                        <ul class="list-unstyled wizard_steps">
                            <!-- active add class selected -->
                            <li>
                                <a id="step-11" class="selected">
                                    <span class="step_no">1</span>
                                </a>
                            </li>
                            <li>
                                <a id="step-22" class="disabled">
                                    <span class="step_no">2</span>
                                </a>
                            </li>
                            <li>
                                <a id="step-33" class="disabled">
                                    <span class="step_no">3</span>
                                </a>
                            </li>
                            <li>
                                <a id="step-44" class="disabled">
                                    <span class="step_no">4</span>
                                </a>
                            </li>
                            <li>
                                <a id="step-55" class="disabled">
                                    <span class="step_no">5</span>
                                </a>
                            </li>
                            <li>
                                <a id="step-66" class="disabled">
                                    <span class="step_no">6</span>
                                </a>
                            </li>
                            <li>
                                <a id="step-77" class="disabled">
                                    <span class="step_no">7</span>
                                </a>
                            </li>
    
                        </ul>
                        <div class="stepContainer">
                            <!-- aktif add style display block and  class content -->
                            <!-- step 1 data program -->
                            <div id="step-1" style="display:block" class="content">
                                <h2 class="StepTitle">Step 1</h2>
                                <form class="form-horizontal form-label-left">
    
                                    <span class="section">Program Studi</span>
    
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="namaprogram">Nama
                                            Program
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" name="namaprogram" id="namaprogram" required="required"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align">Level *</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <select name="level" class="select2_group form-control">
                                                @foreach ($LevelProgram['LevelProgram'] as $item)                
                                                <option value="{{$item->IDLevel}}">{{$item->NamaLevel}}</option>
                                                @endforeach
    
    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align">Kategori Program
                                            *</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <select name="kategori" class="select2_group form-control">
                                                @foreach ($KategoriProgram['KategoriProgram'] as $item1)
                                                    <option value="{{$item1->IDKategoriProgram}}">{{$item1->KategoriProgram}}</option>
                                                @endforeach
    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align">Kategori Global Program
                                            *</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <select name="kategoriglobal" class="select2_group form-control">
                                                @foreach ($KategoriGlobalProgram['KategoriGlobal'] as $item2)
                                                    <option value="{{$item2->IDKategoriGlobalProgram}}">{{$item2->KategoriGlobalProgram}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- step 2 pertemuan -->
                            <div id="step-2" style="display:none">
                                <h2 class="StepTitle">Step 2</h2>
                                <span class="section">Pertemuan</span>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="totalpertemuan">Total
                                        Pertemuan
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="total-pertemuan" name="totalpertemuan" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div id="form-master">


                                </div>
                            </div>
                            <div id="step-3" style="display:none">
                                <h2 class="StepTitle">Step 3</h2>
                                <span class="section">Modul</span>
                                <a id="add_modul" class="btn btn-primary text-white">Tambah modul</a>
                                <label class="text-dark"> Skip jika tidak ada modul</label>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Modul</th>
                                            <th>Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="modul">

                                    </tbody>
                                </table>
                                
                             
                            </div>
                            <div id="step-4" style="display:none">
                                <h2 class="StepTitle">Step 4</h2>
                                <span class="section">Tools</span>
                                <a id="add_tool" class="btn btn-primary text-white">Tambah tool</a>
                                <label class="text-dark"> Skip jika program ini tidak memakai tool</label>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Nama tool</th>
                                            <th>Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tool">

                                    </tbody>
                                </table>
                            </div>
                            <div id="step-5" style="display:none">
                                <h2 class="StepTitle">Step 5</h2>
                                <span class="section">Video</span>
                                <a id="add_video" class="btn btn-primary text-white">Tambah video</a>
                                <label class="text-dark"> Skip jika program ini tidak memakai video</label>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Link</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="video">

                                    </tbody>
                                </table>
                            </div>
                            <!-- step 5 harga -->

                            <div id="step-6" style="display:none">
                                <h2 class="StepTitle">Step 6</h2>
                                <span class="section">Bahan tutor</span>
                                <a id="add_bahantutor" class="btn btn-primary text-white">Tambah bahan tutor</a>
                                <label class="text-dark"> Bahan yang dibutuhkan tutor</label>
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>File</th>
                                      
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bahantutor">

                                    </tbody>
                                </table>
                            </div>

                            <div id="step-7" style="display:none">
                                <h2 class="StepTitle">Step 7</h2>
                                <span class="section">Harga</span>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Harga Program 
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="harga" name="harga" required="required"
                                        onchange="countSubtotal()"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Total Modul 
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="harga_modul_total" readonly required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Total Tools 
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="harga_tool_total" readonly  required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Subtotal (Harga Lunas)
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="harga_subtotal" readonly  required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Cicilan *</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select name="cicilan" id="cicilancreate" value="n" class="select2_group form-control">
    
                                            <option value="n">tidak</option>
                                            <option value="y">ya</option>
    
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3"></div>
                                </div>
                                <div id="hargacicilancreate"></div>
                                <div id="tambahcicilancreate"></div>
                            </div>

                        </div>
                        <div class="actionBar">
                            <div class="msgBox">
                                <div class="content"></div><a href="#" class="close">X</a>
                            </div>
                                <div class="loader">Loading</div>
                                <a href="#" id="prev-button"
                                    class="buttonPrevious  btn btn-primary">Sebelumnya</a>
                                <a href="#" id="next-button"
                                    class="buttonNext btn btn-success">Berikutnya</a>
                                <button type="submit" id="save-button"
                                    class="buttonFinish  btn btn-default">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let prevButton = $('#prev-button');
    let nextButton = $('#next-button');
    let saveButton = $('#save-button');
    let content1 = $('#step-1');
    let content2 = $('#step-2');
    let content3 = $('#step-3');
    let content4 = $('#step-4');
    let content5 = $('#step-5')
    let content6 = $('#step-6');
    let content7 = $('#step-7');
    let stepNav1 = $('#step-11');
    let stepNav2 = $('#step-22');
    let stepNav3 = $('#step-33');
    let stepNav4 = $('#step-44');
    let stepNav5 = $('#step-55');
    let stepNav6 = $('#step-66');
    let stepNav7 = $('#step-77');

    //items//
    let step = 1;
    let CicilanCreate =0;
    let modul = 0;
    let tool = 0;
    let video = 0;
    let bahantutor = 0;

    //HARGA//
    let hargaTotalModul=0;
    let hargaTotalTool=0;

    $(document).ready(function () {
        console.log('siap');
        showButtonByStep(step);

    });

    $(function(){
        $(document).on('click','#add_modul',function(){
            modul +=1;
            $('#modul').append(
                "<tr id=\"modul"+modul+"\">"+
                    "<td>"+
                        "<input type=\"text\" name=\"nama_modul[]\" style=\"width: auto\""+
                        " required=\"required\"class=\"form-control\">"+
                    
                    "</td>"+
                    "<td>"+
                        "<div class=\"bg-primary text-white text-center text-lg\" style=\"border-radius: 2px\">"+

                            "<label for=\"input_modul"+modul+"\""+
                            "style=\"min-width: 10rem;cursor:pointer;margin-top:5px\""+
                            "><i class=\"fa fa-upload\"></i> Pilih modul</label>"+
                        "</div>"+
                        "<input type=\"file\" style=\"display: none\" name=\"modul[]\" id=\"input_modul"+modul+"\" multiple required=\"required\""+
                        "class=\"form-control\">"+
                    "</td>"+
                    "<td>"+
                        "<input type=\"text\" name=\"harga_modul[]\" style=\"width: auto\""+
                        "id=\"harga_modul"+modul+"\"onchange=\"countTotalHargaModul()\""+
                        " required=\"required\""+
                        "class=\"form-control\">"+
                    "</td>"+
                    "<td scope=\"row\">"+
                        "<a onclick=\"hapusModul("+modul+")\" class=\"btn btn-danger text-white\"><i class=\"fa fa-trash\"></i></a>"+
                    "</td>"+
                "</tr>"
            );
           
        });
        $(document).on('click','#add_tool',function(){
            tool +=1;
            $('#tool').append(
                "<tr id=\"tool"+tool+"\">"+
                    "<td>"+
                        "<input type=\"text\" name=\"nama_tool[]\" style=\"width: auto\""+
                        " required=\"required\"class=\"form-control\">"+
                    
                    "</td>"+
                    "<td>"+
                        "<input type=\"text\" name=\"harga_tool[]\" style=\"width: auto\""+
                        "id=\"harga_tool"+tool+"\" onchange=\"countTotalHargaTool()\""+
                        "required=\"required\""+
                        "class=\"form-control\">"+
                    "</td>"+
                    "<td scope=\"row\">"+
                        "<a onclick=\"hapusTool("+tool+")\" class=\"btn btn-danger text-white\"><i class=\"fa fa-trash\"></i></a>"+
                    "</td>"+
                "</tr>"
            );
        });
        $(document).on('click','#add_video',function(){
            video +=1;
            $('#video').append(
                "<tr id=\"video"+video+"\">"+
                    "<td>"+
                        "<input type=\"text\" name=\"judul_video[]\" style=\"width: auto\""+
                        " required=\"required\"class=\"form-control\">"+
                    
                    "</td>"+
                    "<td>"+
                        "<input type=\"text\" name=\"link_video[]\" style=\"width: auto\""+
                        "id=\"link_video"+video+"\" onchange=\"countTotalHargaTool()\""+
                        "required=\"required\""+
                        "class=\"form-control\">"+
                    "</td>"+
                    "<td scope=\"row\">"+
                        "<a onclick=\"hapusVideo("+video+")\" class=\"btn btn-danger text-white\"><i class=\"fa fa-trash\"></i></a>"+
                    "</td>"+
                "</tr>"
            );
        });
        $(document).on('click','#add_bahantutor',function(){
            bahantutor +=1;
            $('#bahantutor').append(
                "<tr id=\"bahantutor"+bahantutor+"\">"+
                    "<td>"+
                        "<input type=\"text\" name=\"nama_bahantutor[]\" style=\"width: auto\""+
                        " required=\"required\"class=\"form-control\">"+
                    
                    "</td>"+
                    "<td>"+
                        "<input type=\"file\" name=\"file_bahantutor[]\" style=\"width: auto\""+
                        " required=\"required\"class=\"form-control\">"+ 
                    "</td>"+
                    "<td scope=\"row\">"+
                        "<a onclick=\"hapusBahanTutor("+bahantutor+")\" class=\"btn btn-danger text-white\"><i class=\"fa fa-trash\"></i></a>"+
                    "</td>"+
                "</tr>"
            );
        });
        $(document).on('change','#total-pertemuan',function(){
            console.log($('#total-pertemuan').val());
            showMasterForm($('#total-pertemuan').val());
        });
        $(document).on('click','#prev-button',function(){
            step -=1;
            showButtonByStep(step);
        });
        $(document).on('click','#next-button',function(){
            step +=1;
            showButtonByStep(step);
        });
        $(document).on('click','#save-button',function(){
            
        });

        $(document).on('change','#cicilancreate',function(){
            CicilanCreate += 1;
            if($('#cicilancreate').val()=='y'){
                $('#hargacicilancreate').empty().append(
                "<div class=\"form-group\" id=\"cicilanjeniscreate"+CicilanCreate+"\" style=\"margin-left:12px\">"+
                    "Cicilan <span id=\"labeljumlahcicilancreate"+CicilanCreate+"\"></span>"+
                    "<div class=\"row mt-1 \" >"+
                        "<div class=\"col col-md-5\" style=\"padding-left: 10px;\">"+
                        "<input type=\"number\" id=\"injumlahcicilancreate"+CicilanCreate+"\" onkeyup=\"injumlahcicilancreate("+CicilanCreate+")\" name=\"jumlahcicilan[]\" class=\"form-control\" placeholder=\"Dicicil berapa kali\">"+
                        "</div>"+
                        "<div class=\"col col-md-5\" >"+
                        "<input type=\"text\" name=\"hargacicilan[]\" class=\"form-control\" placeholder=\"Harga Cicilan\">"+
                        "</div>"+
                        "<div class=\"col col-md-2\" >"+
                        "</div>"+     
                    "</div>"+
                "</div>"
                );
                $('#tambahcicilancreate').empty().append(
                    "<div class=\"form-group\" style=\"margin-left:12px\">"+
                        "<a id=\"btntambahcicilancreate\" class=\"btn btn-sm btn-primary text-white\">Tambah cicilan</a>"+
                    "</div>"
                );
            }else{
                $('#hargacicilancreate').empty();
                $('#tambahcicilancreate').empty();
            }
        });
        $(document).on('click','#btntambahcicilancreate',function(){
            CicilanCreate += 1;
            $('#hargacicilancreate').append(
                "<div class=\"form-group\" id=\"cicilanjeniscreate"+CicilanCreate+"\" style=\"margin-left:12px\">"+
                    "Cicilan <span id=\"labeljumlahcicilancreate"+CicilanCreate+"\"></span>"+
                    "<div class=\"row mt-1 \" >"+
                        "<div class=\"col col-md-5\" style=\"padding-left: 10px;\">"+
                        "<input type=\"number\" id=\"injumlahcicilancreate"+CicilanCreate+"\" onkeyup=\"injumlahcicilancreate("+CicilanCreate+")\" name=\"jumlahcicilan[]\" class=\"form-control\" placeholder=\"Dicicil berapa kali\">"+
                        "</div>"+
                        "<div class=\"col col-md-5\" >"+
                        "<input type=\"text\" name=\"hargacicilan[]\" class=\"form-control\" placeholder=\"Harga Cicilan\">"+
                        "</div>"+
                        "<div class=\"col col-md-2\" >"+
                        "<a onclick=\"hapuscicilancreate("+CicilanCreate+")\" class=\"btn btn-danger text-white\"><i class=\"fa fa-trash\"></i></a>"+
                        "</div>"+     
                    "</div>"+
                "</div>"
            );
        });
    });

    function showButtonByStep(step){

        if(step==1){
            prevButton.hide();
            nextButton.show();
            saveButton.hide();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('selected').addClass('disabled');
            stepNav3.removeClass('selected').addClass('disabled');
            stepNav4.removeClass('selected').addClass('disabled');
            stepNav5.removeClass('selected').addClass('disabled');
            stepNav6.removeClass('selected').addClass('disabled');
            stepNav7.removeClass('selected').addClass('disabled');
            content1.addClass('content');
            content2.removeClass('content');
            content3.removeClass('content');
            content4.removeClass('content');
            content5.removeClass('content');
            content6.removeClass('content');
            content7.removeClass('content');
            content1.css('display','block');
            content2.css('display','none');
            content3.css('display','none');
            content4.css('display','none');
            content5.css('display','none');
            content6.css('display','none');
            content7.css('display','none');
        }else if(step==2){
            prevButton.show();
            nextButton.show();
            saveButton.hide();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('disabled').addClass('selected');
            stepNav3.removeClass('selected').addClass('disabled');
            stepNav4.removeClass('selected').addClass('disabled');
            stepNav5.removeClass('selected').addClass('disabled');
            stepNav6.removeClass('selected').addClass('disabled');
            stepNav7.removeClass('selected').addClass('disabled');
            content2.addClass('content');
            content1.removeClass('content');
            content3.removeClass('content');
            content4.removeClass('content');
            content5.removeClass('content');
            content6.removeClass('content');
            content7.removeClass('content');
            content1.css('display','none');
            content2.css('display','block');
            content3.css('display','none');
            content4.css('display','none');
            content5.css('display','none');
            content6.css('display','none');
            content7.css('display','none');
        }else if(step==3){
            prevButton.show();
            nextButton.show();
            saveButton.hide();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('disabled').addClass('selected');
            stepNav3.removeClass('disabled').addClass('selected');
            stepNav4.removeClass('selected').addClass('disabled');
            stepNav5.removeClass('selected').addClass('disabled');
            stepNav6.removeClass('selected').addClass('disabled');
            stepNav7.removeClass('selected').addClass('disabled');
            content3.addClass('content');
            content1.removeClass('content');
            content2.removeClass('content');
            content4.removeClass('content');
            content5.removeClass('content');
            content6.removeClass('content');
            content7.removeClass('content');
            content1.css('display','none');
            content3.css('display','block');
            content2.css('display','none');
            content4.css('display','none');
            content5.css('display','none');
            content6.css('display','none');
            content7.css('display','none');
        }else if(step==4){
            prevButton.show();
            nextButton.show();
            saveButton.hide();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('disabled').addClass('selected');
            stepNav3.removeClass('disabled').addClass('selected');
            stepNav4.removeClass('disabled').addClass('selected');
            stepNav5.removeClass('selected').addClass('disabled');
            stepNav6.removeClass('selected').addClass('disabled');
            stepNav7.removeClass('selected').addClass('disabled');
            content4.addClass('content');
            content1.removeClass('content');
            content2.removeClass('content');
            content3.removeClass('content');
            content5.removeClass('content');
            content6.removeClass('content');
            content7.removeClass('content');
            content1.css('display','none');
            content4.css('display','block');
            content2.css('display','none');
            content3.css('display','none');
            content5.css('display','none');
            content6.css('display','none');
            content7.css('display','none');
        }else if(step==5){
            prevButton.show();
            nextButton.show();
            saveButton.hide();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('disabled').addClass('selected');
            stepNav3.removeClass('disabled').addClass('selected');
            stepNav4.removeClass('disabled').addClass('selected');
            stepNav5.removeClass('disabled').addClass('selected');
            stepNav6.removeClass('selected').addClass('disabled');
            stepNav7.removeClass('selected').addClass('disabled');
            content1.removeClass('content');
            content2.removeClass('content');
            content3.removeClass('content');
            content6.removeClass('content');
            content4.removeClass('content');
            content7.removeClass('content');
            content5.addClass('content');
            content1.css('display','none');
            content4.css('display','none');
            content2.css('display','none');
            content3.css('display','none');
            content5.css('display','block');
            content6.css('display','none');
            content7.css('display','none');
        }else if(step==6){
            prevButton.show();
            nextButton.show();
            saveButton.hide();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('disabled').addClass('selected');
            stepNav3.removeClass('disabled').addClass('selected');
            stepNav4.removeClass('disabled').addClass('selected');
            stepNav5.removeClass('disabled').addClass('selected');
            stepNav6.removeClass('disabled').addClass('selected');
            stepNav7.removeClass('selected').addClass('disabled');
            content6.addClass('content');
            content1.removeClass('content');
            content2.removeClass('content');
            content4.removeClass('content');
            content5.removeClass('content');
            content3.removeClass('content');
            content7.removeClass('content');
            content1.css('display','none');
            content6.css('display','block');
            content2.css('display','none');
            content4.css('display','none');
            content5.css('display','none');
            content3.css('display','none');
            content7.css('display','none');
        }else{
            prevButton.show();
            nextButton.hide();
            saveButton.show();
            stepNav1.removeClass('disabled').addClass('selected');
            stepNav2.removeClass('disabled').addClass('selected');
            stepNav3.removeClass('disabled').addClass('selected');
            stepNav4.removeClass('disabled').addClass('selected');
            stepNav5.removeClass('disabled').addClass('selected');
            stepNav6.removeClass('disabled').addClass('selected');
            stepNav7.removeClass('selected').addClass('selected');
            content7.addClass('content');
            content1.removeClass('content');
            content2.removeClass('content');
            content4.removeClass('content');
            content5.removeClass('content');
            content3.removeClass('content');
            content6.removeClass('content');
            content1.css('display','none');
            content7.css('display','block');
            content2.css('display','none');
            content4.css('display','none');
            content5.css('display','none');
            content3.css('display','none');
            content6.css('display','none');
        }

    }

    function showMasterForm(pertemuan){
        $.get('/karyawan/admin/master/kategorimateri/getdata')
        .done((data) => {
            console.log(data.KategoriMateri);
            let KategoriMateri=[];
            data.KategoriMateri.forEach((val)=>{
                KategoriMateri.push("<option value=\""+val.IDKategoriMateri+"\">"+
                    val.NamaKategoriMateri+
                "</option>");
            });
            console.log(KategoriMateri);
            $('#form-master').empty();
            for(let i=0;i<pertemuan;i++){
                let index = i+1;
                $('#form-master').append(
                    "<div class=\"form-group row\">"+
                        "<label class=\"col-form-label col-md-3 col-sm-3 label-align\" for=\"\">"+
                           "pertemuan "+
                           index+
                            "<span class=\"required\"> *</span>"+
                        "</label>"+
                        "<div class=\"col-md-3 col-sm-3\">"+
                            "<input type=\"text\" id=\"\" placeholder=\"Materi\" name=\"materi[]\" required=\"required\" class=\"form-control\">"+
                        "</div>"+
                        "<div class=\"col-md-3 col-sm-3\">"+
                            "<select name=\"kategorimateri[]\" class=\"select2_group form-control\">"+
                                "<option value=\"0\">Kategori materi</option>"+
                                KategoriMateri+
                            "</select>"+
                        "</div>"+
                        "<div class=\"col-md-3 col-sm-3\">"+
                            "<input type=\"text\" placeholder=\"Tugas / PR\" name=\"homework[]\"  class=\"form-control\">"+
                        "</div>"+
                    "</div>"
                );
            }
        });
    }

    function hapuscicilancreate(id){
        $('#cicilanjeniscreate'+id).remove();

    }
    function hapusModul(id){
        $('#modul'+id).remove();
        countTotalHargaModul();
    }
    function hapusTool(id){
        $('#tool'+id).remove();
        countTotalHargaTool();
    }
    function hapusVideo(id){
        $('#video'+id).remove();
    }
    function hapusBahanTutor(id){
        $('#bahantutor'+id).remove();
    }
    function injumlahcicilancreate(id){
        $('#labeljumlahcicilancreate'+id).empty().append($('#injumlahcicilancreate'+id).val()+'x');
    }

    function countTotalHargaModul(){
        let countHargaModul=0;
        for(let i=0;i<modul;i++){
            if($('#modul').length){
                countHargaModul += parseInt($('#harga_modul'+(i+1)).val()==undefined?0:$('#harga_modul'+(i+1)).val());
            }
        }
        hargaTotalModul = countHargaModul;
        $('#harga_modul_total').val(IDR(countHargaModul));
        countSubtotal();
    }
    function countTotalHargaTool(){
        let countHargaTool=0;
        console.log(tool);
        for(let i=0;i<tool;i++){
            console.log($('#harga_tool'+(i+1)).val());
            if($('#tool').length){
                countHargaTool += parseInt($('#harga_tool'+(i+1)).val()==undefined?0:$('#harga_tool'+(i+1)).val());
            }
        }
        hargaTotalTool = countHargaTool;
        $('#harga_tool_total').val(IDR(countHargaTool));
        countSubtotal();
    }
    function countSubtotal(){
        $('#harga_subtotal').val( 
            IDR(parseInt(
                hargaTotalTool
            )+ 
            parseInt(
                hargaTotalModul
            )+
            parseInt(
                $('#harga').val()==''?
                0:$('#harga').val()
            ))
        )
    }

    function getKategoriMateri(){
        let KategoriMateri;
       
        return KategoriMateri;
    }
    function IDR(number){
       return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(number);
    }

</script>
@endpush