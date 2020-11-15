<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" type="text/css"/>
    <style>
        .heading h3 {
            font-weight: 700;
            font-size: 24px;
        }
        .heading p {
            line-height: 4px;
            font-size: 14px;
        }

        .admission_form {
            font-weight: 700;
            font-size: 18px;
            background: #bababa;
            border-radius: 20px;
        }

        .img_box {
            width: 169px;
            height: 169px;
            overflow: hidden;
            object-fit: cover;
            padding: 0 !important;
        }

        .img_box img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        table tr th, table tr td {
            padding: 1px 5px !important;
            font-size: 14px;
        }

        table th.heading {
            font-size: 18px;
            background: #bababa;
        }

        .enclosure table tr td,
        .diclare {
            font-size: 12px;
        }

        .footer_table {
            background: #f5f5f5;
        }

        .batch_table {
            background: #f5f5f5;
        }
    </style>
</head>
<body>

<section class="p-3">
    
    <div class="container">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center heading">
                <div style="width:70px">
                    <img class="img-fluid w-100" src="{{asset('images/logo.png')}}" alt="">
                </div>
                <div class="pl-2">
                    <h3>Hypertension & Research Centre, Rangpur</h3>
                    <p>(A sister concern of Dr. Wasim - Waleda Bahumukhi Kallayan Fuoundation)</p>
                    <p>Holding No. 13/2, Hypertension Centre Lane, Jail Road, Dhap, Rangpur</p>
                    <p>Tel: 052153808; Mobile: +8801730448610</p>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-dark text-white text-center">
                    <h5 class="py-1">Certificate Course on Hypertension</h5>
                </div>
            </div>
        </div>
    </div>
        
    <div class="container">
        <p>Dear respected <b>{{$name}}</b>,</p>
        <p style="padding-bottom: 30px">
            Recived Amount : <b>{{$amount}}</b> <br>
            By <b>{{$payment_type}}</b>
        </p>
        <p>Thank You,</p>
        <p>HTNCR</p>
    </div>

</section>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

</body>
</html>
