@extends('headerFooter.HeaderDash')
@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Category: {{ $category->category_name }}</title>
    <style>
/* Import fonts from Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Poppins:wght@400;600&display=swap');

body {
  background-color: #f7f2e9;
  font-family: 'Poppins', sans-serif;  /* Use Poppins for the body text */
  color: #3E3E3E;
}
/* Prevent SweetAlert2 from altering body layout */
body.swal2-shown {
    overflow: auto !important; /* Allow scrolling */
}

body.swal2-no-backdrop {
    overflow: auto !important; /* Ensure body can still scroll with modal */
}

.container {
  max-width: 800px;
  margin-top: 30px;
  padding: 2rem;
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  position: relative; /* Ensure relative positioning for absolute elements like progress lines */
}

h1, .card-title {
  font-family: 'Lora', serif;  /* Use Lora for headings */
  color: #4CAF50;
}


.card {
  border: 1px solid #a5d6a7;
  border-radius: 6px;
  transition: transform 0.3s, box-shadow 0.3s;
  cursor: pointer;
  text-align: center;
  background-color: #f7f2e9;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-bottom: 15px;
  color: black;  /* Make the text color black */
  padding: 5px 10px;
}

.card:hover, .card.border-primary {
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  border-color: #007bff;
  background-color: #e9f7fe;
}

.btn-primary {
  background-color: #5D9B30;
  border: none;
  width: 100%;
}

.btn-primary:hover {
  background-color: #4CAF50;
}

.btn-danger {
  background-color: #ff4d4d;
  width: 100%;
}

#error-message {
  display: none;
  color: red;
}

.selection-card {
  width: 100%;
  max-width: 100%;
  margin: 5px auto;
  font-size: 10px;


}

.selection-card .card-body {
  padding: 5px 10px;
}

.row {
  justify-content: center;
}

/* Progress bar styling */
.progress {
  height: 20px;
  width: 100%;
  max-width: 500px;
  margin: auto;
  margin-bottom: 20px;
}

.progress-bar {
  background-color: #4CAF50;
}

/* Stepped Progress Bar */
.step {
  position: relative;
  text-align: center;
}

.step-number {
  font-size: 24px;
}

.step-label {
  font-size: 12px;
}

.step + .step {
  margin-left: -1px; /* Remove space between steps */
}

.progress-line {
  height: 4px;
}

.step-circle {
  border-radius: 50%;
  width: 40px;
  height: 40px;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  border: 2px solid gray;
  font-size: 16px;
  font-weight: bold;
  transition: background-color 0.3s, border-color 0.3s;
}

/* Active green circle */
.step-circle.completed {
  border-color: green;
  background-color: green;
  color: white;
}

.step-circle.completed i {
  color: white;
}

.progress-line-active {
  position: absolute;
  top: 50%;
  left: 0;
  height: 4px;
  background-color: green;
  z-index: 1;
}


.circle {
  width: 40px;  /* Larger size for the circle */
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  font-size: 16px;
  font-weight: bold;
  background-color: white;
}

.progress-line {
  position: absolute;
  top: 50%; /* Vertically center the line */
  left: 0;
  height: 4px;
  background-color: lightgray;
  width: 100%;
  z-index: 0;
}

.progress-line-active {
  position: absolute;
  top: 50%;
  left: 0;
  height: 4px;
  background-color: green;
  width: 0%;  /* Initial width is 0 */
  transition: width 0.3s ease-in-out;
  z-index: 1;
}

/* Customization for Stepped Progress */
.step-number i {
  font-size: 20px; /* Ensuring icons inside the circle are a good size */
}
/* Custom button styles for confirm (Yes) button in confirmation modal */
.custom-confirm {
    background-color: #4CAF50 !important;  /* Green button */
    border-color: #4CAF50 !important;
}

.custom-confirm:hover {
    background-color: #45a049 !important;  /* Darker green on hover */
}

/* Custom button styles for cancel button in confirmation modal */
.custom-cancel {
    background-color: #f44336 !important;  /* Red button */
    border-color: #f44336 !important;
}

.custom-cancel:hover {
    background-color: #e53935 !important;  /* Darker red on hover */
}

/* Custom button styles for confirm (OK) button in error modal */
.custom-confirm-error {
    background-color: #ff9800 !important;  /* Orange button */
    border-color: #ff9800 !important;
}

.custom-confirm-error:hover {
    background-color: #fb8c00 !important;  /* Darker orange on hover */
}



</style>



</head>

<div class="container">
  <!-- Stepped Progress Bar for Categories -->
  <div class="mb-4 position-relative">
    <!-- Dynamic Progress Line -->
    <div class="d-flex justify-content-between position-relative">
      <!-- Progress line -->
      <div class="progress-line" style="position: absolute; top: 50%; left: 0; height: 4px; background-color: lightgray; width: 100%; z-index: 0;"></div>
      
      <!-- Active progress line (animated) -->
      <div class="progress-line-active" style="position: absolute; top: 50%; left: 0; height: 4px; background-color: green; width: {{ ($completedSteps / count($categories)) * 100 }}%; z-index: 1;"></div>

      @foreach($categories as $index => $categoryItem)
        <div class="step" style="width: {{ 100 / count($categories) }}%; text-align: center; position: relative; z-index: 2;">
          <div class="step-number" id="step-{{ $categoryItem->idcategory_store }}" class="step-circle" style="border: 2px solid {{ $categoryItem->progress == 100 ? 'green' : 'gray' }}; border-radius: 50%; width: 40px; height: 40px; margin: auto; display: flex; align-items: center; justify-content: center; background-color: white;">
            @if($categoryItem->progress == 100)
              <i class="fa fa-check" style="color: green;"></i>
            @else
              {{ $index + 1 }}
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Current Category -->
  <h1 class="text-center">{{ $category->category_description }} <i class="fa fa-paw" aria-hidden="true"></i></h1>

  <!-- Options List -->
  <div class="row justify-content-center">
    @foreach ($selections as $selection)
      <div class="col-md-12">
        <div class="card selection-card" data-selection-id="{{ $selection->idselection_store }}">
          <div class="card-body">
            <h5 class="card-title">{{ $selection->selection_name }}</h5>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Store Selection Button -->
  <div class="text-center mt-3">
    <button type="button" id="store-selection-btn" class="btn btn-primary" style="display: none;">
      Store Selection
    </button>
  </div>

  <!-- Error Message -->
  <p id="error-message" class="alert alert-danger mt-3" style="display: none;"></p>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirm Selection</h5>
        <button type="button" class="close" onclick="closeModal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to store this selection?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirm-store-btn">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Next Category Link -->
<div class="row justify-content-center mt-3">
  <div class="col-auto">
    @if ($nextCategory)
      <a href="{{ route('preferencecategories.view', $nextCategory->idcategory_store) }}" id="next-category-btn" class="btn btn-primary" style="display: none;">
        <i class="fa fa-paw" aria-hidden="true"></i> Next Animal Category
      </a>
    @else
      <div class="text-center mt-3">
        <a href="{{ route('home.view') }}" id="end-adventure-link" class="btn btn-danger" style="display: none;">
          <i class="fa fa-paw" aria-hidden="true"></i> Go to Another Page
        </a>
      </div>
    @endif
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the categories and calculate how many steps are completed
    const categories = @json($categories ?? []);
    let completedSteps = 0;

    categories.forEach((category, index) => {
        // Check the progress for each category
        if (category.progress == 100) {
            completedSteps++;
        }
    });

    // Update the active progress line width
    const progressLineActive = document.querySelector('.progress-line-active');
    if (progressLineActive) {
        const width = (completedSteps / categories.length) * 100;
        progressLineActive.style.width = width + '%'; // Set the width dynamically
    }

    // Optional: Log the completed steps
    console.log('Completed Steps: ', completedSteps);

    // Step progress logic - Update the circles for completed steps
    const steps = document.querySelectorAll('.step'); // Get all steps
    if (steps.length > 0) {
        steps.forEach((step, index) => {
            const stepNumber = step.querySelector('.circle');
            if (stepNumber) { // Check if the .circle element exists
                const categoryItem = categories[index]; // Assuming categories is available as JS object

                // Check progress and mark as completed
                if (categoryItem.progress == 100) {
                    stepNumber.classList.add('completed'); // Add completed class for green color
                } else {
                    stepNumber.classList.remove('completed'); // Remove completed class for unfinished steps
                }
            }
        });
    }

    // Handle other functionality like chart rendering
    const ctx = document.getElementById('analyticsChart');
    
    if (ctx) {
        const chartContext = ctx.getContext('2d');

        // Prepare data for the chart
        const labels = @json($labels ?? []);
        const data = @json($data ?? []);

        // Create the chart only if there is data to display
        if (labels.length > 0 && data.length > 0) {
            const analyticsChart = new Chart(chartContext, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Preferences Count',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });
        } else {
            chartContext.fillStyle = 'rgba(0, 0, 0, 0.5)'; // Set fill color
            chartContext.font = '20px Arial'; // Set font size and family
            chartContext.fillText('No data available', 100, 100); // Display message at specified coordinates
        }
    }

    // Selection Logic
    let selectedSelectionId = null;

    // Use PHP to dynamically generate the next category URL
    let nextCategoryUrl = @json($nextCategory ? route('preferencecategories.view', $nextCategory->idcategory_store) : null);
    let endAdventureUrl = @json(route('home.view'));

    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function() {
            selectedSelectionId = this.getAttribute('data-selection-id');
            // Highlight the selected card (optional)
            document.querySelectorAll('.card').forEach(c => c.classList.remove('border-primary'));
            this.classList.add('border-primary'); // Add a border to highlight selection
            document.getElementById('store-selection-btn').style.display = 'block'; // Show the button
        });
    });

    document.getElementById('store-selection-btn').addEventListener('click', function() {
    if (selectedSelectionId) {
        // SweetAlert2 confirmation modal
        Swal.fire({
            title: 'Confirm Selection',
            text: 'Are you sure you want to store this selection?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Store it!',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'swal2-confirm custom-confirm',  // Custom class for confirm button
                cancelButton: 'swal2-cancel custom-cancel'     // Custom class for cancel button
            }
        }).then((result) => {
            if (result.isConfirmed) {
                storeSelection(selectedSelectionId);
            }
        });
    } else {
        Swal.fire({
            title: 'Error',
            text: 'Please select a selection first.',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'swal2-confirm custom-confirm-error'  // Custom class for error 'OK' button
            }
        });
    }
});


    function storeSelection(selectionId) {
        fetch('/preferences/store', { // Update with your actual route
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // If using CSRF protection
            },
            body: JSON.stringify({ selection_id: selectionId }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK',
            }).then(() => {
                selectedSelectionId = null; // Reset selection
                document.getElementById('store-selection-btn').style.display = 'none'; // Hide button after storing
                
                // Check if there is a next category before redirecting
                if (nextCategoryUrl !== null) { // Check if nextCategoryUrl is not null
                    window.location.href = nextCategoryUrl; // Redirect to the next category
                } else {
                    // Automatically redirect to the other page
                    window.location.href = endAdventureUrl; // Redirect to your specified URL
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'There was a problem with your request. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
});




</script>

@endsection
