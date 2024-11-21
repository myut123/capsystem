@extends('headerFooter.map')
@section('content')
<head>
<meta charset = "UTF-8">
        <meta http-equiv = "X-UA_Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/1d8d68cd8a.js" crossorigin="anonymous"></script>
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="crossorigin=""></script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <title>Location</title>
    <style>
        #map {
            height: 400px; /* Adjust height as needed */
            width: 100%;
        }
        #personInfo, #locationInfo {
            margin-bottom: 20px; /* Add some space between the info sections and the map */
            padding: 10px; /* Add padding for a cleaner look */
            border: 1px solid #ccc; /* Optional: Add a border for separation */
            background-color: #f9f9f9; /* Optional: Light background for visibility */
            width: 100%; /* Ensure it takes the full width */
            font-size: 16px; /* Adjust font size as needed */
        }
    </style>
</head>
    <body>

    <div class="container-fluid vh-100" style="background-color:#D4F1F4;">
        <div class="row h-100">
            <div class="col-md-4 d-flex flex-column justify-content-center pt-4">
                <div class="text-center mb-3" id="personInfo">
                    <h2>User Information</h2>
                    <p><strong>Name:</strong> {{ strtoupper($application->first_name . ' ' . $application->last_name) }}</p>
                    <p><strong>Email:</strong> {{ $application->email }}</p>
                </div>
                <div id="locationInfo" class="text-center"></div>
            </div>
            <div class="col-md-8 d-flex align-items-center justify-content-center">
                <div id="map" style="height: 500px;"></div> <!-- Added height to map for better visibility -->
            </div>
        </div>
    </div>

    <!-- Include Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize Leaflet map
        const map = L.map('map').setView([14.5995, 120.9842], 13); // Default view for Metro Manila

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Retrieve the latitude and longitude from the application data
        const savedLatitude = {{ $application->latitude }}; // Ensure this value is available in your application object
        const savedLongitude = {{ $application->longitude }}; // Ensure this value is available in your application object

        // Function to get the street name using reverse geocoding
        function getStreetName(latitude, longitude, callback) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        callback(data.display_name);
                    } else {
                        callback('Street name not found');
                    }
                })
                .catch(() => {
                    callback('Error fetching street name');
                });
        }

        // Function to display saved location on the map
        function displaySavedLocation(latitude, longitude) {
            // Set map view to user's saved location
            map.setView([latitude, longitude], 16);

            // Add marker to user's saved location
            getStreetName(latitude, longitude, (streetName) => {
                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup(`Saved Location: ${streetName}`)
                    .openPopup();

                // Display location information
                document.getElementById('locationInfo').innerHTML = 'Saved Location: ' + 
                    `${streetName} (${latitude}, ${longitude})`;
            });
        }

        // Check if saved location is available
        if (savedLatitude && savedLongitude) {
            displaySavedLocation(savedLatitude, savedLongitude);
        } else {
            document.getElementById('locationInfo').innerHTML = 'No saved location found.';
        }



        // Call the function to display current geolocation
        displayCurrentLocation();
    </script>

@endsection