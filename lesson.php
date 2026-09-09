<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


// ==========================================
// GET LOGGED-IN STUDENT
// ==========================================

$full_name = $_SESSION["full_name"];


// ==========================================
// GET LESSON ID
// ==========================================

$lesson_id = $_GET["lesson"] ?? "";


// Make sure lesson ID is a number

if (!is_numeric($lesson_id)) {

    header("Location: dashboard.php");
    exit();

}

$lesson_id = (int)$lesson_id;


// ==========================================
// GET LESSON DETAILS
// ==========================================

$sql = "SELECT
            lessons.lesson_id,
            lessons.unit_id,
            lessons.lesson_number,
            lessons.title,
            lessons.description,
            lessons.video_path,
            lessons.video_1080p_path,
            lessons.video_720p_path,
            lessons.video_480p_path,
            lessons.video_360p_path,
            lessons.audio_path,
            lessons.duration_minutes,

            units.unit_number,
            units.unit_title,
            units.grade,

            subjects.subject_code,
            subjects.subject_name

        FROM lessons

        INNER JOIN units
            ON lessons.unit_id = units.unit_id

        INNER JOIN subjects
            ON units.subject_id = subjects.subject_id

        WHERE lessons.lesson_id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $lesson_id);

$stmt->execute();

$result = $stmt->get_result();

$lesson = $result->fetch_assoc();

$stmt->close();


// ==========================================
// CHECK LESSON EXISTS
// ==========================================

if (!$lesson) {

    header("Location: dashboard.php");
    exit();

}

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
        <?php echo htmlspecialchars($lesson["title"]); ?> | A/L TechHub
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


<body class="lesson-page">


    <!-- =========================================
     NAVIGATION
========================================= -->

<nav class="navbar navbar-expand-lg lesson-navbar">

    <div class="container">


        <!-- Back Button -->

        <a
            href="units.php?subject=<?php echo urlencode($lesson["subject_code"]); ?>"
            class="btn btn-lesson-back btn-sm"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to Unit

        </a>


        <!-- Lesson Information -->

        <span class="lesson-navbar-title">

            <i class="bi bi-book me-1"></i>

            <?php echo htmlspecialchars($lesson["subject_code"]); ?>

            <span class="lesson-divider">•</span>

            Unit
            <?php echo str_pad(
                $lesson["unit_number"],
                2,
                "0",
                STR_PAD_LEFT
            ); ?>

            <span class="lesson-divider">•</span>

            Lesson
            <?php echo htmlspecialchars($lesson["lesson_number"]); ?>

        </span>

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


    </div>

</nav>



    <!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="container py-4">


        <div class="row g-4">


            <!-- =================================
                 MAIN LESSON AREA
            ================================== -->

            <div class="col-lg-8">


                <div class="lesson-main-card">


                    <!-- =============================
                         DATA SAVER SWITCHER
                    ============================== -->

                    <div class="data-mode-box">


                        <div class="d-flex align-items-center">


                            <div class="data-mode-icon">

                                <i class="bi bi-lightning-fill"></i>

                            </div>


                            <div>

                                <h6 class="fw-bold mb-1">

                                    Data-Saver Mode

                                </h6>

                                <small>

                                    Switch to low-bitrate audio
                                    when your connection is weak.

                                </small>

                            </div>

                        </div>


                        <!-- Switch -->

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input data-mode-switch"
                                type="checkbox"
                                role="switch"
                                id="dataModeToggle"
                            >

                        </div>

                    </div>


                    <!-- =========================================
                            VIDEO QUALITY SELECTOR
                        ========================================= -->

                        <div class="video-quality-box">

                            <div class="d-flex align-items-center">

                                <div class="video-quality-icon">

                                    <i class="bi bi-camera-video-fill"></i>

                                </div>

                                <div>

                                    <h6 class="fw-bold mb-1">
                                        Video Quality
                                    </h6>

                                    <small>
                                        Select a quality based on your internet connection.
                                    </small>

                                </div>

                            </div>


                            <select
                                id="videoQuality"
                                class="form-select form-select-sm video-quality-select"
                                aria-label="Select video quality"
                            >

                                <option value="1080p"selected>
                                    1080p
                                </option>

                                <option value="720p">
                                    720p
                                </option>

                                <option value="480p">
                                    480p
                                </option>

                                <option value="360p">
                                    360p
                                </option>

                            </select>

                        </div>
                        <!-- =============================
                         VIDEO PLAYER
                    ============================== -->

                    <div
                        id="videoContainer"
                        class="lesson-video-container"
                    >

                       <video
                            id="videoPlayer"
                            controls
                            class="w-100"
                            src="<?php echo htmlspecialchars($lesson["video_path"]); ?>"
                        >

                            Your browser does not support
                            video streaming.

                        </video>

                    </div>



                    <!-- =============================
                         AUDIO PLAYER
                    ============================== -->

                    <div
                        id="audioContainer"
                        class="lesson-audio-container"
                        style="display: none;"
                    >

                        <div class="audio-icon">

                            <i class="bi bi-broadcast"></i>

                        </div>


                        <h5 class="fw-bold mb-1">
                            Data-Saver Mode Active
                        </h5>

                        <p class="audio-description">
                            64 kbps Mono
                            <span>•</span>
                            Reduced Data Usage
                        </p>


                        <audio
                            id="audioPlayer"
                            controls
                            class="w-100"
                        >

                            <source
                                src="<?php echo htmlspecialchars($lesson["audio_path"] ?? ""); ?>"
                                type="audio/mpeg"
                            >

                        </audio>

                    </div>



                    <!-- =============================
                         LESSON INFORMATION
                    ============================== -->

                    <div class="lesson-information">

                        <span class="lesson-label">

    LESSON <?php echo htmlspecialchars($lesson["lesson_number"]); ?>

</span>


<h3 class="fw-bold">

    Lesson
    <?php echo htmlspecialchars($lesson["lesson_number"]); ?>:

    <?php echo htmlspecialchars($lesson["title"]); ?>

</h3>


<p class="lesson-description mb-0">

    <?php echo htmlspecialchars($lesson["description"]); ?>

</p>

                    </div>


                </div>

            </div>



            <!-- =================================
     SIDEBAR
================================== -->

<div class="col-lg-4">


    <!-- =============================
         UNIT RESOURCES
    ============================== -->

    <div class="lesson-side-card mb-4">

        <div class="lesson-side-heading">

            <div class="side-icon blue-side-icon">

                <i class="bi bi-collection-fill"></i>

            </div>

            <div>

                <h6 class="fw-bold mb-0">
                    Unit Resources
                </h6>

                <small>
                    Resources for Unit 01
                </small>

            </div>

        </div>


        <p class="small text-muted mb-3">

            Additional learning resources for
            this unit are available from the
            Unit page.

        </p>


        <a
            href="units.php?subject=<?php echo urlencode($lesson["subject_code"]); ?>"
            class="btn btn-lesson-primary w-100 fw-bold"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Back to Unit Resources

        </a>

    </div>