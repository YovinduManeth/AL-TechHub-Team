<?php

session_start();

require_once "php/db.php";
require_once "php/remember_login.php";

 

if (!isset($_SESSION["user_id"])) {

    header("Location: login.html?error=login_required");
    exit();

}

 

$full_name = $_SESSION["full_name"];


 

$subject_code = $_GET["subject"] ?? "";
$grade = $_GET["grade"] ?? "12";
 

$sql = "SELECT subject_id, subject_name
        FROM subjects
        WHERE subject_code = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $subject_code);

$stmt->execute();

$result = $stmt->get_result();

$subject = $result->fetch_assoc();

$stmt->close();


if (!$subject) {

    die("Subject not found.");

}


$subject_id = $subject["subject_id"];
$subject_name = $subject["subject_name"];


$sql = "SELECT
            unit_id,
            grade,
            unit_number,
            unit_title
        FROM units
        WHERE subject_id = ?
        AND grade = ?
        ORDER BY unit_number";

$stmt = $conn->prepare($sql);

$stmt->bind_param("is", $subject_id, $grade);

$stmt->execute();

$result = $stmt->get_result();

$units = [];

while ($row = $result->fetch_assoc()) {

    $units[] = $row;

}

$stmt->close();