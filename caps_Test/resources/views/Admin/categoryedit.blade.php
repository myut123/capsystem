@extends('headerFooter.adminDash')

@section('content')
<head>
    <title>Pet Categories DashBoard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include SweetAlert2 from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #deletedCategoryResults {
    border: 1px solid #ccc;
    padding: 10px;
    max-height: 200px;
    overflow-y: auto;
    display: block; /* Ensure it is visible */
}

.search-result-item {
    padding: 8px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}

.search-result-item:hover {
    background-color: #f0f0f0;
}

    /* Loading Screen */
    #loadingScreen {
        position: fixed; /* Fix position to cover the whole screen */
        top: 0; /* Align to top */
        left: 0; /* Align to left */
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
        display: flex; /* Use flexbox for centering */
        align-items: center; /* Center items vertically */
        justify-content: center; /* Center items horizontally */
        z-index: 1000; /* Ensure it is above other elements */
    }

    /* Spinner Animation */
    .spinner {
        border: 10px solid #f3f3f3; /* Light grey */
        border-top: 10px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 80px; /* Larger spinner */
        height: 80px; /* Larger spinner */
        animation: spin 1s linear infinite; /* Spin animation */
        margin-bottom: 20px; /* Space between spinner and text */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Container Styles */
    #selectionContainer,
    #update_selectionContainer {
        width: 100%; /* Ensure it takes full width */
        padding: 10px; /* Add some padding */
        border: 1px solid #ddd; /* Optional: to visualize the container */
        background-color: #f8f9fa; /* Optional: to differentiate it */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Optional: to give it some depth */
        margin-bottom: 20px; /* Space below the selection container */
    }

    /* Form Group Styles */
    .form-group {
        margin-bottom: 15px; /* Add space between form groups */
    }

    .form-group input,
    .form-group textarea {
        padding: 10px; /* Add padding inside input and textarea */
        border-radius: 5px; /* Rounded corners for inputs */
        border: 1px solid #ced4da; /* Input border color */
        width: 100%; /* Full width */
        box-sizing: border-box; /* Include padding in the total width */
    }

    /* Input Group Styles */
    .input-group {
        position: relative; /* Allow for absolute positioning of the button */
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Center items vertically */
    }

    /* Remove Button Styles */
    .remove-btn {
        position: absolute; /* Position the button absolutely */
        right: 10px; /* Position it to the right */
        top: 50%; /* Center it vertically */
        transform: translateY(-50%); /* Adjust for perfect centering */
        background: transparent; /* Make the button background transparent */
        border: none; /* Remove default button border */
        color: #dc3545; /* Set the color for the icon */
        cursor: pointer; /* Change cursor to pointer */
        z-index: 1; /* Ensure it sits on top of the input */
    }

    /* Button Styles */
    .btn {
        padding: 10px 20px; /* Add padding to buttons */
        margin-top: 10px; /* Space above buttons */
        border-radius: 5px; /* Rounded corners for buttons */
    }

    /* Search Results Styles */
    .search-results {
        border: 1px solid #ced4da;
        background: white;
        position: absolute;
        z-index: 1000;
        max-height: 200px; /* Limit height of dropdown */
        overflow-y: auto; /* Enable vertical scrolling */
        width: 100%;
        display: none; /* Initially hidden */
        border-radius: 5px; /* Rounded corners for dropdown */
    }

    .search-results div {
        padding: 8px; /* Add padding to results */
        cursor: pointer; /* Pointer cursor for items */
    }

    .search-results div:hover {
        background-color: #f8f9fa; /* Change background on hover */
    }

    /* Checkbox Styles */
    #keep_current_category,
    #keep_current_description {
        margin-right: 8px; /* Space between checkbox and label */
        transform: scale(1.2); /* Make checkbox slightly larger */
        width: auto; /* Prevent stretching */
        flex: 0 0 auto; /* Prevent growing */
    }

    /* Checkbox Label Styles */
    #keep_current_category + .form-check-label,
    #keep_current_description + .form-check-label {
        margin-left: 0; /* Remove margin if unnecessary */
    }

    /* Optional: General Flexbox Container for Checkboxes */
    .form-check {
        display: flex; /* Align items in a row */
        align-items: center; /* Center items vertically */
        margin-bottom: 10px; /* Space between checkboxes */
    }
    
</style>
</head>


    <div class="container">
        <div class="row mt-4">
            <!-- Analytics Chart -->
            <div class="col-md-12">
                <h2 class="text-center">Dashboard For Pet Preference</h2>
                <div class="chart-container border rounded p-3 bg-light">
                    <canvas id="petPreferenceChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Add Category and Delete Category Forms -->
            <div class="col-md-6">
                <!-- Add Category and Selections Form -->
                <div class="card">
                    <div class="card-body">
                        <h3>Add Category and Selections</h3>
                        <form id="addCategoryForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" id="category_name" name="category_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="category_description">Category Description</label>
                                <textarea id="category_description" name="category_description" class="form-control" rows="5" required></textarea>
                            </div>
                            <div id="selectionContainer">
                                <div class="form-group selection-group">
                                    <label for="selection_name_1">Selection Name</label>
                                    <div class="input-group">
                                        <input type="text" id="selection_name_1" name="selection_names[]" class="form-control" required>
                                        <button type="button" class="remove-btn" title="Remove Selection">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </div>
                                    <!-- New Field: Selection Choice -->
                                    <div class="form-group mt-2">
                                        <label for="selection_choice_1">Selection Choice</label>
                                        <input type="text" id="selection_choice_1" name="selection_choices[]" class="form-control" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="selection_image_1">Selection Image</label>
                                        <input type="file" id="selection_image_1" name="selection_images[]" class="form-control-file" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <button type="button" id="addSelectionBtn" class="btn btn-primary me-2">Add Another Selection</button>
                                <button type="submit" class="btn btn-success">Add Category and Selections</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Delete Category Form -->
                <div class="card">
                    <div class="card-body">
                        <h3>Delete Category</h3>
                        <form id="deleteCategoryForm">
                            @csrf
                            <div class="form-group">
                                <label for="category_search">Search Category</label>
                                <div class="position-relative">
                                    <input type="text" id="category_search" name="category_search" class="form-control" autocomplete="off" required>
                                    <input type="hidden" id="category_id" name="category_id">
                                    <div id="search-results" class="search-results"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger">Delete Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Update Category and Delete Selection Forms -->
            <div class="col-md-6">
                <!-- Update Category Form -->
                <div class="card">
                    <div class="card-body">
                        <h3>Update Category</h3>
                        <form id="updateCategoryForm">
                            @csrf
                            <div class="form-group">
                                <label for="update_category_search">Search Category</label>
                                <div class="position-relative">
                                    <input type="text" id="update_category_search" name="update_category_search" class="form-control" autocomplete="off" required>
                                    <input type="hidden" id="update_category_id" name="update_category_id">
                                    <div id="update_search_results" class="search-results"></div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="update_category_name">Category Name</label>
                                <input type="text" id="update_category_name" name="update_category_name" class="form-control">
                            </div>
                            <div class="form-group form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="keep_current_category" name="keep_current_category">
                                <label class="form-check-label" for="keep_current_category">Keep Current Category Name</label>
                            </div>
                            <div class="form-group mt-2">
                                <label for="update_category_description">Category Description</label>
                                <textarea id="update_category_description" name="update_category_description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="keep_current_description" name="keep_current_description">
                                <label class="form-check-label" for="keep_current_description">Keep Current Category Description</label>
                            </div>
                            <div id="update_selectionContainer">
                                <div class="form-group selection-group">
                                    <label for="update_selection_name_1">Selection Name</label>
                                    <div class="input-group">
                                        <input type="text" id="update_selection_name_1" name="update_selection_names[]" class="form-control" required>
                                        <button type="button" class="remove-btn" title="Remove Selection">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <button type="button" id="updateAddSelectionBtn" class="btn btn-primary me-2">Add Another Selection</button>
                                <button type="submit" class="btn btn-success">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Delete Selection Form -->
                <div class="card">
                    <div class="card-body">
                        <h3>Delete Selection</h3>
                        <form id="formDeleteSelection">
                            @csrf
                            <div class="form-group">
                                <label for="inputCategorySearch">Search Category</label>
                                <input type="text" id="inputCategorySearch" name="category_search" class="form-control" autocomplete="off" required>
                                <input type="hidden" id="hiddenCategoryId" name="category_id">
                                <div id="divSearchResults" class="search-results" style="display:none;"></div>
                                <div id="selection-display-container" class="mt-3"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
    <!-- Restore Category and Selection Form -->
    <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h3>Restore Category</h3>
            <form id="restoreCategoryForm">
                @csrf
                <!-- Category Search -->
                <div class="form-group">
                    <label for="deletedCategorySearch">Search Deleted Category</label>
                    <div class="position-relative">
                        <input type="text" id="deletedCategorySearch" name="restore_category_search" class="form-control" autocomplete="off" required>
                        <input type="hidden" id="restore_category_id" name="restore_category_id">
                        <div id="deletedCategoryResults" class="search-results" style="display: none;"></div> <!-- Initially hidden search results -->
                    </div>
                </div>

                <!-- Restore Button -->
                <button type="submit" class="btn btn-warning mt-2">Restore Category/Selection</button>
            </form>
        </div>
    </div>
</div>
        </div>


    </div>




    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch analytics data for chart
        fetch('{{ route('analytics.view') }}')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('petPreferenceChart').getContext('2d');
        const petPreferenceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['With Pet Preferences', 'Without Pet Preferences'],
                datasets: [{
                    label: 'User Count',
                    data: [data.usersWithPreferences, data.usersWithoutPreferences], // Corrected access to data
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)', // Color for with pets
                        'rgba(255, 99, 132, 0.2)'  // Color for without pets
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false, // Allow height to be set independently
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Pet Preference Analytics'
                    }
                }
            }
        });

        // Set a specific height for the chart container
        const chartContainer = document.querySelector('.chart-container');
        chartContainer.style.height = '300px'; // Set the desired height for the chart
    })
    .catch(error => {
        console.error('Error fetching analytics data:', error);
    });
        // Adding dynamic selection input fields
        let selectionCounter = 2; // Start with 2 since the 1st selection is already present
        document.getElementById('addSelectionBtn').addEventListener('click', function () {
            const selectionContainer = document.getElementById('selectionContainer');

            // Create a new div for the next selection input
            const newSelectionGroup = document.createElement('div');
            newSelectionGroup.classList.add('form-group', 'selection-group');

            // Create the label for the selection name
            const label = document.createElement('label');
            label.setAttribute('for', `selection_name_${selectionCounter}`);
            label.textContent = 'Selection Name';

            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group');

            // Create the input field for selection name
            const input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('id', `selection_name_${selectionCounter}`);
            input.setAttribute('name', 'selection_names[]');
            input.classList.add('form-control');
            input.required = true; // Mark it as required

            // Create the remove button
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('remove-btn');
            removeButton.title = 'Remove Selection';
            removeButton.innerHTML = '<i class="fas fa-minus-circle"></i>';

            // Create the label for the selection choice input
            const choiceLabel = document.createElement('label');
            choiceLabel.setAttribute('for', `selection_choice_${selectionCounter}`);
            choiceLabel.textContent = 'Selection Choice';

            // Create the input field for selection choice
            const choiceInput = document.createElement('input');
            choiceInput.setAttribute('type', 'text');
            choiceInput.setAttribute('id', `selection_choice_${selectionCounter}`);
            choiceInput.setAttribute('name', 'selection_choices[]'); // Use an array for selection choices
            choiceInput.classList.add('form-control');
            choiceInput.required = true; // Mark it as required

            // Create the label for the image input
            const imageLabel = document.createElement('label');
            imageLabel.setAttribute('for', `selection_image_${selectionCounter}`);
            imageLabel.textContent = 'Selection Image';

            // Create the image input field
            const imageInput = document.createElement('input');
            imageInput.setAttribute('type', 'file');
            imageInput.setAttribute('id', `selection_image_${selectionCounter}`);
            imageInput.setAttribute('name', 'selection_images[]'); // Array for image uploads
            imageInput.classList.add('form-control-file');
            imageInput.accept = 'image/*'; // Accept only image files

            // Append label and input to the new selection group
            inputGroup.appendChild(input);
            inputGroup.appendChild(removeButton);
            newSelectionGroup.appendChild(label);
            newSelectionGroup.appendChild(inputGroup);
            
            // Append choice label and input to the new selection group
            newSelectionGroup.appendChild(choiceLabel);
            newSelectionGroup.appendChild(choiceInput);

            // Append the image label and input to the new selection group
            newSelectionGroup.appendChild(imageLabel);
            newSelectionGroup.appendChild(imageInput);

            // Append the new selection group to the container
            selectionContainer.appendChild(newSelectionGroup);
            selectionCounter++;

            // Add event listener for the remove button
            removeButton.addEventListener('click', function () {
                selectionContainer.removeChild(newSelectionGroup);
            });
        });

        // Event delegation to handle removal of selections
        document.getElementById('selectionContainer').addEventListener('click', function (e) {
            if (e.target.closest('.remove-btn')) {
                const selectionGroup = e.target.closest('.selection-group');
                if (selectionGroup) {
                    selectionContainer.removeChild(selectionGroup);
                }
            }
        });

        // Handle Add Category and Selection Form Submission
        document.getElementById('addCategoryForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            // Collect dynamically added selections
            const selections = document.querySelectorAll('[name="selection_names[]"]');
            selections.forEach((selection, index) => {
                formData.append(`selections[${index}]`, selection.value);
            });

            // Collect dynamically added choices
            const choices = document.querySelectorAll('[name="selection_choices[]"]');
            choices.forEach((choice, index) => {
                formData.append(`choices[${index}]`, choice.value); // Append the choice value
            });

            // Collect dynamically added images
            const images = document.querySelectorAll('[name="selection_images[]"]');
            images.forEach((image, index) => {
                if (image.files.length > 0) {
                    formData.append(`images[${index}]`, image.files[0]); // Append the image file
                }
            });

            // Add the description to the FormData
            const description = document.getElementById('category_description').value;
            formData.append('category_description', description);

            addCategoryWithSelections(formData);
        });

        function addCategoryWithSelections(formData) {
        fetch('{{ route('add.category.with.selections') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Show SweetAlert on successful category and selection addition
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                timer: 3000,  // 3 seconds delay
                timerProgressBar: true,  // Optional: Show progress bar
                showConfirmButton: false // Optional: Hide confirm button
            });

            // Reload the page after the alert is shown
            setTimeout(function() {
                location.reload();
            }, 3000); // Match the timer duration (3 seconds)
        })
        .catch(error => {
            // Show SweetAlert on error
            Swal.fire({
                title: 'Error!',
                text: 'Failed to add category and selections. Please try again.',
                icon: 'error',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });

            console.error('Error adding category and selections:', error);
        });
    }



        // Handle Delete Category Form Submission
        document.getElementById('deleteCategoryForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route('delete.category') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Show SweetAlert on successful category deletion
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                timer: 3000,  // 3 seconds delay
                timerProgressBar: true,  // Optional: Show progress bar
                showConfirmButton: false // Optional: Hide confirm button
            });

            // Reload the page after the alert is shown
            setTimeout(function() {
                location.reload();
            }, 3000); // Match the timer duration (3 seconds)
        })
        .catch(error => {
            // Show SweetAlert on error
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while deleting the category. Please try again.',
                icon: 'error',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });

            console.error('Error deleting category:', error);
        });
    });

        // Implementing Search Functionality for Categories
        const categorySearchInput = document.getElementById('category_search');
        const searchResultsContainer = document.getElementById('search-results');

        categorySearchInput.addEventListener('input', function () {
            const searchTerm = this.value;

            // Clear previous search results
            searchResultsContainer.innerHTML = '';

            if (searchTerm) {
                // Show the results container
                searchResultsContainer.style.display = 'block';

                // Fetch matching categories from the server
                fetch(`{{ route('search.categories') }}?query=${encodeURIComponent(searchTerm)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        const categories = data.categories; // Access the categories from the response

                        if (categories.length > 0) {
                            categories.forEach(category => {
                                const resultDiv = document.createElement('div');
                                resultDiv.textContent = category.category_name; // Display the category name
                                resultDiv.setAttribute('data-id', category.idcategory_store); // Set the category ID in a data attribute

                                // Add a click event listener to each result
                                resultDiv.addEventListener('click', function (event) {
                                    event.preventDefault(); // Prevent default action (if it's a link)

                                    // Set the input value to the selected category name
                                    categorySearchInput.value = category.category_name;

                                    // Set the hidden category ID directly
                                    document.getElementById('category_id').value = category.idcategory_store; // Ensure this matches your data structure

                                    // Clear search results
                                    searchResultsContainer.innerHTML = '';
                                    searchResultsContainer.style.display = 'none'; // Hide search results
                                });

                                searchResultsContainer.appendChild(resultDiv);
                            });
                        } else {
                            searchResultsContainer.innerHTML = '<div>No categories found.</div>'; // Display no results message
                        }
                    })
                    .catch(error => console.error('Error searching categories:', error));
            } else {
                searchResultsContainer.style.display = 'none'; // Hide results if no search term
            }
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function (e) {
            if (!categorySearchInput.contains(e.target) && !searchResultsContainer.contains(e.target)) {
                searchResultsContainer.innerHTML = ''; // Clear search results
                searchResultsContainer.style.display = 'none'; // Hide search results
            }
        });

        // Update Category Functionality
        // Update Category Functionality
(function () {
    const categorySearchInput = document.getElementById('category_search');
    const searchResultsContainer = document.getElementById('search-results');
    const updateCategorySearchInput = document.getElementById('update_category_search');
    const updateSearchResultsContainer = document.getElementById('update_search_results');

    // Function to handle category searching
    function handleCategorySearch(inputElement, resultsContainer, categoryIdElement, fetchUrl, updateSelections) {
        inputElement.addEventListener('input', function () {
            const searchTerm = this.value;
            resultsContainer.innerHTML = '';

            if (searchTerm) {
                resultsContainer.style.display = 'block';

                fetch(`${fetchUrl}?query=${encodeURIComponent(searchTerm)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        const categories = data.categories;
                        if (Array.isArray(categories) && categories.length > 0) {
                            categories.forEach(category => {
                                const resultDiv = document.createElement('div');
                                resultDiv.textContent = category.category_name;
                                resultDiv.dataset.id = category.idcategory_store;
                                resultDiv.classList.add('search-result-item');

                                // Event listener for clicking a search result
                                resultDiv.addEventListener('click', function () {
                                    inputElement.value = category.category_name;
                                    categoryIdElement.value = category.idcategory_store;
                                    resultsContainer.innerHTML = '';
                                    resultsContainer.style.display = 'none';

                                    // Fetch and update selections if needed
                                    if (updateSelections) {
                                        fetch(`${updateSelections}?categoryId=${category.idcategory_store}`)
                                            .then(response => {
                                                if (!response.ok) throw new Error('Network response was not ok');
                                                return response.json();
                                            })
                                            .then(selections => {
                                                const selectionContainer = document.getElementById('update_selectionContainer');
                                                selectionContainer.innerHTML = '';
                                                selections.forEach(selection => {
                                                    const selectionDiv = document.createElement('div');
                                                    selectionDiv.classList.add('form-group');
                                                    selectionDiv.innerHTML = `
                                                        <label for="update_selection_name_${selection.idselection_store}">Selection Name</label>
                                                        <input type="hidden" id="update_selection_id_${selection.idselection_store}" name="update_selection_ids[]" value="${selection.idselection_store}">
                                                        <input type="text" id="update_selection_name_${selection.idselection_store}" name="update_selection_names[]" class="form-control" value="${selection.selection_name}" required>
                                                        <label for="update_selection_choice_${selection.idselection_store}">Selection Choice</label>
                                                        <input type="text" id="update_selection_choice_${selection.idselection_store}" name="update_selection_choices[]" class="form-control" value="${selection.selection_choice}" required>
                                                    `;
                                                    selectionContainer.appendChild(selectionDiv);
                                                });
                                            })
                                            .catch(error => console.error('Error fetching selections:', error));
                                    }
                                });

                                resultsContainer.appendChild(resultDiv);
                            });
                        } else {
                            resultsContainer.innerHTML = '<div>No categories found.</div>';
                        }
                    })
                    .catch(error => console.error('Error searching categories:', error));
            } else {
                resultsContainer.style.display = 'none';
            }
        });
    }

    // Initialize category search
    handleCategorySearch(categorySearchInput, searchResultsContainer, document.getElementById('category_id'), '{{ route("search.categories") }}');

    // Initialize update category search
    handleCategorySearch(updateCategorySearchInput, updateSearchResultsContainer, document.getElementById('update_category_id'), '{{ route("search.categories") }}', '{{ route("get.selections") }}');

    // Hide search results when clicking outside
    document.addEventListener('click', function (e) {
        if (!categorySearchInput.contains(e.target) && !searchResultsContainer.contains(e.target)) {
            searchResultsContainer.innerHTML = '';
            searchResultsContainer.style.display = 'none';
        }
        if (!updateCategorySearchInput.contains(e.target) && !updateSearchResultsContainer.contains(e.target)) {
            updateSearchResultsContainer.innerHTML = '';
            updateSearchResultsContainer.style.display = 'none';
        }
    });

    // Handle Update Category Form Submission
    document.getElementById('updateCategoryForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission
        const formData = new FormData(this); // Create FormData from the form

        // Check if the user wants to keep the current category name
        const keepCurrentCategory = document.getElementById('keep_current_category').checked;

        // If the user wants to keep the current name, remove the category name from the form data
        if (keepCurrentCategory) {
            formData.delete('update_category_name'); // Remove the category name
        } else {
            // Optionally, perform additional validation to ensure the category name is not empty
            const categoryName = document.getElementById('update_category_name').value.trim();
            if (!categoryName) {
                alert('Error: Category name is required when not keeping the current name.');
                return; // Stop form submission if category name is empty
            }
        }

        // Check if the user wants to keep the current description
        const keepCurrentDescription = document.getElementById('keep_current_description').checked;

        // If the user wants to keep the current description, remove the category description from the form data
        if (keepCurrentDescription) {
            formData.delete('update_category_description'); // Remove the description
        } else {
            // Optionally, perform additional validation to ensure the description is not empty
            const categoryDescription = document.getElementById('update_category_description').value.trim();
            if (!categoryDescription) {
                alert('Error: Category description is required when not keeping the current description.');
                return; // Stop form submission if description is empty
            }
        }

        // Collect dynamically added selections and their choices
        const selections = document.querySelectorAll('[name="update_selection_names[]"]');
        const selectionChoices = document.querySelectorAll('[name="update_selection_choices[]"]');
        const selectionIds = Array.from(document.querySelectorAll('[name="update_selection_ids[]"]')).map(input => input.value);

        // Clear existing IDs array to avoid duplicates
        formData.delete('update_selection_ids[]');

        selections.forEach((selection, index) => {
            const selectionId = selectionIds[index]; // Get the corresponding ID directly
            formData.append('update_selection_names[]', selection.value); // Append the name directly
            formData.append('update_selection_choices[]', selectionChoices[index].value); // Append the choice directly

            if (selectionId && selectionId !== 'null') {
                // Append existing selection ID for update
                formData.append('update_selection_ids[]', selectionId);
            } else {
                // Append an empty string for new selections
                formData.append('update_selection_ids[]', '');
            }
        });

        const categoryId = document.getElementById('update_category_id').value;
        if (!categoryId) {
            alert('Error: Category ID is missing');
            return; // Stop form submission if category ID is missing
        }

        // Append the category ID using the correct key for validation
        formData.append('update_selection_category', categoryId);

        // Call the function to handle the category update with selections
        updateCategoryWithSelections(formData);
    });

    // Example function for sending the form data (you can adjust the URL and method)
    function updateCategoryWithSelections(formData) {
        console.log('Form Data Before Sending:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        fetch('/update/category', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Success:', data);

            // Show SweetAlert on success
            Swal.fire({
                title: 'Success!',
                text: 'Selections updated successfully!',
                icon: 'success',
                timer: 3000,  // 3 seconds delay
                timerProgressBar: true,  // Optional: Show progress bar
                showConfirmButton: false // Optional: Hide confirm button
            });
        })
        .catch(error => {
            console.error('Error:', error);

            // Show SweetAlert on error
            Swal.fire({
                title: 'Error!',
                text: 'Error updating selection: ' + error.message,
                icon: 'error',
                timer: 3000,  // 3 seconds delay
                timerProgressBar: true,  // Optional: Show progress bar
                showConfirmButton: false // Optional: Hide confirm button
            });
        });
    }

    // Add another selection input
    document.getElementById('updateAddSelectionBtn').addEventListener('click', function () {
        const selectionContainer = document.getElementById('update_selectionContainer');
        const selectionCount = selectionContainer.children.length + 1;

        // Create a new div to hold the input and button
        const selectionGroup = document.createElement('div');
        selectionGroup.classList.add('form-group', 'selection-group');

        // Update the innerHTML to include the input and button in a single input group
        selectionGroup.innerHTML = `
            <label for="update_selection_name_${selectionCount}">Selection Name</label>
            <div class="input-group">
                <input type="text" id="update_selection_name_${selectionCount}" name="update_selection_names[]" class="form-control" required>
                <input type="text" id="update_selection_choice_${selectionCount}" name="update_selection_choices[]" class="form-control" placeholder="Selection Choice" required>
                <input type="hidden" id="update_selection_id_${selectionCount}" name="update_selection_ids[]" value=""> <!-- Empty for new selections -->
                <button type="button" class="btn btn-danger remove-selection-btn">Remove</button>
            </div>
        `;
        selectionContainer.appendChild(selectionGroup);

        // Add an event listener for the remove button
        selectionGroup.querySelector('.remove-selection-btn').addEventListener('click', function () {
            selectionGroup.remove();
        });
    });
})();

        (function () {
    const categorySearchInput = document.getElementById('inputCategorySearch');
    const searchResultsContainer = document.getElementById('divSearchResults');
    const selectionContainerInput = document.getElementById('inputSelectionContainer');
    const deleteSelectionForm = document.getElementById('formDeleteSelection');

    function handleCategorySearch() {
        categorySearchInput.addEventListener('input', function () {
            const searchTerm = this.value;
            searchResultsContainer.innerHTML = '';

            if (searchTerm) {
                searchResultsContainer.style.display = 'block';

                fetch(`{{ route('search.categories') }}?query=${encodeURIComponent(searchTerm)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        const categories = data.categories;

                        if (categories.length > 0) {
                            categories.forEach(category => {
                                const resultDiv = document.createElement('div');
                                resultDiv.textContent = category.category_name;
                                resultDiv.setAttribute('data-id', category.idcategory_store);

                                resultDiv.addEventListener('click', function () {
                                    categorySearchInput.value = category.category_name;
                                    document.getElementById('hiddenCategoryId').value = category.idcategory_store;
                                    searchResultsContainer.innerHTML = '';
                                    searchResultsContainer.style.display = 'none';

                                    // Fetch selections for the selected category
                                    fetchSelections(category.idcategory_store)
                                        .then(displaySelections) // Now passing a single selection
                                        .catch(error => console.error('Error fetching selections:', error));
                                });

                                searchResultsContainer.appendChild(resultDiv);
                            });
                        } else {
                            searchResultsContainer.innerHTML = '<div>No categories found.</div>';
                        }
                    })
                    .catch(error => console.error('Error searching categories:', error));
            } else {
                searchResultsContainer.style.display = 'none';
            }
        });
    }

    // Function to fetch selections for a given category
    function fetchSelections(categoryId) {
        console.log('Fetching selections for category ID:', categoryId);

        return fetch(`{{ route('get.selections') }}?categoryId=${categoryId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(selections => {
                console.log('Fetched selections:', selections);
                return selections; // Return all selections
            });
    }

    function displaySelections(selections, categoryId) {
        const displayContainer = document.getElementById('selection-display-container');
        displayContainer.innerHTML = '';

        const label = document.createElement('label');
        label.setAttribute('for', 'selection-display-container');
        label.textContent = 'Selection To Delete';
        displayContainer.appendChild(label);

        if (selections && selections.length > 0) {
            selections.forEach(selection => {
                console.log('Selection object:', selection); // Log each selection
                createSelectionItem(displayContainer, selection); // Pass the selection object
            });
        } else {
            const noSelectionMessage = document.createElement('div');
            noSelectionMessage.textContent = 'No selections available for this category.';
            displayContainer.appendChild(noSelectionMessage);
        }
    }

    function createSelectionItem(container, selection) {
        console.log('Creating selection item for:', selection); // Log the selection being created
        console.log('Selection ID:', selection.idselection_store); // Log the correct selection ID
        const selectionDiv = document.createElement('div');
        selectionDiv.className = 'selection-item mt-2';

        const selectionInput = document.createElement('input');
        selectionInput.type = 'text';
        selectionInput.value = selection.selection_name; // Ensure this is the correct field
        selectionInput.className = 'form-control d-inline';
        selectionInput.style.width = '80%';
        selectionInput.readOnly = true;

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger ml-2';
        deleteButton.textContent = 'Delete';

        deleteButton.addEventListener('click', function() {
            console.log('Delete button clicked for selection ID:', selection.idselection_store); // Log the correct ID
            deleteSelection(selection.idselection_store, selectionDiv);
        });

        selectionDiv.appendChild(selectionInput);
        selectionDiv.appendChild(deleteButton);
        container.appendChild(selectionDiv);
    }

    function deleteSelection(selectionId, selectionDiv) {
        console.log('Attempting to delete selection with ID:', selectionId); // Debug: log the selection ID

        // Prepare the data to be sent
        const formData = new FormData();
        formData.append('id', selectionId); // Append the selection ID
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); // CSRF token

        fetch('{{ route('delete.selection') }}', { // Ensure this matches the route
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message); // Handle the response message
            if (data.message === 'Selection deleted successfully.') {
                selectionDiv.remove(); // Remove the selection from the display

                // Show SweetAlert for success
                Swal.fire({
                    title: 'Success!',
                    text: 'Selection deleted successfully!',
                    icon: 'success',
                    timer: 3000,  // 3 seconds delay
                    timerProgressBar: true,  // Optional: Show progress bar
                    showConfirmButton: false // Optional: Hide confirm button
                }).then(() => {
                    location.reload(); // Reload the page after the alert
                });
            } else {
                // Show SweetAlert for error if deletion failed
                Swal.fire({
                    title: 'Error!',
                    text: 'Error: ' + data.message,
                    icon: 'error',
                    timer: 3000,  // 3 seconds delay
                    timerProgressBar: true,  // Optional: Show progress bar
                    showConfirmButton: false // Optional: Hide confirm button
                });
            }
        })
        .catch(error => {
            console.error('Error deleting selection:', error);

            // Show SweetAlert for network or unexpected errors
            Swal.fire({
                title: 'Error!',
                text: 'Error deleting selection: ' + error.message,
                icon: 'error',
                timer: 3000,  // 3 seconds delay
                timerProgressBar: true,  // Optional: Show progress bar
                showConfirmButton: false // Optional: Hide confirm button
            });
        });
    }
    handleCategorySearch();
})();
$(document).ready(function () {
    // Search for Deleted Categories
    $('#deletedCategorySearch').on('input', function () {
        const query = $(this).val();

        if (query.length > 2) { // Only search if query length is greater than 2
            searchDeletedCategories(query);
        } else {
            $('#deletedCategoryResults').empty().hide();  // Hide the results if input is cleared
        }
    });

    // Function to Call searchDeletedCategories
    function searchDeletedCategories(query) {
        $.ajax({
            type: 'GET',
            url: '/search-deleted-categories',
            data: { query: query },
            success: function (response) {
                const searchResults = response.categories;
                const resultsContainer = $('#deletedCategoryResults');

                resultsContainer.empty(); // Clear previous results

                if (searchResults.length > 0) {
                    searchResults.forEach(category => {
                        const resultItem = `<div class="search-result-item" data-id="${category.idcategory_store}">
                                                <strong>${category.category_name}</strong>
                                            </div>`;
                        resultsContainer.append(resultItem);
                    });
                    resultsContainer.show(); // Show the results
                    attachClickEvent(); // Attach click event after displaying the results
                } else {
                    resultsContainer.append('<div>No deleted categories found.</div>');
                    resultsContainer.show(); // Show the results even if no categories are found
                    attachClickEvent(); // Attach click event
                }
            },
            error: function (error) {
                console.error('Error searching deleted categories:', error);
            }
        });
    }

    // Function to attach the click event to the result items
    function attachClickEvent() {
        $('.search-result-item').on('click', function () {
        const categoryId = $(this).data('id');
        const categoryName = $(this).text().trim();  // Trim any extra spaces from the text

        $('#restore_category_id').val(categoryId);
        $('#deletedCategorySearch').val(categoryName); // Set the trimmed category name
        $('#deletedCategoryResults').empty().hide(); // Hide the results after selection
    });

    }
    // Function to Get Deleted Selections
    function getDeletedSelections(categoryId) {
        $.ajax({
            type: 'GET',
            url: '/get-deleted-selections',
            data: { categoryId: categoryId },
            success: function (response) {
                const selectionsContainer = $('#deletedSelectionsContainer');

                selectionsContainer.empty(); // Clear previous selections

                if (response.length > 0) {
                    response.forEach(selection => {
                        const selectionItem = `<div class="deleted-selection-item" data-id="${selection.idselection_store}">
                                                <strong>${selection.selection_name}</strong> (Choice: ${selection.choice})
                                            </div>`;
                        selectionsContainer.append(selectionItem);
                    });

                    // Click event to select a deleted selection
                    $('.deleted-selection-item').on('click', function () {
                        const selectionId = $(this).data('id');
                        $('#restore_selection_id').val(selectionId); // Set the selection ID
                        $('#restore_selection_search').val($(this).text()); // Set the selected name
                        selectionsContainer.empty(); // Clear the selections after selecting one
                    });
                } else {
                    selectionsContainer.append('<div>No deleted selections found for this category.</div>');
                }
            },
            error: function (error) {
                console.error('Error fetching deleted selections:', error);
            }
        });
    }

    // Restore Category Form Submission
    $('#restoreCategoryForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: '/restore-category',
        data: formData,
        success: function (response) {
            // Show SweetAlert after successful restoration
            Swal.fire({
                title: 'Success!',
                text: response.message,
                icon: 'success',
                timer: 3000,  // 3 seconds delay
                timerProgressBar: true, // Optional: Show progress bar
                showConfirmButton: false // Optional: Hide confirm button
            });

            // Clear the form and hide results after submission
            $('#restoreCategoryForm')[0].reset();
            $('#deletedCategoryResults').empty().hide();
        },
        error: function (error) {
            // Show SweetAlert for errors
            Swal.fire({
                title: 'Error!',
                text: error.responseJSON.error,
                icon: 'error',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }
    });
});

});




});
</script>


@endsection
