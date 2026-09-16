<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html?error=login_required");
    exit();
}

$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Us | A/L TechHub</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="contact-page">

    <!-- =================================
         Navigation Bar
    ================================== -->

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar">

        <div class="container">

            <!-- Brand -->
            <a
                class="navbar-brand fw-bold dashboard-brand"
                href="index.html"
            >
                <i class="bi bi-mortarboard-fill me-1"></i>
                A/L TechHub
            </a>


            <!-- Mobile Toggle -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#contactNavbar"
                aria-controls="contactNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>


            <!-- Navigation -->
            <div
                class="collapse navbar-collapse"
                id="contactNavbar"
            >

                <ul class="navbar-nav me-auto ms-lg-4">

                    <li class="nav-item">
                        <a
                            class="nav-link dashboard-nav-link"
                            href="index.html"
                        >
                            <i class="bi bi-house me-1"></i>
                            Home
                        </a>
                    </li>


                    <li class="nav-item">
                        <a
                            class="nav-link dashboard-nav-link"
                            href="dashboard.php"
                        >
                            <i class="bi bi-grid-1x2-fill me-1"></i>
                            Dashboard
                        </a>
                    </li>


                   

                    <li class="nav-item">
                        <a
                            class="nav-link dashboard-nav-link active"
                            href="contact.php"
                        >
                            <i class="bi bi-envelope me-1"></i>
                            Contact Us
                        </a>
                    </li>

                </ul>


                <div class="d-flex align-items-center gap-3">

    <a
    href="profile.php"
    class="dashboard-user text-decoration-none"
>
    <i class="bi bi-person-circle me-1"></i>
    <?php echo htmlspecialchars($username); ?>
</a>


    <!-- Day / Night Mode -->
    <button
        type="button"
        id="themeToggle"
        class="btn btn-link theme-toggle"
        aria-label="Switch to night mode"
        title="Switch to night mode"
    >
        <i
            class="bi bi-moon"
            id="themeIcon"
        ></i>
    </button>


    <a
        href="login.php"
        class="btn btn-outline-primary btn-sm px-3"
    >
        <i class="bi bi-box-arrow-right me-1"></i>
        Logout
    </a>

</div>

            </div>

        </div>

    </nav>