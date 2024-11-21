@extends('headerFooter.HeaderDash')
@section('content')

<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Pet List</title>
    <style>
        /* Ensure the carousel takes full width */
        #campaignCarousel {
            width: 100%;
        }

        .carousel-item {
            height: 40vh; /* Adjust height to make it shorter */
            position: relative;
        }

        .carousel-item img {
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            object-fit: cover; /* Cover the entire container */
        }

        .carousel-caption {
            top: 50%;
            bottom: auto;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent dark background */
            padding: 20px; /* Add some padding around the text */
            border-radius: 10px; /* Rounded corners */
        }

        .carousel-caption h5, 
        .carousel-caption p {
            color: white; /* Ensure the text is readable */
        }
        /* Custom styles for pet cards */
        .pet-card {
            width: 250px; /* Set a fixed width for the card */
            border: 1px solid #ccc; /* Border for the card */
            border-radius: 8px; /* Rounded corners */
            padding: 16px; /* Padding inside the card */
            margin: 10px auto; /* Center the card and add margin around it */
            text-align: center; /* Center-align text */
            background-color: #f9f9f9; /* Light background color */
            transition: transform 0.2s; /* Animation effect on hover */
        }

        .pet-card:hover {
            transform: scale(1.05); /* Scale effect on hover */
        }

        .pet-card img {
            width: 100%; /* Make the image responsive */
            height: 200px; /* Fixed height for uniformity */
            object-fit: cover; /* Cover the area without stretching */
            object-position: center; /* Center the image in the card */
        }
        .card {
    height: 100%; /* Make the card take the full height of the column */
    display: flex; /* Use flex to control the layout of the card contents */
    flex-direction: column; /* Arrange contents vertically */
    justify-content: space-between; /* Ensure the content is evenly distributed */
}

.card-img-top {
    width: 100%; /* Make the image fill the width */
    height: 200px; /* Set a fixed height for all images */
    object-fit: cover; /* Ensure the image doesn't stretch and fills the container */
}

.card-body {
    flex-grow: 1; /* Allow the body to take up remaining space */
    padding: 10px;
}


        .card:hover {
            transform: scale(1.02); /* Optional: Slightly scale on hover */
        }
        @media (max-width: 768px) {
            .pet-card img {
                height: 150px; /* Smaller height for mobile */
            }
        }

        @media (min-width: 769px) {
            .pet-card img {
                height: 200px; /* Standard height for larger screens */
            }
        }
        .carousel-item img {
        max-height: 400px; /* Control the height of images */
        object-fit: cover; /* Ensure images cover the area without distortion */
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5); /* Optional: add a background for better readability */
    }
    #pagination-container {
        margin-top: 30px; /* Adjust the value as needed */
    }
   /* Initially hide the sidebar on small screens */
#sidebar {
    transition: all 0.3s ease;
}

.sidebar-content {
    display: block; /* Display sidebar content */
}

#sidebar.collapsed {
    width: 0; /* Make sidebar disappear */
    overflow: hidden;
}

#sidebar.collapsed .sidebar-content {
    display: none; /* Hide the sidebar content */
}

#sidebarToggleBtn {
    position: absolute;
    top: 10px;
    left: 10px;
}

.category-link {
    color: green; /* Green font color */
}

.category-link:hover {
    color: darkgreen; /* Darker green on hover */
}


    </style>
</head>
<!-- Full-width container for carousel -->
<div class="p-0">
    <div id="campaignCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner" id="campaigns-row">
            <!-- Dynamic campaign items will be injected here -->
        </div>
    </div>
</div>

<!-- Tab navigation for categories -->
<ul class="nav nav-tabs justify-content-center my-4" id="categoryTabs" role="tablist">
    <!-- Recommended Tab First -->
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="tab-recommended" data-bs-toggle="tab" href="#tab-recommended-content" role="tab" aria-controls="tab-recommended" aria-selected="true" data-category-id="recommended">
            Recommended for You
        </a>
    </li>

    <!-- All Pets Tab Second -->
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab-all" data-bs-toggle="tab" href="#tab-all-content" role="tab" aria-controls="tab-all" aria-selected="false" data-category-id="all">
            All Pets
        </a>
    </li>
</ul>

<!-- Tab content for All Pets and Recommended tabs -->
<div class="tab-content" id="myTabContent">
    <!-- Content for Recommended tab -->
    <div class="tab-pane fade show active" id="tab-recommended-content" role="tabpanel" aria-labelledby="tab-recommended">
        <div class="row">
            <!-- No Sidebar in Recommended tab -->
            <div class="col-12">

    <div class="row" id="recommendations-container">
        <!-- Recommended pets will be dynamically appended here -->
    </div>
    <div id="recommendation-pagination" class="mt-3 text-center">
        <!-- Pagination buttons will be dynamically appended here -->
    </div>


                <!-- Pagination for recommended pets -->
                <div id="pagination-container-recommended" class="mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="pagination-recommended">
                            <!-- Pagination buttons dynamically inserted here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Content for All Pets tab -->
    <div class="tab-pane fade" id="tab-all-content" role="tabpanel" aria-labelledby="tab-all">
        <div class="row">
            <!-- Left Sidebar Column (Smaller) -->
            <div class="col-lg-2 col-md-3 col-sm-12" id="sidebar">
                <!-- Button to toggle the sidebar on small screens -->
                <button class="btn btn-outline-success d-md-none" id="sidebarToggleBtn">
                    <i class="bi bi-list"></i> <!-- Icon for the button -->
                </button>

                <!-- Sidebar content -->
                <div class="sidebar-content">
                    <h4>Categories</h4>
                    <ul class="list-group list-group-flush">
                        <!-- You can dynamically populate categories here -->
                        <li class="list-group-item border-0">
                            <a href="#" class="category-filter-link" data-category-id="all">All Pets</a>
                        </li>
                    </ul>
                </div>

                <div id="category-content" class="mt-4">
                    <!-- Dynamic category content will be injected here -->
                </div>

            </div>

            <!-- Right Column with Pets Content -->
            <div class="col-lg-10 col-md-9 col-sm-12">
                <div id="pet-content-all">
                    <!-- Dynamic pet content for All Pets will be injected here -->
                </div>

                <!-- Pagination -->
                <div id="pagination-container" class="mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="pagination">
                            <!-- Pagination buttons dynamically inserted here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar Toggle Button -->
<button id="sidebar-toggle" class="btn btn-primary d-block w-100 d-md-none">☰ Open Sidebar</button>



<script>
$(document).ready(function () {
    // Fetch campaigns data for carousel
    $.ajax({
        url: '{{ route('fetch.data') }}',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            const campaignsRow = $('#campaigns-row');
            campaignsRow.empty(); // Clear previous content

            data.forEach((campaign, index) => {
                const activeClass = index === 0 ? 'active' : '';
                campaignsRow.append(`
                    <div class="carousel-item ${activeClass}">
                        <img src="{{ asset('storage/${campaign.img}') }}" alt="${campaign.title}" class="d-block w-100">
                        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center">
                            <h5>${campaign.title}</h5>
                            <p>${campaign.description}</p>
                        </div>
                    </div>
                `);
            });
        },
        error: function () {
            console.error('Error fetching campaigns');
            $('#campaigns-row').append('<p>Failed to load campaigns. Please try again later.</p>');
        }
    });

    // Handle category tab clicks
    $('#categoryTabs a[data-category-id]').on('click', function (e) {
        e.preventDefault();

        const categoryId = $(this).data('category-id');
        const tabContentId = $(this).attr('href');

        // Check if this tab has been loaded before
        if (!$(tabContentId).hasClass('loaded')) {
            const url = categoryId === 'all' ? '/pets/all' : '/category/' + categoryId + '/pets';

            if (categoryId === 'recommended') {
                fetchRecommendations(); // Call this to load recommended pets directly
            } else if (categoryId === 'all') {
                loadPets(); // Ensure pagination is displayed for "All Pets"
            } else {
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        const contentContainer = $('#pet-content-' + categoryId);
                        contentContainer.empty(); // Clear previous content

                        if (response.success === false) {
                            contentContainer.append('<p>' + response.message + '</p>');
                        } else if (response.petDetails && response.petDetails.length > 0) {
                            let row = $('<div class="row">');
                            response.petDetails.forEach((pet, index) => {
                                row.append(`
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <div class="card pet-card clickable-card" data-pet-id="${pet.idpet}" style="cursor: pointer;">
                                            <img src="/storage/${pet.img}" class="card-img-top" alt="${pet.name}">
                                            <div class="card-body">
                                                <h5 class="card-title">${pet.name}</h5>
                                                <p class="card-text">${pet.description || 'No description available'}</p>
                                            </div>
                                        </div>
                                    </div>
                                `);

                                if ((index + 1) % 3 === 0) {
                                    contentContainer.append(row);
                                    row = $('<div class="row">');
                                }
                            });

                            contentContainer.append(row);
                        } else {
                            contentContainer.append('<p>No pets available for this category.</p>');
                        }
                    },
                    error: function () {
                        const contentContainer = $('#pet-content-' + categoryId);
                        contentContainer.empty();
                        contentContainer.append('<p>Failed to load pets. Please try again later.</p>');
                    }
                });
            }
        }
    });

    // Load pets for "All" category
    function loadPets(page = 1) {
        $.ajax({
            url: '/pets/all',
            method: 'GET',
            dataType: 'json',
            data: { page: page },
            success: function (response) {
                const allPetsContent = $('#pet-content-all');
                allPetsContent.empty();

                if (response.petDetails.length > 0) {
                    let row = $('<div class="row">');
                    response.petDetails.forEach((pet, index) => {
                        row.append(`
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                <div class="card pet-card clickable-card" data-pet-id="${pet.idpet}" style="cursor: pointer;">
                                    <img src="/storage/${pet.img}" class="card-img-top" alt="${pet.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${pet.name}</h5>
                                        <p class="card-text">${pet.description || 'No description'}</p>
                                    </div>
                                </div>
                            </div>
                        `);

                        if ((index + 1) % 3 === 0 || index === response.petDetails.length - 1) {
                            allPetsContent.append(row);
                            row = $('<div class="row">');
                        }
                    });

                    const pagination = $('#pagination');
                    pagination.empty();

                    // Render pagination for All Pets
                    for (let i = 1; i <= response.totalPages; i++) {
                        pagination.append(`
                            <button class="page-link" data-page="${i}">${i}</button>
                        `);
                    }
                } else {
                    allPetsContent.append('<p>No pets available.</p>');
                }
            },
            error: function () {
                const allPetsContent = $('#pet-content-all');
                allPetsContent.empty();
                allPetsContent.append('<p>Error fetching pets.</p>');
            }
        });
    }

    loadPets(); // Load pets on page load

    // Handle pagination clicks for All Pets
    $(document).on('click', '.page-link', function () {
        const page = $(this).data('page');
        loadPets(page); // Load pets for the clicked page
    });

    // Sidebar toggle
    $('#sidebarToggleBtn').on('click', function () {
        $('#sidebar').toggleClass('collapsed');
    });

    // Fetch recommendations (this will be called when the "Recommended for You" tab is clicked)
    function fetchRecommendations(page = 1) {
    $.ajax({
        url: '/recommend-pets', // Update with the actual route for your recommendPets function
        method: 'GET',
        data: { page: page },
        dataType: 'json',
        success: function (response) {
            console.log(response);  // Log the response to see what is returned

            const recommendationsContainer = $('#recommendations-container');
            recommendationsContainer.empty(); // Clear existing content

            // Check if pets array exists and has data
            if (response.pets && response.pets.length > 0) {
                // Loop through recommended pets and add them to the page
                response.pets.forEach(pet => {
                    recommendationsContainer.append(`
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                            <div class="card pet-card clickable-card" data-pet-id="${pet.pet_id}" style="cursor: pointer;">
                                <img src="/storage/${pet.image_url}" class="card-img-top" alt="${pet.pet_name}">
                                <div class="card-body">
                                    <h5 class="card-title">${pet.pet_name}</h5>
                                    <p class="card-text">Recommendation Score: ${pet.score.toFixed(2)}</p>
                                </div>
                            </div>
                        </div>
                    `);
                });

                // Pagination for recommendations
                const paginationContainer = $('#recommendation-pagination');
                paginationContainer.empty();
                for (let i = 1; i <= response.totalPages; i++) {
                    paginationContainer.append(`
                        <button class="btn btn-outline-primary pagination-btn" data-page="${i}">${i}</button>
                    `);
                }

                // Make the pet cards clickable
                makePetCardsClickable();
            } else {
                recommendationsContainer.append('<p>No recommendations available.</p>');
            }
        },
        error: function () {
            console.error('Error fetching recommendations.');
            $('#recommendations-container').html('<p>Failed to load recommendations. Please try again later.</p>');
        }
    });
}

// New function to handle the click event for pet cards
function makePetCardsClickable() {
    $('.clickable-card').on('click', function () {
        const petId = $(this).data('pet-id'); // Get pet ID from the data attribute
        if (petId) {
            window.location.href = `/pet/${petId}`; // Navigate to the pet details page
        } else {
            console.error('Pet ID not found on card.');
        }
    });
}

// Initial fetch of recommendations
fetchRecommendations();



// Handle click event on recommendation pet cards
$(document).on('click', '.clickable-card', function () {
    const petId = $(this).data('pet-id'); // Get pet ID from the clicked card
    console.log('Clicked Pet ID:', petId); // Debugging: log clicked pet ID

    if (petId) {
        window.location.href = `/pet/${petId}`; // Redirect to pet's detail page
    } else {
        console.error('Pet ID not found on card.');
    }
});

// Handle recommendation pagination click
$(document).on('click', '.pagination-btn', function () {
    const page = $(this).data('page');
    fetchRecommendations(page); // Fetch recommendations for the clicked page
});


});


</script>

@endsection

