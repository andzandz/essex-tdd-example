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

        input.form-control {
            font-size:20px;
        }

        .title {
            font-size: 63px;
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

        .topmargin {
            margin-top: 15px;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MEGAGardening™ LTD Quote</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <form method="POST" action="/getquote">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-12 text-center title text-shadow m-b-md titlediv">
                MEGAGardening™ LTD Quote
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 text-right">
                <h3>Size of astro turf to mow: </h3>
            </div>
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-5">
                        <input type="text" name="astro_width" class="form-control topmargin">
                    </div>
                    <div class="col-sm-2 text-center">
                        <h3>x</h3>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" name="astro_depth" class="form-control topmargin">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <h3>smoots</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 text-right">
                <h3>Gnomes to train: </h3>
            </div>
            <div class="col-sm-4">
                <input type="text" name="num_gnomes" class="form-control topmargin" value="{{$request['num_gnomes'] ?? ''}}">
            </div>
            <div class="col-sm-4">
                <h3>gnomes</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 text-right">
                <h3>Chocolate fountains to build: </h3>
            </div>
            <div class="col-sm-4">
                <input type="text" name="chocolate_fountains" class="form-control topmargin" value="{{$request['chocolate_fountains'] ?? ''}}">
            </div>
            <div class="col-sm-4">
                <h3>fountains</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 text-right">
                <h3>Chocolate amount: </h3>
            </div>
            <div class="col-sm-4">
                <input type="text" name="chocolate_amount_freddos" class="form-control topmargin">
            </div>
            <div class="col-sm-4">
                <h3>freddos</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 text-right">
                <h3>Length of hedge fund to trim: </h3>
            </div>
            <div class="col-sm-4">
                <input type="text" name="hedge_fund_length" class="form-control topmargin">
            </div>
            <div class="col-sm-4">
                <h3>investment officers</h3>
            </div>
        </div>
        <div class="row m-b-md">
            <div class="col-sm-4 text-right">
                <h3>Exorcisms: </h3>
            </div>
            <div class="col-sm-4">
                <input type="text" name="exorcisms" class="form-control topmargin">
            </div>
            <div class="col-sm-4">
                <h3>ghosts</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 title m-b-md text-center">
                <button type="submit" class="btn btn-primary">
                    <h1>Calculate quote</h1>
                </button>
            </div>
        </div>
    </form>
    @if($quote_amount)
    <div class="row">
        <div class="col-sm-12 text-center">
            <h3>Your Quote: £{{$quote_amount}}</h3>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="pull-right">
                <i>built by Nonsense Web Solutions Inc.</i>
            </div>
        </div>
    </div>
</div>
</body>
</html>
