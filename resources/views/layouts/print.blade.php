<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ strtoupper($title) }}</title>

    <style>
        .header {
            display: table;
            width: 100%;
            padding: 20px;
            text-align: center;
            color: #000;
        }

        .header img {
            display: table-cell;
            width: 100px;
            vertical-align: middle;
        }

        .header-content {
            display: table-cell;
            width: 70%;
            vertical-align: middle;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
        }

        .content {
            padding-left: 10%;
            padding-right: 5%;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .no-padding {
            padding: 0;
        }

        .row {
            display: block;
            width: 100%;
            clear: both;
            /* Ensures floats don't affect the block */
        }

        .col-6 {
            width: 50%;
            float: left;
        }

        .col-8 {
            width: 70%;
            float: left;
        }

        .col-10 {
            width: 90%;
            float: left;
        }

        .col-4 {
            width: 30%;
            float: left;
        }

        .col-2 {
            width: 30%;
            float: left;
        }


        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 6rem !important;
        }

        .mt-1 {
            margin-to: 1rem !important;
        }

        .info-surat td {
            padding: 0px;
        }

        #content-to-print {
            display: block;
        }

        .no-margin {
            margin: 0px;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
