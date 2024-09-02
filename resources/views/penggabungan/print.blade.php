<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .header-thumb {
            float: left
        }

        .pl-15 {
            padding-left: 15px
        }

        .header-thumb img {
            display: block
        }

        .header-content {
            margin-left: 210px
        }

        .section-title {
            font-weight: 800;
            font-size: 12px;
            margin-bottom: 3px
        }

        .mx-3 {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        /*! CSS Used from: Embedded */
        .div-border {
            border: 1px solid #ccc !important;
            margin-bottom: 8px;
            padding: 10px;
        }

        .container-checkbox {
            display: block;
            position: relative;
            padding-left: 32px;
            margin-bottom: 0px;
            cursor: pointer;
            font-size: 0.75rem;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .container-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .container-checkbox label {
            font-size: 0.75rem;
        }

        .checkmark {
            border: 1px;
            position: absolute;
            border-style: groove;
            border-color: rgb(122, 120, 119);
            border-width: 0.75px;
            padding: 1px;
            top: 0;
            left: 0;
            height: 19px;
            width: 28px;
            background-color: #eee;
        }

        .container-checkbox:hover input~.checkmark {
            background-color: #ccc;
        }

        .container-checkbox input:checked~.checkmark {
            background-color: #ccc;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .container-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .container-checkbox .checkmark:after {
            left: 8px;
            top: 1px;
            width: 6px;
            height: 11px;
            border: solid black;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        /*! CSS Used from: http://127.0.0.1:8001/css/akura.css */
        .div-border {
            border: 3px solid rgb(0, 0, 0) !important;
            margin-bottom: 8px;
        }

        hr {
            border: 0.70 px solid rgb(219, 213, 213) !important;
        }

        /*! CSS Used from: http://127.0.0.1:8001/css/bootstrap.min.css */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        hr {
            box-sizing: content-box;
            height: 0;
            overflow: visible;
        }

        h1 {
            margin-top: 0;
            margin-bottom: .5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
        }

        input {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        input {
            overflow: visible;
        }

        input[type=checkbox] {
            box-sizing: border-box;
            padding: 0;
        }

        fieldset {
            min-width: 0;
            padding: 0;
            margin: 0;
            border: 0;
        }

        h1 {
            margin-bottom: .5rem;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.2;
            color: inherit;
        }

        h1 {
            font-size: 2.5rem;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .container-fluid {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-1,
        .col-12,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-8,
        .col-9 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-1 {
            -ms-flex: 0 0 8.333333%;
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-2 {
            -ms-flex: 0 0 16.666667%;
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-5 {
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-8 {
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-9 {
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-12 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .flex-row {
            -ms-flex-direction: row !important;
            flex-direction: row !important;
        }

        .justify-content-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .my-0 {
            margin-top: 0 !important;
        }

        .mx-0 {
            margin-right: 0 !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .mx-0 {
            margin-left: 0 !important;
        }

        .mt-1 {
            margin-top: .25rem !important;
        }

        .my-2 {
            margin-top: .5rem !important;
        }

        .my-2 {
            margin-bottom: .5rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .pl-1 {
            padding-left: .25rem !important;
        }

        .px-2 {
            padding-right: .5rem !important;
        }

        .pl-2,
        .px-2 {
            padding-left: .5rem !important;
        }

        .px-3 {
            padding-right: 1rem !important;
        }

        .px-3 {
            padding-left: 1rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        @media print {

            *,
            ::after,
            ::before {
                text-shadow: none !important;
                box-shadow: none !important;
            }

            thead {
                display: table-header-group;
            }

            img,
            tr {
                page-break-inside: avoid;
            }

            p {
                orphans: 3;
                widows: 3;
            }
        }

        /*! CSS Used from: Embedded */
        .cert-mark {
            border: 1px solid rgb(255, 23, 15);
        }

        @media all {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }
    </style>
</head>

<body>

    <style>
        .header-thumb {
            float: left
        }

        .pl-15 {
            padding-left: 15px
        }

        .header-thumb img {
            display: block
        }
    </style>
    <div class="row  justify-content-center mb-2">
        <div class="col-8 text-center">
            <div class="card-block px-2">
                <div class="header-thumb">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid mr-3" width="64" height="64"
                        alt="">
                </div>
                <h6 class="mb-0 header-title font-bold">KEMENETRIAN AGRARIA DAN TATA RUANG / BADAN
                    PERTANAHAN NASIONAL</h6>
                <h6 class="mb-0 header-title">CONTRACT ORDER REVIEW CHECKLIST</h6>
            </div>
            <hr>
        </div>
    </div>

</body>

</html>
