@extends('headerFooter.header')
@section('content')
<head>
    <title>Add A Schedule</title>
    <style>
    .zoom-container {
        max-width: 600px; /* Limit the max width of the form */
        margin: 20px auto; /* Center the container */
        padding: 20px; /* Add padding around the content */
        border: 1px solid #ddd; /* Light border */
        border-radius: 8px; /* Rounded corners */
        background-color: #f9f9f9; /* Light background color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    }

    .zoom-h1 {
        text-align: center; /* Center the title */
        margin-bottom: 20px; /* Space below the title */
        color: #333; /* Darker text color */
    }

    .zoom-label {
        display: block; /* Make labels block elements */
        margin-bottom: 5px; /* Space below labels */
        color: #555; /* Dark grey color for labels */
    }

    .zoom-input {
        width: 100%; /* Full width inputs */
        padding: 10px; /* Padding inside inputs */
        margin-bottom: 15px; /* Space below inputs */
        border: 1px solid #ccc; /* Light border */
        border-radius: 4px; /* Slightly rounded corners */
        font-size: 16px; /* Font size for inputs */
    }

    .zoom-button {
        width: 100%; /* Full width button */
        padding: 10px; /* Padding inside button */
        background-color: #007bff; /* Bootstrap primary color */
        color: white; /* White text color */
        border: none; /* Remove border */
        border-radius: 4px; /* Slightly rounded corners */
        font-size: 16px; /* Font size for button */
        cursor: pointer; /* Pointer cursor on hover */
        transition: background-color 0.3s ease; /* Transition effect for hover */
    }

    .zoom-button:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    @media (max-width: 768px) {
        .zoom-container {
            padding: 15px; /* Less padding on smaller screens */
        }

        .zoom-button {
            font-size: 14px; /* Smaller font size on smaller screens */
        }
    }
</style>

    
</head>
<div class="zoom-container mt-5">
    <h1 class="zoom-h1">Schedule a Meeting</h1>

    <form action="/zoom/schedule" method="POST">
        @csrf
        <label for="topic" class="zoom-label">Meeting Topic:</label>
        <input type="text" id="topic" name="topic" class="zoom-input" required>

        <label for="start_time" class="zoom-label">Start Time (UTC):</label>
        <input type="datetime-local" id="start_time" name="start_time" class="zoom-input" required>

        <label for="timezone" class="zoom-label">Timezone:</label>
        <input type="text" id="timezone" name="timezone" class="zoom-input" value="UTC" readonly>

        <button type="submit" class="zoom-button">Schedule Meeting</button>
    </form>
</div>

@endsection 