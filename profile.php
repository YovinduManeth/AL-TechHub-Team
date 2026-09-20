<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION["user_id"];

$sql = "SELECT full_name, username, email, role
        FROM users
        WHERE user_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: login.html");
    exit();
}

$user = $result->fetch_assoc();

$stmt->close();
$subject_sql = "SELECT s.subject_name
                FROM student_subjects ss
                INNER JOIN subjects s
                    ON ss.subject_id = s.subject_id
                WHERE ss.user_id = ?
                ORDER BY s.subject_id";

$subject_stmt = $conn->prepare($subject_sql);

$subject_stmt->bind_param("i", $user_id);

$subject_stmt->execute();

$subject_result = $subject_stmt->get_result();

$student_subjects = [];

while ($subject = $subject_result->fetch_assoc()) {
    $student_subjects[] = $subject["subject_name"];
}

$subject_stmt->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | A/L TechHub</title>

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

<body>


<!-- ==============================
     Navigation Bar
================================ -->

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top dashboard-navbar">

    <div class="container">

        <!-- Brand -->
        <a
            class="navbar-brand fw-bold dashboard-brand"
            href="dashboard.php"
        >

            <i class="bi bi-mortarboard-fill me-1"></i>
            A/L TechHub

        </a>


        <!-- Mobile Toggle -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#profileNavbar"
            aria-controls="profileNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- Navbar Content -->
        <div
            class="collapse navbar-collapse"
            id="profileNavbar"
        >

            <!-- Left Navigation -->
            <ul class="navbar-nav me-auto ms-lg-4">

                <li class="nav-item">

                    <a
                        class="nav-link dashboard-nav-link"
                        href="index.php"
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
                        class="nav-link dashboard-nav-link"
                        href="contact.php"
                    >

                        <i class="bi bi-envelope me-1"></i>
                        Contact Us

                    </a>

                </li>

            </ul>

                <!-- User Account -->

<div class="d-flex align-items-center gap-3">

    <a
        href="profile.php"
        class="dashboard-user text-decoration-none"
    >

        <i class="bi bi-person-circle me-1"></i>
        User Account

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


    <!-- Logout -->

    <a
        href="php/logout.php"
        class="btn btn-outline-primary btn-sm px-3"
    >

        <i class="bi bi-box-arrow-right me-1"></i>
        Logout

    </a>

</div>
            

        </div>

    </div>

</nav>

<!-- ==============================
     Profile Content
================================ -->

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">


            <!-- Page Heading -->

            <div class="mb-4">

                <p class="small dashboard-label mb-1">
                    STUDENT ACCOUNT
                </p>

                <h2 class="fw-bold mb-1">
                    My Profile
                </h2>

                <p class="text-muted mb-0">
                    View and manage your A/L TechHub student account.
                </p>

            </div>



            <!-- Profile Card -->

            <div class="card border-0 shadow-sm rounded-4 mb-4 profile-card">

                <div class="card-body p-4">

                    <div class="row align-items-center">

                        <!-- Profile Icon -->

                        <div class="col-md-3 text-center mb-4 mb-md-0">

                            <div class="profile-avatar">

                                <i class="bi bi-person-fill"></i>

                            </div>

                            <h5 class="fw-bold mt-3 mb-1">
                                Student
                            </h5>

                            <span class="badge profile-status">
                                Active Student
                            </span>

                        </div>


                        <!-- Student Information -->

                        <div class="col-md-9">

                            <h5 class="fw-bold mb-3">
                                Personal Information
                            </h5>


                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="profile-label">
                                        Full Name
                                    </label>

                                 <p class="profile-value">
                                    <?php echo htmlspecialchars($user["full_name"]); ?>
                                </p>

                                </div>


                                <div class="col-md-6">

                                    <label class="profile-label">
                                        Username
                                    </label>

                                     <p class="profile-value">
                                        <?php echo htmlspecialchars($user["username"]); ?>
                                    </p>

                                </div>


                                <div class="col-md-6">

                                    <label class="profile-label">
                                        Email Address
                                    </label>

                                    <p class="profile-value">
                                        <?php echo htmlspecialchars($user["email"]); ?>
                                    </p>

                                </div>


                                

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Academic Information -->

            <div class="card border-0 shadow-sm rounded-4 mb-4 profile-card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <div class="profile-section-icon me-3">

                            <i class="bi bi-mortarboard-fill"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-0">
                                Academic Information
                            </h5>

                            <p class="text-muted small mb-0">
                                Your selected Technology Stream subjects.
                            </p>

                        </div>

                    </div>


                    <div class="row g-3">


                        <!-- SFT -->

                        <div class="col-md-4">

                            <div class="profile-subject-card">

                                <i class="bi bi-flask-fill"></i>

                                <h6 class="fw-bold mt-2 mb-1">
                                <?php echo htmlspecialchars($student_subjects[0]); ?>
                            </h6>

                                <small class="text-muted">
                                    Compulsory Core
                                </small>

                            </div>

                        </div>


                        <!-- ET -->

                        <div class="col-md-4">

                            <div class="profile-subject-card">

                                <i class="bi bi-gear-fill"></i>

                                <h6 class="fw-bold mt-2 mb-1">
                                <?php echo htmlspecialchars($student_subjects[1]); ?>
                            </h6>

                                <small class="text-muted">
                                    Basket 02 Elective
                                </small>

                            </div>

                        </div>


                        <!-- ICT -->

                        <div class="col-md-4">

                            <div class="profile-subject-card">

                                <i class="bi bi-pc-display"></i>

                                <h6 class="fw-bold mt-2 mb-1">
                                <?php echo htmlspecialchars($student_subjects[2]); ?>
                            </h6>

                                <small class="text-muted">
                                    Basket 03 Elective
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <!-- Account Actions -->

            <div class="card border-0 shadow-sm rounded-4 profile-card">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Account Settings
                    </h5>


                    <div class="d-flex flex-column flex-md-row gap-2">

                        <a
                            href="edit-profile.php"
                            class="btn btn-dashboard"
                        >
                            <i class="bi bi-pencil-square me-1"></i>
                            Edit Profile
                        </a>


                        <a
                            href="change-password.php"
                            class="btn btn-outline-primary"
                        >
                            <i class="bi bi-key me-1"></i>
                            Change Password
                        </a>


                        <a
                            href="dashboard.php"
                            class="btn btn-outline-secondary"
                        >

                            <i class="bi bi-arrow-left me-1"></i>
                            Back to Dashboard

                        </a>

                    </div>

                </div>

            </div>


        </div>

    </div>

</main>


<!-- Bootstrap JavaScript -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

<script src="./js/script.js"></script>


</body>

</html>