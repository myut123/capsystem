<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome.min.css">
    <title>Your Website Title</title>
    <style>
        html, body {
            height: 100%; /* Ensure full height */
            margin: 0; /* Remove default margin */
            display: flex; /* Use flexbox */
            flex-direction: column; /* Stack children vertically */
        }

        .content {
            flex: 1; /* Allow this div to grow and take available space */
        }

        footer {
            margin-top: auto; /* Push footer to the bottom */
            background-color: #D4F1F4;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Your page content goes here -->
        @yield('content')
    </div>

    <footer class="text-center text-lg-start text-dark t-5">
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row my-4">
                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 150px; height: 150px;">
                        <!-----Beneficiary Logo----->
                        <img src="\img\logo.png" height="150" alt="" loading="lazy" />
                    </div>
                    <p class="text-center">Pawsome And Furfect Match</p>
                    <ul class="list-unstyled d-flex flex-row justify-content-center">
                        <li>
                            <a class="text-dark px-2" href="#!">
                                <i class="fab fa-facebook-square"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Animals</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>Missing Pets</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>How to adopt?</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>Pets for adoption</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>Donate</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>Volunteer activities</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">About</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>About the shelter</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>Statistic data</a>
                        </li>
                        <li class="mb-2">
                            <a href="#!" class="text-dark"><i class="fas fa-paw pe-3"></i>Contact</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Contact</h5>
                    <ul class="list-unstyled">
                        <li>
                            <p><i class="fas fa-map-marker-alt pe-2"></i>Tanauan, Batangas Philippines</p>
                        </li>
                        <li>
                            <p><i class="fas fa-phone pe-2"></i>+ 01 234 567 89</p>
                        </li>
                        <li>
                            <p><i class="fas fa-envelope pe-2 mb-0"></i>contact@example.com</p>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2024 Copyright:
            <a class="text-white" href="https://www.facebook.com/straysworthsaving">Strays Worth Saving</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>
</html>
