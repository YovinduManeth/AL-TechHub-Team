<?php

session_start();

require_once "db.php";


// ==========================================
// CHECK LOGIN
// ==========================================

if (!isset($_SESSION["user_id"])) {

    http_response_code(401);
    exit("Not logged in");

}


// ==========================================
// GET USER ID
// ==========================================

$user_id = (int)$_SESSION["user_id"];


// ==========================================
// GET LESSON ID
// ==========================================

$lesson_id = $_POST["lesson_id"] ?? "";


// Make sure lesson ID is a number

if (!is_numeric($lesson_id)) {

    http_response_code(400);
    exit("Invalid lesson ID");

}

$lesson_id = (int)$lesson_id;