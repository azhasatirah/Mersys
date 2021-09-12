<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evaluasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        .a4{
            width:794px; 
            min-height:1122px;
            margin-left: auto;
            margin-right: auto;
            
        }
        .content{
         
            padding:40px 40px 40px 40px;
        }
        .title{
            font-size:15px;
            font-weight: bold;
        }
        .header{
            font-size:13px;
            font-weight: bold;
        }
        table{
            border: 1px solid black;
            width: 100%
        }
        table tr td{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="a4">
        <div class="content">

            <div class="header">
                <p class="title text-center">FORM EVALUASI</p>
                <div class="row">
                    <div class="col-md-4">
                        Tanggal :{{date('Y-m-d',$Tanggal)}}
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        Tutor : {{$KursusSiswa[0]->NamaKaryawan}}
                    </div>
                </div>
            </div>
            <table>
                @php
                    $NamaProdi = explode(' (Bulanan',$KursusSiswa[0]->NamaProdi)[0];
                @endphp
                <tr>
                    <td style="border-bottom: none" colspan="5">Nama murid : {{$KursusSiswa[0]->NamaSiswa}}</td>
                </tr>
                <tr>
                    <td style="border-top: none" colspan="5">{{$NamaProdi}} {{$KursusSiswa[0]->KategoriGlobal==2?'(Bulanan)': '(Reguler)'}}</td>
                </tr>
                <tr style="text-align: center">
                    <td rowspan="2">Pert.</td>
                    <td rowspan="2">Materi</td>
                    <td colspan="3">Progress</td>
                </tr>
                <tr style="text-align: center">
                    <td>(+)</td>
                    <td >(-)</td>
                    <td >Saran</td>
                </tr>
                @foreach ($NilaiEvaluasi as $item)
                    
                <tr>
                    <td style="width:6%" >
                        {{$item['NoRecord']}}
                    </td>
                    <td style="width:26ch" >
                        {{$item['NamaMateri']}}
                    </td>
                    <td style="width:22%" >
                        {{$item['Plus']}}
                    </td>
                    <td style="width:22%" >
                        {{$item['Minus']}}
                    </td>
                    <td style="width:22%" >
                        {{$item['Saran']}}
                    </td>

                </tr>
                @endforeach
            </table>
        </div>

    </div>
</body>
</html>