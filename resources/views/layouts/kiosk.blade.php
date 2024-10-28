<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/img/icon.ico') }}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <title>Antrian</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    {{--  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/kiosk.css') }}">  --}}
    <link rel="stylesheet" href="{{ asset('assets/css/exo-fonts.css') }}">
    @stack('css-page')

    @stack('extra-style')
    <style>
        #logo h1 {

            font-size: 65px;
            color: #f0e8e8;
            font-family: 'Exo', sans-serif;
            text-transform: uppercase
        }

        .marquee-container {
            overflow: hidden;
            align-items: center;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
        }

        .marquee-content {
            display: inline-block;
            /* Keep content inline */
            animation: marquee 50s linear infinite;
            /* Continuous scrolling */
        }

        @keyframes marquee {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(-100%);
            }
        }

        .user-card {
            margin: 20px;
            /* Adds margin around the user card */
            padding: 15px;

        }
    </style>
</head>

<body>

    <div class="content ">
        <div class="page-inner">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript">
        // Optional
        function fullscreen() {
            document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document
                .webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement
                .requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement
                .mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement
                .webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document
                .cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document
                .webkitCancelFullScreen && document.webkitCancelFullScreen()
        }
    </script>

    @stack('extra-script')

</body>

</html>
