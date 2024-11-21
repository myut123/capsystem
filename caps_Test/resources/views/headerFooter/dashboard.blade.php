<nav class="navbar" style="background-color: #D4F1F4;">
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-white shadow-1-strong d-flex justify-content-center align-items-center me-2" style="width: 70px; height: 70px;">
                <img src="\img\logo.png" height="70" alt="Logo" loading="lazy" />
            </div>
            <h1 class="m-0" style="font-size: 24px;">Pawsome</h1>
        </div>
        <div class="position-relative" style="flex-grow: 1;"></div> <!-- Filler div for spacing -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container-fluid">
    <!-- Offcanvas Sidebar positioned to the right -->
    <div class="offcanvas offcanvas-end bg-dark-custom" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarLabel">Dashboard</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-dark d-flex flex-column align-items-center">
            <ul class="nav flex-column w-100">
                <li class="nav-item py-2">
                    <a href="/staff/petUpload" class="nav-link text-white d-flex align-items-center">
                        <i class="fa fas-solid fa-upload me-2"></i>
                        Upload
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="/applicants" class="nav-link text-white d-flex align-items-center">
                        <i class="fas fa-user-lock me-2"></i>
                        Adoption Applications
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a href="/qr" class="nav-link text-white d-flex align-items-center">
                        <i class="fa fas-solid fa-qrcode me-2"></i>
                        Generate QR
                    </a>
                </li>
            </ul>
            <div class="w-100 text-center mt-3">
                <button class="btn btn-danger logout-btn" onclick="location.href='logout.php'">Log out</button>
            </div>
        </div>
    </div>

    @yield('content')
</div>
