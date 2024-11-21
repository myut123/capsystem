@extends('headerFooter.header')
@section('content')
<head>
    <title>Scheduled Meetings</title>
    <style>
    .meeting-container {
        max-width: 800px; /* Set a max width for the container */
        margin: 20px auto; /* Center the container */
        padding: 20px; /* Add padding around the content */
        border: 1px solid #ddd; /* Light border */
        border-radius: 8px; /* Rounded corners */
        background-color: #f9f9f9; /* Light background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    }

    .meeting-container h1 {
        text-align: center; /* Center the title */
        margin-bottom: 20px; /* Space below the title */
        color: #333; /* Darker text color */
    }

    .alert {
        margin-bottom: 20px; /* Space below the alert */
    }

    .meeting-list {
        list-style-type: none; /* Remove default list styles */
        padding: 0; /* Remove padding */
    }

    .meeting-item {
        border-bottom: 1px solid #ddd; /* Add a border between items */
        padding: 10px 0; /* Vertical padding */
    }

    .meeting-item:last-child {
        border-bottom: none; /* Remove border for the last item */
    }

    .meeting-item strong {
        color: #007bff; /* Bootstrap primary color */
    }

    .meeting-item a {
        color: #007bff; /* Link color */
        text-decoration: none; /* Remove underline */
    }

    .meeting-item a:hover {
        text-decoration: underline; /* Underline on hover */
    }
</style>
</head>
<div class="meeting-container">
    <h1>Your Scheduled Zoom Meetings</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <ul class="meeting-list">
        @foreach ($meetings as $meeting)
            <li class="meeting-item">
                <strong>{{ $meeting->topic }}</strong><br>
                Start Time: {{ $meeting->start_time }}<br>
                Duration: {{ $meeting->duration }} minutes<br>
                Join URL: <a href="{{ $meeting->join_url }}" target="_blank">{{ $meeting->join_url }}</a>
            </li>
        @endforeach
    </ul>
</div>

@endsection 