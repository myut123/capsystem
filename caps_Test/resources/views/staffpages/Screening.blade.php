@extends('headerFooter.header')
@section('content')

    <head>
    <meta charset = "UTF-8">

        <meta http-equiv = "X-UA_Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/1d8d68cd8a.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Scripts -->
        <style>
        #map {  
            height: 500px;
            width: auto;
         }
         #locationInfo {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        #personInfo {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <title>Staff Screening</title>
    </head>
<body>
<div class="row justify-content-center">
    <div class="col-md-10">
        <h1 class="text-center pt-5">Adoptive Owner Applications</h1>
        <br>
        <div class="table-responsive">
            @if (session('message')) <div class="alert alert-success"> {{session('message')}} </div> @endif
            @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Application</th>
                        <th scope="col">Status</th>
                        <th scope="col">Updated At</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($applicants as $applicant)
                    <tr>
                        <td>{{ $applicant->first_name }}</td>
                        <td>{{ $applicant->application_date }}</td>
                        <td><a href="{{ route('application.show', $applicant->idadoption_application) }}" class="text-dark">view application</a></td>
                        <td>{{ $applicant->status }}</td>
                        <td>{{ $applicant->updated_at }}</td>
 
                           

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

 @endsection 