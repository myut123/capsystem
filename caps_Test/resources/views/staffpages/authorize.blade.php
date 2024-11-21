@extends('headerFooter.header')
@section('content')
<head>
    <title>Login Zoom Acc</title>
    <style>
    .zoom-auth-container {
        max-width: 600px; /* Limit the max width of the container */
        margin: 40px auto; /* Center the container with space on top */
        padding: 20px; /* Add padding around the content */
        border: 1px solid #ddd; /* Light border */
        border-radius: 8px; /* Rounded corners */
        background-color: #f9f9f9; /* Light background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
        text-align: center; /* Center align the text */
    }

    .zoom-auth-container h1 {
        margin-bottom: 20px; /* Space below the title */
        color: #333; /* Darker text color */
    }

    .zoom-auth-container p {
        margin-bottom: 30px; /* Space below the paragraph */
        color: #555; /* Dark grey color for text */
        font-size: 16px; /* Font size for the paragraph */
    }

    .zoom-auth-container .btn {
        padding: 12px 20px; /* Padding inside the button */
        font-size: 16px; /* Font size for button text */
        transition: background-color 0.3s ease; /* Transition effect for hover */
    }

    .zoom-auth-container .btn:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
</style>

</head>
<div class="zoom-auth-container mt-5">
    <h1>Authorize Zoom</h1>
    <p>To access your Zoom meetings, please authorize the application by clicking the button below.</p>
    <a href="{{ url('/oauth/zoom') }}" class="btn btn-primary">Authorize Zoom</a>
</div>

@endsection 