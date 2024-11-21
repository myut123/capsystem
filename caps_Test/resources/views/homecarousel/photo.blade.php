<div class="container">
    <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <a href="url-to-link-1">
            <img src="img\dogs.jpg" alt="clickable image1" class="img-fluid">
        </a>
        <div class="caption">
        <h5>Our dogs</h5>
    </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="url-to-link-2">
            <img src="img\dogs.jpg" alt="clickable image2" class="img-fluid">
        </a>
        <div class="caption">
        <h5>Our Cats</h5>
    </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="url-to-link-3">
            <img src="img\dogs.jpg" alt="clickable image3" class="img-fluid">
        </a>
        <div class="caption">
        <h5>Volunteer</h5>
    </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <a href="url-to-link-4"> <img src="img\dogs.jpg" alt="clickable image4" class="img-fluid">
        </a>
        <div class="caption">
        <h5>Animal Abuse</h5>
    </div>
    </div>
</div>
    </div>
</div>
<style>
    .photo-container {
    padding: 2rem 0;
    background-color: #fff;
    text-align: center;
}

.photo-container h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.photo-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 1rem;
}

.photo-item {
    position: relative;
}

.photo-item img {
    width: 100%;
    height: auto;
}

.photo-info {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 0.5rem;
    color: #fff;
}
</style>