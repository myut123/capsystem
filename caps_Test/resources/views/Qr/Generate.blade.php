@extends('headerFooter.header')
@section('content')


    <head>
        <meta charset = "UTF-8">
        <meta http-equiv = "X-UA_Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/1d8d68cd8a.js" crossorigin="anonymous"></script>
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <title>Generate QR</title>
    </head>

    <body>
    <div class="row justify-content-center">
    <div class="col-md-10 ">
        <h1 class="text-center pt-5">Qr Applicants</h1>
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
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach($adopteds as $adopted)
                    <tr>

                        <td>{{ $adopted->first_name }}</td>
                        <td>{{ $adopted->application_date }}</td>
                        <td><a href="{{ route('qr.generate') }}" class="text-dark">Generate QR</a></td>
                        <td>{{ $adopted->status }}</td>
                        <td>{{ $adopted->updated_at }}</td>
                        <td>
                            <form action="{{ route('qr.generate') }}" method="post" style="display: inline;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $adopted->idadoption_application }}">
                                <button type="submit" class="btn btn-success">Generate QR</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</html>
@endsection 