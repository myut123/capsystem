<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <script src="https://kit.fontawesome.com/1d8d68cd8a.js" crossorigin="anonymous"></script>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8eedd;
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow-x: hidden;
    }

    /* Navbar Styling */
    .navbar {
        padding: 20px 30px; /* Increased padding for better spacing */
        position: sticky;
        top: 0;
        z-index: 1030;
        background-color: #cce6cc; /* Light green to white gradient */
        border-bottom: 1px solid #ccc;
        display: flex;
        align-items: center; /* Center items vertically */
    }

    .navbar-brand {
        margin-left: 20px; /* Adjust margin for better spacing */
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
        margin: 0 25px; /* Adjusted margin for better spacing */
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
        padding: 10px; /* Added padding for button */
    }

    .logout-btn:hover {
        background-color: #c0392b;
    }

    .footer {
        background-color: #dde7f8;
        padding: 20px 15px; /* Added top/bottom padding for more space */
        text-align: center;
        position: relative;
        margin-top: 20px; /* Added margin-top for spacing above footer */
        width: 100%;
    }

    .content {
        padding: 2rem; /* Added padding for better spacing inside content */
        margin-bottom: 20px; /* Added margin-bottom for spacing between content and footer */
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
        margin-right: 15px; /* Adjusted space between image and text */
    }

    .user-info div {
        line-height: 1.2; /* Adjust line height */
    }

    .user-info strong {
        display: block; /* Force name to take its own line */
    }
</style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-brand">
            <img src="\img\Tallow Sans Pen.png" height="70" alt="Logo" loading="lazy" />
        </div>

        <div class="navbar-search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="query" aria-label="Search">
                <span class="input-group-text" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>

        <div class="navbar-links">
            <a class="nav-link active" href="/Admin/Homepage">Home</a>
        

        </div>
    </nav>

    <!-- Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start bg-dark-custom" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarLabel">Dashboard</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="user-info" id="userInfo">
                <img src="\img\doggo.jpg" alt="User Image" class="img-fluid">
                <div>
                    <!-- User Info will be populated here by JavaScript -->
                </div>
            </div>
            <hr style="border: 1px solid white; margin: 10px 0;">
            <ul class="nav flex-column">
                <li class="nav-item py-2">
                    <a href="/staff/petUpload" class="nav-link text-white active">
                        <i class="fa fas-solid fa-upload"></i> Messages
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="/zoom/meetings" class="nav-link text-white">
                        <i class="fas fa-user-lock icon"></i> Sched Meeting
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
    </div>
   

    @yield('content')

    <!-- Footer -->
    <footer class="footer" style="padding-top: 20px;">
        <p>&copy; 2024 Pawsome. All rights reserved.</p>
    </footer>
    </body>

    <script>
    $(document).ready(function () {
        // Initialize Offcanvas without backdrop
        var offcanvasElement = document.getElementById('sidebar');
        var offcanvas = new bootstrap.Offcanvas(offcanvasElement, {
            backdrop: false, // Disable backdrop
        });
    });

    // Assuming you pass the user data to the view
    const user = @json($user);

    // Format user info
    if (user) {
        const formattedName = user.first_name.toUpperCase() + " " + user.last_name.toUpperCase();
        const formattedRole = user.role.replace('is_', '').charAt(0).toUpperCase() + user.role.slice(4).toLowerCase();

        document.getElementById('userInfo').children[1].innerHTML = `<strong>${formattedName}</strong><br>${formattedRole}`;
    }
</script>

</body>

</html>
