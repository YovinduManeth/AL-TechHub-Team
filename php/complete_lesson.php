<?php

session_start();

require_once "db.php";


if (!isset($_SESSION["user_id"])) {

    http_response_code(401);
    exit("Not logged in");

}


$user_id = (int)$_SESSION["user_id"];


$lesson_id = $_POST["lesson_id"] ?? "";


// Make sure lesson ID is a number

if (!is_numeric($lesson_id)) {

    http_response_code(400);
    exit("Invalid lesson ID");

}

$lesson_id = (int)$lesson_id;


$sql = "INSERT INTO student_progress
            (user_id, lesson_id, completed, completed_at)

        VALUES
            (?, ?, 1, NOW())

        ON DUPLICATE KEY UPDATE

            completed = 1,
            completed_at = NOW()";


$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $user_id,
    $lesson_id
);


if ($stmt->execute()) {

    echo "success";

} else {

    http_response_code(500);
    echo "error";

}


$stmt->close();

$conn->close();

?>