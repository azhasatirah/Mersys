<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <style>
        @font-face { 
            font-family:comic; src: url('/fonts/comici.ttf');
        }
        @font-face { 
            font-family:play; src: url('/fonts/p3.otf');
        }
        #body {
            background-image:url('{{url('images/sertifikat/s-depan-blank.png')}}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 80% auto;
        }

        #content {
            height: 600px;
        }
        table.table-bordered > thead > tr > th{
            border:1px solid black;
        }
        table.table-bordered > tbody > tr > td{
            border:1px solid black;
        }
        #table{
            /* margin:0 400px 0 400px; */
           
        }
        .title{
            padding-top:145px
        }
        .score{
            padding-top: 5px
        }
        #program_name{
            text-decoration: underline;
            font-size: 16px;
        }

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Sertifikat</title>
</head>

<body>
    <div id="body" class="container-fluid">
        <div class="d-flex justify-content-between">
            <div></div>
            <div id="content" style="padding-top: 280px;padding-left:210px" >
                <h1 id="nama" style="font-family:play;font-size:50px" >{{$Nilai['NamaSiswa']}}</h1>
                <p id="des" style="color: red;font-size:15px;font-family:comic">
                    has successfully completed the Merachel Program: 
                    <span style="text-decoration: underline">{{$Nilai['NamaProdi']}}</span> <br>
                    demonstrating the required skills and knowledge. The Final Evaluation was passed <br>
                    with a score <span style="text-decoration: underline">{{$Nilai['Grade']}}</span> 
                    out of minimum 100% on <span style="text-decoration: underline">{{date('d M Y')}}</span>
                </p>
            </div>
            <div></div>
        </div>
    </div>
    <div class="mt-4"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

</body>

</html>