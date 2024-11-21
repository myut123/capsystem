@extends('headerFooter.header')
@section('content')
<div>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Staff Upload</title>
    <style>
/* General Styling */
.custom-card {
    background-color: #f7f2e9;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 900px;
    margin: 20px auto;
    position: relative;
}

h1 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 20px;
    text-align: left;
}

#submitBtn {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    font-size: 1rem;

    background-color: green;
}

/* Preview Sections */
.preview-container {
    background-color: #ffffff; /* Contrasting background */
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    margin-top: 10px;
}

/* Thumbnail Preview Adjustments */
/* Thumbnail Preview Adjustments */
#thumbnailPreview {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;  /* Keep the height */
    width: 350px;   /* Increased width for a wider preview */
}

#thumbnailPreviewImg {
    max-width: 350px;  /* Set max width to match the container */
    height: auto;      /* Keep aspect ratio */
    object-fit: contain;
    display: none;
    border: 1px solid #ccc;
    border-radius: 8px;
}

#thumbnailPreview .upload-placeholder {
    text-align: center;
    color: #999;
    font-size: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

/* Additional Images Preview Adjustments */
#additionalImagesPreview img {
    width: 100px;        /* Set width */
    height: 100px;       /* Set height */
    object-fit: cover;   /* Maintain aspect ratio */
    margin: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Video Preview Adjustments */
#videosPreview {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Space between videos */
    justify-content: flex-start;
}

#videosPreview .preview-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;       /* Adjust height */
    width: 200px;        /* Adjust width */
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #fff;
    padding: 10px;
    margin: 10px;
    position: relative;
    overflow: hidden;
}

#videosPreview video {
    width: 100%;         /* Set video to take full container width */
    height: 100%;        /* Ensure video maintains aspect ratio */
    object-fit: contain; /* Fit video inside container */
    border-radius: 8px;
    border: 1px solid #ccc;
}

#videosPreview .upload-placeholder {
    text-align: center;
    color: #999;
    font-size: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

/* Responsive adjustments for smaller screens */
@media (max-width: 768px) {
    #thumbnailPreview {
        height: 150px;      /* Smaller height for thumbnails */
        width: 150px;       /* Smaller width */
    }

    #thumbnailPreviewImg {
        max-width: 150px;   /* Smaller max-width for thumbnail image */
    }

    #additionalImagesPreview img {
        width: 80px;        /* Smaller image previews */
        height: 80px;
    }

    #videosPreview .preview-container {
        width: 150px;       /* Smaller video preview container */
        height: 150px;
    }

    #videosPreview video {
        width: 100%;
        height: 100%;
    }



}
</style>

<div class="container my-5 custom-card">
    <form method="POST" action="{{ route('petUpload.insert') }}" enctype="multipart/form-data" class="row" id="petForm">
        @csrf

        <!-- Form Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">PET UPLOAD FORM</h1>
            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
        </div>
        <hr>

        <!-- Left Section -->
        <div class="col-lg-6 col-md-12">
            <div class="form-group mb-4">
                <!-- Thumbnail Preview Container -->
                <div id="thumbnailPreview" class="preview-container">
                    <img id="thumbnailPreviewImg">
                    <!-- Hidden File Input -->
                    <input 
                        type="file" 
                        id="pet_img" 
                        name="pet_img" 
                        accept="image/*" 
                        required 
                        style="display: none;">
                    <!-- Placeholder Text -->
                    <div class="upload-placeholder" id="thumbnailPlaceholder">
                        Click here to upload a thumbnail
                    </div>
                </div>
            </div>

            <!-- Additional Images Section -->
            <div class="form-group mb-4">
                <label class="form-label">Additional Images:</label>
                <div id="additionalImagesPreview" class="preview-container d-flex flex-wrap">
                    <div class="upload-placeholder" id="additionalPlaceholder">
                        Click here to upload additional images
                    </div>
                    <input
                        type="file"
                        id="pet_imgs"
                        name="pet_imgs[]"
                        accept="image/*"
                        multiple
                        style="display: none;">
                </div>
            </div>

            <!-- Video Upload Section -->
            <div class="form-group mb-4">
                <label class="form-label">Videos:</label>
                <div id="videosPreview" class="preview-container d-flex flex-wrap">
                    <div class="upload-placeholder" id="videoPlaceholder">
                        Click here to upload videos
                    </div>
                    <input
                        type="file"
                        id="pet_videos"
                        name="pet_videos[]"
                        accept="video/*"
                        multiple
                        style="display: none;">
                </div>
            </div>
        </div> <!-- End Left Section -->

        <!-- Right Section -->
        <div class="col-lg-6 col-md-12">
            <div class="form-group mb-4">
                <label for="pet_name" class="form-label">Pet Name:</label>
                <input type="text" id="pet_name" name="pet_name" class="form-control" placeholder="Enter pet name" required>
            </div>

            <div class="form-group mb-4">
                <label for="pet_desc" class="form-label">Pet Description:</label>
                <textarea id="pet_desc" name="pet_desc" class="form-control" placeholder="Enter pet description" rows="4" required></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="category" class="form-label">Categories:</label>
                <div class="row">
                    @foreach($categories as $categoryId => $selections)
                    <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                        <label for="selection_{{ $categoryId }}" class="form-label">{{ $selections->first()->category_name }}</label>
                        <select class="form-select selection" id="selection_{{ $categoryId }}" name="selection_id[]" required>
                            <option value="">Select {{ $selections->first()->category_name }}</option>
                            @foreach($selections as $selection)
                            <option value="{{ $selection->selection_id }}">{{ $selection->choice }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> <!-- End Right Section -->

    </form>
</div> <!-- End Container -->






<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const petImgInput = document.getElementById('pet_img');
  const additionalImagesPreview = document.getElementById('additionalImagesPreview');
  const videosPreview = document.getElementById('videosPreview');
  const thumbnailPreviewImg = document.getElementById('thumbnailPreviewImg');
  const additionalImagesInput = document.getElementById('pet_imgs');
  const videoInput = document.getElementById('pet_videos');
  const thumbnailPreviewContainer = document.getElementById('thumbnailPreview');
  const thumbnailImg = document.getElementById('thumbnailPreviewImg');
  const thumbnailPlaceholder = document.getElementById('thumbnailPlaceholder');
  const additionalPlaceholder = document.getElementById('additionalPlaceholder');
  const videoPlaceholder = document.getElementById('videoPlaceholder');

  let petImage = null; // To hold the thumbnail image
  let additionalImages = []; // To hold additional images
  let videos = []; // To hold video files

  // Handle thumbnail preview
  thumbnailPreviewContainer.addEventListener('click', () => {
    petImgInput.click(); // Open file selector for thumbnail
  });

  petImgInput.addEventListener('change', (e) => {
    const file = e.target.files[0];

    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = (event) => {
        thumbnailImg.src = event.target.result;
        thumbnailImg.classList.add('visible');
        thumbnailPlaceholder.style.display = 'none'; // Hide placeholder text
      };
      reader.readAsDataURL(file);
      petImage = file; // Store the thumbnail image file
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Invalid File',
        text: 'Please select a valid image file.',
      });
    }
  });

  // Handle additional image preview
  additionalImagesPreview.addEventListener('click', () => {
    additionalImagesInput.click(); // Trigger file input for additional images
  });

  additionalImagesInput.addEventListener('change', (e) => {
    additionalImagesPreview.innerHTML = ''; // Clear existing previews
    additionalImages = Array.from(e.target.files); // Store the selected images
    if (additionalImages.length === 0) {
      additionalPlaceholder.style.display = 'block'; // Show placeholder if no files
    } else {
      additionalPlaceholder.style.display = 'none'; // Hide placeholder when files are added
      additionalImages.forEach((file) => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = (event) => {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.style.maxWidth = '100px';
            img.style.margin = '5px';
            img.style.height = 'auto';
            img.style.border = '1px solid #ddd';
            img.style.borderRadius = '4px';
            additionalImagesPreview.appendChild(img);
          };
          reader.readAsDataURL(file);
        }
      });
    }
  });

  // Handle video preview
  videosPreview.addEventListener('click', () => {
    videoInput.click(); // Trigger file input for videos
  });

  videoInput.addEventListener('change', (e) => {
    videosPreview.innerHTML = ''; // Clear existing previews
    videos = Array.from(e.target.files); // Store the selected videos
    if (videos.length === 0) {
      videoPlaceholder.style.display = 'block'; // Show placeholder if no files
    } else {
      videoPlaceholder.style.display = 'none'; // Hide placeholder when files are added
      videos.forEach((file) => {
        if (file.type.startsWith('video/')) {
          const url = URL.createObjectURL(file);
          const video = document.createElement('video');
          video.src = url;
          video.controls = true;
          video.style.maxWidth = '150px';
          video.style.margin = '5px';
          video.style.height = 'auto';
          video.style.border = '1px solid #ddd';
          video.style.borderRadius = '4px';
          videosPreview.appendChild(video);
        }
      });
    }
  });

  // Form submission handling
  const submitBtn = document.getElementById('submitBtn');
  submitBtn.addEventListener('click', function (e) {
    e.preventDefault(); // Prevent default form submission

    const petName = document.getElementById('pet_name').value.trim();
    const petDesc = document.getElementById('pet_desc').value.trim();

    if (!petName) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Information',
        text: 'Please enter a pet name.',
      });
      return;
    }

    if (!petDesc) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Information',
        text: 'Please enter a pet description.',
      });
      return;
    }

    // Create FormData to include files and data
    const formData = new FormData();
    formData.append('pet_name', petName);
    formData.append('pet_desc', petDesc);

    // Append category selections
    const selections = document.querySelectorAll('.selection');
    const selectedIds = Array.from(selections)
        .map(select => select.value)
        .filter(Boolean);
    selectedIds.forEach(id => formData.append('selection_id[]', id));

    // Append thumbnail image
    if (petImage) {
        formData.append('pet_img', petImage);
    } else {
        Swal.fire({
            icon: 'error',
            title: 'No Image',
            text: 'Please upload a pet thumbnail image.',
        });
        return;
    }

    // Append additional images
    additionalImages.forEach(image => formData.append('pet_imgs[]', image));

    // Append videos
    videos.forEach(video => formData.append('pet_videos[]', video));

    // Submit via AJAX
    fetch('/pet-upload/inserted', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Pet Uploaded!',
                text: 'Your pet has been uploaded successfully.',
            });
            document.getElementById('petForm').reset();
            petImage = null;
            additionalImages = [];
            videos = [];
            thumbnailPreviewImg.style.display = 'none';
            additionalImagesPreview.innerHTML = '';
            videosPreview.innerHTML = '';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Upload Failed',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Something went wrong. Please try again later.',
        });
    });
  });
</script>



@endsection
