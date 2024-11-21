@extends('headerFooter.HeaderDash')
@section('content')

<head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap CSS (if you are using Bootstrap) -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Bootstrap Datepicker CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <!-- Bootstrap JS (if you are using Bootstrap) -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap Datepicker JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Adoption Form</title>
        <style>
        /* Underline Input Styles */
        .underline-input {
            border: none; /* Remove border */
            border-bottom: 2px solid #000; /* Add underline */
            outline: none; /* Remove outline */
            padding: 0.75rem 0; /* Increase vertical padding */
            font-size: 1.1rem; /* Slightly larger font size */
            width: 90%; /* Set input width to 90% */
            transition: border-bottom 0.3s; /* Transition for the underline effect */
            margin-bottom: 1.5rem; /* Add margin to space input boxes */
        }

        /* Focus Effect for Input Fields */
        .underline-input:focus {
            border-bottom: 2px solid #007bff; /* Thicker blue underline on focus */
        }

        /* Custom Container Styles */
        .custom-container {
            max-width: 600px; /* Increased maximum width for a more spacious look */
            margin: 0 auto; /* Center the container horizontally */
            padding: 3rem; /* Increased padding for better spacing */
            background-color: #ffffff; /* White background for better contrast */
            border-radius: 10px; /* Rounded corners */
            min-height: 600px; /* Set a minimum height for the container */
        }

        /* Additional Container Background Style */
        .container-fluid {
            background-color: #f7f2e9; /* Light background color */
            padding: 3rem; /* Padding around the container */
        }

        /* Button Styles */
        .btn-primary {
            padding: 0.75rem 1.5rem; /* Increase button padding */
            font-size: 1.1rem; /* Slightly larger button font size */
            background-color: #4CAF50; /* Earthy green for headings */
        }
        
        /* Custom styles for time and date inputs */
        .time-meridiem {
            display: flex; /* Use flex to align items */
            gap: 0.5rem; /* Space between inputs */
        }

        /* Optional: Set the width for the time and date inputs */
        .time-input,
        .date-input {
            width: auto; /* Allow auto width */
        }
    </style>
</head>

<div class="container-fluid">
    <div class="custom-container">
        <h1 class="text-center fw-bold mb-4"> <i class="fas fa-paw"></i> Adoption Form <i class="fas fa-paw"></i></h1>
        <hr>
        
        <!-- Main Form Section -->
        <div id="main-form-section">
            <form id="adoption-form" method="POST" action="{{ route('adoption.submit') }}">
                @csrf
                <div class="mb-4">
                    <div class="row mb-3">
                        <h2>Information</h2>
                        <div class="col-md-6">
                            <label>First Name:</label>
                            <input type="text" class="underline-input form-control" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" required />
                        </div>
                        <div class="col-md-6">
                            <label>Last Name:</label>
                            <input type="text" class="underline-input form-control" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label>Street:</label>
                            <input type="text" class="underline-input form-control" name="street" placeholder="Street" required />
                        </div>
                        <div class="col-sm-4">
                            <label>Barangay:</label>
                            <input type="text" class="underline-input form-control" name="barangay" placeholder="Barangay" required />
                        </div>
                        <div class="col-sm-4">
                            <label>City:</label>
                            <input type="text" class="underline-input form-control" name="city" placeholder="City" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label>Region:</label>
                            <input type="text" class="underline-input form-control" name="region" placeholder="Region" required />
                        </div>
                        <div class="col-sm-6">
                            <label>Postal Code:</label>
                            <input type="text" class="underline-input form-control" name="postal_code" placeholder="Postal Code" required />
                        </div>
                    </div>

                    <!-- Time, Meridiem, and Date Inputs -->
                    <div class="mb-3">
                        <div class="row">
                            <h2>Transportation</h2>
                            <div class="col-md-5">
                                <label for="time">Time:</label>
                                <input type="text" class="underline-input time-input form-control" name="time" placeholder="Time" required />
                                <label for="meridiem">AM/PM:</label>
                                <select class="underline-input form-select" name="meridiem" required>
                                    <option value="">AM/PM</option>
                                    <option value="AM" {{ (old('meridiem', 'AM') == 'AM') ? 'selected' : '' }}>AM</option>
                                    <option value="PM" {{ (old('meridiem', 'PM') == 'PM') ? 'selected' : '' }}>PM</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="datepicker">Date:</label>
                                <input type="text" id="datepicker" class="underline-input date-input form-control" name="date" placeholder="Date" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="submitAdoptionForm()">Submit</button>
                </div>
            </form>
        </div>

        <!-- Employment Information Section (Initially Hidden) -->
        <div id="employment-section" class="mb-4" style="display: none;">
            <div class="alert alert-info" role="alert">
                To ensure the safety and stability of the pet, we require the adoptee to submit necessary employment information.
            </div>
            <h2>Employment Information</h2>
            <form id="employment-form" method="POST" action="{{ route('employment.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Job Title:</label>
                        <input type="text" class="underline-input form-control" name="job_title" placeholder="Job Title" required />
                    </div>
                    <div class="col-md-6">
                        <label>Monthly Income:</label>
                        <input type="number" class="underline-input form-control" name="monthly_income" placeholder="Monthly Income" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Utility Bills:</label>
                        <input type="file" class="form-control" name="utility_bills" accept=".pdf, .jpg, .jpeg, .png" required />
                    </div>
                    <div class="col-md-6">
                        <label>Employment Proof:</label>
                        <input type="file" class="form-control" name="employment_proof" accept=".pdf, .jpg, .jpeg, .png" required />
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="submitEmploymentForm()">Submit Employment Information</button>
                </div>
            </form>
        </div>


        <!-- Reference Information Section (Initially Hidden) -->
        <div id="reference-section" class="mb-4" style="display: none;">
            <div class="alert alert-info" role="alert">
                Please provide a reference to support your adoption application.
            </div>
            <h2>Reference Information</h2>
            <form id="reference-form" method="POST" action="{{ route('identification.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Valid Id 1:</label>
                        <input type="file" class="underline-input form-control" name="valid_id_1" accept="image/*" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Valid Id 2:</label>
                        <input type="file" class="underline-input form-control" name="valid_id_2" accept="image/*" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Selfie Picture:</label>
                        <input type="hidden" id="selfie-data" name="selfie_picture" required />
                        <img id="photo" src="" alt="Selfie will appear here" style="display:none; max-width: 100%;" />
                        <video id="video" width="320" height="240" autoplay style="display:none;"></video>
                        <button type="button" id="capture" class="btn btn-secondary">Capture Selfie</button>
                        <button type="button" id="start-camera" class="btn btn-info">Start Camera</button>
                        <select id="camera-select" class="form-select" style="margin-top: 10px; display: none;"></select>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="submitReferenceForm()">Submit Reference Information</button>
                </div>
            </form>
        </div>
     </div>
</div>

<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    const video = document.getElementById('video');
    const photo = document.getElementById('photo');
    const selfieDataInput = document.getElementById('selfie-data');
    const cameraSelect = document.getElementById('camera-select');

    // Fetch available video input devices
    async function getVideoDevices() {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');
        videoDevices.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.textContent = device.label || `Camera ${cameraSelect.length + 1}`;
            cameraSelect.appendChild(option);
        });
        cameraSelect.style.display = videoDevices.length > 0 ? 'block' : 'none';
    }

    // Start the camera
    document.getElementById('start-camera').addEventListener('click', async function() {
        await getVideoDevices();
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const constraints = {
                video: { deviceId: cameraSelect.value ? { exact: cameraSelect.value } : undefined }
            };
            navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                video.srcObject = stream;
                video.style.display = 'block'; // Show video element
                video.play();
            });
        }
    });

    // Update video stream based on selected camera
    cameraSelect.addEventListener('change', function() {
        startCamera(); // Restart camera with selected device
    });

    // Capture the image
    document.getElementById('capture').addEventListener('click', function() {
        const canvas = document.createElement('canvas');
        canvas.width = 320;
        canvas.height = 240;
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert the canvas image to a data URL
        const dataURL = canvas.toDataURL('image/png');
        selfieDataInput.value = dataURL; // Set hidden input value to the data URL
        photo.src = dataURL; // Show captured selfie
        photo.style.display = 'block'; // Show the image
        video.style.display = 'none'; // Hide video after capturing
    });

    // Function to start camera with selected device
    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const constraints = {
                video: { deviceId: cameraSelect.value ? { exact: cameraSelect.value } : undefined }
            };
            navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                video.srcObject = stream;
                video.play();
            });
        }
    }

    // Call this function to get available video devices when the page loads
    getVideoDevices();

    function submitAdoptionForm() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to submit the form?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = $('#adoption-form').serialize();

                $.ajax({
                    url: $('#adoption-form').attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#main-form-section').hide();
                        $('#employment-section').show();

                        Swal.fire({
                            title: 'Success!',
                            text: 'Your information has been submitted. Please fill out the employment information below.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error submitting the form. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    function submitEmploymentForm() {
    const formData = new FormData($('#employment-form')[0]); // Get form data

    $.ajax({
        url: $('#employment-form').attr('action'),
        type: 'POST',
        data: formData,
        processData: false, // Important for file uploads
        contentType: false, // Important for file uploads
        success: function(response) {
            // Hide the employment section and show the reference section
            $('#employment-section').hide();
            $('#reference-section').show();

            Swal.fire({
                title: 'Success!',
                text: response.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        errorMessage += errors[key].join(', ') + '\n';
                    }
                }
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}
function submitReferenceForm() {
    const formData = new FormData($('#reference-form')[0]); // Get form data

    $.ajax({
        url: $('#reference-form').attr('action'),
        type: 'POST',
        data: formData,
        processData: false, // Important for file uploads
        contentType: false, // Important for file uploads
        success: function(response) {
            // Handle success, e.g., show a success message or modal
            Swal.fire({
                title: 'Success!',
                text: 'Your application will be reviewed by the staff for validation.',
                icon: 'success',
                confirmButtonText: 'Back to Home', // Change this text as needed
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/homepage'; // Change this to your desired route
                }
            })
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        errorMessage += errors[key].join(', ') + '\n';
                    }
                }
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    });
}


</script>

@endsection 