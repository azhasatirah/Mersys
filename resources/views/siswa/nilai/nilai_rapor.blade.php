<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapor</title>
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
            font-weight: 500;
            width: 100%
        }
        table tr td{
            border: 1px solid black;
        }
         .table-title td{
            border-style: none;
        }
    </style>
</head>
<body>
    <div class="a4">
        <div class="content">

            <div class="header">
                <div style="text-align: center">
                    <img 
                    src="{{url('images/icons/merachel.png')}}"
                    style="max-width:400px;max-height:100px;object-fit:cover;">
                </div>
                <table>

                </table>
            </div>
            <table>
                <tr class="table-title">
                    <td colspan="2">Nama Murid : {{$Normal[0]['NamaSiswa']}}</td>
                    <td colspan="3">Program : {{$Normal[0]['NamaProdi']}}</td>
                </tr>
                <tr class="table-title">
                    <td colspan="2">Nama Tutor : {{$Normal[0]['NamaTutor']}}</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="table-title">
                    <td colspan="2">Bulan : {{date('M Y',$Tanggal)}}</td>
                    <td colspan="3"></td>
                </tr>
                <tr style="text-align: center">
                    <td>No</td>
                    <td >Materi</td>
                    <td >Standard Nilai</td>
                    <td>Nilai Murid</td>
                    <td>Nilai Dalam Huruf</td>
                </tr>
                @foreach($Normal as $rapor)     
                       
                <tr style="text-align: center">
                    <td style="width:6%">{{$loop->iteration}}</td>
                    <td style="width:50%">{{$rapor['NamaNilai']}}</td>
                    <td style="width:10%">75</td>
                    <td style="width:10%">{{$rapor['Nilai']}}</td>
                    @if ($loop->iteration == 1)    
                        <td rowspan="{{count($Normal)+2}}" style="width: 20%">{{$rapor['NilaiRaporHuruf']}}</td>
                    @endif
                </tr>            
                @endforeach
                <tr style="text-align: center">
                    <td colspan="3">TOTAL NILAI</td>
                    <td>{{$Normal[0]['NilaiRapor']}}</td>
                </tr>
            </table>
            @foreach ($Look as $rapor)
            <p style="margin-bottom: 0px" class="title text-center mt-3">TOTAL LOOK</p>
            <table>
                <tr style="text-align: center">
                    <td>No</td>
                    <td >Materi</td>
                    <td >Standard Nilai</td>
                    <td>Nilai Murid</td>
                    <td>Nilai Dalam Huruf</td>
                </tr>
                <tr style="text-align: center">
                    <td style="width:6%">{{$loop->iteration}}</td>
                    <td style="width:50%">{{$rapor['NamaNilai']}}</td>
                    <td style="width:10%">75</td>
                    <td style="width:11%">{{$rapor['Nilai']}}</td>
                    @if ($loop->iteration == 1)    
                        <td rowspan="4" style="width: 20%">{{$rapor['NilaiRaporHuruf']}}</td>
                    @endif
                </tr>
                <tr style="text-align: center">
                    <td colspan="{{count($Look)+2}}">TOTAL NILAI</td>
                    <td>{{$rapor['NilaiRapor']}}</td>
                </tr>
            </table>
            @endforeach
            <p class="mt-3">* A:95-100 | B+:90-94 | B:80-89 C+:75-79 <br>
                A=Excellent B+=Exceeds Standard B=Good C+=Standard
            </p>
            <p style="margin-bottom: 0px" class="title text-left mt-2">EVALUASI FINAL PRESENTASI MURID</p>
            <table>
                <tr >
                    <td style="height: 200px;vertical-align:top">
                        <span style="margin-left:10px">

                            {{count($FinalEvaluasi)>0?$FinalEvaluasi[0]->EvaluasiFinal:''}}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>