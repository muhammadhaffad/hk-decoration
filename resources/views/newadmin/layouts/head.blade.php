<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Administrator | {{ $title }}</title>
    <link href="/admin/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/trix.css')}}">
    <script type="text/javascript" src="{{asset('js/trix.js')}}"></script>
    @yield('style')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik&display=swap');
        body {
            font-family: 'Rubik', sans-serif;
            line-height: 1.5em;
            font-size: 15px;
        }
        .astext {
            background: none;
            border: none;
            margin: 0;
            padding: 0;
            cursor: pointer;
        }
    </style>
</head>