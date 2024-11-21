<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFE4C4;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .otp-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 0;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: row;
            min-height: 600px;
        }

        .illustration {
            flex: 1;
            height: 100%;
            max-height: 600px;
            overflow: hidden;
            padding: 0;
        }

        .illustration img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .otp-form {
            padding: 30px;
            flex: 1;
            margin-top: 40px;
            position: relative;
            z-index: 1;
        }

        h3 {
            font-size: 2.5rem;
            color: #6c757d;
            margin-bottom: 25px;
            font-family: 'Comic Sans MS', cursive;
        }

        p {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .otp-input {
            text-align: center;
            font-size: 1.5rem;
            padding: 5px;
            margin-right: 10px;
            width: 50px;
            height: 60px;
        }

        .otp-input:last-child {
            margin-right: 0;
        }

        .otp-input-group {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .btn-primary {
            background-color: #f08a5d;
            border-color: #f08a5d;
        }

        .btn-primary:hover {
            background-color: #b83b5e;
            border-color: #b83b5e;
        }

        .btn-link {
            color: #f08a5d;
        }

        .btn-link:hover {
            color: #b83b5e;
        }

        @media (max-width: 768px) {
            .otp-container {
                flex-direction: column;
                min-height: 400px;
            }

            .illustration {
                height: 200px;
            }

            .otp-form {
                margin-top: 20px;
            }

            .otp-input {
                width: 40px;
                height: 50px;
                font-size: 1.2rem;
                margin-right: 5px;
            }

            .otp-input-group {
                flex-wrap: wrap;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .otp-input {
                width: 35px;
                height: 45px;
                font-size: 1rem;
            }

            .otp-form {
                padding: 20px;
            }

            .otp-container {
                max-width: 100%;
            }

            .otp-container .otp-form h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <!-- Combined Container for Image and OTP Form -->
        <div class="otp-container row">
            <!-- Illustration Section -->
            <div class="col-md-6 illustration d-none d-md-block">
                <img src="img/doggo.jpg" alt="OTP FORM" class="img-fluid">
            </div>

            <!-- OTP Verification Form Section -->
            <div class="col-md-6">
                <div class="otp-form text-center">
                    <h3>OTP Verification Code</h3>

                    <!-- OTP Verification Form -->
                    <form action="{{ route('verify.otp') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="d-flex justify-content-center mb-3 otp-input-group">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required oninput="moveFocus(this)" onkeydown="handleKeyDown(event, this)">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required oninput="moveFocus(this)" onkeydown="handleKeyDown(event, this)">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required oninput="moveFocus(this)" onkeydown="handleKeyDown(event, this)">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required oninput="moveFocus(this)" onkeydown="handleKeyDown(event, this)">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required oninput="moveFocus(this)" onkeydown="handleKeyDown(event, this)">
                            <input type="text" maxlength="1" class="form-control otp-input" name="otp[]" required oninput="moveFocus(this)" onkeydown="handleKeyDown(event, this)">
                        </div>

                        <!-- Verify OTP Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-3">Verify OTP</button>
                    </form>

                    <!-- Resend OTP Button -->
                    <form action="{{ route('resend.otp') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link">Resend OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function moveFocus(current) {
            if (current.value.length >= 1) {
                const nextInput = current.nextElementSibling;
                if (nextInput) {
                    nextInput.focus();
                }
            }
        }

        function handleKeyDown(event, current) {
            if (event.key === 'Backspace' && current.value.length === 0) {
                const previousInput = current.previousElementSibling;
                if (previousInput) {
                    previousInput.focus();
                }
            }
        }
    </script>
</body>

</html>
