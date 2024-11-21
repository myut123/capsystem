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
        font-family: 'Arial', sans-serif;
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-x: hidden;
    }

    h1 {
        color: #4CAF50;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Navbar Styling */
    .navbar {
        padding: 10px 20px;
        position: sticky;
        top: 0;
        z-index: 1030;
        background-color: #cce6cc;
        border-bottom: 1px solid #ccc;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .navbar-brand img {
        max-height: 70px;
    }

    .navbar-search {
        flex-grow: 1;
        max-width: 300px;
    }

    .input-group {
        width: 100%;
    }

    .navbar-toggler {
        margin-left: auto;
        padding: 5px 10px;
    }

    .offcanvas {
        background-color: #343a40;
    }

    .offcanvas-header {
        background-color: #D4F1F4;
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
        background-color: #c2b69c;
        padding: 15px;
        text-align: center;
        position: relative;
        margin-top: auto;
        width: 100%;
        color: #4A4A4A;
        font-size: 0.9em;
    }
</style>

<body>

<nav class="navbar">
    <!-- Logo Section -->
    <div class="navbar-brand">
        <img src="\img\Tallow Sans Pen.png" alt="Logo" />
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

    <!-- Sidebar Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-end bg-dark-custom" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Dashboard</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body bg-dark">
        <ul class="nav flex-column w-100">
            <li class="nav-item py-2">
                <a href="/pet-upload" class="nav-link text-white d-flex align-items-center">
                    <i class="fa fas-solid fa-upload me-2"></i> Upload
                </a>
            </li>
            <li class="nav-item py-2">
                <a href="/applicants" class="nav-link text-white d-flex align-items-center">
                    <i class="fas fa-user-lock me-2"></i> Adoption Applications
                </a>
            </li>
            <li class="nav-item py-2">
                <a href="/qr" class="nav-link text-white d-flex align-items-center">
                    <i class="fa fas-solid fa-qrcode me-2"></i> Generate QR
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout.submit') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button class="btn btn-danger logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</button>
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
