<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";


if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}


$full_name = $_SESSION["full_name"];
$user_id = (int)$_SESSION["user_id"];


$lesson_id = $_GET["lesson"] ?? "";
$part_number = $_GET["part"] ?? 1;


// Make sure lesson ID is a number

if (!is_numeric($lesson_id)) {

    header("Location: dashboard.php");
    exit();

}

$lesson_id = (int)$lesson_id;


$part_number = (int)$part_number;

if ($part_number < 1) {

    $part_number = 1;

}



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
            units.subject_id,

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



if (!$lesson) {

    header("Location: dashboard.php");
    exit();

}



/*
    Get the selected lesson part.

    If the lesson has parts, the requested part
    must exist. This prevents an invalid part
    number from falling back to the parent lesson.
*/

$selected_part = null;

$sql = "SELECT
            part_id,
            lesson_id,
            part_number,
            title,
            video_path,
            video_1080p_path,
            video_720p_path,
            video_480p_path,
            video_360p_path,
            audio_path,
            duration_minutes

        FROM lesson_parts

        WHERE lesson_id = ?
        AND part_number = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $lesson_id,
    $part_number
);

$stmt->execute();

$result = $stmt->get_result();

$selected_part = $result->fetch_assoc();

$stmt->close();


/*
    Check whether this lesson has any parts.
*/

$has_parts = false;

$sql = "SELECT part_id
        FROM lesson_parts
        WHERE lesson_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "i",
    $lesson_id
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $has_parts = true;

}

$stmt->close();


/*
    If the lesson uses parts but the requested
    part does not exist, return to the unit page.
*/

if ($has_parts && !$selected_part) {

    header(
        "Location: units.php?subject=" .
        urlencode($lesson["subject_code"])
    );

    exit();

}



/*
    Check whether the student is enrolled
    in this subject.
*/

$sql = "SELECT
            student_subject_id

        FROM student_subjects

        WHERE user_id = ?
        AND subject_id = ?";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $user_id,
    $lesson["subject_id"]
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    $stmt->close();

    die("You are not enrolled in this subject.");

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

    <?php echo htmlspecialchars($lesson["title"]); ?>

    <?php if ($selected_part): ?>

        - Part
        <?php echo str_pad(
            $selected_part["part_number"],
            2,
            "0",
            STR_PAD_LEFT
        ); ?>

    <?php endif; ?>

    | A/L TechHub

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




<main class="container py-4">


    <div class="row g-4">


        <div class="col-lg-8">


            <div class="lesson-main-card">


                <!-- Data Saver -->

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




                <!-- Video Quality -->

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

                        <option value="1080p">
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



                <!-- Video -->

                <div
                    id="videoContainer"
                    class="lesson-video-container"
                >

                    <video
                        id="videoPlayer"
                        controls
                        controlsList="nodownload"
                        class="w-100"
                    >
                        Your browser does not support
                        video streaming.
                    </video>

                </div>



                <!-- Audio -->

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

                    </audio>

                </div>



                <!-- Lesson Information -->

                <div class="lesson-information">

    <span class="lesson-label">

        LESSON
        <?php echo htmlspecialchars($lesson["lesson_number"]); ?>

        <?php if ($selected_part): ?>

            <span class="lesson-divider">•</span>

            PART
            <?php echo str_pad(
                $selected_part["part_number"],
                2,
                "0",
                STR_PAD_LEFT
            ); ?>

        <?php endif; ?>

    </span>


    <h3 class="fw-bold">

        Lesson
        <?php echo htmlspecialchars($lesson["lesson_number"]); ?>:

        <?php echo htmlspecialchars($lesson["title"]); ?>

        <?php if ($selected_part): ?>

            <br>

            <small class="text-muted">

                Part
                <?php echo str_pad(
                    $selected_part["part_number"],
                    2,
                    "0",
                    STR_PAD_LEFT
                ); ?>:
                <?php echo htmlspecialchars(
                    $selected_part["title"]
                ); ?>

            </small>

        <?php endif; ?>

    </h3>


    <p class="lesson-description mb-0">

        <?php echo htmlspecialchars($lesson["description"]); ?>

    </p>

</div>


            </div>

        </div>



        <div class="col-lg-4">


            <!-- Unit Resources -->

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

                            Resources for Unit
                            <?php echo str_pad(
                                $lesson["unit_number"],
                                2,
                                "0",
                                STR_PAD_LEFT
                            ); ?>

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



            <!-- Current Lesson -->

            <div class="lesson-side-card mb-4">

                <div class="lesson-side-heading">

                    <div class="side-icon teal-side-icon">

                        <i class="bi bi-check-circle-fill"></i>

                    </div>

                    <div>

                        <h6 class="fw-bold mb-0">
                            Lesson
                        </h6>

                        <small>
                            Current lesson
                        </small>

                    </div>

                </div>


                <div class="d-flex align-items-center gap-2">

                    <i class="bi bi-play-circle-fill text-primary"></i>

                    <span class="small">

                        Lesson
                        <?php echo htmlspecialchars($lesson["lesson_number"]); ?>
                        is currently selected

                    </span>

                </div>


                <p class="small text-muted mt-3 mb-0">

                    Complete the lesson before moving
                    to the next lesson in this unit.

                </p>

            </div>

            

        </div>


    </div>

</main>


<script>

const currentLessonId =
    <?php echo (int)$lesson["lesson_id"]; ?>;


const currentPartNumber =
    <?php echo (int)$part_number; ?>;


const selectedPart =
    <?php echo json_encode(
        $selected_part,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    ); ?>;


const videoPlayer =
    document.getElementById("videoPlayer");


const videoQuality =
    document.getElementById("videoQuality");


const dataModeToggle =
    document.getElementById("dataModeToggle");


const videoContainer =
    document.getElementById("videoContainer");


const audioContainer =
    document.getElementById("audioContainer");


const audioPlayer =
    document.getElementById("audioPlayer");



/*
    Old lesson-level video data.

    Used for existing lessons such as SFT
    that do not have lesson_parts.
*/

const oldLessonData = {

    video_path:
        <?php echo json_encode($lesson["video_path"] ?? ""); ?>,

    video_1080p_path:
        <?php echo json_encode($lesson["video_1080p_path"] ?? ""); ?>,

    video_720p_path:
        <?php echo json_encode($lesson["video_720p_path"] ?? ""); ?>,

    video_480p_path:
        <?php echo json_encode($lesson["video_480p_path"] ?? ""); ?>,

    video_360p_path:
        <?php echo json_encode($lesson["video_360p_path"] ?? ""); ?>,

    audio_path:
        <?php echo json_encode($lesson["audio_path"] ?? ""); ?>

};



/*
    Use lesson part if available.
    Otherwise use the old lesson video.
*/

const videoData =
    selectedPart || oldLessonData;



/*
    Get video path.
*/

function getVideoPath(quality) {

    const qualityPath =
        videoData["video_" + quality + "_path"];


    if (qualityPath) {

        return qualityPath;

    }


    if (videoData.video_path) {

        return videoData.video_path;

    }


    return "";

}



/*
    Update available quality options.
*/

function updateQualityOptions() {

    const qualities = [
        "1080p",
        "720p",
        "480p",
        "360p"
    ];


    let firstAvailable = "";


    qualities.forEach(
        function (quality) {

            const option =
                videoQuality.querySelector(
                    'option[value="' + quality + '"]'
                );


            if (!option) {

                return;

            }


            const path =
                getVideoPath(quality);


            if (path) {

                option.disabled = false;

                if (!firstAvailable) {

                    firstAvailable = quality;

                }

            } else {

                option.disabled = true;

            }

        }
    );


    if (
        !videoQuality.value ||
        videoQuality.querySelector(
            'option[value="' +
            videoQuality.value +
            '"]'
        ).disabled
    ) {

        videoQuality.value =
            firstAvailable;

    }

}



/*
    Load video.
*/

function loadVideo() {

    updateQualityOptions();


    const selectedQuality =
        videoQuality.value;


    const videoPath =
        getVideoPath(
            selectedQuality
        );


    if (!videoPath) {

        videoPlayer.removeAttribute("src");

        videoPlayer.load();

        console.log(
            "No video available."
        );

        return;

    }


    videoPlayer.src =
        videoPath;


    videoPlayer.load();


    console.log(
        "Lesson ID:",
        currentLessonId
    );


    console.log(
        "Part:",
        currentPartNumber
    );


    console.log(
        "Quality:",
        selectedQuality
    );


    console.log(
        "Video:",
        videoPath
    );

}



/*
    Complete lesson.
*/

function completeLesson() {

    fetch(
        "php/complete_lesson.php",
        {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/x-www-form-urlencoded"

            },

            body:
                "lesson_id=" +
                encodeURIComponent(
                    currentLessonId
                )

        }
    )

    .then(function (response) {

        if (!response.ok) {

            throw new Error(
                "Failed to complete lesson."
            );

        }

        return response.text();

    })

    .then(function (data) {

        console.log(
            "Lesson completion:",
            data
        );

    })

    .catch(function (error) {

        console.error(
            "Lesson completion error:",
            error
        );

    });

}



/*
    Video quality change.
*/

videoQuality.addEventListener(
    "change",
    function () {

        const selectedQuality =
            this.value;


        const newVideoPath =
            getVideoPath(
                selectedQuality
            );


        if (!newVideoPath) {

            alert(
                "The " +
                selectedQuality +
                " video is not available."
            );

            return;

        }


        const currentTime =
            videoPlayer.currentTime;


        const wasPlaying =
            !videoPlayer.paused;


        videoPlayer.src =
            newVideoPath;


        videoPlayer.load();


        videoPlayer.addEventListener(
            "loadedmetadata",
            function restorePosition() {

                videoPlayer.currentTime =
                    currentTime;


                if (wasPlaying) {

                    videoPlayer.play().catch(
                        function (error) {

                            console.log(
                                "Playback error:",
                                error
                            );

                        }
                    );

                }


                videoPlayer.removeEventListener(
                    "loadedmetadata",
                    restorePosition
                );

            }
        );

    }
);



/*
    Data-Saver Mode.
*/

dataModeToggle.addEventListener(
    "change",
    function () {

        const audioPath =
            videoData.audio_path || "";


        if (
            this.checked &&
            !audioPath
        ) {

            alert(
                "Data-Saver audio is not available for this lesson part yet."
            );

            this.checked = false;

            return;

        }


        const currentTime =
            videoPlayer.currentTime;


        const wasVideoPlaying =
            !videoPlayer.paused;


        if (this.checked) {

            videoPlayer.pause();


            videoContainer.style.display =
                "none";


            audioContainer.style.display =
                "block";


            audioPlayer.src =
                audioPath;


            audioPlayer.load();


            const videoQualityBox =
                videoQuality.closest(
                    ".video-quality-box"
                );


            if (videoQualityBox) {

                videoQualityBox.style.display =
                    "none";

            }


            audioPlayer.currentTime =
                currentTime;


            if (wasVideoPlaying) {

                audioPlayer.play().catch(
                    function (error) {

                        console.log(
                            "Audio playback error:",
                            error
                        );

                    }
                );

            }

        } else {

            const audioTime =
                audioPlayer.currentTime;


            audioPlayer.pause();


            audioContainer.style.display =
                "none";


            videoContainer.style.display =
                "block";


            const videoQualityBox =
                videoQuality.closest(
                    ".video-quality-box"
                );


            if (videoQualityBox) {

                videoQualityBox.style.display =
                    "flex";

            }


            videoPlayer.currentTime =
                audioTime;


            videoPlayer.play().catch(
                function (error) {

                    console.log(
                        "Video playback error:",
                        error
                    );

                }
            );

        }

    }
);



/*
    Video error.
*/

videoPlayer.addEventListener(
    "error",
    function () {

        console.log(
            "Video error:",
            videoPlayer.error
        );

    }
);



/*
    Complete the lesson when
    the selected video finishes.

    For now, this keeps the same
    completion behavior as before.
*/

videoPlayer.addEventListener(
    "ended",
    function () {

        completeLesson();

    }
);


audioPlayer.addEventListener(
    "ended",
    function () {

        completeLesson();

    }
);



/*
    Load selected part.
*/

loadVideo();

</script>



<script src="js/script.js"></script>


</body>

</html>