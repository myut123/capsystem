<div id="carousel" class="carousel slide container" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carousel" data-slide-to="0" class="active"></li>
    <li data-target="#carousel" data-slide-to="1"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="\img\animal-adoption-shelter-banner-with-cartoon-pets-vector-33851556.jpg" class="d-block w-100" alt="Dog">
      <div class="carousel-caption">
        <h5 class="text-white">EVENTS</h5>
        <p class="text-white">Join us for our upcoming events!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="\img\animal-adoption-shelter-banner-with-cartoon-pets-vector-33851556.jpg" class="d-block w-100" alt="Cat">
      <div class="carousel-caption">
        <h5 class="text-white">CAMPAIGN</h5>
        <p class="text-white">Learn more about our latest campaign!</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<style>
    .carousel {
    width: 80%; /* Adjust the width of the carousel */
  margin: 0 auto;
  height: 400px; /* Set a fixed height for the carousel container */
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
  }
  
  .carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
  }
  
  .carousel-item {
    position: relative;
    display: none;
    float: left;
    width: 100%;
    height: 400px; /* Set the height to a fixed value */
    margin-right: -100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transition: transform 0.6s ease-in-out;
  }
  .carousel-item img {
    object-fit: cover; /* Ensure the image covers the entire container */
  width: 100%; /* Set the width of the image to 100% */
  height: 100%; /* Set the height of the image to 100% */
  }

  
  
  .carousel-item.active,
  .carousel-item-next,
  .carousel-item-prev {
    display: block;
  }
  
  .carousel-item-next:not(.carousel-item-left),
  .active.carousel-item-right {
    transform: translateX(100%);
  }
  
  .carousel-item-prev:not(.carousel-item-right),
  .active.carousel-item-left {
    transform: translateX(-100%);
  }
  
  .carousel-control-prev,
  .carousel-control-next {
    position: absolute;
    top: 0;
    bottom: 0;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 15%;
    color: #fff;
    text-align: center;
    opacity: 0.5;
    transition: opacity 0.15s ease;
  }
  
  .carousel-control-prev:hover,
  .carousel-control-prev:focus,
  .carousel-control-next:hover,
  .carousel-control-next:focus {
    color: #fff;
    text-decoration: none;
    outline: 0;
    opacity: 0.9;
  }
  
  .carousel-control-prev {
    left: 0;
  }
  
  .carousel-control-next {
    right: 0;
  }
  
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    background: no-repeat 50% / 100% 100%;
  }
  
  .carousel-control-prev-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e");
  }
  
  .carousel-control-next-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3e%3c/svg%3e");
  }
  
  .carousel-indicators {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 15;
    display: flex;
    justify-content: center;
    padding-left: 0;
    margin-right: 15%;
    margin-left: 15%;
    list-style: none;
  }
  
  .carousel-indicators li {
    box-sizing: content-box;
    flex: 0 1 auto;
    width: 30px;
    height: 3px;
    margin-right: 3px;
    margin-left: 3px;
    text-indent: -999px;
    cursor: pointer;
    background-color: #fff;
    background-clip: padding-box;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    opacity: 0.5;
    transition: opacity 0.6s ease;
  }
  
  .carousel-indicators.active {
    opacity: 1;
  }

  .carousel-caption {
  background-color: rgba(0, 0, 0, 0.5);
  padding: 20px;
  border-radius: 5px;
}

.carousel-caption h5 {
  font-size: 24px;
}

.carousel-caption p {
  font-size: 18px;
}
</style>