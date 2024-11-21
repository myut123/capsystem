@extends('headerFooter.map')
@section('content')
<!DOCTYPE html>
<html lang = "en">

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
        <!-- Scripts -->
        <style>
        #map {
            height: 500px;
            width: auto;
        }

        #locationInfo {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #personInfo {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <title>All Dogs</title>
    </head>
    <body>
    <div class="container-fluid vh-100" style="background-color:#D4F1F4;">
    <div class="row h-100">
        <div class="col-md-4 d-flex flex-column justify-content-center pt-4">
            <div class="row text-center">
                <h1>CURRENT PET LOCATION</h1>
            </div>
            <div class="row d-flex justify-content-center m-2">
                <div id="locationInfo"></div>
            </div>
            <br>
            <div class="row d-flex justify-content-center m-2">
                <div id="personInfo"></div>
            </div>
        </div>
        <div class="col-md-8 d-flex align-items-center justify-content-center">
            <div id="map" class="w-100 h-100"></div>
        </div>
    </div>
</div>


    <script>
        // Parse the URL to extract parameters
        const urlParams = new URLSearchParams(window.location.search);
const idadop = urlParams.get('Id');  // Extracting parameters

if (idadop) {
    axios.get(`/api/adoption_application/${idadop}`)
        .then(response => {
            const userData = response.data;

            // Update the HTML to display user information
            document.getElementById('personInfo').innerHTML = `
                <h2>User Information</h2>
                <p><strong>Name:</strong> ${userData.first_name}</p>
                <p><strong>Pet:</strong> ${userData.name}</p>
                <p><strong>Email:</strong> ${userData.email}</p>
            `;

            // Initialize Leaflet map with default coordinates
            var map = L.map('map').setView([0, 0], 13);

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Get user's current location
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        // Set map view to user's current location with higher zoom level for better accuracy
                        map.setView([latitude, longitude], 16);

                        // Add marker to user's current location
                        L.marker([latitude, longitude]).addTo(map)
                            .bindPopup('Your Location')
                            .openPopup();

                        // Fetch location information (address) using OpenStreetMap's reverse geocoding API
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('locationInfo').innerHTML = 'Current Location: ' + data.display_name;

                                // Save the location to the database
                                saveLocation(userData.id, latitude, longitude);
                            })
                            .catch(error => {
                                console.error('Error fetching location information:', error);
                            });
                    }, 
                    function(error) {
                        console.error('Error occurred. Error code: ' + error.code);
                    },
                    {
                        enableHighAccuracy: true,  // Requests more accurate location data
                        timeout: 10000,            // Timeout after 10 seconds
                        maximumAge: 0              // Forces a fresh location request
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser');
            }
        })
        .catch(error => {
            console.error('Error fetching user information:', error);
        });
}

// Function to save the location in the database
function saveLocation(userId, latitude, longitude) {
    axios.post('/map/save', {
        user_id: userId,  // Assuming userData.id contains the user ID
        latitude: latitude,
        longitude: longitude
    })
    .then(response => {
        console.log(response.data.message); // Handle success message
        sendLocationEmail(userId); // Send the location email after saving
    })
    .catch(error => {
        console.error('Error saving location:', error); // Handle error
    });
}

// Function to send the location email
function sendLocationEmail(userId) {
    axios.post('/send-location-email', {
        user_id: userId  // Pass the user ID to the backend
    })
    .then(response => {
        console.log(response.data.message); // Handle success message for email
    })
    .catch(error => {
        console.error('Error sending location email:', error); // Handle error for email
    });
}

    </script>
</body>


</script>





@endsection 
