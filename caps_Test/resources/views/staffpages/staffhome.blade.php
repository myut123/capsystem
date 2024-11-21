@extends('headerFooter.header')

@section('content')
    <h1 class="text-center">Applicant Details</h1>

    <div class="container applicant-details">
        <style>
            .applicant-details {
                margin-top: 50px;
                border-collapse: collapse;
                width: 100%;
            }
            
            .applicant-details th, .applicant-details td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            
            .applicant-details tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .applicant-details tr:hover {
                background-color: #ddd;
            }

            .applicant-details th {
                background-color: #007bff;
                color: white;
                text-align: left;
            }

            .back-button {
                margin-top: 20px;
            }
        </style>

        <table class="applicant-details">
            <tr>
                <th>ID</th>
                <td>{{ $applicant->id }}</td>
            </tr>
            <tr>
                <th>Pet ID</th>
                <td>{{ $applicant->idpet }}</td>
            </tr>
            <tr>
                <th>Application Date</th>
                <td>{{ $applicant->application_date }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $applicant->status }}</td>
            </tr>
            <tr>
                <th>First Name</th>
                <td>{{ $applicant->first_name }}</td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>{{ $applicant->last_name }}</td>
            </tr>
            <tr>
                <th>Transportation Time</th>
                <td>{{ $applicant->transportation_time }}</td>
            </tr>
            <tr>
                <th>Transportation Date</th>
                <td>{{ $applicant->transportation_date }} {{ $applicant->meridiem }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>
                    {{ $applicant->street }}, 
                    {{ $applicant->city }}, 
                    {{ $applicant->barangay }}, 
                    {{ $applicant->postalCode }}, 
                    {{ $applicant->region }}
                </td>
            </tr>
            <tr>
                <th>Pet Name</th>
                <td>{{ $applicant->pet_name }}</td>
            </tr>
        </table>

        <div class="text-center back-button">
            <a href="{{ route('applicants.index') }}" class="btn btn-primary">Back to Applicants</a>
        </div>
    </div>
@endsection
