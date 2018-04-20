<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>

    <style>
    body, html {
        background: url('/img/spark-bg.png');
        background-repeat: repeat;
        background-size: 150px 100px;
        height: 100%;
        margin: 0;
    }

    .full-height {
        min-height: 100%;
    }

    .flex-column {
        display: flex;
        flex-direction: column;
    }

    .flex-fill {
        flex: 1;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }


    .text-center {
        text-align: center;
    }

    .links {
        padding: 1em;
        text-align: right;
    }

    .links a {
        text-decoration: none;
    }

    .links button {
        background-color: #3097D1;
        border: 0;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        font-family: 'Open Sans';
        font-size: 14px;
        font-weight: 600;
        padding: 15px;
        text-transform: uppercase;
        width: 100px;
    }
    </style>
</head>
<body>
    <div class="full-height flex-column">
        <nav class="links">
            <a href="/login" style="margin-right: 15px;">
                <button>
                    {{__('Login')}}
                </button>
            </a>
            <a href="/register">
                <button>
                    {{__('Register')}}
                </button>
            </a>
        </nav>
        <div class="flex-fill flex-center">
            <h1 class="text-center">
                DebeHaber
                {{-- <img src="/img/color-logo.png"> --}}
            </h1>
        </div>
    </div>
</body>
</html>
