<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1d8d68cd8a.js" crossorigin="anonymous"></script>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<style>
  body {
            background-color: #e9f5f5; 
            font-family: 'Arial', sans-serif; /* Font for the page */
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-x: hidden;
        }

        h1 {
            color: #4CAF50; /* Earthy green for headings */
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: #3E3E3E; /* Dark gray for subheadings */
            margin-top: 40px;
        }

        /* Navbar Styling */
        .navbar {
            padding: 10px 20px;
            position: sticky; /* Make the navbar sticky */
            top: 0; /* Stick it to the top of the viewport */
            z-index: 1030; /* Ensure it stays on top of other elements */
            background-color: #cce6cc; /* Light green to white gradient */
            border-bottom: 1px solid #ccc;
            display: flex;
            align-items: center; /* Center items vertically */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for better visibility */
        }

        .navbar-brand {
            margin-left: 10px; /* Adjust margin as needed */
        }

        .navbar-search {
            margin-left: auto; /* Move search to the right */
        }

        .navbar-brand img {
            max-height: 70px;
        }

        .navbar-links {
            display: flex;
            justify-content: center;
            flex-grow: 1;
            margin: 0;
            padding: 0;
        }

        .navbar-links .nav-link {
            color: #000;
            margin: 0 20px;
        }

        .navbar-toggler {
            margin-left: auto;
            padding: 5px 10px;
        }

        .offcanvas {
            background-color: #343a40; /* Dark background for sidebar */
        }

        .offcanvas-header {
            background-color: #D4F1F4; /* Light background for header */
        }

        .logout-btn {
            background-color: #e74c3c;
            border: none;
            border-radius: 5px;
            width: 100%;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .footer {
            background-color: #c2b69c; /* A pastel brown color */

            padding: 15px;
            text-align: center;
            position: relative;
            margin-top: auto;
            width: 100%;
            color: #4A4A4A; /* Darker text for better visibility */
            font-size: 0.9em; /* Slightly smaller font size */
        }

        .content {
            padding: 1rem;
            flex-grow: 1; /* Allow content to expand and fill space */
        }

        .user-info {
            color: white;
            margin-bottom: 20px;
            display: flex;
            align-items: center; /* Center items vertically */
        }

        .user-info img {
            width: 50px; /* Adjust width as needed */
            height: 50px; /* Adjust height as needed */
            border-radius: 50%;
            margin-right: 10px; /* Space between image and text */
        }

        .user-info div {
            line-height: 1.2; /* Adjust line height */
        }

        .user-info strong {
            display: block; /* Force name to take its own line */
        }

        /* Card Style */
        .card {
            border: 2px solid #a5d6a7; /* Light green border */
            border-radius: 15px; /* Rounded corners */
            transition: transform 0.2s; /* Smooth scale on hover */
            cursor: pointer;
            text-align: center;
            background-color: #ffffff; /* White background for cards */
            margin: 10px; /* Add margin between cards */
        }

        .card:hover {
            transform: scale(1.05); /* Scale effect on hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

        .card-title {
            font-size: 1.5rem; /* Larger font size for titles */
            color: #4CAF50; /* Earthy green for titles */
        }

        .btn-primary {
            background-color: #5D9B30; /* Deep green button color */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners for buttons */
        }

        .btn-primary:hover {
            background-color: #4CAF50; /* Lighter green on hover */
        }

        #error-message {
            display: none; /* Initially hidden */
        }

        .text-center {
            text-align: center; /* Center align text */
        }

</style>

<body>

<nav class="navbar">
    <!-- Logo Section (Left) -->
    <div class="navbar-brand">
        <img src="\img\Tallow Sans Pen.png" height="70" alt="Logo" loading="lazy" />
    </div>

    <!-- Search Bar Section -->
    <div class="navbar-search">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search..." name="query" aria-label="Search">
            <span class="input-group-text" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
        </div>
    </div>

    <!-- Centered Links Section -->
    <div class="navbar-links">
        <a class="nav-link active" href="{{ route('home.view') }}">Home</a>
        <a class="nav-link" href="#">About</a>
        <a class="nav-link" href="#">Contact</a>
    </div>
    <!-- Sidebar Toggler (Right) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
    <i class="fas fa-bars"></i> <!-- Font Awesome bars icon -->
</button>

</nav>

<!-- Offcanvas Sidebar (Right Side) -->
<div class="offcanvas offcanvas-end bg-dark-custom" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Dashboard</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body bg-dark">
        <ul class="nav flex-column">
            <li class="nav-item py-2">
                <a href="/profile/edit" class="nav-link text-white active">
                    <i class="fa fas-solid fa-upload"></i> Edit Profile
                </a>
            </li>
            <li class="nav-item py-2">
                <a href="" class="nav-link text-white">
                <i class="fa-solid fa-calendar-days"></i> Sched Meet
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout.submit') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <button class="btn btn-danger logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Log out
        </button>
    </div>
</div>

@yield('content')

<footer class="footer">
    <p>&copy; 2024 Pawsome. All rights reserved.</p>
    <div>
        <a href="#" class="text-decoration-none me-3"><i class="fa fa-facebook"></i></a>
        <a href="#" class="text-decoration-none me-3"><i class="fa fa-twitter"></i></a>
        <a href="#" class="text-decoration-none"><i class="fa fa-instagram"></i></a>
    </div>
</footer>

</body>
</html>
