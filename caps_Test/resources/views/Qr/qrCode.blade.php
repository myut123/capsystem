@extends('headerFooter.header')
@section('content')

<head>

        <title>Staff Upload</title>
        <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableQR, #printableQR * {
                visibility: visible;
            }
            #printableQR {
                position: absolute;
                left: 0;
                top: 0;
                width: 4in; /* Ensuring the container is 4 inches */
                height: 4in; /* Ensuring the container is 4 inches */
            }
            #printableQR img {
                width: 100%; /* Ensure the QR code fills the 4x4 inch container */
                height: 100%;
            }
            /* Hide the print button during printing */
            .print-btn {
                display: none;
            }
        }
        /* Style the button to be smaller */
        .print-btn {
            padding: 8px 16px;
            font-size: 14px;
            width: auto; /* Auto width to fit the text */
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center">
        <div class="col pt-5 text-center">
            <div class="row">
                <h1>QR Code</h1>
            </div>
            <div class="row d-flex justify-content-center">
                <div id="printableQR" class="text-center">
                    <!-- QR Code -->
                    {!! $qrCode !!}
                    <br>
                    <!-- Print button directly under the QR Code -->
                    <button onclick="printQRCode()" class="btn btn-primary print-btn mt-3">Print QR Code</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printQRCode() {
            window.print();
        }
    </script>

@endsection 
