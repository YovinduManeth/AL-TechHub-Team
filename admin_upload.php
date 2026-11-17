<?php

session_start();


if (
    !isset($_SESSION["user_id"]) ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: admin-login.html");
    exit();
}


set_time_limit(600);

require_once "php/db.php";
require_once "php/ffmpeg.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: admin-upload.php");
    exit();

}


$resource_type = $_POST["resource_type"] ?? "";

$unit_id = $_POST["unit_id"] ?? "";

$lesson_number = trim($_POST["lesson_number"] ?? "");

if ($resource_type === "short_notes") {

    $title = trim($_POST["title"] ?? "");

} else {

    $title = trim($_POST["lesson_title"] ?? "");

}

$description = trim($_POST["description"] ?? "");




if ($resource_type === "past_paper") {



    $subject_id = $_POST["subject_id"] ?? "";

    $paper_year = $_POST["paper_year"] ?? "";

    $paper_title = trim($_POST["paper_title"] ?? "");



    if (
    empty($subject_id) ||
    empty($paper_year) ||
    empty($paper_title) ||
    !isset($_FILES["paper_file"])
) {

    die(
        "Please select a subject, enter a year, " .
        "enter a paper title, and select a PDF file."
    );

}


    if (!is_numeric($subject_id)) {

        die("Invalid subject selected.");

    }

    $subject_id = (int)$subject_id;


    if (
        !is_numeric($paper_year) ||
        (int)$paper_year < 2000 ||
        (int)$paper_year > 2100
    ) {

        die("Invalid year.");

    }

    $paper_year = (int)$paper_year;


    if (
        $_FILES["paper_file"]["error"] !==
        UPLOAD_ERR_OK
    ) {

        die("Past paper upload failed.");

    }


    $paper_file = $_FILES["paper_file"];


 
    $file_extension = strtolower(
        pathinfo(
            $paper_file["name"],
            PATHINFO_EXTENSION
        )
    );


    if ($file_extension !== "pdf") {

        die(
            "Only PDF files are allowed " .
            "for past papers."
        );

    }


      $past_paper_directory =
        "uploads/past_papers/";


    if (!is_dir($past_paper_directory)) {

        mkdir(
            $past_paper_directory,
            0777,
            true
        );

    }


    $unique_name =
        "paper_" .
        time() .
        "_" .
        bin2hex(random_bytes(4)) .
        ".pdf";


    $paper_path =
        $past_paper_directory .
        $unique_name;


    if (
        !move_uploaded_file(
            $paper_file["tmp_name"],
            $paper_path
        )
    ) {

        die(
            "Failed to save the past paper."
        );

    }


$sql = "INSERT INTO past_papers
        (
            subject_id,
            year,
            title,
            file_path
        )
        VALUES (?, ?, ?, ?)";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "iiss",
    $subject_id,
    $paper_year,
    $paper_title,
    $paper_path
);

    
    if (!$stmt->execute()) {


        // Remove uploaded PDF
        // if database insertion fails

        if (file_exists($paper_path)) {

            unlink($paper_path);

        }


        die(
            "Database error: " .
            $stmt->error
        );

    }


    $stmt->close();


    echo "<h2>Past paper uploaded successfully!</h2>";


    echo "<p>File: " .
         htmlspecialchars($paper_path) .
         "</p>";


    echo "<p>Subject ID: " .
         htmlspecialchars($subject_id) .
         "</p>";

    echo "<p>Year: " .
         htmlspecialchars($paper_year) .
         "</p>";


    echo "<p>Title: " .
         htmlspecialchars($paper_title) .
         "</p>";


    echo "<p>The past paper was saved successfully.</p>";


    exit();

}


if ($resource_type === "quiz") {

   

    $grade = $_POST["grade"] ?? "";

    $quiz_title = trim($_POST["quiz_title"] ?? "");

    $time_limit = $_POST["time_limit"] ?? "";




    $question_text = $_POST["question_text"] ?? [];

    $option_a = $_POST["option_a"] ?? [];

    $option_b = $_POST["option_b"] ?? [];

    $option_c = $_POST["option_c"] ?? [];

    $option_d = $_POST["option_d"] ?? [];

    $correct_answer = $_POST["correct_answer"] ?? [];


   

    if (
        empty($unit_id) ||
        empty($grade) ||
        empty($quiz_title) ||
        $time_limit === ""
    ) {

        die("Please complete all quiz details.");

    }


    if (
        !is_numeric($unit_id) ||
        !in_array((string)$grade, ["12", "13"], true) ||
        !ctype_digit((string)$time_limit)
    ) {

        die("Invalid quiz information.");

    }


    $unit_id = (int)$unit_id;

    $time_limit = (int)$time_limit;


    if ($unit_id <= 0) {

        die("Invalid syllabus unit.");

    }


    if ($time_limit < 1 || $time_limit > 180) {

        die("Time limit must be between 1 and 180 minutes.");

    }




    $unit_sql = "SELECT unit_id
                 FROM units
                 WHERE unit_id = ?
                 AND grade = ?";

    $unit_stmt = $conn->prepare($unit_sql);

    $unit_stmt->bind_param(
        "is",
        $unit_id,
        $grade
    );

    $unit_stmt->execute();

    $unit_result = $unit_stmt->get_result();

    if ($unit_result->num_rows === 0) {

        $unit_stmt->close();

        die("The selected unit does not belong to the selected grade.");

    }

    $unit_stmt->close();


    

    if (
        !is_array($question_text) ||
        !is_array($option_a) ||
        !is_array($option_b) ||
        !is_array($option_c) ||
        !is_array($option_d) ||
        !is_array($correct_answer)
    ) {

        die("Invalid quiz question data.");

    }


    $question_count = count($question_text);


    if ($question_count < 1) {

        die("Please add at least one quiz question.");

    }


    if (
        count($option_a) !== $question_count ||
        count($option_b) !== $question_count ||
        count($option_c) !== $question_count ||
        count($option_d) !== $question_count ||
        count($correct_answer) !== $question_count
    ) {

        die("Some quiz questions have missing information.");

    }



    $valid_answers = ["A", "B", "C", "D"];

    $questions = [];


    for ($i = 0; $i < $question_count; $i++) {

        $question = trim($question_text[$i]);

        $a = trim($option_a[$i]);

        $b = trim($option_b[$i]);

        $c = trim($option_c[$i]);

        $d = trim($option_d[$i]);

        $answer = strtoupper(
            trim($correct_answer[$i])
        );


        if (
            $question === "" ||
            $a === "" ||
            $b === "" ||
            $c === "" ||
            $d === ""
        ) {

            die(
                "Please complete Question " .
                ($i + 1) .
                " and all four options."
            );

        }


        if (!in_array($answer, $valid_answers, true)) {

            die(
                "Please select a valid correct answer " .
                "for Question " .
                ($i + 1) .
                "."
            );

        }


        if (
            strlen($a) > 500 ||
            strlen($b) > 500 ||
            strlen($c) > 500 ||
            strlen($d) > 500
        ) {

            die(
                "An option in Question " .
                ($i + 1) .
                " exceeds the allowed length."
            );

        }


        $questions[] = [
            "question" => $question,
            "a" => $a,
            "b" => $b,
            "c" => $c,
            "d" => $d,
            "answer" => $answer
        ];

    }


   

    try {

        // Start database transaction.

        $conn->begin_transaction();


        // Insert quiz information.

        $quiz_sql = "INSERT INTO quizzes
                     (
                         unit_id,
                         title,
                         time_limit
                     )
                     VALUES (?, ?, ?)";


        $quiz_stmt = $conn->prepare($quiz_sql);

        $quiz_stmt->bind_param(
            "isi",
            $unit_id,
            $quiz_title,
            $time_limit
        );


        if (!$quiz_stmt->execute()) {

            throw new Exception(
                "Failed to create quiz: " .
                $quiz_stmt->error
            );

        }


        // Get the newly created quiz ID.

        $quiz_id = $conn->insert_id;

        $quiz_stmt->close();


        // Prepare question insertion.

        $question_sql = "INSERT INTO quiz_questions
                         (
                             quiz_id,
                             question_text,
                             option_a,
                             option_b,
                             option_c,
                             option_d,
                             correct_answer
                         )
                         VALUES (?, ?, ?, ?, ?, ?, ?)";


        $question_stmt = $conn->prepare($question_sql);


        

        foreach ($questions as $question) {

            $question_stmt->bind_param(
                "issssss",
                $quiz_id,
                $question["question"],
                $question["a"],
                $question["b"],
                $question["c"],
                $question["d"],
                $question["answer"]
            );


            if (!$question_stmt->execute()) {

                throw new Exception(
                    "Failed to save a quiz question: " .
                    $question_stmt->error
                );

            }

        }


        $question_stmt->close();


        

        $conn->commit();


      

        echo "<div style='
                max-width:600px;
                margin:60px auto;
                padding:30px;
                text-align:center;
                font-family:Arial;
                border:1px solid #ddd;
                border-radius:10px;
              '>";

        echo "<h2 style='color:green;'>
                Quiz created successfully!
              </h2>";

        echo "<p><strong>Quiz Title:</strong> " .
             htmlspecialchars($quiz_title) .
             "</p>";

        echo "<p><strong>Questions Added:</strong> " .
             $question_count .
             "</p>";

        echo "<p><strong>Time Limit:</strong> " .
             $time_limit .
             " minutes</p>";

        echo "<a href='admin-upload.php'
                 style='
                    display:inline-block;
                    margin-top:15px;
                    padding:12px 20px;
                    background:#2563eb;
                    color:white;
                    text-decoration:none;
                    border-radius:6px;
                 '>
                 Back to Admin Portal
              </a>";

        echo "</div>";


        exit();


    } catch (Throwable $e) {

        // Undo all database changes if something fails.

        $conn->rollback();


        die(
            "Quiz creation failed: " .
            htmlspecialchars($e->getMessage())
        );

    }

}




// Video Lessons and Short Notes need a unit.
// Past Papers and Quizzes are handled separately.

if (empty($unit_id)) {

    die("Please select a syllabus unit.");

}


if ($resource_type === "short_notes") {


    if (
        empty($title) ||
        !isset($_FILES["note_file"])
    ) {

        die(
            "Please enter the note title " .
            "and select a PDF file."
        );

    }



    if (
        $_FILES["note_file"]["error"] !==
        UPLOAD_ERR_OK
    ) {

        die("Short note upload failed.");

    }


    $note_file = $_FILES["note_file"];


    $file_extension = strtolower(
        pathinfo(
            $note_file["name"],
            PATHINFO_EXTENSION
        )
    );


    if ($file_extension !== "pdf") {

        die(
            "Only PDF files are allowed " .
            "for short notes."
        );

    }

    $notes_directory = "uploads/notes/";


    if (!is_dir($notes_directory)) {

        mkdir(
            $notes_directory,
            0777,
            true
        );

    }

    $unique_name =
        "note_" .
        time() .
        "_" .
        bin2hex(random_bytes(4)) .
        ".pdf";


    $note_path =
        $notes_directory .
        $unique_name;


   
    if (
        !move_uploaded_file(
            $note_file["tmp_name"],
            $note_path
        )
    ) {

        die(
            "Failed to save the short note."
        );

    }


    $sql = "INSERT INTO short_notes
            (
                unit_id,
                title,
                file_path
            )
            VALUES (?, ?, ?)";


    $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "iss",
        $unit_id,
        $title,
        $note_path
    );


  
    if (!$stmt->execute()) {


        // Remove uploaded PDF
        // if database insertion fails

        if (file_exists($note_path)) {

            unlink($note_path);

        }


        die(
            "Database error: " .
            $stmt->error
        );

    }


    $stmt->close();


   
    echo "<h2>Short note uploaded successfully!</h2>";


    echo "<p>File: " .
         htmlspecialchars($note_path) .
         "</p>";


    echo "<p>Title: " .
         htmlspecialchars($title) .
         "</p>";


    echo "<p>The short note was saved successfully.</p>";


    exit();

}



if ($resource_type !== "lesson") {

    die(
        "Currently only Video Lessons, " .
        "Short Notes, and Past Papers are supported."
    );

}



if (
    empty($lesson_number) ||
    empty($title) ||
    !isset($_FILES["video"])
) {

    die(
        "Please complete all required lesson fields."
    );

}

if (
    $_FILES["video"]["error"] !==
    UPLOAD_ERR_OK
) {

    die("Video upload failed.");

}


$video_file = $_FILES["video"];


$file_extension = strtolower(
    pathinfo(
        $video_file["name"],
        PATHINFO_EXTENSION
    )
);


if ($file_extension !== "mp4") {

    die(
        "Only MP4 video files are allowed."
    );

}


$unique_name =
    "lesson_" .
    time() .
    "_" .
    bin2hex(random_bytes(4)) .
    ".mp4";



$video_directory =
    "uploads/videos/";

$video_quality_directory =
    "uploads/videos/quality/";

$audio_directory =
    "uploads/audios/";

if (!is_dir($video_directory)) {

    mkdir(
        $video_directory,
        0777,
        true
    );

}

if (!is_dir($video_quality_directory)) {

    mkdir(
        $video_quality_directory,
        0777,
        true
    );

}

if (!is_dir($audio_directory)) {

    mkdir(
        $audio_directory,
        0777,
        true
    );

}



$video_path =
    $video_directory .
    $unique_name;


$audio_name =
    pathinfo(
        $unique_name,
        PATHINFO_FILENAME
    ) .
    ".mp3";


$audio_path =
    $audio_directory .
    $audio_name;



$video_filename =
    pathinfo(
        $unique_name,
        PATHINFO_FILENAME
    );


$video_1080p_path =
    $video_quality_directory .
    $video_filename .
    "_1080p.mp4";


$video_720p_path =
    $video_quality_directory .
    $video_filename .
    "_720p.mp4";


$video_480p_path =
    $video_quality_directory .
    $video_filename .
    "_480p.mp4";


$video_360p_path =
    $video_quality_directory .
    $video_filename .
    "_360p.mp4";


if (
    !move_uploaded_file(
        $video_file["tmp_name"],
        $video_path
    )
) {

    die(
        "Failed to save uploaded video."
    );

}

// 1080p
$result_1080p =
    generateVideoQuality(
        $video_path,
        $video_1080p_path,
        1080
    );

if (!$result_1080p["success"]) {

    die(
        "1080p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_1080p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// 720p
$result_720p =
    generateVideoQuality(
        $video_path,
        $video_720p_path,
        720
    );

if (!$result_720p["success"]) {

    die(
        "720p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_720p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// 480p
$result_480p =
    generateVideoQuality(
        $video_path,
        $video_480p_path,
        480
    );

if (!$result_480p["success"]) {

    die(
        "480p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_480p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}


// 360p
$result_360p =
    generateVideoQuality(
        $video_path,
        $video_360p_path,
        360
    );

if (!$result_360p["success"]) {

    die(
        "360p video generation failed.<br><pre>" .
        htmlspecialchars(
            implode(
                "\n",
                $result_360p["output"] ?? []
            )
        ) .
        "</pre>"
    );

}



$audio_result =
    generateAudioFromVideo(
        $video_path,
        $audio_path
    );


if (!$audio_result["success"]) {


    // Remove uploaded video
    // if audio generation fails

    if (file_exists($video_path)) {

        unlink($video_path);

    }


    echo "<h2>Audio generation failed.</h2>";


    echo "<pre>";

    print_r($audio_result);

    echo "</pre>";


    exit();

}


$duration_seconds = getVideoDuration($video_path);

if ($duration_seconds === false) {

    // Remove generated files if duration cannot be detected

    if (file_exists($video_path)) {
        unlink($video_path);
    }

    if (file_exists($audio_path)) {
        unlink($audio_path);
    }

    if (file_exists($video_1080p_path)) {
        unlink($video_1080p_path);
    }

    if (file_exists($video_720p_path)) {
        unlink($video_720p_path);
    }

    if (file_exists($video_480p_path)) {
        unlink($video_480p_path);
    }

    if (file_exists($video_360p_path)) {
        unlink($video_360p_path);
    }

    die("Could not determine video duration.");
}


// Convert seconds to minutes

$duration_minutes =
    round($duration_seconds / 60, 2);


$sql = "INSERT INTO lessons
        (
            unit_id,
            lesson_number,
            title,
            description,
            video_path,
            video_1080p_path,
            video_720p_path,
            video_480p_path,
            video_360p_path,
            audio_path,
            duration_minutes
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = $conn->prepare($sql);


$stmt->bind_param(
    "isssssssssd",
    $unit_id,
    $lesson_number,
    $title,
    $description,
    $video_path,
    $video_1080p_path,
    $video_720p_path,
    $video_480p_path,
    $video_360p_path,
    $audio_path,
    $duration_minutes
);


if (!$stmt->execute()) {

    // Remove original video
    if (file_exists($video_path)) {
        unlink($video_path);
    }

    // Remove audio
    if (file_exists($audio_path)) {
        unlink($audio_path);
    }

    // Remove 1080p video
    if (file_exists($video_1080p_path)) {
        unlink($video_1080p_path);
    }

    // Remove 720p video
    if (file_exists($video_720p_path)) {
        unlink($video_720p_path);
    }

    // Remove 480p video
    if (file_exists($video_480p_path)) {
        unlink($video_480p_path);
    }

    // Remove 360p video
    if (file_exists($video_360p_path)) {
        unlink($video_360p_path);
    }

    die(
        "Database error: " .
        $stmt->error
    );

}


$stmt->close();


echo "<h2>Lesson uploaded successfully!</h2>";


echo "<p>Video: " .
     htmlspecialchars($video_path) .
     "</p>";


echo "<p>Audio: " .
     htmlspecialchars($audio_path) .
     "</p>";


echo "<p>Lesson Number: " .
     htmlspecialchars($lesson_number) .
     "</p>";


echo "<p>FFmpeg successfully generated the audio.</p>";

?>   