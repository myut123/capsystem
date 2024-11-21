<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP - Animal Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:#FFE4C4; /* Animal-themed background */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .otp-container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 60px; /* Increased padding for a larger look */
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 550px; /* Increased width */
            width: 100%;
        }

        h1 {
            font-size: 2.5rem; /* Increased font size */
            color: #6c757d;
            margin-bottom: 25px;
            font-family: 'Comic Sans MS', cursive;
        }

        p {
            color: #6c757d;
            margin-bottom: 20px;
            font-size: 1.25rem; /* Increased font size */
        }

        .btn-primary {
            background-color: #f08a5d;
            border-color: #f08a5d;
            font-size: 1.2rem; /* Larger button text */
            padding: 15px; /* Increase padding for bigger button */
        }

        .btn-primary:hover {
            background-color: #b83b5e;
            border-color: #b83b5e;
        }

        #responseMessage {
            margin-top: 15px;
            font-size: 1.1rem; /* Slightly larger text for response */
        }

        /* Custom Paw Icon */
        .paw-icon {
            color: #f08a5d;
            font-size: 2.5rem; /* Larger paw print */
            margin-bottom: 15px;
        }

        .footer-text {
            font-size: 1rem;
            color: #b83b5e;
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <i class="paw-icon">&#128062;</i> <!-- Unicode paw print for the theme -->
        <h1>We will send OTP to Your Email</h1>
        
        <p>Your registered email:{{ $user->email }}</p>

        <!-- Bootstrap Form -->
        <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}"> <!-- Example email -->
            
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 py-2">Send OTP</button>
        </form>

        <!-- Response Message -->
        <div id="responseMessage" class="text-danger mt-3"></div>

        <div class="footer-text">Adopt, Don’t Shop &#128062;</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#otpForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting the traditional way

                $.ajax({
                    url: '{{ route("view.otp") }}', // Your Laravel route to send OTP
                    type: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Handle the response here
                        if (response.success) {
                            $('#responseMessage').html('<span class="text-success">OTP sent successfully!</span>');
                            // You can redirect to the next page or show a success message without reloading
                            window.location.href = '/otp-verification-page'; // Example of redirecting to the next step
                        } else {
                            $('#responseMessage').html('<span class="text-danger">' + response.message + '</span>');
                        }
                    },
                    error: function(xhr) {
                        // Handle error response
                        $('#responseMessage').html('<span class="text-danger">Something went wrong. Please try again later.</span>');
                    }
                });
            });
        });
    </script>
</body>

</html>
