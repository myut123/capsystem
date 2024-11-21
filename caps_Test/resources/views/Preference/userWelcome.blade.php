@extends('headerFooter.HeaderDash')
@section('content')
<head>
    <title>Welcome To Pawsome</title>
    <style>
    .btn-primary {
        display: inline-block; /* Make the button block level */
        padding: 15px 25px; /* Padding inside the button */
        font-size: 1.2em; /* Size of the button text */
        color: #fff; /* Text color */
        background-color: #28a745; /* Green background color */
        border: none; /* Remove default border */
        border-radius: 5px; /* Rounded corners for the button */
        text-decoration: none; /* Remove underline */
        text-align: center; /* Center text inside the button */
        transition: background-color 0.3s ease; /* Smooth transition on hover */
    }

    .btn-primary:hover {
        background-color: #218838; /* Darker green on hover */
    }

    /* Animal themed heading styling */
    h1 {
        font-size: 3em; /* Make the heading larger */
        font-family: 'Comic Sans MS', cursive, sans-serif; /* Fun, playful font */
        color: #5B8C43; /* A greenish color for a nature theme */
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Add a slight shadow for depth */
        margin-bottom: 20px; /* Add some space below the heading */
    }
    
    /* Optional: Add some paw print background */
    .paw-print {
        position: absolute;
        opacity: 0.2;
        pointer-events: none; /* Avoid mouse events */
    }
</style>

<div class="container d-flex justify-content-center align-items-center vh-100 position-relative">
    <img src="/img/pawprint.jpg" alt="Paw Print" class="paw-print" style="top: 20px; left: 20px; width: 100px;">
    <img src="/img/pawprint.jpg" alt="Paw Print" class="paw-print" style="bottom: 20px; right: 20px; width: 100px;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4 text-center">
        <h1>Welcome to Pawsome</h1>
        <p>We're thrilled to have you here! By taking this step, you’re one step closer to becoming a loving fur parent. Each pet in our care is waiting for someone special like you to share their life with.</p>
        
        <p>Whether you're looking for a playful puppy, a cuddly kitten, or a loyal companion, we’re here to help you find the perfect match. Join us on this heartwarming journey to make a difference in a furry friend’s life!</p>
        
        <p>Let’s embark on this pawsitive adventure together!</p>

        @if ($firstCategory)
            <a href="{{ route('preferencecategories.view', $firstCategory->idcategory_store) }}" class="btn btn-primary">
                Explore Category
            </a>
        @else
            <p>No categories available to start the tutorial.</p>
        @endif
    </div>
</div>


@endsection