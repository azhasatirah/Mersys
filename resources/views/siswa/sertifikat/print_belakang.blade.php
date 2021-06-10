<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <style>
        #body {
            background-image: url(https://i.ibb.co/XjKthFq/s-belakang-blank.png);
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
        <div id="content">
            <div class="title text-center">
                <h5>
                    STUDY PROGRAM :
                    <span id="program_name">{{strtoupper($Nilai[0]['NamaProdi'])}}</span>
                </h5>
            </div>
            <table style=" width: 550px ;margin-left:auto;margin-right:auto;margin-top:20px " class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">KIND OF EVALUATION</th>
                    <th scope="col">SCORE</th>
                    <th scope="col">GRADE</th>
                    <th scope="col">DESCRIPTION</th>
                  </tr>
                </thead>
                <tbody style="line-height:1.4">
                @foreach ($Nilai as $item)              
                <tr>
                  <td>{{$item['Jenis']}}</td>
                  <td>{{$item['Nilai']}}</td>
                  <td>{{$item['Grade']}}</td>
                  <td>{{$item['Desc']}}</td>
                </tr>
                @endforeach

                </tbody>
            </table>
            <table style=" width: 220px;line-height: 1; ;font-size:10px;margin-left:auto;margin-right:auto " class="table table-bordered">
                <thead>
                    <tr>
                        <th>Letter</th>
                        <th>Marks Range</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td>95-100</td>
                        <td>Excellent</td>
                    </tr>
                    <tr>
                        <td>B+</td>
                        <td>90-94</td>
                        <td>Exceeds Standard</td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>80-89</td>
                        <td>Good</td>
                    </tr>
                    <tr>
                        <td>C+</td>
                        <td>75-79</td>
                        <td>Standard</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

</body>

</html>