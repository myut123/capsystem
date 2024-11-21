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
    <title>Animal Shelter Registration</title>
    <style>
/* General Styles */
    body {
        background-color: #454545;
        background-size: cover;
        color: #333;
    }

    /* Background Video */
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

    /* Card Styles */
    .card {
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background: rgba(255, 255, 255, 0.9);
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        overflow: hidden;
    }

    .form-container {
        width: 100%;
        padding: 20px;
        max-width: 800px; /* Adjusted for wider layout */
        margin: 0 auto;
    }

    /* Input Fields */
    input.form-control {
        width: 100%; /* Full width inside the container */
        padding: 12px 14px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        box-sizing: border-box;
        height: 42px;
    }

    /* Buttons */
    .btn {
        width: 100%;
        padding: 12px;
        background-color: #f08a5d;
        color: #fff;
        font-size: 1.2rem;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #d4734a;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
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
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }

    /* Modal Footer */
    .modal-footer {
        display: flex;
        justify-content: space-between;
    }

    .modal-footer button {
        padding: 10px 20px;
    }

    /* Paw Icon Styling */
    .paw-icon {
        font-size: 3rem;
        font-weight: bold;
        color: #333;
        text-align: center;
    }

    .paw-icon::before {
        color: green;
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .row > .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
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
        <div class="col-12 col-md-12"> <!-- Adjusted column width -->
            <div class="card">

                <div class="form-container d-flex align-items-center">
                    <div class="card-body text-black">
                        <div class="d-flex align-items-center mb-3 pb-1">
                            <i class="paw-icon fas fa-paw me-3"></i>
                            <span class="h1 fw-bold mb-0">Sign Up</span>
                            <i class="paw-icon fas fa-paw me-3"></i>
                        </div>

                        <p class="h5">Register an account</p>

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif

                        <form method="POST" action="{{ route('register.submit') }}" id="registrationForm" onsubmit="return checkPrivacy()">
                            @csrf
                            <!-- Form Fields -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-outline">
                                        <input type="text" id="form3Example1c" class="form-control" name="fname" required />
                                        <label class="form-label" for="form3Example1c">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-outline">
                                        <input type="text" id="form3Example2c" class="form-control" name="mname" required />
                                        <label class="form-label" for="form3Example2c">Middle Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-outline">
                                        <input type="text" id="form3Example3c" class="form-control" name="lname" required />
                                        <label class="form-label" for="form3Example3c">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-outline">
                                        <input type="email" id="form3Example4c" class="form-control" name="emailReg" required />
                                        <label class="form-label" for="form3Example4c">Your Email</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-outline">
                                        <input type="password" id="form3Example5c" class="form-control" name="passwordReg" required />
                                        <label class="form-label" for="form3Example5c">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-outline">
                                        <input type="password" id="form3Example6c" class="form-control" name="conPassword" required />
                                        <label class="form-label" for="form3Example6c">Repeat Password</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="agreeCheck" onclick="showModalIfChecked()" />
                                <label class="form-check-label" for="agreeCheck">
                                    I agree to all statements in the Terms of Use
                                </label>
                            </div>

                            <div class="pt-1 mb-4">
                                <button class="btn btn-lg btn-block" type="submit">Register</button>
                            </div>

                            <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? 
                                <a href="/Login" style="color: #393f81;">Login here</a>
                            </p>
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
</body>







<!-- JavaScript to handle modal, buttons, and form submission -->
<script>
    let privacyAgreed = false;

    // Show the modal when the checkbox is checked
    function showModalIfChecked() {
        const checkBox = document.getElementById("agreeCheck");
        if (checkBox.checked && !privacyAgreed) {
            openModal();
        } else if (!checkBox.checked) {
            privacyAgreed = false; // Reset if unchecked
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
        document.getElementById("agreeCheck").checked = true; // Ensure the checkbox is checked
    }

    // Handle "Disagree" button click
    function disagree() {
        closeModal();
        document.getElementById("agreeCheck").checked = false; // Uncheck the checkbox
        privacyAgreed = false; // Reset privacy agreement
    }

    // Check if the Privacy Policy checkbox is checked before form submission
    function checkPrivacy() {
        if (!privacyAgreed) {
            Swal.fire({
                icon: 'warning',
                title: 'Please accept the Privacy Policy',
                text: 'You must agree to the Privacy Policy before registering.',
            });
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }

    // Close modal if clicking outside the modal content
    window.onclick = function(event) {
        var modal = document.getElementById('privacyModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>
