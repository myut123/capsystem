@extends('headerFooter.header')
@section('content')
<head>
    <title>Applicant Information</title>
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
</head>
<div class="container">
    <h1 class="text-center my-4">Applicant Details</h1>

    <!-- Main Card Section -->
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <!-- User Information Column -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-center">User Information</h5>
                    <table class="table table-striped">
                        
                        <tr>
                            <th>First Name</th>
                            <td>{{ $applicant->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $applicant->last_name }}</td>
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
                    </table>
                </div>

                <!-- Pet Information Column -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-center">Pet Information</h5>
                    <table class="table table-striped">
                      
                        <tr>
                            <th>Pet Name</th>
                            <td>{{ $applicant->name }}</td>
                        </tr>
                        
                        
                    </table>
                </div>

                <!-- Transport Information Column -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-center">Adoption Details</h5>
                    <table class="table table-striped">
                        <tr>
                            <th>Transportation Time</th>
                            <td>{{ $applicant->transportation_time }}</td>
                        </tr>
                        <tr>
                            <th>Transportation Date</th>
                            <td>{{ $applicant->transportation_date }} {{ $applicant->meridiem }}</td>
                        </tr>
                        <tr>
                            <th>Application Date</th>
                            <td>{{ $applicant->application_date }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $applicant->status }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Buttons -->
    <div class="mt-4 d-flex justify-content-between">
        <form action="{{ route('applicant.accept', $applicant->idadoption_application) }}" method="post" class="mx-2">
            @csrf
            <button type="submit" class="btn btn-success btn-lg">Accept</button>
        </form>
        <form action="{{ route('applicant.reject', $applicant->idadoption_application) }}" method="post" class="mx-2">
            @csrf
            <button type="submit" class="btn btn-danger btn-lg">Reject</button>
        </form>
    </div>
</div>


<style>
   /* General Container Styling */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 10px;
}

/* Card Styling */
.card {
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

/* Section Headers */
.card h5 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #343a40;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 10px;
    margin-bottom: 15px;
    text-align: center;
}

/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
    color: #555;
}

.table th,
.table td {
    padding: 15px;
    font-size: 0.95rem;
    border-bottom: 1px solid #e0e0e0;
}

.table th {
    background-color: #f9fafb;
    font-weight: 600;
    color: #495057;
}

.table td {
    background-color: #ffffff;
}

/* Button Styling */
.btn {
    width: 160px;
    padding: 12px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 8px;
    text-align: center;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-success {
    background-color: #38c172;
    border-color: #38c172;
    color: #fff;
}

.btn-danger {
    background-color: #e3342f;
    border-color: #e3342f;
    color: #fff;
}

.btn:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

/* Centering Text and Forms */
.text-center {
    text-align: center;
}

.d-flex {
    display: flex;
    align-items: center;
}

/* Spacing for the Buttons */
.mt-4 {
    margin-top: 30px;
}

.mx-2 {
    margin-left: 15px;
    margin-right: 15px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }

    .btn {
        width: 100%;
        margin-top: 10px;
    }

    .mx-2 {
        margin: 0;
    }
}

</style>


@endsection 