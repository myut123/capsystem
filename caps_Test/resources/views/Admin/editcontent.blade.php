@extends('headerFooter.adminDash')
@section('content')
<head>
    <title>Add Campaign</title>
</head>
<style>
    .custom-form-container {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 30px;
        padding-bottom: 40px; /* Added bottom padding */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 800px; /* Set a maximum width */
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px; /* Added margin-top for spacing above each form */
        margin-bottom: 30px; /* Added margin-bottom for spacing below each form */
        min-height: 400px; /* Ensure a minimum height for better layout */
    }
    .custom-form-container h2 {
        font-weight: bold;
        margin-bottom: 20px;
    }
    .short-input {
        max-width: 100%; /* Allow full width */
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="container mt-5">
@if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('message'))
                    <div class="alert alert-info">
                        {{ session('message') }}
                    </div>
                @endif

    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Left column for Upload Form -->
            <div class="custom-form-container">
                <h2 class="text-center">Upload Campaign</h2>

              
                <form action="{{ route('store.campaign') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="mb-3 short-input">
                        <label for="title" class="form-label">Campaign Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter campaign title" required>
                        <div class="invalid-feedback">
                            Please provide a campaign title.
                        </div>
                    </div>

                    <div class="mb-3 short-input">
                        <label for="description" class="form-label">Campaign Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter a brief description" required></textarea>
                        <div class="invalid-feedback">
                            Please provide a campaign description.
                        </div>
                    </div>

                    <div class="mb-3 short-input">
                        <label for="content" class="form-label">Campaign Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Enter the campaign content" required></textarea>
                        <div class="invalid-feedback">
                            Please provide the campaign content.
                        </div>
                    </div>

                    <div class="mb-3 short-input">
                        <label for="image" class="form-label">Upload Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                        <div class="invalid-feedback">
                            Please upload an image.
                        </div>
                    </div>

                    <div class="short-input">
                        <button type="submit" class="btn btn-primary w-100">Submit Campaign</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6"> <!-- Right column for Update Form -->
            <div class="custom-form-container">
                <h2 class="text-center">Update Campaign</h2>
                
                <!-- Search Input for Campaign Titles -->
                <div class="mb-3">
                    <label for="search_campaign" class="form-label">Search Campaign Title</label>
                    <input type="text" class="form-control" id="search_campaign" placeholder="Search campaign titles" onkeyup="searchCampaign()">
                </div>

                <div id="campaignList" class="mb-3">
                    <!-- List of campaigns to search through -->
                    <ul id="campaignTitles">
                        <!-- Campaign titles will be populated here -->
                    </ul>
                </div>

                <form action="{{ route('update.campaign') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3 short-input">
                        <label for="update_title" class="form-label">Campaign Title</label>
                        <input type="text" class="form-control" id="update_title" name="title" placeholder="Enter campaign title" required>
                        <input type="hidden" name="campaign_id" id="campaign_id" value="">
                        <div class="invalid-feedback">
                            Please provide a campaign title.
                        </div>
                    </div>

                    <div class="mb-3 short-input">
                        <label for="update_description" class="form-label">Campaign Description</label>
                        <textarea class="form-control" id="update_description" name="description" rows="3" placeholder="Enter a brief description" required></textarea>
                        <div class="invalid-feedback">
                            Please provide a campaign description.
                        </div>
                    </div>

                    <div class="mb-3 short-input">
                        <label for="update_content" class="form-label">Campaign Content</label>
                        <textarea class="form-control" id="update_content" name="content" rows="5" placeholder="Enter the campaign content" required></textarea>
                        <div class="invalid-feedback">
                            Please provide the campaign content.
                        </div>
                    </div>

                    <div class="mb-3 short-input">
                        <label for="update_image" class="form-label">Upload New Image (optional)</label>
                        <input class="form-control" type="file" id="update_image" name="image" accept="image/*">
                        <div class="invalid-feedback">
                            Please upload an image.
                        </div>
                    </div>

                    <div class="short-input">
                        <button type="submit" class="btn btn-warning w-100">Update Campaign</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!-- Bootstrap 5 JS and Popper.js for validation -->


<script>
    function searchCampaign() {
    const searchInput = document.getElementById('search_campaign').value.toLowerCase();
    const campaignTitles = document.getElementById('campaignTitles');

    // Clear previous search results
    campaignTitles.innerHTML = '';

    // AJAX request to fetch campaigns based on the search input
    fetch(`/search-campaigns?title=${searchInput}`) // Make sure the URL matches your defined route
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Check if data is not empty
            if (data.length === 0) {
                const li = document.createElement('li');
                li.textContent = 'No campaigns found';
                campaignTitles.appendChild(li);
                return;
            }

            data.forEach(campaign => {
                const li = document.createElement('li');
                li.textContent = campaign.title;
                li.setAttribute('data-id', campaign.id);
                li.onclick = function() {
                    document.getElementById('update_title').value = campaign.title; 
                    document.getElementById('campaign_id').value = campaign.id; 
                    document.getElementById('update_description').value = campaign.description; 
                    document.getElementById('update_content').value = campaign.content; 
                    campaignTitles.innerHTML = ''; // Clear list after selection
                };
                campaignTitles.appendChild(li);
            });
        })
        .catch(error => {
            console.error('Error fetching campaigns:', error);
        });
}
    (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
