<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alice&display=swap');
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <style>
        body {
            font-family: 'Mulish', 'system-ui', 'sans-serif';
            line-height: 1.5em;
        }

        img {
            border-radius: 12px;
        }

        .badge {
            padding: 0.35rem;
        }

        .btn:focus,
        .btn:active,
        .btn-close:focus,
        .btn-close:active,
        .btn-group:focus,
        .btn-group:active,
        .form-control:active,
        .form-control:focus,
        .navbar-toggler:active,
        .navbar-toggler:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .lead {
            font-family: 'Alice', sans-serif;
        }

        #header,
        #myCarousel {
            font-family: 'Alice', sans-serif;
        }

        .bg-transparent {
            -webkit-transition: all 0.6s ease-out;
            -moz-transition: all 0.6s ease-out;
            -o-transition: all 0.6s ease-out;
            -ms-transition: all 0.6s ease-out;
            transition: all 0.6s ease-out;
        }
    </style>
    <style>
        .rating {
            --dir: right;
            --fill: gold;
            --fillbg: rgba(100, 100, 100, 0.15);
            --star: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.25l-6.188 3.75 1.641-7.031-5.438-4.734 7.172-0.609 2.813-6.609 2.813 6.609 7.172 0.609-5.438 4.734 1.641 7.031z"/></svg>');
            --stars: 5;
            --starsize: 1.5rem;
            --symbol: var(--star);
            --value: 1;
            --w: calc(var(--stars) * var(--starsize));
            --x: calc(100% * (var(--value) / var(--stars)));
            block-size: var(--starsize);
            inline-size: var(--w);
            position: relative;
            touch-action: manipulation;
            -webkit-appearance: none;
        }

        [dir="rtl"] .rating {
            --dir: left;
        }

        .rating::-moz-range-track {
            background: linear-gradient(to var(--dir), var(--fill) 0 var(--x), var(--fillbg) 0 var(--x));
            block-size: 100%;
            mask: repeat left center/var(--starsize) var(--symbol);
        }

        .rating::-webkit-slider-runnable-track {
            background: linear-gradient(to var(--dir), var(--fill) 0 var(--x), var(--fillbg) 0 var(--x));
            block-size: 100%;
            mask: repeat left center/var(--starsize) var(--symbol);
            -webkit-mask: repeat left center/var(--starsize) var(--symbol);
        }

        .rating::-moz-range-thumb {
            height: var(--starsize);
            opacity: 0;
            width: var(--starsize);
        }

        .rating::-webkit-slider-thumb {
            height: var(--starsize);
            opacity: 0;
            width: var(--starsize);
            -webkit-appearance: none;
        }

        .rating,
        .rating-label {
            display: block;
            font-family: ui-sans-serif, system-ui, sans-serif;
        }

        .rating-label {
            margin-block-end: 1rem;
        }

        /* NO JS */
        .rating--nojs::-moz-range-track {
            background: var(--fillbg);
        }

        .rating--nojs::-moz-range-progress {
            background: var(--fill);
            block-size: 100%;
            mask: repeat left center/var(--starsize) var(--star);
        }

        .rating--nojs::-webkit-slider-runnable-track {
            background: var(--fillbg);
        }

        .rating--nojs::-webkit-slider-thumb {
            background-color: var(--fill);
            box-shadow: calc(0rem - var(--w)) 0 0 var(--w) var(--fill);
            opacity: 1;
            width: 1px;
        }

        [dir="rtl"] .rating--nojs::-webkit-slider-thumb {
            box-shadow: var(--w) 0 0 var(--w) var(--fill);
        }
    </style>
    @yield('style')
    <title>HK-Decoration | @yield('title')</title>
</head>

<body class="d-flex flex-column min-vh-100">
    @if(!isset($noMenu))
    @include('layouts.navbar')
    @else
    @include('layouts.navbar-no-menu')
    @endif
    <main class="d-flex flex-column min-vh-100">
        @yield('content')
    </main>
    <script src="{{asset('js/bootstrap-input-spinner.js')}}"></script>
    @yield('js')
    @if(request()->is('/') || request()->is('decoration') || request()->is('partern') || request()->is('gallery*'))
    <script>
        var startY = $('.navbar-ku').height() * 2; //The point where the navbar-ku changes in px
        function checkScroll() {
            if ($(window).scrollTop() < startY) {
                $('.navbar-ku').addClass("bg-transparent");
            } else {
                $('.navbar-ku').removeClass("bg-transparent");
            }
        }

        $('.navbar-toggler-ku').click(function() {
            if ($(window).scrollTop() < startY) {
                $('.navbar-ku').toggleClass('bg-transparent');
            }
        });

        if ($('.navbar-ku').length > 0) {
            $(window).on("scroll load resize", function() {
                checkScroll();
            });
        }
    </script>
    @endif
    @include('layouts.footer')
</body>

</html>