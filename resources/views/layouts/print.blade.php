<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f4eb;
        }

        .container {
            width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-left: 30px;
            margin-right: 30px;
            text-align: center;
            color: #000000;
        }

        .header img {
            max-width: 100px;
            /* Adjust the size as needed */
            margin-right: 20px;
        }

        .header-content {
            max-width: 70%;
        }

        .header p {
            margin: -10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 1.5cm; */
        }

        td {
            padding: 5px;
        }

        .signature {
            margin-top: 2cm;
            margin-right: 30%;
            text-align: right;
        }


        .content {
            margin-left: 13%;
            margin-right: 7%;

        }

        .content p {
            font-size: 14px;
            margin-top: 0px;
            margin-bottom: 3px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
            padding-left: 15%;
            padding-right: 5%;
        }

        .col {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        /* Column sizes (like Bootstrap's col-1 to col-12 system) */
        .col-1 {
            flex: 0 0 8.33%;
            max-width: 8.33%;
        }

        .col-2 {
            flex: 0 0 16.66%;
            max-width: 16.66%;
        }

        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-4 {
            flex: 0 0 33.33%;
            max-width: 33.33%;
        }

        .col-5 {
            flex: 0 0 41.66%;
            max-width: 41.66%;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-7 {
            flex: 0 0 58.33%;
            max-width: 58.33%;
        }

        .col-8 {
            flex: 0 0 66.66%;
            max-width: 66.66%;
        }

        .col-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-10 {
            flex: 0 0 83.33%;
            max-width: 83.33%;
        }

        .col-11 {
            flex: 0 0 91.66%;
            max-width: 91.66%;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Example styling for visualization */
        .box {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            text-align: center;
            padding: 20px;
            margin-bottom: 15px;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 6rem !important;
        }

        .m-0 {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

        .mt-1 {
            margin-top: 1rem !important;
        }


        .info-surat td {
            padding: 0px;
        }

        #content-to-print {
            display: block;
            /* Ensure this is visible */
        }

        table.table-no-padding {
            margin-top: 10px;
        }

        table.table-no-padding td {
            padding: 0px !important;
        }


        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #ff3a6e;
            border-color: #ff3a6e;
        }



        .btn-lg {
            padding: .5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }
    </style>
</head>

<body>
    <button id="download-pdf" class="btn btn-primary btn-lg" style="float: right;">Download</button>
    <div id="content-to-print">
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '#download-pdf', function(e) {
                var element = document.getElementById('content-to-print');
                var opt = {
                    filename: '{{ $title }} {{ $data->no_surat }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 1
                    },
                    html2canvas: {
                        scale: 4,
                        dpi: 72,
                        letterRendering: true
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'A4'
                    }
                };
                html2pdf().set(opt).from(element).save().then(closeScript);
            });
        });
    </script>
</body>

</html>
