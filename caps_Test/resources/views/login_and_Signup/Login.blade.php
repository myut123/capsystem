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
    <title>Login</title>
    <style>
        /* Custom styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            color: #000;
            text-decoration: underline;
        }

        .close:hover,
        .close:focus {
            color: red;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
        }

        .modal-footer button {
            padding: 10px 20px;
        }

        body {
            background-color: #454545;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
        }

        .footer-text {
            color: #ff6347;
            text-align: center;
            margin-top: 15px;
        }

        .paw-icon {
            color: #ff6347;
            font-size: 2rem;
        }

        /* Adjust fixed image container for a smaller size */
        .fixed-image-container {
            width: 300px;
            height: 600px;
            overflow: hidden;
        }

        /* Adjust image to fit the container */
        .fixed-image {
            height: 100%;
            width: auto;
            object-fit: cover;
        }

        .form-container {
            flex: 1;
            padding: 20px;
            max-width: 400px;
        }

        .btn {
            background-color: #f08a5d;
            border-color: #f08a5d;
            font-size: 1.2rem;
        }

        /* Style for background video */
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .video-background__video {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .container-fluid {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <!-- Background Video Section -->
    <div class="video-background">
        <video autoplay loop muted class="video-background__video">
            <source src="{{ asset('video/Dogs - Cinematic Background Video ( NO COPYRIGHT ) 4k (1).mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="container-fluid d-flex justify-content-center align-items-center h-100 mt-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-md-12">
                <div class="card">
                    <!-- Form Section -->
                    <div class="form-container d-flex align-items-center">
                        <div class="card-body text-black">
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            <form method="POST" action="{{ route('login.submit') }}" onsubmit="return checkPrivacy()">
                                @csrf
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <i class="paw-icon fas fa-paw me-3"></i>
                                    <span class="h1 fw-bold mb-0">Pawsome And Furfect</span>
                                </div>

                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                                <div class="form-outline mb-4">
                                    <input type="email" id="form2Example17" name="emailInput" class="form-control form-control-lg" required />
                                    <label class="form-label" for="form2Example17">Email address</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="form2Example27" name="passwordInput" class="form-control form-control-lg" required />
                                    <label class="form-label" for="form2Example27">Password</label>
                                </div>

                                <!-- Checkbox for Privacy Policy -->
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="privacyCheck" onclick="showModalIfChecked()">
                                    <label class="form-check-label" for="privacyCheck">
                                        I agree to the Privacy Policy
                                    </label>
                                </div>

                                <div class="pt-1 mb-4">
                                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                </div>

                                <a class="small text-muted" href="#!">Forgot password?</a>
                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="/register" style="color: #393f81;">Register here</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="privacyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h5>Data Privacy Policy</h5>
            <p>We value your privacy. This data privacy policy explains how we collect, use, and protect your personal information.</p>

            <div class="modal-footer">
                <button id="agreeButton" onclick="agree()">Agree</button>
                <button id="disagreeButton" onclick="disagree()">Disagree</button>
            </div>
        </div>
    </div>

    <style>
        /* Style for background video */
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Make sure video is behind other content */
        }

        .video-background__video {
            object-fit: cover; /* Ensure video covers the entire container */
            width: 100%;
            height: 100%;
        }

        .container-fluid {
            position: relative; /* Ensures the form and content are on top of the video */
            z-index: 1;
        }
    </style>
</body>



<!-- JavaScript to handle modal, buttons, and form submission -->
<script>
    let privacyAgreed = false;

    // Show the modal when the checkbox is checked
    function showModalIfChecked() {
        var checkBox = document.getElementById("privacyCheck");
        if (checkBox.checked && !privacyAgreed) {
            openModal();
        }
    }

    // Open modal
    function openModal() {
        document.getElementById('privacyModal').style.display = 'block';
    }

    // Close modal
    function closeModal() {
        document.getElementById('privacyModal').style.display = 'none';
    }

    // Handle "Agree" button click
    function agree() {
        privacyAgreed = true;
        closeModal();
    }

    // Handle "Disagree" button click
    function disagree() {
        window.location.reload();
    }

    // Check if the Privacy Policy checkbox is checked before form submission
    function checkPrivacy() {
        if (!privacyAgreed) {
            Swal.fire({
                icon: 'warning',
                title: 'Please accept the Privacy Policy',
                text: 'You must agree to the Privacy Policy before logging in.',
            });
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }

    // Track user online/offline status
    $(document).ready(function() {
        // Send AJAX request to mark user as online
        $.ajax({
            type: 'POST',
            url: '/set-status', // Your Laravel route to set online status
            data: { status: 'online', _token: '{{ csrf_token() }}' },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });

        // Send AJAX request to mark user as offline when they leave
        $(window).on('beforeunload', function() {
            $.ajax({
                type: 'POST',
                url: '/set-status', // Your Laravel route to set offline status
                data: { status: 'offline', _token: '{{ csrf_token() }}' },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

    // Close modal if clicking outside the modal content
    window.onclick = function(event) {
        var modal = document.getElementById('privacyModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>


</body>
</html>
