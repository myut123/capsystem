<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1d8d68cd8a.js" crossorigin="anonymous"></script>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Admin Dashboard</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background-image: url('{{ asset('img/paws.jpg') }}'); 
            background-size: cover; /* Cover the entire area */
            background-position: center; /* Center the image */
            font-family: 'Nunito', sans-serif;
            overflow-y: auto;
        }

        body::-webkit-scrollbar {
            width: 0; /* Hide scrollbar for WebKit browsers */
        }

        body.show-scrollbar {
            overflow-y: scroll; /* Allow scrolling */
        }

        body.show-scrollbar::-webkit-scrollbar {
            width: 10px; /* Set scrollbar width */
        }

        body.show-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5); /* Set scrollbar color */
            border-radius: 10px; /* Rounded corners for scrollbar */
        }

        body.show-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1); /* Background for the scrollbar track */
        }

        .navbar {
            background-color: #cce6cc; /* Light green to white gradient */
        }

        .navbar h1 {
            color: #2c3e50;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .logout-btn {
            background-color: #e74c3c;
            border: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .animal-logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .animal-logo img {
            border-radius: 50%;
            width: 100%;
            height: auto;
        }

        .container-fluid {
            flex: 1;
            display: flex;
            padding: 0;
            margin: 0;
            flex-direction: row; /* Keep items in a row */
            flex-wrap: nowrap; /* Prevent wrapping */
        }

        .scrollable-area {
            width: 30%;
            height: calc(100vh - 175px);
            overflow-y: auto;
            background-color: #f8eedd;
            padding: 20px;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column; /* For internal alignment */
            justify-content: flex-start; /* Align children at the top */
        }
        .scrollable-area::-webkit-scrollbar {
            width: 0; /* Hide scrollbar for WebKit browsers */
        }

        .scrollable-area.show-scrollbar {
            overflow-y: scroll; /* Allow scrolling */
        }

        .scrollable-area.show-scrollbar::-webkit-scrollbar {
            width: 10px; /* Set scrollbar width */
        }

        .scrollable-area.show-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5); /* Set scrollbar color */
            border-radius: 10px; /* Rounded corners for scrollbar */
        }

        .scrollable-area.show-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1); /* Background for the scrollbar track */
        }

        .cards-area {
            width: 80%;
            padding: 20px;
            display: flex;
            flex-direction: column; /* Ensure cards are stacked */
            gap: 20px;
            flex-grow: 1; /* Allows this section to take up available space */
            overflow: hidden; /* Prevent overflow */
        }

        .card {
            transition: transform 0.3s;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        footer {
            background-color: #dde7f8;
            padding: 15px 0;
            text-align: center;
            width: 100%;
        }

        footer p {
            margin: 0;
            color: #2c3e50;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            color: #2c3e50;
            margin: 0 10px;
            text-decoration: none;
        }

        .social-icons a:hover {
            color: #e74c3c;
        }

        .card img {
            width: 100%;
            height: auto;
            max-height: 150px;
            object-fit: cover;
        }

        .card-body {
            min-height: 100px;
        }

        /* Style for Profile Picture and Info */
        .profile-section {
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center; /* Center horizontally */
        }

        .profile-pic {
            position: relative;
            display: inline-block; 
        }

        .status-indicator {
    position: absolute;
    bottom: 5px; /* Adjust as needed */
    right: 23px; /* Adjust as needed */
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: gray; /* Default color */
    border: 2px solid white;
    z-index: 1; /* Ensure it appears above the image */
}

        .profile-pic img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            margin-right: 15px;
        }

        .logout-btn {
            margin-top: 10px; /* Space above the logout button */
            width: 100%; /* Make button full width */
        }

        .user-info h5, .user-info p {
            margin: 0;
        }

        .separator {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .container-fluid {
                flex-direction: column; /* Stack items vertically on smaller screens */
            }
            .scrollable-area {
                width: 100%; /* Take full width */
                height: 200px; /* Set a fixed height for the scrollable area */
                border-right: none; /* Remove border */
                border-bottom: 1px solid #ddd; /* Add bottom border */
            }
            .cards-area {
                width: 100%; /* Take full width */
                padding: 10px; /* Adjust padding */
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="animal-logo d-flex justify-content-center align-items-center me-2">
                    <img src="/img/logo.png" alt="Pawsome Logo" loading="lazy" />
                </div>
                <h1 class="m-0">DashBoard</h1>
            </div>
        </div>
    </nav>

    <!-- Dynamic Content Section -->
    <div class="container-fluid">
        <!-- Scrollable Area for Admin Settings Menu -->
        <div class="scrollable-area">
            <div class="row mt-4">
                <!-- Profile Section with Picture and Info -->
                <div class="col-12 mb-3">
                    <div class="profile-section">
                        <div class="profile-pic">
                            <div class="status-indicator" style="background-color: {{ $user->is_online ? 'green' : 'gray' }};"></div>
                            <img src="{{ asset('img/doggo.jpg') }}" alt="User Profile Picture">
                        </div>
                        <div class="user-info">
                            <h5 id="userName">{{ $user->first_name }} {{ $user->last_name }}</h5>
                            <p id="userRole">{{ $user->role }}</p>
                            <button class="btn btn-danger logout-btn" aria-label="Log out" onclick="handleLogout()">Log out</button>
                        </div>
                    </div>
                </div>

                <div class="separator"></div>

                <!-- New Card 1: User Management -->
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">User Management</h5>
                            <p class="card-text">Manage user accounts and roles.</p>
                        </div>
                    </div>
                </div>

                <!-- New Card 2: Reports -->
                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Reports</h5>
                            <p class="card-text">View and generate various reports.</p>
                        </div>
                    </div>
                </div>

               

             
            </div>
        </div>

        <!-- Cards Area -->
        <div class="cards-area">
            <div class="row">
                <!-- Content Section -->
                <div class="col-md-6 mb-4">
                    <a href="/Admin/Update/Category" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('img/dogs.jpg') }}" alt="Feedback Management" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Pet Preference</h5>
                                <p class="card-text">Review and manage user feedback and suggestions.</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Additional Cards -->
                <div class="col-md-6 mb-4">
                    <a href="/campaign/upload-view" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('img/dogs.jpg') }}" alt="Settings" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Settings</h5>
                                <p class="card-text">Manage site settings and preferences.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Pawsome. All Rights Reserved.</p>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <script>
        document.addEventListener('scroll', () => {
            // Add the class to show the scrollbar when the user scrolls
            document.body.classList.add('show-scrollbar');

            // Remove the class after a timeout (e.g., 1000 ms) to hide the scrollbar again
            clearTimeout(scrollableArea.scrollTimeout);
            scrollableArea.scrollTimeout = setTimeout(() => {
                document.body.classList.remove('show-scrollbar');
            }, 1000);
        });


        const scrollableArea = document.querySelector('.scrollable-area');

        scrollableArea.addEventListener('scroll', () => {
            // Add the class to show the scrollbar when the user scrolls
            scrollableArea.classList.add('show-scrollbar');
            
            // Remove the class after a timeout (e.g., 1000 ms) to hide the scrollbar again
            clearTimeout(scrollableArea.scrollTimeout);
            scrollableArea.scrollTimeout = setTimeout(() => {
                scrollableArea.classList.remove('show-scrollbar');
            }, 1000);
        });

        function handleLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/Login';
                }
            });
        }
        const userName = document.getElementById('userName');
        const userRole = document.getElementById('userRole');
        userName.textContent = userName.textContent.toUpperCase(); // Convert to uppercase
        userRole.textContent = userRole.textContent.replace(/is_/g, ''); // Remove "is_" from role
    </script>
</body>

</html>
