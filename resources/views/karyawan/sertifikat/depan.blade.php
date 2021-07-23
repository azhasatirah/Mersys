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
            background-size: 65% auto;
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Sertifikat</title>
</head>

<body>
    <a onclick="getImage()" class="btn btn-primary" href="javascript:void(0)" role="button">download</a>
    <div id="body" class="container-fluid">
        <div class="d-flex justify-content-between">
            <div ></div>
            <div id="content" style="padding-top: 280px;padding-left:225px">
                <h1 style="font-family: play" id="nama" >{{$Nilai['NamaSiswa']}}</h1>
                <p id="des" style="color: red;font-size:14px;font-family:comic">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script>
   
        function getImage(){
            var node = document.getElementById('body');
          
            domtoimage.toPng(node,{quality:1})
                .then(function (dataUrl) {
                    let name = new Date().getTime()
                    var link = document.createElement('a');
                    link.download = 'sertifikat-depan'+name+'.jpeg';
                    link.href = dataUrl;
                    link.click();
                })
                .catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });
        }
        // Default export is a4 paper, portrait, using millimeters for units
        const doc = new jsPDF({
            orientation : 'landscape'
        });
        function downloadPDF(){
            let ele = document.getElementById('body')
            doc.fromHTML(ele, 10, 10);
            doc.save("a4.pdf");
        }

    </script>

</body>

</html>