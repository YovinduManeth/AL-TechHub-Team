<?php

session_start();

require_once "php/db.php";


if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


$full_name = $_SESSION["full_name"];


$subject_id = $_GET["subject"] ?? "";


// Make sure subject ID is valid

if (!is_numeric($subject_id)) {

    header("Location: dashboard.php");
    exit();

}

$subject_id = (int)$subject_id;


$sql = "SELECT
            subject_id,
            subject_code,
            subject_name
        FROM subjects
        WHERE subject_id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $subject_id);

$stmt->execute();

$result = $stmt->get_result();

$subject = $result->fetch_assoc();

$stmt->close();


if (!$subject) {

    header("Location: dashboard.php");
    exit();

}


$sql = "SELECT
            paper_id,
            year,
            title,
            file_path,
            created_at
        FROM past_papers
        WHERE subject_id = ?
        ORDER BY year DESC";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $subject_id
);

$stmt->execute();

$result = $stmt->get_result();

$papers = [];

while ($row = $result->fetch_assoc()) {

    $papers[] = $row;

}

$stmt->close();

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Past Papers |
        <?php echo htmlspecialchars($subject["subject_code"]); ?>
        |
        A/L TechHub
    </title>


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

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>


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
            data-bs-target="#navPortal"
            aria-controls="navPortal"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- Navigation -->

        <div
            class="collapse navbar-collapse"
            id="navPortal"
        >

            <ul class="navbar-nav me-auto ms-lg-4">


                <!-- Home -->

                <li class="nav-item">

                    <a
                        class="nav-link dashboard-nav-link"
                        href="index.php"
                    >

                        <i class="bi bi-house me-1"></i>

                        Home

                    </a>

                </li>


                <!-- Dashboard -->

                <li class="nav-item">

                    <a
                        class="nav-link dashboard-nav-link active"
                        href="dashboard.php"
                    >

                        <i class="bi bi-grid-1x2-fill me-1"></i>

                        Dashboard

                    </a>

                </li>


                <!-- Contact -->

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


            <!-- Student -->

            <div class="d-flex align-items-center gap-3">

                <span class="dashboard-user">

                    <i class="bi bi-person-circle me-1"></i>

                    <?php echo htmlspecialchars($full_name); ?>

                </span>


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


<main class="container py-4">


    <div class="mb-3">

        <a
            href="dashboard.php"
            class="text-decoration-none"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to Dashboard

        </a>

    </div>

  
    <div class="welcome-card p-4 rounded-4 shadow-sm mb-4">


        <p class="small dashboard-label mb-1">

    <?php echo htmlspecialchars($subject["subject_code"]); ?>

    •

    G.C.E. A/L

</p>


        <h3 class="fw-bold mb-2">

            <?php echo htmlspecialchars($subject["subject_name"]); ?>

            — Past Papers

        </h3>


        <p class="text-muted small mb-0">

            Previous examination papers to help you
            practise and prepare for your examinations.

        </p>

    </div>


     <div class="mb-4">

        <p class="small dashboard-label mb-1">

            EXAMINATION MATERIALS

        </p>


        <h5 class="fw-bold mb-1">

            Past Papers

        </h5>


        <p class="text-muted small mb-0">

            Open or download available past papers
            for this subject.

        </p>

    </div>


    <?php if (empty($papers)): ?>


        <!-- No Papers -->

        <div class="alert alert-info rounded-4">

            <i class="bi bi-info-circle me-2"></i>

            No past papers are available for this subject yet.

        </div>


    <?php else: ?>


        <div class="row g-4">


            <?php foreach ($papers as $paper): ?>


                <div class="col-md-6 col-lg-4">


                    <div class="card subject-card h-100 rounded-4">


                        <div class="card-body p-4">


                            <!-- PDF Icon -->

                            <div class="mb-3">

                                <i
                                    class="bi bi-file-earmark-pdf-fill fs-1 text-danger"
                                ></i>

                            </div>


                            <!-- Year -->

                            <p class="small dashboard-label mb-1">

                                <?php echo htmlspecialchars($paper["year"]); ?>

                            </p>


                            <!-- Title -->

                            <h5 class="fw-bold mb-2">

                                <?php
                                echo htmlspecialchars(
                                    $paper["title"]
                                );
                                ?>

                            </h5>

                                <!-- PDF Information -->

                                    <p class="text-muted small mb-4">

                                        <i class="bi bi-file-earmark-pdf me-1"></i>

                                        G.C.E. A/L Past Paper

                                        <span class="mx-1">•</span>

                                        PDF Document

                                    </p>
                           


                            <!-- Open PDF -->

                            <a
                                href="<?php echo htmlspecialchars($paper["file_path"]); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-dashboard fw-bold w-100"
                            >

                                <i class="bi bi-file-earmark-pdf me-1"></i>

                                Open Past Paper

                            </a>

                        </div>

                    </div>

                </div>


            <?php endforeach; ?>


        </div>


    <?php endif; ?>


</main>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>