<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        html, body {
            background-color: #fff;
            color: #222;
            font-family: 'Sans', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .title {
            font-size: 84px;
            color: white;
        }

        .text-shadow {
            text-shadow: 4px 4px #040;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .titlediv {
            background-color: #080
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MEGAGardening™ LTD</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center title text-shadow m-b-md titlediv">
            MEGAGardening™ LTD
        </div>
        <div class="col-sm-12 m-b-md text-left">
            <ul>
                <li><h3>Need that astro turf mown?</h3></li>
                <li><h3>Need your gnomes trained?</h3></li>
                <li><h3>Need a chocolate fountain built or maintained?</h3></li>
                <li><h3>Need that hedge fund trimmed?</h3></li>
                <li><h3>Require a tree or flowerbed exorcism?</h3></li>
            </ul>
            {{-- if hedge fund and gnomes, also require financial-shield fence --}}
        </div>
        <div class="col-sm-12 title m-b-md text-center">
            <a href="/quote" class="btn btn-primary">
                <h1>GET YOUR QUOTE</h1>
            </a>
        </div>
        <div class="pull-right">
            <i>built by Nonsense Web Solutions Inc.</i>
        </div>
    </div>
</div>
</body>
</html>
