@extends('headerFooter.HeaderDash')
@section('content')

<head>
    <title>Pawsome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .hero-section {
            background-color: #f7f2e9;
            padding: 50px 20px;
            text-align: center;
        }

        .hero-image {
            width: 100%; /* Ensure the image takes full width of the container */
            height: auto; /* Maintain aspect ratio */
            max-width: 600px; /* Increased maximum width for larger screens */
            border-radius: 10px;
        }
 
        h2 {
            font-size: 3rem; /* Increase font size */
            font-weight: bold; /* Make the text bold */
            color: #4CAF50; 
            margin: 20px 0; /* Add margin for spacing */
            text-transform: uppercase; /* Make the text uppercase */
            letter-spacing: 1px; /* Add space between letters */
            text-align: left; /* Ensure text is aligned to the left */
        }
        
        h3 {
            font-size: 2rem; /* Increase font size */
            font-weight: bold; /* Make the text bold */
            color: #4CAF50; 
            margin: 20px 0; /* Add margin for spacing */
            text-transform: uppercase; /* Make the text uppercase */
            letter-spacing: 1px; /* Add space between letters */
            text-align: center; /* Ensure text is aligned to the left */
        }
        
        #main {
            text-align: left; /* Ensure text is aligned to the left */
        }

        /* Optional: Different styles for each h2 element */
        .hero-heading {
            font-size: 2.5rem; /* Larger size for the first heading */
            color: #5a5a5a; /* Slightly lighter color */
        }

        .sub-heading {
            font-size: 2rem; /* Regular size for the second heading */
            color: #777; /* Medium gray color */
            font-style: italic; /* Make it italic for differentiation */
        }

        .gallery-section {
            padding: 100px 10px; /* Reduced padding for the gallery section */
        }

        .gallery-link {
            position: relative; /* Set positioning for the title */
            display: block; /* Allow the title to take up the full width */
            overflow: hidden; /* Hide overflow to avoid title showing out of bounds */
        }

        .gallery-image {
            border-radius: 8px; /* Add rounded corners */
            height: 300px; /* Set a fixed height for the images */
            width: 100%; /* Make images responsive to the column width */
            object-fit: cover; /* Ensure images cover the area well */
            margin-bottom: 15px; /* Add some space below each image */
            transition: transform 0.3s, filter 0.3s; /* Add a transition for hover effect */
        }

        .gallery-link:hover .gallery-image {
            transform: scale(1.05); /* Slightly enlarge the image on hover */
            filter: brightness(0.7); /* Darken the image on hover */
        }

        .gallery-title {
            position: absolute; /* Position title absolutely */
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Adjust for the element's size */
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
            color: #fff; /* White text color */
            padding: 10px; /* Padding around the title */
            border-radius: 5px; /* Rounded corners for the title */
            opacity: 0; /* Initially hide the title */
            transition: opacity 0.3s; /* Transition for opacity */
            font-size: 1.5rem; /* Increase font size for the title */
            text-align: center; /* Center text within the title */
        }

        .gallery-link:hover .gallery-title {
            opacity: 1; /* Show title on hover */
        }

        /* Flexbox for the row */
        .row {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping of items */
        }

        .col-md-4, .col-md-6, .col-md-8 {
            padding: 5px; /* Add some padding to columns for spacing */
        }

        .cta-section {
            background-color: #fde8cd;
            padding: 50px 20px;
            text-align: center;
        }

        .cta-image {
            max-width: 150px;
            height: auto; /* Maintain aspect ratio */
        }

        /* Campaigns section */
        .campaign-section {
            padding: 50px 10px; /* Add padding for the campaigns section */
           
        }
        .campaign-title {
            text-align: center;
            margin-bottom: 30px;
            color: #4CAF50; /* Earthy green color for the title */
        }

        .campaign {
            background-color: #ffffff; /* White background for campaigns */
            border: 2px solid #a5d6a7; /* Light green border */
            border-radius: 15px; /* Rounded corners */
            padding: 20px; /* Padding inside the campaign box */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effects */
            text-align: center; /* Center-align text */
            height: 300px; /* Fixed height for the card */
            display: flex; /* Enable flexbox for card layout */
            flex-direction: column; /* Stack children vertically */
            justify-content: space-between; /* Distribute space evenly */
        }
        .campaign:hover {
            transform: scale(1.05); /* Slightly scale up on hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Shadow effect on hover */
        }

        .campaign h4 {
            color: #3E3E3E; /* Dark gray for campaign titles */
        }

        .campaign p {
            color: #5A5A5A; /* Dark gray for campaign descriptions */
            text-align: left;
        }
            .campaign img {
            width: 100%; /* Make the image responsive */
            height: 150px; /* Fixed height for images */
            object-fit: cover; /* Ensure the image covers the space without distortion */
            border-radius: 10px; /* Rounded corners for the image */
            margin-bottom: 15px; /* Space below the image */
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 hero-section d-flex flex-column align-items-center">
                <div class="d-flex flex-column flex-md-row align-items-center">
                    <img src="{{ asset('img/dogandcat.png') }}" alt="Dog and Owner" class="hero-image mb-4 mb-md-0 me-md-4">
                    <div>
                        <h2>
                            <i class="fas fa-paw"></i> Pawsome and Furfect Match:
                        </h2>
                        <h2>Connecting Hearts, One Adoption at a Time!</h2>
                        <p id = 'main' >Many people are choosing to adopt pets from shelters or rescue organizations due to the numerous benefits, such as saving animals' lives, reducing overpopulation in shelters, and providing loving homes for animals in need.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="gallery-section container">
        <div class="row gy-4">
            <div class="col-12 col-md-4">
                <a href="/allrecommended" class="gallery-link">
                    <img src="\img\dogs.jpg" alt="Dogs" class="img-fluid gallery-image">
                    <div class="gallery-title">Our Pets</div>
                </a>
            </div>
            <div class="col-12 col-md-8">
                <a href="#" class="gallery-link">
                    <img src="\img\staticdog.png" alt="Dog with bandana" class="img-fluid gallery-image">
                    <div class="gallery-title">Discussion Board</div>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="#" class="gallery-link">
                    <img src="\img\staticqr.png" alt="Apply For Qr Tracking" class="img-fluid gallery-image">
                    <div class="gallery-title">Apply For Qr Tracking</div>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="#" class="gallery-link">
                    <img src="\img\cat.jpg" alt="Volunteer" class="img-fluid gallery-image">
                    <div class="gallery-title">Volunteer</div>
                </a>
            </div>
        </div>
    </div>

    <!-- Campaigns Section -->
    <div class="campaign-section container">
    <h3 class="campaign-title">Our Campaigns</h3>
    <div class="row" id="campaigns-row">
        <!-- Campaigns will be populated here -->
    </div>
</div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Want to know more?</h3>
                    <a href="#" class="btn btn-warning btn-lg mt-3">Visit About Us</a>
                    <div class="mt-4">
                    <img src="\img\logo.png"  alt="Happy Dog" class="cta-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('fetch.data') }}',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const campaignsRow = $('#campaigns-row');
                campaignsRow.empty(); // Clear previous content

                data.forEach(campaign => {
                    // Append new campaign content dynamically
                    campaignsRow.append(`
                        <div class="col-12 col-md-4">
                            <div class="campaign">
                              <img src="{{ asset('storage/${campaign.img}') }}" alt="${campaign.title}"> <!-- Image from database -->
                                <h4>${campaign.title}</h4>
                  
                            </div>
                        </div>
                    `);
                });
            },
            error: function() {
                console.error('Error fetching campaigns');
                $('#campaigns-row').append('<p>Failed to load campaigns. Please try again later.</p>');
            }
        });
    });
</script>
@endsection
