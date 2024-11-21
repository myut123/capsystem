@extends('headerFooter.HeaderDash')
@section('content')
<head>

<title>Pet Details</title>

<style>
    body{
        background-color: white;
    }
        .pet-container {
            margin-top: 0;              /* Remove the top margin */
            margin-bottom: 50px;        /* Maintain bottom margin */
            padding: 30px;              /* Padding for the container */
            width: 100%;          /* Ensures the container takes the full width of the screen */
            max-width: 100vw;      /* Ensures it fills the entire viewport width */
            padding-left: 0;       /* Adjust padding for a fully wide container */
            padding-right: 0;
            background-color: #eaf5ea;
        }

        /* Optional media query to add more padding for smaller screens */
        @media (max-width: 768px) {
            .pet-container {
                padding-left: 15px;   /* Add some padding on small screens */
                padding-right: 15px;
            }
        }

        .pet-image {
            width: 100%;               /* Makes sure the image takes up the full width of its container */
            max-width: 450px;           /* Sets a maximum width for larger screens */
            height: 300px;              /* Sets a fixed height */
            object-fit: cover;          /* Ensures the image scales properly to fill its dimensions without warping */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .pet-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .pet-description {
            margin-top: 20px;
            font-size: 18px;
            line-height: 1.6;
            color: #555;
        }

        .traits-list {
            list-style: none;
            padding-left: 0;
            margin-top: 20px;
        }

        .traits-list h2 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        hr {
            border: 0.5px solid #ccc;
            margin: 10px 0;
        }
        .pet-header {
            background-color: #f7f2e9;
            width: 100%;
            padding: 20px 0;            /* Padding for top and bottom */
            text-align: center;          /* Center the text */
            border-radius: 10px 10px 0 0; /* Rounded corners on top only */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
            margin-bottom: -5px;        /* Adjust margin to overlap with the pet container */
        }
        .analytics-chart {
        max-width: 600px; /* Set a maximum width */
        margin: 0 auto;   /* Center the chart */
        }

        #myRadarChart {
            width: 100%;      /* Make the canvas responsive */
            height: auto;     /* Maintain aspect ratio */
        }
        .pet-img {
            height: 200px; /* Set a fixed height for the images */
            object-fit: cover; /* Ensure the images fill the space without distortion */
            width: 100%; /* Make sure the image takes the full width of the card */
        }
    </style>


<!-- Pet Details Header Section -->
<div class="pet-header">
    <h1>Pet Details</h1>
</div>

<!-- Pet Section -->
<div class="container pet-container">
    <div class="row">
        <!-- Pet Image Section -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="{{ asset('storage/' . $pets[0]->img) }}" class="pet-image">
        </div>

        <!-- Pet Information Section -->
        <div class="col-md-6">
            @if(!$pets->isEmpty())
                <h1 class="pet-title">{{ $pets[0]->name }}</h1>


                <!-- Hidden Input for Pet ID -->
                <input type="hidden" id="petId" value="{{ $pets[0]->idpet }}">

                <!-- Pet Options -->
                <div class="pet-options mt-4">
                    <div class="mt-4">
                        <ul class="traits-list">
                            @foreach($pets as $pet)
                                <h2>
                                    <strong>{{ $pet->category_name }}:</strong> {{ $pet->choice}}
                                    <hr>
                                </h2>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Button to view more details or take an action -->
                <div class="mt-4">
                    <button id="viewMoreButton" class="btn btn-primary">Adopt Pet</button>
                </div>
            @else
                <p>No information available for this pet.</p>
            @endif
        </div>
    </div>
</div>

<hr>

<div class="analytics-chart">
    <h1>Compatibility Overview</h1>
    <canvas id="myRadarChart" width="600" height="400"></canvas> <!-- Specify size here -->
</div>

<hr>

<div class="related-products mt-5">
    @if(!$similarPets->isEmpty())
        <h1>Recommended Pets:</h1>
        <div class="row" id="pet-content-all">
            @foreach($similarPets as $similarPet)
                <div class="col-md-3">
                    <div class="card pet-card text-decoration-none" data-pet-id="{{ $similarPet->idpet }}" style="cursor: pointer;">
                        <img src="{{ asset('storage/' . $similarPet->pet_image) }}" class="card-img-top pet-img" alt="{{ $similarPet->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $similarPet->name }}</h5>
                            <p class="card-text">{{ $similarPet->description ?? 'No description available' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No similar pets found.</p>
    @endif
</div>



<script>

document.addEventListener('DOMContentLoaded', function () {
    const petId = document.getElementById('petId').value;
    // Fetch compatibility data from the backend
    fetch(`/compatibility/${petId}`) // Adjust the URL according to your route
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const ctx = document.getElementById('myRadarChart').getContext('2d');
            const myRadarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: Object.keys(data), // Use the keys from the compatibility data as labels
                    datasets: [{
                        label: 'Compatibility Score',
                        data: Object.values(data), // Use the values from the compatibility data
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scale: {
                        ticks: {
                            beginAtZero: true,
                            max: 100 // Set this based on your data range
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching compatibility data:', error);
        });
        document.querySelectorAll('.pet-card').forEach(card => {
        card.addEventListener('click', function() {
            const petId = this.getAttribute('data-pet-id'); // Get the pet ID from the data attribute
            window.location.href = `/pet/${petId}`; // Redirect to compatibility page
        });
    });
    document.getElementById('viewMoreButton').addEventListener('click', function() {
        const petId = document.getElementById('petId').value; // Get the pet ID
        window.location.href = `/adoption/apply/${petId}`; // Redirect to the details page
    });
});


</script>




@endsection 
