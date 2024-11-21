@extends('headerFooter.HeaderDash')
@section('content')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Profile Update</title>
    <style>
        body{
            background-color: #f7f2e9; /* Light background color */
            
        }
       .tab-content {
            margin-top: 20px;
            padding: 20px;
            
        }

        .container {
            max-width: 600px; /* Set a maximum width for the container */
            margin: auto; /* Center the container */
            padding: 20px; /* Add padding for aesthetics */
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .edit-profile-container, .category-container {
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        .edit-profile-container h1, .category-container h1 {
            font-size: 28px;
            font-weight: bold;
            color: #4CAF50; /* Earthy green for headings */
            text-align: center;
            margin-bottom: 20px;
        }

        .edit-profile-container input, .category-container input {
            border: none;
            border-bottom: 2px solid #ccc;
            background: none;
            padding: 8px 5px; /* Shortened input padding */
            width: 100%;
            font-size: 16px; /* Slightly smaller font */
            margin-bottom: 20px; /* Reduced margin */
            transition: border-color 0.3s;
        }

        .edit-profile-container input:focus, .category-container input:focus {
            border-bottom-color: #007bff;
            outline: none;
        }

        .edit-profile-container button, .category-container button {
            display: block;
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 0; /* Shorter button height */
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .edit-profile-container button:hover, .category-container button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .edit-profile-container, .category-container {
                padding: 20px;
            }

            .edit-profile-container h1, .category-container h1 {
                font-size: 24px; /* Reduced title size for mobile */
            }
        }
        .nav-link{
            color: #4CAF50; /* Earthy green for headings */
            text-align: center;
            margin-bottom: 20px;
            
        }

    </style>
</head>

    <div class="container mt-5">
        
    <h1> <i class="fas fa-paw"></i>EDIT <i class="fas fa-paw"></i></h1>
    <hr>
        <div class="tab-content">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="tab1" href="#content1">Edit Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab2" href="#content2">Edit Preference</a>
            </li>
        </ul>
     
            <div class="tab-pane fade show active" id="content1">
                <div class="edit-profile-container border bg-light">
                    
                    <form id="editProfileForm">
                   
                        <div class="mb-3">
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="fname" value="{{ old('fname', $user->fname) }}" placeholder="First Name" required>
                            @error('fname')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="mname" value="{{ old('mname', $user->mname) }}" placeholder="Middle Name" required>
                            @error('mname')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="lname" value="{{ old('lname', $user->lname) }}" placeholder="Last Name" required>
                            @error('lname')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                        <input type="password" name="new_password" placeholder="New Password">
                            </div>
                            <div class="mb-3">
                            <input type="password" name="new_password_confirmation" placeholder="Confirm New Password">
                            </div>

                        <button type="button" id="saveChanges">Save Changes</button> <!-- Changed to button type -->
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
            <div class="tab-pane fade" id="content2">
           
                <div id="categoryContent" class="category-container">
                
                    <!-- This is where the category form will be displayed -->
                </div>
            </div>

        </div>
    </div>
    </div>
    <div></div>


<script>
$(document).ready(function() {
    // Set CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// Handle form submission for Edit Profile
$('#saveChanges').on('click', function(e) {
    e.preventDefault(); // Prevent default form submission

    var form = $('#editProfileForm');

    $.ajax({
        type: 'POST',
        url: '{{ route("profile.update") }}', // Laravel route for profile update
        data: form.serialize(), // Serialize form data
        success: function(response) {
            $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
            // Refresh the page after a successful update
            setTimeout(function() {
                location.reload(); // Reload the current page
            }, 2000); // Adjust the time (in milliseconds) before the refresh
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMessages = '';
            $.each(errors, function(key, value) {
                errorMessages += '<div class="alert alert-danger">' + value[0] + '</div>';
            });
            $('#responseMessage').html(errorMessages);
        }
    });
});

    // Function to fetch categories and display in Tab 2
    function fetchCategories() {
    $.ajax({
        type: 'GET',
        url: '{{ route("profile.categories") }}', // Laravel route for fetching categories
        success: function(response) {
            if (response.data && response.data.length > 0) {
                let categoryContent = '<form id="categoryForm">';
                let categoriesMap = {}; // To group selections by category

                // Loop through the response data to create a mapping of categories and their selections
                $.each(response.data, function(index, item) {
                    if (!categoriesMap[item.category_name]) {
                        categoriesMap[item.category_name] = {
                            selections: [],
                            selectedId: item.selected_id // Store the selected_id for this category
                        };
                    }
                    categoriesMap[item.category_name].selections.push(item.selection_name);
                });

                // Now iterate through the categoriesMap to construct the form
                $.each(categoriesMap, function(categoryName, data) {
                    categoryContent += `
                        <div class="mb-3">
                            <label for="${categoryName}">${categoryName}</label>
                            <select name="category[${categoryName}][selection_name]" id="${categoryName}" class="form-select" required>
                                <option value="" disabled>Select a Selection</option>`;

                    // Loop through the selections for the current category
                    $.each(data.selections, function(selectionIndex, selectionName) {
                        let isSelected = (data.selectedId === selectionName) ? 'selected' : '';
                        categoryContent += `
                            <option value="${selectionName}" ${isSelected}>${selectionName}</option>`;
                    });

                    categoryContent += `
                            </select>
                        </div>`;
                });

                categoryContent += '<button type="button" id="saveCategoryChanges">Save Changes</button>';
                categoryContent += '</form>';

                $('#categoryContent').html(categoryContent); // Populate the category content div

                // Handle category form submission
                $('#saveCategoryChanges').on('click', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    var form = $('#categoryForm');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("profile.categories.update") }}',
                        data: form.serialize(),
                        success: function(response) {
                            // Show success message
                            $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');

                            // Refresh categories after showing the success message
                            setTimeout(function() {
                                fetchCategories(); // Call the fetchCategories function to refresh the list
                            }, 2000); // Delay of 2 seconds before refreshing
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += '<div class="alert alert-danger">' + value[0] + '</div>';
                            });
                            $('#responseMessage').html(errorMessages);
                        }
                    });
                });

            } else {
                $('#categoryContent').html('<p>No categories found.</p>'); // Handle no results
            }
        },
        error: function(xhr) {
            console.log(xhr); // Debugging: Log the error response
            let errors = xhr.responseJSON.errors;
            let errorMessages = '';
            $.each(errors, function(key, value) {
                errorMessages += '<div class="alert alert-danger">' + value[0] + '</div>';
            });
            $('#responseMessage').html(errorMessages);
        }
    });
}


    // Tab functionality
    $('.nav-tabs a').on('click', function(e) {
        e.preventDefault(); // Prevent default anchor click behavior

        // Check if the tab being clicked is Tab 2
        if ($(this).attr('id') === 'tab2') {
            fetchCategories(); // Call the function to fetch categories
        }

        // Activate the clicked tab
        $(this).tab('show');
    });

});
</script>


@endsection
